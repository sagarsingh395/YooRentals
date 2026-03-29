<?= $this->extend("_layout/master") ?>
<?= $this->section("content") ?>

<!-- Product Grid -->
<div class="container">
    <div class="row g-4">

        <!-- Product Card 1 -->
        <?php if (!empty($products)) {
            foreach ($products as $list) { ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 text-center">
                        <a href="<?= base_url('product/' . $list->url) ?>" style="text-decoration:none;">
                            <img src="<?= base_url('public/assets/upload/images/' . $list->image) ?>"
                                class="img-fluid mx-auto d-block mt-3" alt="<?= $list->product_name ?>"
                                style="width: 120px; height: 120px; object-fit: contain;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= $list->product_name ?></h5>
                            <p class="card-text text-success fw-bold">₹<?= $list->price ?> <small
                                    class="text-muted">(<?= $list->unit . $list->measur ?>)</small></p>
                            <button class="btn btn-warning mt-auto add-to-cart" data-pro_id="<?= $list->pro_id ?>">Add to
                                Cart</button>
                        </div>
                    </div>
                </div>
        <?php }
        } else {
            echo '<p class="text-danger">Product not available</p>';
        } ?>



    </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=<?= getenv('PAYPAL_CLIENT_ID') ?>"></script>

<div id="paypal-button"></div>

<script>
    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';

    paypal.Buttons({
        fundingSource: paypal.FUNDING.CARD,
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

            return fetch('<?= base_url('/capture-order') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        orderID: data.orderID,

                    })
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    if (res.status === 'success') {
                        alert("✅ Payment Success");
                    } else {
                        alert("❌ Failed");
                    }
                });
        }

    }).render('#paypal-button');
</script>