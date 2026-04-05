 public function createOrder()
    {
        $baseURL = getenv('PAYPAL_BASE_URL');
        $token = paypalAccessToken();
        $data = $this->request->getJSON(true);
        $category = $this->commonmodel->getOneRecord('tbl_category', ['category_id' => $data['category_id']]);
        if (!$category) return $this->response->setJSON(['error' => 'Invalid category']);
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
        curl_close($ch);
        return $this->response->setJSON(json_decode($result, true));
    }
/*****************CAPTURE ORDER**************************/
    public function captureOrder()
    {
        $req = $this->request->getJSON(true);
        $rules = [
            'name'        => 'required|min_length[3]',
            'email'       => 'required|valid_email',
            'phone'       => 'required|numeric|min_length[10]|max_length[12]',
            'orderID'     => 'required',
            'category_id' => 'required'
        ];
        if (!$this->validateData($req, $rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors(),
                'csrf_token' => csrf_hash()
            ]);
        }
        $category = $this->commonmodel->getOneRecord('tbl_category', ['category_id' => $req['category_id']]);
        if (!$category) return $this->response->setJSON(['status' => 'error', 'message' => 'Category not found']);
        $booking_code = strtoupper(substr(md5(time()), 0, 6));
        $paymentData = [
            'booking_code'    => $booking_code,
            'payment'         => $category->rent,
            'orderID'         => "Paid via PayPal. OrderID: " . $req['orderID'],
            'payment_details' => json_encode($req),
            'created_at'      => date('Y-m-d H:i:s')
        ];
        $payment_id = $this->commonmodel->insertRecord('tbl_payment', $paymentData);
        $bookingData = [
            'booking_code'   => $booking_code,
            'category_id'    => $req['category_id'],
            'service_id'     => $category->service_id,
            'name'           => $req['name'],
            'email'          => $req['email'],
            'phone'          => $req['phone'],
            'rent'           => $category->rent,
            'payment_id'     => $payment_id,
            'payment_status' => 1,
            'status'         => 2,
            'created_at'     => date('Y-m-d H:i:s')
        ];

        try {
            $this->commonmodel->insertRecord('tbl_booking', $bookingData);
            $this->commonmodel->updateRecord('tbl_category', ['category_id' => $req['category_id']], ['status' => 2]);
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


//     paypal.Buttons({
//         onClick: function(data, actions) {
//             document.querySelectorAll('.error-text').forEach(el => el.innerText = "");

//             let name = document.querySelector('[name="name"]').value;
//             let email = document.querySelector('[name="email"]').value;
//             let phone = document.querySelector('[name="phone"]').value;

//             if (!name || !email || !phone) {
//                 alert("Please fill all details before payment.");
//                 return actions.reject();
//             }
//         },
//         createOrder: function() {
//             return fetch('<?= base_url('create-order') ?>', {
//                     method: 'POST',
//                     headers: {
//                         'Content-Type': 'application/json',
//                         'X-Requested-With': 'XMLHttpRequest',
//                         [csrfName]: csrfHash
//                     },
//                     body: JSON.stringify({
//                         category_id: document.querySelector('[name="category_id"]').value
//                     })
//                 })
//                 .then(res => res.json())
//                 .then(data => {
//                     if (data.id) return data.id;
//                     else alert("Could not initiate PayPal order.");
//                 });
//         },
//         onApprove: function(data) {
//             let formData = new FormData(document.getElementById('bookingForm'));
//             let obj = {};
//             formData.forEach((value, key) => obj[key] = value);
//             obj.orderID = data.orderID;

//             return fetch('<?= base_url('capture-order') ?>', {
//                     method: 'POST',
//                     headers: {
//                         'Content-Type': 'application/json',
//                         'X-Requested-With': 'XMLHttpRequest',
//                         [csrfName]: csrfHash
//                     },
//                     body: JSON.stringify(obj)
//                 })
//                 .then(res => res.json())
//                 .then(res => {
//                     if (res.status === 'success') {
//                         alert("✅ Booking Confirmed!");
//                         window.location.href = "<?= base_url('invoice') ?>/" + res.booking_code;
//                     } else {
//                         /* Input errors*/
//                         if (res.errors) {
//                             Object.keys(res.errors).forEach(key => {
//                                 let errorSpan = document.querySelector('.' + key + '_error');
//                                 if (errorSpan) errorSpan.innerText = res.errors[key];
//                             });
//                         }
//                         if (res.csrf_token) csrfHash = res.csrf_token;
//                     }
//                 });
//         }
//     }).render('#paypal-button');
