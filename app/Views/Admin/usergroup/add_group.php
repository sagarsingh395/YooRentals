<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>
<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="page-title mb-0">User Groups</h1>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Admin</a></li>
            <li class="breadcrumb-item active">add-group</li>
        </ol>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="index-title">Add Group</h5>
            <a href="<?= base_url('admin/user-group') ?>" class="btn btn-primary btn-sm">Back</a>
        </div>
        <div class="card-body">
            <form action="<?= current_url(); ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Group Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="group_name" placeholder="Group Name">
                        <span
                            class="text-danger"><?= isset($validation['group_name']) ? $validation['group_name'] : '' ?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Add Privilege</label>
                    <div class="col-sm-10">
                        <?php if (count($menulist) > 0) { ?>
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="AllPrivilege" name="" value="">
                                <label class="form-check-label">All Privilege</label>
                            </div>
                            <?php foreach ($menulist as $key => $menu) {
                                $disable = '';
                                if ($menu->menu_id == 2) {
                                    $disable = 'disabled';
                                }
                            ?>
                                <div class="row menu-row">
                                    <div class="col-md-3 menu-name">
                                        <div class="form-check">
                                            <input class="form-check-input privilege-checkbox" type="checkbox"
                                                name="menu_id[<?= $key ?>]" value="<?= $menu->menu_id ?>" <?= $disable ?>>
                                            <label class="form-check-label">
                                                <?= $menu->menu_name ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="checkbox-group">
                                            <input type="hidden" name="crudid[<?= $key ?>][]" value="1">
                                            <?php if ($menu->function != '') {
                                                $value = 2;
                                                $functionArr = explode(',', $menu->function);
                                                foreach ($functionArr as $fun) { ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input privilege-checkbox" type="checkbox"
                                                            name="crudid[<?= $key ?>][]" id="<?= $fun . $key ?>" value="<?= $value ?>"
                                                            <?= $disable ?>>
                                                        <label class="form-check-label" data-toggle="tooltip" data-placement="right"
                                                            title="<?= $value ?>"><?= $fun ?></label>
                                                    </div>
                                            <?php $value++;
                                                }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Status</label>
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
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                <a href="<?= base_url('admin/user-group') ?>" class="btn btn-warning btn-sm">Cancel</a>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // All Privilege
    $("#AllPrivilege").on("change", function() {
        $("input[type=checkbox]").prop("checked", $(this).prop("checked"));

    });

    $(".privilege-checkbox").on("change", function() {
        if (!$(this).prop("checked")) {
            $("#AllPrivilege").prop("checked", false);
        }
    });
</script>

<?= $this->endSection() ?>