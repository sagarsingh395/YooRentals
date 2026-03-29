<!DOCTYPE html>
<html>

<head>
    <title>Booking Page</title>
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID"></script>
</head>

<body>

    <div style="max-width:800px; margin:80px auto; font-family:Poppins, sans-serif;">

        <?php
        $item = $_GET['item'] ?? 'Not Selected';

        $price = 10;
        if (str_contains($item, 'Room')) {
            $price = 1000;
        } elseif (str_contains($item, 'Car')) {
            $price = 2000;
        } elseif (str_contains($item, 'Hall')) {
            $price = 5000;
        }
        ?>

        <div style="background:#fff; padding:30px; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.1);">

            <h2 style="text-align:center;">Booking Summary</h2>

            <p><b>Item:</b> <?= $item ?></p>
            <p><b>Price:</b> ₹<?= $price ?></p>

            <hr>

            <!-- FORM -->
            <form id="bookingForm">
                <input type="text" name="name" placeholder="Name" required><br><br>
                <input type="email" name="email" placeholder="Email" required><br><br>
                <input type="text" name="phone" placeholder="Phone" required><br><br>

                <input type="hidden" name="price" value="<?= $price ?>">
                <input type="hidden" name="item" value="<?= $item ?>">
            </form>

            <hr>

            <div id="paypal-button"></div>

        </div>
    </div>

    <script>
    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';

    paypal.Buttons({

        createOrder: function() {
            return fetch('<?= base_url('/create-order') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        [csrfName]: csrfHash
                    })
                })
                .then(res => res.json())
                .then(data => data.id);
        },

        onApprove: function(data) {

            const formData = new FormData(document.getElementById('bookingForm'));

            let obj = {};
            formData.forEach((value, key) => obj[key] = value);

            obj.orderID = data.orderID;

            return fetch('<?= base_url('/capture-order') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(obj)
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        alert("✅ Payment Success & Booking Saved");
                    } else {
                        alert("❌ Payment Failed");
                    }
                });
        }

    }).render('#paypal-button');
    </script>

</body>

</html>