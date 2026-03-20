<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>
<div class="content-wrapper">
    <main>
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h2>Change Password</h2>
                    <a href="<?= base_url('/admin') ?>" class="btn btn-info">Back</a>
                </div>
                
            </div>
            <?php if (session()->has('message')) {
                echo session()->get('message');
            } ?>

            <div class="card shadow-lg border-0 mb-4">
                <div class="card-body">
                    <form autocomplete="off" action="<?= base_url('admin/profile/change_password') ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-8 my-2">
                                <div class="form-group">
                                    <label for="pwd">New Password</label>
                                    <input type="password" class="form-control" name="pwd" id="pwd"
                                        value="<?= set_value('pwd'); ?>" placeholder="Enter Password">
                                    <span
                                        class="text-danger"><?= isset($validation) ? $validation->showError('pwd') : ''; ?></span>
                                </div>
                            </div>
                            <div class="col-md-8 my-2">
                                <div class="form-group">
                                    <label for="cpwd">Confirm Password</label>
                                    <input type="password" class="form-control" name="cpwd" id="cpwd"
                                        value="<?= set_value('cpwd'); ?>" placeholder="Enter Confirm Password">
                                    <span
                                        class="text-danger"><?= isset($validation) ? $validation->showError('cpwd') : ''; ?></span>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary me-3">Submit</button>

                    </form>
                </div>
            </div>
        <!-- </div> -->
    </main>
</div>

<?= $this->endSection() ?>