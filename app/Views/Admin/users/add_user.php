<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card shadow-lg border-0">

            <!-- Header -->
            <div class="card-header text-white py-3" style="background: linear-gradient(135deg,#6f42c1,#8e44ad);">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-person-plus-fill me-2"></i> Add User
                    </h4>
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-light btn-sm fw-semibold">
                        <i class="bi bi-arrow-left-circle"></i> Back
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body bg-light p-4">
                <form action="<?= current_url() ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="row justify-content-center">
                        <div class="col-md-8">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">User Name</label>
                                <input type="text" name="name" value="<?= set_value('name') ?>"
                                    class="form-control rounded-3 shadow-sm">
                                <span class="text-danger small">
                                    <?= (isset($validation)) ? $validation->showError('name') : '' ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="text" name="email" value="<?= set_value('email') ?>"
                                    class="form-control rounded-3 shadow-sm">
                                <span class="text-danger small">
                                    <?= (isset($validation)) ? $validation->showError('email') : '' ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="number" name="phone" value="<?= set_value('phone') ?>"
                                    class="form-control rounded-3 shadow-sm">
                                <span class="text-danger small">
                                    <?= (isset($validation)) ? $validation->showError('phone') : '' ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Photo</label>
                                <input type="file" name="image" value="<?= set_value('image') ?>" class="form-control">
                                <span
                                    class="text-danger"><?= (isset($validation)) ? $validation->showError('image') : '' ?></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" value="<?= set_value('password') ?>"
                                    class="form-control rounded-3 shadow-sm">
                                <span class="text-danger small">
                                    <?= (isset($validation)) ? $validation->showError('password') : '' ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Confirm Password</label>
                                <input type="password" name="cpassword" value="<?= set_value('cpassword') ?>"
                                    class="form-control rounded-3 shadow-sm">
                                <span class="text-danger small">
                                    <?= (isset($validation)) ? $validation->showError('cpassword') : '' ?>
                                </span>
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold d-block">Status</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" value="1" checked>
                                    <label class="form-check-label text-success fw-semibold">
                                        Active
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" value="0">
                                    <label class="form-check-label text-danger fw-semibold">
                                        Inactive
                                    </label>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn text-white px-4 fw-semibold"
                                    style="background-color:#6f42c1;">
                                    <i class="bi bi-check-circle me-1"></i> Submit
                                </button>

                                <button type="reset" class="btn btn-outline-secondary px-4 fw-semibold">
                                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                                </button>

                                <a href="<?= base_url('admin/users') ?>" class="btn text-white px-4 fw-semibold"
                                    style="background-color:#8e44ad;">
                                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>