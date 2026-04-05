<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>
<link href="<?= base_url('/assets/css/style.css') ?>" rel="stylesheet">

<div class="content-wrapper">
    <div class="card purple-card shadow-lg">
        <div class="card-header text-white d-flex justify-content-between align-items-center"
            style="background: linear-gradient(135deg,#6f42c1,#8e44ad);">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-pencil-square me-2"></i> View User
            </h5>
            <a href="<?= base_url('admin/users') ?>"
                class="btn btn-sm btn-light fw-semibold">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>
        </div>
        <div class="card-body">
            <?php if (isset($user) && !empty($user)): ?>
                <table class="table table-bordered table-hover align-middle">
                    <tr>
                        <th>User ID</th>
                        <td><?= $user->user_id ?></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><?= $user->name ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $user->email ?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?= $user->phone ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?= $user->address ?></td>
                    </tr>
                    <tr>
                        <th>Create Date</th>
                        <td><?= $user->created_at ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php if ($user->status == 1): ?>
                                <span class="status-badge">Active</span>
                            <?php else: ?>
                                <span class="status-badge bg-danger">Inactive</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>

            <?php else: ?>
                <div class="alert alert-warning">No user data available.</div>
            <?php endif; ?>

        </div>

        <!-- Footer -->
        <div class="card-footer d-flex justify-content-between flex-wrap">

            <a href="<?= base_url('admin/users') ?>" class="btn purple-btn">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>

            <div>
                <a href="<?= base_url('admin/edit_user/' . $user->user_id) ?>" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>

                <a href="<?= base_url('admin/delete_user/' . $user->user_id) ?>" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Delete
                </a>
            </div>

        </div>

    </div>
</div>

<?= $this->endSection() ?>