<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="page-title mb-0">Service List</h1>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="<?= base_url('admin'); ?>">Admin</a>
            </li>
            <li class="breadcrumb-item active">
                Service
            </li>
        </ol>
    </div>
    <div class="card">
        <div class="card-body">
            <?php if (session()->getFlashdata('message')): ?>
                <?php
                $type = session()->getFlashdata('type');
                $alertClass = ($type === 'success') ? 'alert-success' : 'alert-danger';
                ?>
                <div id="flashMessage" class="alert <?= $alertClass ?> alert-dismissible fade show small" role="alert">
                    <?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <script>
                    setTimeout(() => {
                        let alert = document.getElementById('flashMessage');
                        if (alert) {
                            let bsAlert = new bootstrap.Alert(alert);
                            bsAlert.close();
                        }
                    }, 4000);
                </script>
            <?php endif; ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="index-title">service Index</h5>
                <?php if (is_privilege(7, 2)) { ?>
                    <a href="<?= base_url('admin/add-service') ?>" class="btn btn-primary btn-sm">Add Service</a>
                <?php } ?>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Service Name</th>
                            <th>Status</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($servicelist)) {
                            $n = 1;
                            foreach ($servicelist as $list) {
                        ?>
                                <tr>
                                    <td><?= $n++; ?></td>
                                    <td><?= $list->service_name ?></td>
                                    <td>
                                        <?php if ($list->status) { ?>
                                            <span class="status-badge">Active</span>
                                        <?php } else { ?>
                                            <span class="status-badge bg-danger">Inactive</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if (is_privilege(7, 4)) { ?>
                                            <a href="<?= base_url('admin/view-service/' . $list->service_id) ?>" title="View" class="action-icon mdi mdi-eye"><i class="mdi mdi-square-eye-outline"></i></a>
                                        <?php } ?>
                                        <?php if (is_privilege(7, 3)) { ?>
                                            <a href="<?= base_url('admin/edit-service/' . $list->service_id) ?>" title="Edit" class="action-icon edit-icon"><i class="mdi mdi-square-edit-outline"></i></a>
                                        <?php } ?>
                                        <?php if (is_privilege(7, 5)) { ?>
                                            <a href="<?= base_url('admin/delete-service/' . $list->service_id) ?>" title="Delete"
                                                class="action-icon delete-icon" onclick="return confirm('Are you sure?');"><i class="mdi mdi-delete"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<tr>
                            <td colspan="4"class="text-center text-danger">No record available</td>
                        </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>