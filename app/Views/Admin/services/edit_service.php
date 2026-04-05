<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>

<div class="content-wrapper">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="page-title mb-0">Service</h1>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Admin</a></li>
            <li class="breadcrumb-item active">Edit-service</li>
        </ol>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="index-title">Edit service</h5>
            <a href="<?= base_url('admin/service') ?>" class="btn btn-primary btn-sm">Back</a>
        </div>
        <div class="card-body">
            <form action="<?= current_url(); ?>" method="POST">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $prev_details->service_id ?>">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Service Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="service_name" id="service_name" value="<?= $prev_details->service_name ?? '' ?>" placeholder="Service Name">
                        <span class="text-danger"><?= isset($validation['service_name']) ? $validation['service_name'] : '' ?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Status</label>
                    <?php
                    if (isset($prev_details->status)) {
                        $status = $prev_details->status;
                    } else {
                        $status = '';
                    }
                    ?>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="1" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="0">
                            <label class="form-check-label">Inactive</label>
                        </div>
                        <span
                            class="text-danger"><?= isset($validation['status']) ? $validation['status'] : '' ?></span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                <a href="<?= base_url('admin/service') ?>" class="btn btn-warning btn-sm">Cancel</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>