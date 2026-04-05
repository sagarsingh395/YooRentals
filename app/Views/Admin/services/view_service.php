<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="page-title">View Service</h1>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Admin</a></li>
            <li class="breadcrumb-item active">view service</li>
        </ol>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <?php if (is_privilege(8, 2)) { ?>
                    <a href="<?= base_url('admin/add-category/' . $service->service_id) ?>" class="btn btn-success btn-sm">Add Category</a>
                <?php } ?>
                <?php /*<a href="<?= base_url('admin/edit-service') ?>" class="btn btn-warning btn-sm">Edit Service</a> */ ?>
                <a href="<?= base_url('admin/service') ?>" class="btn btn-primary btn-sm">Back</a>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="index-title">Service Details</h5>
        </div>
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
            <div class="row mb-2">
                <div class="col-sm-3"><strong>Service Name :</strong></div>
                <div class="col-sm-9"><?= esc($service->service_name ?? '') ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-3"><strong>Status :</strong></div>
                <div class="col-sm-9">
                    <?= ($service->status == 1) ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="index-title">Category List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Category Name</th>
                            <th>Property Status</th>
                            <th>Rent</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categorylist)) : ?>
                            <?php foreach ($categorylist as $key => $category) : ?>
                                <td><?= $key + 1 ?></td>
                                <td>
                                    <img src="<?= base_url(CA_PATH . $category->image) ?>"
                                        width="100"
                                        data-bs-toggle="modal"
                                        data-bs-target="#imgModal<?= $category->category_id ?>"
                                        style="cursor:pointer; border-radius:0;">
                                </td>
                                <!-- Modal -->
                                <div class="modal fade" id="imgModal<?= $category->category_id ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <img src="<?= base_url(CA_PATH . $category->image) ?>" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <td><?= esc($category->category_name) ?></td>
                                <td>
                                    <?php if ($category->property_status == 1): ?>
                                        <span class="badge bg-success">Available</span>
                                    <?php elseif ($category->property_status == 2): ?>
                                        <span class="badge bg-danger">Booked</span>
                                    <?php elseif ($category->property_status == 3): ?>
                                        <span class="badge bg-warning text-dark">Maintenance</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($category->rent) ?></td>
                                <td><?= esc($category->type) ?></td>
                                <td>
                                    <?php if ($category->status) { ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php } else { ?>
                                        <span class="badge bg-danger">Inactive</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if (is_privilege(8, 3)) { ?>
                                        <a href="<?= base_url('admin/edit-category/' . $category->category_id) ?>" title="Edit"
                                            class="action-icon edit-icon"><i class="mdi mdi-square-edit-outline"></i></a>
                                    <?php } ?>
                                    <?php if (is_privilege(8, 5)) { ?>
                                        <a href="<?= base_url('admin/delete-category/' . $category->category_id) ?>"
                                            class="action-icon delete-icon" onclick="return confirm('Are you sure?');"><i
                                                class="mdi mdi-delete"></i></a>
                                    <?php } ?>
                                </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center">No Categories Found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>