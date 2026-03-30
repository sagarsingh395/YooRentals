<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>

<style>
    .page-title {
        font-size: 26px;
        font-weight: 600;
    }

    .index-title {
        color: #4e73df;
        font-weight: 500;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .delete-icon {
        color: #dc3545
    }
</style>

<div class="content-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="page-title">View Service</h1>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <a href="<?= base_url('admin/add-room/' . $service->service_id) ?>"
                    class="btn btn-success btn-sm">
                    Add Category
                </a>
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
                    <?= ($service->status == 1) ? 'Active' : 'Inactive' ?>
                </div>
            </div>

        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5 class="index-title">Room List</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Room Name</th>
                            <th>Price</th>
                            <th>Type</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($roomlist)) : ?>
                            <?php foreach ($roomlist as $key => $room) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><img src="<?= esc(CA_PATH . $room->image) ?>" alt="Room Image" width="100"></td>
                                    <td><?= esc($room->room_name) ?></td>
                                    <td><?= esc($room->price) ?></td>
                                    <td><?= esc($room->type) ?></td>
                                    <td>
                                        <?php if (is_privilege(1)) { ?>
                                            <a href="<?= base_url('admin/edit-room/' . $room->id) ?>"
                                                class="action-icon edit-icon"><i class="mdi mdi-square-edit-outline"></i></a>
                                        <?php } ?>
                                        <?php if (is_privilege(7, 5)) { ?>
                                            <a href="<?= base_url('admin/delete-room/' . $room->id) ?>"
                                                class="action-icon delete-icon" onclick="return confirm('Are you sure?');"><i
                                                    class="mdi mdi-delete"></i></a>
                                        <?php } ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center">No Rooms Found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>