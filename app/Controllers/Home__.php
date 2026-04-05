<?php

namespace App\Controllers;

use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends BaseController
{
    public $commonmodel;
    public function __construct()
    {
        $this->commonmodel = model('App\Models\CommonModel', false);
    }

    public function index()
    {
        $data['house'] = $this->commonmodel->getAllRecord('tbl_category', ['status' => 1, 'property_status' => 1, 'service_id' => 1]);
        $data['rooms'] = $this->commonmodel->getAllRecord('tbl_category', ['status' => 1, 'property_status' => 1, 'service_id' => 2]);
        return view('welcome', $data);
    }

    /*****************Booking Page (View Render)**************************/
    public function saveBooking()
    {
        $category_id = $this->request->getGet('category_id');
        $item = $this->commonmodel->getOneRecord('tbl_category', ['category_id' => $category_id]);

        if (!$item) return redirect()->to('/');

        $user_ip = $this->request->getIPAddress();
        if ($user_ip == '::1' || $user_ip == '127.0.0.1') {
            $user_ip = '103.174.102.100';
        }

        $geo = @json_decode(file_get_contents("http://ip-api.com/json/{$user_ip}"));
        $countryCode = $geo->countryCode ?? 'IN';

        if ($countryCode == 'IN') {
            $data['display_currency'] = 'INR';
            $data['display_sign'] = '₹';
            $data['display_amount'] = $item->rent;
        } else {
            $usd_to_inr_rate = $this->getLiveUsdRate();
            $data['display_currency'] = 'USD';
            $data['display_sign'] = '$';
            $data['display_amount'] = number_format($item->rent * $usd_to_inr_rate, 2, '.', '');
        }

        $data['item'] = $item;
        return view('saveBooking', $data);
    }

    /*****************CREATE PAYPAL ORDER (API)**************************/
    public function createOrder()
    {
        $baseURL = getenv('PAYPAL_BASE_URL');
        $token = paypalAccessToken();
        $data = $this->request->getJSON(true);

        if (!isset($data['category_id'])) {
            return $this->response->setJSON(['error' => 'Category ID missing']);
        }

        $category = $this->commonmodel->getOneRecord('tbl_category', ['category_id' => $data['category_id']]);
        if (!$category) {
            return $this->response->setJSON(['error' => 'Invalid category']);
        }
        $usd_to_inr_rate = $this->getLiveUsdRate();

        // PayPal ke liye hum hamesha USD bhejenge taaki "Currency Not Supported" error na aaye
        $currency = 'USD';
        $final_amount = number_format($category->rent * $usd_to_inr_rate, 2, '.', '');

        $payload = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => $currency,
                    "value" => $final_amount
                ]
            ]]
        ];
        // CURL Execution
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $baseURL . "/v2/checkout/orders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer " . $token
            ]
        ]);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return $this->response->setJSON(['error' => curl_error($ch)]);
        }
        curl_close($ch);

        $response = json_decode($result, true);
        return $this->response->setJSON($response);
    }

    /*****************CAPTURE ORDER**************************/
    public function captureOrder()
    {
        $req = $this->request->getJSON(true);
        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'required|numeric|min_length[10]|max_length[12]',
            'orderID' => 'required'
        ];

        if (!$this->validateData($req, $rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors(),
                'csrf_token' => csrf_hash()
            ]);
        }

        $category = $this->commonmodel->getOneRecord('tbl_category', ['category_id' => $req['category_id']]);
        $booking_code = strtoupper(substr(md5(time()), 0, 6));

        $bookingData = [
            'booking_code' => $booking_code,
            'category_id'  => $req['category_id'],
            'service_id'   => $category->service_id,
            'name'         => $req['name'],
            'email'        => $req['email'],
            'phone'        => $req['phone'],
            'price'        => $category->rent,
            'payment_id'   => $req['orderID'],
            'payment_status' => 1,
            'status'       => 2
        ];

        $this->commonmodel->insertRecord('tbl_booking', $bookingData);
        $this->commonmodel->updateRecord('tbl_category', ['category_id' => $req['category_id']], ['status' => 2]);

        $this->generateInvoice($bookingData, $category);

        return $this->response->setJSON([
            'status' => 'success',
            'booking_code' => $booking_code
        ]);
    }

    /********************PDF INVOICE**********************/
    private function generateInvoice($booking, $category)
    {
        $mpdf = new Mpdf();

        $html = "<h2 style='text-align:center;'>YooRental Invoice</h2>
        <hr>
        <h3>Booking Info</h3>
        Booking ID: {$booking['booking_code']} <br>
        Date: " . date('d-m-Y') . "<br><br>

        <h3>Customer</h3>
        Name: {$booking['name']} <br>
        Email: {$booking['email']} <br>
        Phone: {$booking['phone']} <br><br>

        <h3>Room Details</h3>
        {$category->category_name} <br>
        Price: ₹{$booking['price']} <br><br>

        <h3>Payment</h3>
        Payment ID: {$booking['payment_id']} <br>
        Status: Paid";

        $mpdf->WriteHTML($html);
        $file = FCPATH . "invoice/{$booking['booking_code']}.pdf";
        $mpdf->Output($file, 'F');
    }
    public function downloadInvoice($code)
    {
        $file = FCPATH . "invoice/$code.pdf";
        return $this->response->download($file, null);
    }

    public function contact()
    {
        $data['title'] = 'I am contact page, i am coming from controller';
        return view('contact', $data);
    }
    public function contact_save()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'name'    => 'required|min_length[3]',
                'phone'   => 'required|numeric|min_length[10]|max_length[10]',
                'email'   => 'required|valid_email',
                'message' => 'required|min_length[5]'
            ];
            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $validation->getErrors(),
                    'csrf_token' => csrf_hash()
                ]);
            }
            $data = [
                'name'     => $this->request->getPost('name'),
                'phone'    => $this->request->getPost('phone'),
                'email'    => $this->request->getPost('email'),
                'message'  => $this->request->getPost('message'),
                'added_at' => date('Y-m-d H:i:s')
            ];
            $this->commonmodel->insertRecord('tbl_contact', $data);
            return $this->response->setJSON([
                'status'     => 'success',
                'message'    => 'Thank you! Your message has been sent.',
                'csrf_token' => csrf_hash()
            ]);
        }
        return redirect()->to('/contact');
    }
}
