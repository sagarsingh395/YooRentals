<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>
<style>
    .form-check .form-check-input {
        margin-left: 5px;
    }

    .form-group {
        margin-bottom: .4rem;
    }

    .page-title {
        font-size: 26px;
        font-weight: 600;
        white-space: nowrap;
    }

    .index-title {
        color: #4e73df;
        font-weight: 500;
    }

    .menu-row {
        margin-bottom: 4px;
        align-items: center;
        display: flex;
    }

    .menu-name {
        overflow-x: auto;
    }

    .menu-name label {
        white-space: nowrap;
        display: inline-block;
    }

    .checkbox-group {
        display: flex;
        flex-wrap: nowrap;
        gap: 8px;
        overflow-x: auto;
    }

    .checkbox-group .form-check {
        margin-bottom: 2px;
    }

    .menu-name::-webkit-scrollbar {
        height: 4px;
    }

    .menu-name::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 5px;
    }
</style>

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="page-title mb-0">User Groups</h1>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Admin</a></li>
            <li class="breadcrumb-item active">edit-group</li>
        </ol>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="index-title">Edit Group</h5>
            <a href="<?= base_url('admin/user-group') ?>" class="btn btn-primary btn-sm">Back</a>
        </div>
        <div class="card-body">
            <form action="<?= current_url(); ?>" method="POST">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $prev_details->group_id ?>">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Group Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="group_name"
                            id="group_name" value="<?= $prev_details->group_name ?? '' ?>" placeholder="Group Name">
                        <span
                            class="text-danger"><?= isset($validation['group_name']) ? $validation['group_name'] : '' ?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Add Privilege</label>
                    <div class="col-sm-10">
                        <?php if (count($menulist) > 0) {
                            $commonmodel = model('App\Models\Commonmodel', false);
                        ?>
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="AllPrivilege">
                                <label class="form-check-label">All Privilege</label>
                            </div>

                            <?php foreach ($menulist as $key => $menu) {
                                $disable = '';
                                if ($menu->menu_id == 2) {
                                    $disable = 'disabled';
                                }
                                $menuchecked = '';
                                $prvlid = '';
                                $crud = array();
                                $ismenuexist = $commonmodel->getOneRecord('tbl_group_privilege', array('group_id' => $prev_details->group_id, 'menu_id' => $menu->menu_id));
                                if ($ismenuexist) {
                                    $menuchecked = 'checked';
                                    $prvlid = $ismenuexist->id;
                                    $crud = explode(',', $ismenuexist->crud_ids);
                                }
                            ?>
                                <div class="row menu-row">
                                    <div class="col-md-3 menu-name">
                                        <div class="form-check">
                                            <input class="form-check-input privilege-checkbox" type="checkbox"
                                                name="menu_id[<?= $key ?>]" value="<?= $menu->menu_id ?>" id="<?= $menu->menu_name ?>" <?= $menuchecked ?>
                                                <?= $disable ?>>
                                            <label class="form-check-label" for="<?= $menu->menu_name ?>" data-toggle="tooltip" data-placement="right" title="<?= $menu->menu_id ?>"><?= $menu->menu_name ?></label>
                                            <input type="hidden" name="prvlid[<?= $key ?>]" value="<?= $prvlid ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="checkbox-group">
                                            <input type="hidden" name="crudid[<?= $key ?>][]" id="Listingh<?= $key ?>" value="1">
                                            <?php if ($menu->function != '') {
                                                $value = 2;
                                                $functionArr = explode(',', $menu->function);
                                                foreach ($functionArr as $fun) { ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input privilege-checkbox" type="checkbox"
                                                            name="crudid[<?= $key ?>][]" value="<?= $value ?>" id="<?= $fun . $key ?>"
                                                            <?= (in_array($value, $crud)) ? 'checked' : ''; ?> <?= $disable ?>>
                                                        <label class="form-check-label" for="Delete" data-toggle="tooltip" data-placement="right" title="<?= $value ?>"><?= $fun ?></label>
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
                    <label for="image" class="col-sm-2 mb-3 mb-sm-0">Status:</label>
                    <?php
                    if (isset($prev_details->status)) {
                        $status = $prev_details->status;
                    } else {
                        $status = '';
                    }
                    ?>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1" <?= ($status == '1') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="exampleRadios1">
                                Active
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="0" <?= ($status == '0') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="exampleRadios2">
                                In Active
                            </label>
                        </div>
                        <span class="text-danger"><?= isset($validation['status']) ? $validation['status'] : '' ?></span>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                    <a href="<?= base_url('admin/user-group') ?>" class="btn btn-warning btn-sm">Cancel</a>
                </div>
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