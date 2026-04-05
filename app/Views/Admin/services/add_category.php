<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="page-title">Add New Category</h1>
        <a href="<?= base_url('admin/view-service/' . $service_id) ?>" class="btn btn-primary btn-sm">Back</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="index-title">Add Category</h5>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="service_id" value="<?= $service_id ?>">
                <div class="form-group mb-2">
                    <label>Category Name</label>
                    <input type="text" name="category_name" value="<?= old('category_name') ?>" class="form-control">
                    <span class="text-danger"><?= isset($validation['category_name']) ? $validation['category_name'] : '' ?></span>
                </div>
                <div class="form-group">
                    <label>Property Status</label><br>
                    <input type="radio" name="property_status" value="1" checked>
                    <span class="badge bg-success">Available</span>
                    <input type="radio" name="property_status" value="2">
                    <span class="badge bg-danger">Rented</span>
                    <input type="radio" name="property_status" value="3">
                    <span class="badge bg-warning text-dark">Maintenance</span>
                    <br>
                    <span class="text-danger"><?= isset($validation['property_status']) ? $validation['property_status'] : '' ?></span>
                </div>
                <div class="form-group mb-2">
                    <label>Rent</label>
                    <input type="text" name="rent" value="<?= old('rent') ?>" class="form-control">
                    <span class="text-danger">
                        <?= $validation['rent'] ?? '' ?>
                    </span>
                </div>
                <div class="form-group mb-2">
                    <label>Type</label>
                    <input type="text" name="type" value="<?= old('type') ?>" class="form-control">
                    <span class="text-danger"><?= $validation['type'] ?? '' ?></span>
                </div>
                <div class="form-group mb-2">
                    <label>Image</label>
                    <input type="file" name="image" value="<?= set_value('image') ?>" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label>Status</label><br>
                    <input type="radio" name="status" value="1"
                        <?= old('status', 1) == 1 ? 'checked' : '' ?>> Active
                    <input type="radio" name="status" value="0"
                        <?= old('status') == 0 ? 'checked' : '' ?>> Inactive
                    <br>
                    <span class="text-danger">
                        <?= $validation['status'] ?? '' ?>
                    </span>
                </div>
                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                <a href="<?= base_url('admin/view-service/' . $service_id) ?>" class="btn btn-warning btn-sm">Cancel</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>