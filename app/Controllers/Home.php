<?php

namespace App\Controllers;

use Mpdf\Mpdf;

class Home extends BaseController
{
    public $commonmodel;
    public function __construct()
    {
        $this->commonmodel = model('App\Models\CommonModel', false);
        helper(['url', 'form', 'paypal']);
    }
    public function index()
    {
        $data['house'] = $this->commonmodel->getAllRecord('tbl_category', ['status' => 1, 'property_status' => 1, 'service_id' => 1]);
        $data['rooms'] = $this->commonmodel->getAllRecord('tbl_category', ['status' => 1, 'property_status' => 1, 'service_id' => 2]);
        return view('welcome', $data);
    }

    /***************** Booking Page **************************/
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
        $usd_rate = getLiveUsdRate();
        if ($countryCode == 'IN') {
            $data['display_currency'] = 'INR';
            $data['display_sign'] = '₹';
            $data['display_amount'] = $item->rent;
        } else {
            $data['display_currency'] = 'USD';
            $data['display_sign'] = '$';
            $data['display_amount'] = number_format($item->rent * $usd_rate, 2, '.', '');
        }
        $data['item'] = $item;
        return view('saveBooking', $data);
    }

    /***************** CREATE PAYPAL ORDER **************************/
   public function createOrder()
{
    $baseURL = getenv('PAYPAL_BASE_URL');
    $token = paypalAccessToken();
    $data = $this->request->getJSON(true);
    if (!isset($data['category_id'])) {
        return $this->response->setJSON(['error' => 'Category ID missing']);
    }
    $category = $this->commonmodel->getOneRecord('tbl_category', [
        'category_id' => $data['category_id']
    ]);
    if (!$category) {
        return $this->response->setJSON(['error' => 'Invalid category']);
    }
    $usd_rate = getLiveUsdRate();
    $final_amount = number_format($category->rent * $usd_rate, 2, '.', '');
    $payload = [
        "intent" => "CAPTURE",
        "purchase_units" => [[
            "amount" => [
                "currency_code" => "USD",
                "value" => $final_amount
            ]
        ]]
    ];
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
        return $this->response->setJSON([
            'error' => curl_error($ch)
        ]);
    }
    curl_close($ch);
    $response = json_decode($result, true);
    return $this->response->setJSON([
        'id' => $response['id'] ?? null
    ]);
}
    /*****************CAPTURE ORDER**************************/
    public function captureOrder()
{
    $req = $this->request->getJSON(true);
    $rules = [
        'form_name'  => 'required|min_length[3]',
        'form_email' => 'required|valid_email',
        'form_phone' => 'required|numeric|min_length[10]|max_length[12]',
        'orderID'    => 'required',
        'category_id'=> 'required'
    ];

    if (!$this->validateData($req, $rules)) {
        return $this->response->setJSON([
            'status' => 'error',
            'errors' => $this->validator->getErrors(),
            'csrf_token' => csrf_hash()
        ]);
    }

    $category = $this->commonmodel->getOneRecord('tbl_category', ['category_id' => $req['category_id']]);
    if (!$category) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Category not found'
        ]);
    }
    $booking_code = strtoupper(substr(md5(time()), 0, 6));
    $payment_method = 'PayPal';
    if (isset($req['card_name'])) {
        $payment_method = 'Card';
    }
    $paymentData = [
        'booking_code'       => $booking_code,
        'orderID'            => $req['orderID'],
        'payer_name'         => $req['card_name'] ?? '',
        'payer_email'        => $req['card_email'] ?? '',
        'payment_method'     => $payment_method,
        'transaction_status' => 'COMPLETED',
        'payment'            => $category->rent,
        'payment_details'    => json_encode($req),
        'created_at'         => date('Y-m-d H:i:s')
    ];

    $payment_id = $this->commonmodel->insertRecord('tbl_payment', $paymentData);
    $ip = $this->request->getIPAddress();
    $bookingData = [
        'booking_code'    => $booking_code,
        'category_id'     => $req['category_id'],
        'service_id'      => $category->service_id,
        'name'            => $req['form_name'],
        'email'           => $req['form_email'],
        'phone'           => $req['form_phone'],
        'billing_address' => $req['billing_address'] ?? '',
        'customer_ip'     => $ip,
        'rent'            => $category->rent,
        'payment_id'      => $payment_id,
        'payment_status'  => 1, // Paid
        'status'          => 2, // Confirmed
        'created_at'      => date('Y-m-d H:i:s')
    ];

    try {
        $this->commonmodel->insertRecord('tbl_booking', $bookingData);
        $this->commonmodel->updateRecord(
            'tbl_category',
            ['category_id' => $req['category_id']],
            ['status' => 2]
        );
        $this->generateInvoice($bookingData, $category, $req['orderID']);
        return $this->response->setJSON([
            'status' => 'success',
            'booking_code' => $booking_code
        ]);
    } catch (\Exception $e) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Processing Error: ' . $e->getMessage()
        ]);
    }
}
    private function generateInvoice($booking, $category, $paypalOrderID)
    {
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => sys_get_temp_dir(),
            'curlAllowUnsafeSslRequests' => true
        ]);
        $logoUrl = base_url('assets/admin/images/logo1b.png');
        $html = "
        <div style='font-family: sans-serif; padding: 20px;'>
            <div style='text-align:center; margin-bottom: 20px;'>
                <img src='{$logoUrl}' width='120' />
            </div>
            <h2 style='text-align:center; color: #6f42c1; margin-top:0;'>YooRental Invoice</h2>
            <hr style='color: #eee;'>
            <table width='100%' style='margin-top: 20px;'>
                <tr>
                    <td style='vertical-align: top;'>
                        <strong>YooRentals PVT LTD</strong><br>
                        Patna, Bihar, India
                    </td>
                    <td align='right' style='vertical-align: top;'>
                        <strong>Customer:</strong> {$booking['name']}<br>
                        <strong>Phone:</strong> {$booking['phone']}
                    </td>
                </tr>
            </table>
            <table width='100%' style='margin-top: 30px;'>
                <tr>
                    <td><strong>Booking ID:</strong> #{$booking['booking_code']}</td>
                    <td align='right'><strong>Date:</strong> " . date('d-M-Y') . "</td>
                </tr>
            </table>
            <table width='100%' border='0' cellpadding='12' style='border-collapse: collapse; margin-top: 20px;'>
                <thead>
                    <tr style='background-color: #6f42c1; color: white;'>
                        <th align='left'>Description</th>
                        <th align='right'>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style='background-color: #f9f9f9;'>
                        <td style='border-bottom: 1px solid #eee;'>{$category->category_name}</td>
                        <td align='right' style='border-bottom: 1px solid #eee;'>₹" . number_format($booking['rent'], 2) . "</td>
                    </tr>
                    <tr>
                        <td align='right'><strong>Total Paid:</strong></td>
                        <td align='right'><strong>₹" . number_format($booking['rent'], 2) . "</strong></td>
                    </tr>
                </tbody>
            </table>
            <div style='margin-top: 30px; border: 1px dashed #ccc; padding: 10px;'>
                <p style='margin:0; font-size: 13px;'><strong>PayPal Order ID:</strong> {$paypalOrderID}</p>
                <p style='margin:0; font-size: 13px;'><strong>Status:</strong> Payment Confirmed</p>
            </div>
            <div style='margin-top: 50px; text-align: center;'>
                <p style='font-size: 14px; font-weight: bold;'>Thank you for choosing YooRental!</p>
            </div>
        </div>";
        $mpdf->WriteHTML($html);
        $folderPath = FCPATH . "invoice/";
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        $fileName = $booking['booking_code'] . ".pdf";
        $mpdf->Output($folderPath . $fileName, 'F');
    }
    public function downloadInvoice($code)
    {
        $filePath = FCPATH . "invoice/" . $code . ".pdf";
        if (file_exists($filePath)) {
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'inline; filename="Invoice-' . $code . '.pdf"')
                ->setBody(file_get_contents($filePath));
        } else {
            return "Error: Invoice file not found. Please contact support.";
        }
    }
    /***************** CONTACT SAVE **************************/
    public function contact()
    {
        return view('contact');
    }
    public function contact_save()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'name'    => 'required|min_length[3]',
                'phone'   => 'required|numeric|exact_length[10]',
                'email'   => 'required|valid_email',
                'message' => 'required|min_length[5]'
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors(),
                    'csrf_token' => csrf_hash()
                ]);
            }

            $data = [
                'name'     => $this->request->getPost('name'),
                'phone'    => $this->request->getPost('phone'),
                'email'    => $this->request->getPost('email'),
                'message'  => $this->request->getPost('message'),
                'status'   => 1,
                'added_at' => date('Y-m-d H:i:s')
            ];

            $res = $this->commonmodel->insertRecord('tbl_contact', $data);

            if ($res) {
                return $this->response->setJSON([
                    'status'     => 'success',
                    'message'    => '✅ Thank you! Your message has been sent.',
                    'csrf_token' => csrf_hash()
                ]);
            } else {
                return $this->response->setJSON([
                    'status'     => 'error',
                    'message'    => 'Database Error: Could not save data.',
                    'csrf_token' => csrf_hash()
                ]);
            }
        }
        return redirect()->to('/contact');
    }
}
