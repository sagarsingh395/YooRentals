<div style="max-width:900px; margin:80px auto; font-family:Poppins, sans-serif;">

    <h2 style="margin-bottom:20px; font-weight:600;">Booking Details</h2>

    <?php
    $item = $_GET['item'] ?? 'Not Selected';

    $price = 0;
    if (str_contains($item, 'Room')) {
        $price = 1000;
    } elseif (str_contains($item, 'Car')) {
        $price = 2000;
    } elseif (str_contains($item, 'Hall')) {
        $price = 5000;
    }
    ?>

    <div style="background:#fff; padding:25px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1);">

        <h4>
            Selected Item:
            <span style="color:#0d6efd;"><?= esc($item) ?></span>
        </h4>

        <h5 style="margin-top:15px;">
            Price:
            <span style="color:green;">₹<?= $price ?></span>
        </h5>

        <hr style="margin:20px 0;">

        <!-- USER DETAILS -->
        <form>

            <div style="display:flex; gap:15px; margin-bottom:15px;">
                <div style="flex:1;">
                    <label>Name</label>
                    <input type="text" placeholder="Enter Name"
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
                </div>

                <div style="flex:1;">
                    <label>Email</label>
                    <input type="email" placeholder="Enter Email"
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
                </div>
            </div>

            <div style="display:flex; gap:15px;">
                <div style="flex:1;">
                    <label>Phone</label>
                    <input type="text" placeholder="Enter Phone"
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
                </div>

                <div style="flex:1;">
                    <label>Date</label>
                    <input type="date" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
                </div>
            </div>

        </form>

        <hr style="margin:25px 0;">

        <!-- PAYPAL BUTTON -->
        <h5 style="margin-bottom:15px;">Pay Now</h5>

        <div id="paypal-button"></div>

    </div>

</div>

<!-- PAYPAL SCRIPT -->
<script src="https://www.paypal.com/sdk/js?client-id=<?= getenv('PAYPAL_CLIENT_ID') ?>&currency=INR"></script>

<script>
const csrfName = '<?= csrf_token() ?>';
const csrfHash = '<?= csrf_hash() ?>';

paypal.Buttons({

    fundingSource: paypal.FUNDING.CARD,

    createOrder: function() {
        return fetch("<?= base_url('/create-order') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    amount: <?= $price ?>,
                    [csrfName]: csrfHash
                })
            })
            .then(res => res.json())
            .then(data => data.id);
    },

    onApprove: function(data) {
        return fetch("<?= base_url('/capture-order') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    orderID: data.orderID
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    alert("✅ Payment Successful!");
                    window.location.href = "<?= base_url('/') ?>";
                } else {
                    alert("❌ Payment Failed");
                }
            });
    }

}).render('#paypal-button');
</script>