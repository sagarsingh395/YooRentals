<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>
<?= $this->include('pluging'); ?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card shadow border-0">

            <!-- Purple Header -->
            <div class="card-header text-white text-center"
                 style="background: linear-gradient(135deg,#6f42c1,#8e44ad);">
                <h4 class="mb-0 fw-bold">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Delete User
                </h4>
            </div>

            <!-- Body -->
            <div class="card-body text-center bg-light py-5">

                <div class="mb-4">
                    <h5 class="fw-semibold text-danger">
                        Are you sure you want to delete this user?
                    </h5>

                    <p class="mt-3">
                        <strong>
                            <?= $user->name; ?>
                            <br>
                            <span class="text-muted">
                                (<?= $user->email; ?> , <?= $user->phone ?>)
                            </span>
                        </strong>
                    </p>
                </div>

                <form action="<?= base_url('admin/doDelete/' . $user->user_id) ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="d-flex justify-content-center gap-3 flex-wrap">

                        <button type="submit"
                                class="btn btn-danger px-4 fw-semibold"
                                onclick="return confirm('Are you sure you want to delete this user?')">
                            <i class="bi bi-trash"></i> Yes, Delete
                        </button>

                        <a href="<?= base_url('admin/users') ?>"
                           class="btn text-white px-4 fw-semibold"
                           style="background-color:#6f42c1;">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>

                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
