<?=$this->extend("admin/_layouts/master") ?>
<?=$this->section("content") ?>

<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-0">
    <h1 class="h3 mb-0 text-gray-800">User Groups</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=base_url('admin'); ?>">Admin</a></li>
      <li class="breadcrumb-item active" aria-current="page">addgroup</li>
    </ol>
  </div>
  <!-- Row -->
  <div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header py-1 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Add Group</h6>
          <div class="dropdown no-arrow">
            <a href="<?=base_url('admin/user_groups')?>" class="btn btn-primary btn-sm">Back</a>
          </div>
        </div>
        <div class="card-body">
            <form action="<?=current_url(); ?>" method="post">
              <?= csrf_field(); ?>
                <div class="form-group row">
                    <label for="post_name" class="col-sm-2 col-form-label">Group Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="post_name" id="post_name" placeholder="Group Name">
                        <span class="text-danger"><?= isset($validation) ?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-sm-2 mb-3 mb-sm-0">Add Privilege:</label>
                    <div class="col-sm-10">
                        <?php if(count($menulist) > 0){ ?>
                        <div class="form-check">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input class="form-check-input" type="checkbox" name="" value="" id="AllPrivilege" >
                                    <label class="form-check-label" for="AllPrivilege">All Privilege</label>
                                </div>
                            </div>
                        </div>
                        <?php foreach($menulist as $key=>$menu){ 
                          $disable = '';
                          if($menu->menu_id == 2){
                            $disable = 'disabled';
                          }
                        ?>
                        <div class="form-check">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input class="form-check-input" type="checkbox" name="menu_id[<?=$key?>]" value="<?=$menu->menu_id?>" id="<?=$menu->menu_name?>" <?=$disable?>>
                                    <label class="form-check-label" for="<?=$menu->menu_name?>" data-toggle="tooltip" data-placement="right" title="<?= $menu->menu_id ?>"><?=$menu->menu_name?></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="hidden" name="crudid[<?=$key?>][]" id="Listingh<?=$key?>" value="1">
                                    
                                    <?php if($menu->function != ''){
                                        $value = 2;
                                        $functionArr = explode(',', $menu->function);
                                        foreach($functionArr as $fun){ ?>
                                            <div class="form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="crudid[<?=$key?>][]" id="<?=$fun.$key?>" value="<?= $value ?>" <?=$disable?>>
                                                <label class="form-check-label" for="Delete" data-toggle="tooltip" data-placement="right" title="<?= $value ?>"><?= $fun ?></label>
                                            </div>
                                            <?php $value++; ?>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <?php } } ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-sm-2 mb-3 mb-sm-0">Status:</label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1" >
                            <label class="form-check-label" for="exampleRadios1">
                                Active
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="0" >
                            <label class="form-check-label" for="exampleRadios2">
                                In Active
                            </label>
                        </div>
                        <span class="text-danger"><?= isset($validation)?></span> 
                    </div>
                </div>
                    
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="Reset" class="btn btn-secondary">Reset</button>
                <a href="<?= base_url('admin/user_groups') ?>" class="btn btn-warning">Cancel</a>
            </form> 
            
        </div> <!-- Card Body -->
      </div>
    </div>
   </div>
   <script>
    //check all
    $("#AllPrivilege").click(function() {
        $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
    });

    $("input[type=checkbox]").click(function() {
        if (!$(this).prop("checked")) {
        $("#AllPrivilege").prop("checked", false);
        }
    });
    </script>
<?=$this->endSection() ?>