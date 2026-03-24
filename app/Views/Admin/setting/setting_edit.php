<?= $this->extend("admin/_layouts/master") ?>
<?= $this->section("content") ?>
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-1">
        <h1 class="h3 mb-0 text-gray-800">Setting</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Admin</a></li>
            <li class="breadcrumb-item" aria-current="page">setting</li>
            <!--<li class="breadcrumb-item active" aria-current="page">Blank Page</li>-->
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <!-- Form Basic -->
            <div class="card mb-4">
                <div class="card-header py-1 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Update Setting</h6>
                </div>
                <?php if (session()->getFlashdata('message') !== NULL) {
                    // echo alertBS(session()->getFlashdata('message'),session()->getFlashdata('type'));
                } ?>
                <div class="card-body">
                    <form autocomplete="off" action="<?= base_url('admin/setting') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" id="name" name="name" value="<?= $settings->name ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="text" id="email" name="email" value="<?= $settings->email ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone 1</label>
                                    <input class="form-control" type="text" id="phone" name="phone" value="<?= $settings->phone ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone2">Phone 2</label>
                                    <input class="form-control" type="text" id="phone2" name="phone2" value="<?= $settings->phone2 ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input class="form-control" type="text" id="address" name="address" value="<?= $settings->address ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input class="form-control" type="text" id="website" name="website" value="<?= $settings->website ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook_link">facebook_link</label>
                                    <input class="form-control" type="text" id="facebook_link" name="facebook_link" value="<?= $settings->facebook_link ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="twitter_link">twitter_link</label>
                                    <input class="form-control" type="text" id="twitter_link" name="twitter_link" value="<?= $settings->twitter_link ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linkedin_link">linkedin_link</label>
                                    <input class="form-control" type="text" id="linkedin_link" name="linkedin_link" value="<?= $settings->linkedin_link ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="youtube_link">youtube_link</label>
                                    <input class="form-control" type="text" id="youtube_link" name="youtube_link" value="<?= $settings->youtube_link ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="instagram_link">instagram_link</label>
                                    <input class="form-control" type="text" id="instagram_link" name="instagram_link" value="<?= $settings->instagram_link ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="wh_template"><strong>WhatsApp Template</strong></label>
                                    <input class="form-control" type="text" id="wh_template" name="wh_template" value="<?= $settings->wh_template ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="enqlist_limit"><strong>Enquiry List Limit</strong></label>
                                    <input class="form-control" type="text" id="enqlist_limit" name="enqlist_limit" value="<?= $settings->enqlist_limit ?>">
                                </div>
                            </div>

                        </div>
                        <input type="hidden" name="submit" value="gen_setting">
                        <button type="submit" class="btn btn-success">Update</button>
                        <!--<button type="reset" class="btn btn-primary waves-effect waves-light m-r-3">Reset</button>-->
                        <a href="<?= base_url('/admin') ?>" class="btn btn-warning" role="button">Back</a>
                    </form>
                </div>
            </div><!-- end card -->
        </div><!-- end column -->
    </div><!-- end row -->
    <?= $this->endSection() ?>