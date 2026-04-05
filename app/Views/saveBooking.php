<title>Booking</title>
<link href="<?= base_url('assets/users/css/bootstrap.min.css') ?>" rel="stylesheet">
<link rel="shortcut icon" href="<?= base_url('assets/admin/images/logo1a.png') ?>" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .card-box {
        background: #fff;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .left img {
        border-radius: 10px;
        height: 250px;
        object-fit: cover;
    }

    .price {
        font-size: 22px;
        font-weight: bold;
        color: green;
    }
</style>
<div class="container mt-5 pt-5">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card-box left">
                <img src="<?= base_url('assets/upload/categories/' . $item->image) ?>" class="img-fluid mb-3">
                <h3><?= $item->category_name ?></h3>
                <p class="price">₹<?= $item->rent ?></p>
                <p>Comfortable stay with best facilities.</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-box">
                <h4 class="mb-3">Customer Details</h4>
                <form id="bookingForm">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="category_id" value="<?= $item->category_id ?>">
                    <div class="mb-3">
                        <input type="text" id="name" name="name" class="form-control" placeholder="Full Name">
                        <span class="text-danger error-text name_error" style="font-size: 13px;"></span>
                    </div>
                    <div class="mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email Address">
                        <span class="text-danger error-text email_error" style="font-size: 13px;"></span>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number">
                        <span class="text-danger error-text phone_error" style="font-size: 13px;"></span>
                    </div>
                </form>
                <script src="https://www.paypal.com/sdk/js?client-id=<?= getenv('PAYPAL_CLIENT_ID') ?>"></script>
                <?php /* <script src="https://www.paypal.com/sdk/js?client-id=<?= getenv('PAYPAL_CLIENT_ID') ?>&currency=<?= $display_currency ?>&disable-funding=card"></script> 
                <script src="https://www.paypal.com/sdk/js?client-id=<?= getenv('PAYPAL_CLIENT_ID') ?>&currency=<?= $display_currency ?>"></script> */ ?>
                <a href="<?= base_url('/') ?>" class="btn btn-danger w-100 mt-3">Cancel Booking</a>
                <div id="paypal-button-container" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const csrfName = '<?= csrf_token() ?>';
    let csrfHash = '<?= csrf_hash() ?>';
    paypal.Buttons({
        onClick: function(data, actions) {
            let isValid = true;
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();

            document.querySelector('.name_error').innerHTML = '';
            document.querySelector('.email_error').innerHTML = '';
            document.querySelector('.phone_error').innerHTML = '';

            if (name === '') {
                document.querySelector('.name_error').innerHTML = 'Name is required';
                isValid = false;
            }
            if (email === '') {
                document.querySelector('.email_error').innerHTML = 'Email is required';
                isValid = false;
            } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                document.querySelector('.email_error').innerHTML = 'Invalid email';
                isValid = false;
            }
            if (phone === '') {
                document.querySelector('.phone_error').innerHTML = 'Phone is required';
                isValid = false;
            } else if (!/^[0-9]{10,12}$/.test(phone)) {
                document.querySelector('.phone_error').innerHTML = 'Invalid phone number';
                isValid = false;
            }
            if (!isValid) {
                Swal.fire('Error', 'Please fill all required fields correctly', 'error');
                return actions.reject();
            }
            return actions.resolve();
        },
        createOrder: function(data, actions) {
            return fetch("<?= base_url('create-order') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        category_id: "<?= $item->category_id ?>"
                    })
                })
                .then(res => res.json())
                .then(order => {
                    if (!order.id) {
                        throw new Error("Order ID missing from server");
                    }
                    return order.id;
                });
        },
        onApprove: function(data, actions) {
            Swal.fire({
                title: 'Processing Payment...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading()
            });
            return actions.order.capture().then(function(details) {

                const payer = details.payer || {};
                const nameObj = payer.name || {};
                const purchase = details.purchase_units?.[0] || {};
                const shipping = purchase.shipping?.address || {};
                const fullName = (nameObj.given_name || '') + ' ' + (nameObj.surname || '');
                const email = payer.email_address || '';
                const address = [
                    shipping.address_line_1 || '',
                    shipping.admin_area_2 || '',
                    shipping.admin_area_1 || '',
                    shipping.postal_code || '',
                    shipping.country_code || ''
                ].filter(Boolean).join(', ');

                const postData = {
                    orderID: data.orderID,
                    category_id: "<?= $item->category_id ?>",
                    form_name: document.getElementById('name').value,
                    form_email: document.getElementById('email').value,
                    form_phone: document.getElementById('phone').value,
                    card_name: fullName,
                    card_email: email,
                    billing_address: address
                };
                return fetch("<?= base_url('capture-order') ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(postData)
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Payment Successful!',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "<?= base_url('invoice') ?>/" + res.booking_code;
                            });
                        } else {
                            Swal.fire('Error', res.message || 'Failed', 'error');
                        }
                    });
            });
        },
        onError: function(err) {
            console.log(err);
            Swal.fire('Error', 'Payment failed', 'error');
        }
    }).render('#paypal-button-container');
</script>
<script src="<?= base_url('assets/admin/js/error_remove.js') ?>"></script>