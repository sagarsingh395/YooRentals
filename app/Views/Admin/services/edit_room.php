<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>

<div class="content-wrapper">
    <h3>Edit Room</h3>

    <form method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <input type="hidden" name="service_id" value="<?= $room->service_id ?>">

        <div class="form-group">
            <label>Room Name</label>
            <input type="text" name="room_name" value="<?= $room->room_name ?>" class="form-control">
            <span class="text-danger"><?= isset($validation['room_name']) ? $validation['room_name'] : '' ?></span>

        </div>

        <div class="form-group">
            <label>Price</label>
            <input type="text" name="price" value="<?= $room->price ?>" class="form-control">
            <span class="text-danger"><?= isset($validation['price']) ? $validation['price'] : '' ?></span>
        </div>

        <div class="form-group">
            <label>Type</label>
            <input type="text" name="type" value="<?= $room->type ?>" class="form-control">
            <span class="text-danger"><?= isset($validation['type']) ? $validation['type'] : '' ?></span>
        </div>

        <div class="form-group">
            <label>Old Image</label><br>
            <img src="<?= base_url($room->image) ?>" width="100">
            <span class="text-danger"><?= isset($validation['image']) ? $validation['image'] : '' ?></span>
        </div>

        <div class="form-group">
            <label>Change Image</label>
            <input type="file" name="image" class="form-control">
            <span class="text-danger"><?= isset($validation['image']) ? $validation['image'] : '' ?></span>
        </div>

        <div class="form-group">
            <label>Status</label><br>
            <input type="radio" name="status" value="1" <?= ($room->status == 1) ? 'checked' : '' ?>> Active
            <input type="radio" name="status" value="0" <?= ($room->status == 0) ? 'checked' : '' ?>> Inactive
            <span class="text-danger"><?= isset($validation['status']) ? $validation['status'] : '' ?></span>
        </div>

        <button class="btn btn-primary">Update</button>
        <button class="btn btn-secondary" type="reset">Reset</button>
        <a href="<?= base_url('admin/view-service' )?>" class="btn btn-warning">Cancel</a>
    </form>
</div>

<?= $this->endSection() ?>