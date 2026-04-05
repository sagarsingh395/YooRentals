<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="page-title mb-0">Edit Category</h1>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Admin</a></li>
            <li class="breadcrumb-item active">edit-category</li>
        </ol>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="index-title">Edit Category</h5>
            <a href="<?= base_url('admin/view-service/' . $category->service_id) ?>" class="btn btn-primary btn-sm">
                Back
            </a>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="service_id" value="<?= $category->service_id ?>">
                <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" name="category_name" value="<?= $category->category_name ?>" class="form-control">
                    <span class="text-danger"><?= isset($validation['category_name']) ? $validation['category_name'] : '' ?></span>
                </div>
                <div class="form-group">
                    <label>Property Status</label><br>
                    <input type="radio" name="property_status" value="1" <?= ($category->property_status == 1) ? 'checked' : '' ?>>
                    <span class="badge bg-success">Available</span>
                    <input type="radio" name="property_status" value="2" <?= ($category->property_status == 2) ? 'checked' : '' ?>>
                    <span class="badge bg-danger">Booked</span>
                    <input type="radio" name="property_status" value="3" <?= ($category->property_status == 3) ? 'checked' : '' ?>>
                    <span class="badge bg-warning text-dark">Maintenance</span>
                </div>
                <div class="form-group">
                    <label>Rent</label>
                    <input type="text" name="rent" value="<?= $category->rent ?>" class="form-control">
                    <span class="text-danger"><?= isset($validation['rent']) ? $validation['rent'] : '' ?></span>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <input type="text" name="type" value="<?= $category->type ?>" class="form-control">
                    <span class="text-danger"><?= isset($validation['type']) ? $validation['type'] : '' ?></span>
                </div>
                <div class="form-group">
                    <label>Change Image</label>
                    <input type="file" name="image" class="form-control">
                    <span class="text-danger"><?= isset($validation['image']) ? $validation['image'] : '' ?></span>
                </div>
                <div class="form-group">
                    <label>Status</label><br>
                    <input type="radio" name="status" value="1" <?= ($category->status == 1) ? 'checked' : '' ?>> Active
                    <input type="radio" name="status" value="0" <?= ($category->status == 0) ? 'checked' : '' ?>> Inactive
                    <br>
                    <span class="text-danger"><?= isset($validation['status']) ? $validation['status'] : '' ?></span>
                </div>
                <button class="btn btn-primary btn-sm">Update</button>
                <button class="btn btn-secondary btn-sm" type="reset">Reset</button>
                <a href="<?= base_url('admin/view-service/' . $category->service_id) ?>"
                    class="btn btn-warning btn-sm">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>