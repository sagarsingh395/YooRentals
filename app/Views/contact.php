<footer class="bg-light text-dark">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">YooRental</h4>
                        <p>All rentals in one platform</p>
                        <p><strong>Phone:</strong> +91 98765 43210</p>
                        <p><strong>Email:</strong> support@yoorental.com</p>
                        <p><strong>Address:</strong> Arrah, Bihar, India</p>
                    </div>
                </div>
            </div>
            <!-- Contact Form -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Contact Us</h5>
                        <form id="contactForm" method="POST" class="row g-3">
                            <?= csrf_field() ?>
                            <div class="col-md-6">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Full Name">
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone Number">
                            </div>
                            <div class="col-md-12">
                                <input type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com">
                            </div>
                            <div class="col-12">
                                <textarea name="message" id="message" class="form-control" rows="3" placeholder="Your Message"></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <div id="statusMsg"></div>
                                <button type="submit" id="submitBtn" class="btn btn-primary w-100">Send Message</button>
                            </div>
                        </form>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                $("#contactForm").on("submit", function(e) {
                                    e.preventDefault();
                                    let submitBtn = $("#submitBtn");
                                    let statusMsg = $("#statusMsg");
                                    submitBtn.prop('disabled', true).text("Sending...");
                                    $(".error-msg").remove();
                                    $.ajax({
                                        url: "<?= base_url('contact/save') ?>",
                                        type: "POST",
                                        data: $(this).serialize(),
                                        dataType: "json",
                                        success: function(response) {
                                            if (response.csrf_token) {
                                                $('input[name="<?= csrf_token() ?>"]').val(response.csrf_token);
                                            }
                                            if (response.status === 'error') {
                                                if (response.errors) {
                                                    $.each(response.errors, function(key, value) {
                                                        $("#" + key).after(
                                                            '<div class="text-danger error-msg" style="font-size:12px; text-align:left;">' + value + '</div>'
                                                        );
                                                    });
                                                } else {
                                                    alert(response.message);
                                                }
                                            } else {
                                                alert(response.message);
                                                $("#contactForm")[0].reset();
                                            }
                                        },
                                        error: function(xhr) {
                                            console.log(xhr.responseText);
                                            alert("Something went wrong.");
                                        },
                                        complete: function() {
                                            submitBtn.prop('disabled', false).text("Send Message");
                                        }
                                    });
                                });
                            });
                        </script>
                        <script src="<?= base_url('assets/admin/js/error_remove.js') ?>"></script>