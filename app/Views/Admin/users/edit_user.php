<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>
<?= $this->include('pluging'); ?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card shadow border-0">

            <!-- Purple Header -->
            <div class="card-header text-white d-flex justify-content-between align-items-center"
                 style="background: linear-gradient(135deg,#6f42c1,#8e44ad);">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-pencil-square me-2"></i> Edit User
                </h5>
                <a href="<?= base_url('admin/users') ?>" 
                   class="btn btn-sm btn-light fw-semibold">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
            </div>

            <!-- Body -->
            <div class="card-body bg-light">

                <?php if (session()->getFlashdata('message')): ?>
                    <div class="alert alert-<?= session()->getFlashdata('type') ?> alert-dismissible fade show small">
                        <?= session()->getFlashdata('message') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger small"><?= esc($error) ?></div>
                <?php endif; ?>

                <form action="<?= current_url() ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="row justify-content-center">
                        <div class="col-lg-7">

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">User Name</label>
                                <input type="text" name="name"
                                    value="<?= set_value('name', $user->name) ?>"
                                    class="form-control border"
                                    style="border-color:#6f42c1;">
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email"
                                    value="<?= set_value('email', $user->email) ?>"
                                    class="form-control">
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="number" name="phone"
                                    value="<?= set_value('phone', $user->phone) ?>"
                                    class="form-control">
                            </div>

                            <!-- Photo -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Photo</label>
                                <input type="file" name="image"
                                    class="form-control">
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold d-block">Status</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"
                                        type="radio" name="status"
                                        value="1"
                                        <?= ($user->status == 1) ? 'checked' : '' ?>>
                                    <label class="form-check-label text-success">
                                        Active
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"
                                        type="radio" name="status"
                                        value="0"
                                        <?= ($user->status < 1) ? 'checked' : '' ?>>
                                    <label class="form-check-label text-danger">
                                        Inactive
                                    </label>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="submit"
                                        class="btn text-white"
                                        style="background-color:#6f42c1;">
                                    <i class="bi bi-check-circle"></i> Update
                                </button>

                                <button type="reset"
                                        class="btn btn-outline-secondary">
                                    Reset
                                </button>

                                <a href="<?= base_url('admin/users') ?>"
                                   class="btn btn-secondary">
                                    Back
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
