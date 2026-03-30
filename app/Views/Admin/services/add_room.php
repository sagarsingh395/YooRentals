<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>

<div class="content-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="page-title">Add Category</h1>
        <a href="<?= base_url('admin/view-service/' . $service_id) ?>" class="btn btn-primary btn-sm">Back</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="index-title">Add Room</h5>
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <!-- Hidden Service ID -->
                <input type="hidden" name="service_id" value="<?= $service_id ?>">

                <!-- Room Name -->
                <div class="form-group mb-2">
                    <label>Room Name</label>
                    <input type="text" name="room_name" value="<?= old('room_name') ?>"class="form-control">
                    <span class="text-danger"><?= $validation['room_name'] ?? '' ?></span>
                </div>

                <!-- Price -->
                <div class="form-group mb-2">
                    <label>Price</label>
                    <input type="text" name="price"value="<?= old('price') ?>" class="form-control">
                    <span class="text-danger">
                        <?= $validation['price'] ?? '' ?>
                    </span>
                </div>

                <!-- Type -->
                <div class="form-group mb-2">
                    <label>Type</label>
                    <input type="text" name="type" 
                           value="<?= old('type') ?>" 
                           class="form-control">
                    <span class="text-danger">
                        <?= $validation['type'] ?? '' ?>
                    </span>
                </div>

                <!-- Image -->
                <div class="form-group mb-2">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <!-- Status -->
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

                <!-- Buttons -->
                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                <a href="<?= base_url('admin/view-service/' . $service_id) ?>" 
                   class="btn btn-warning btn-sm">Cancel</a>

            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>