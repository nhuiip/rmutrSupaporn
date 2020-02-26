<?
if (isset($listdata) && count($listdata) != 0) {
    foreach ($listdata as $key => $value) {
        $id = $value['ad_id'];
        $position = $value['position'];
        $ad_fullname = $value['ad_fullname'];
        $ad_email = $value['ad_email'];
    }
    $Form = "formUser_edit";
    $actionUrl = site_url('admin/update/' . $id);
    $checkEmail = site_url('admin/checkEmail/' . $id);
} else {
    $Form = "formUser";
    $actionUrl = site_url('admin/create');
    $checkEmail = site_url('admin/checkEmail');
}
?>
<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2><?= $header; ?></h2>
            <ul class="breadcrumb padding-0">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard/index'); ?>"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('admin/index'); ?>">Manage User</a></li>
                <li class="breadcrumb-item active"><?= $header; ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <form action="<?= $actionUrl; ?>" method="post" enctype="multipart/form-data" name="<?= $Form; ?>" id="<?= $Form; ?>" novalidate>
                <div class="body row">
                <input type="hidden" name="formcrf" id="formcrf" value="<? if (isset($formcrf)) {echo $formcrf; } ?>">
                    <div class="form-group col-md-6">
                        <label><b>Full Name</b> <small style="color: red">*</small></label>
                        <input type="text" class="form-control" placeholder="Full Name" name="ad_fullname" id="ad_fullname" value="<? if (isset($ad_fullname)) {echo $ad_fullname;} ?>">
                    </div>
                    <div class="form-group col-md-6"></div>
                    <div class="form-group col-md-6">
                        <label><b>Email</b> <small style="color: red">*</small></label>
                        <input type="email" class="form-control" placeholder="Email" name="ad_email" id="ad_email" value="<? if (isset($ad_email)) {echo $ad_email;} ?>" data-url="<?= $checkEmail; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label><b>Position</b> <small style="color: red">*</small></label>
                        <select class="form-control show-tick" name="position" id="position">
                            <option value="">Select Position</option>
                            <? foreach ($Role as $key => $value) { ?>
                                <option value="<?= $value ?>" <?PHP if (isset($position) && $position == $value) {echo 'selected';} ?>><?= $value ?></option>
                            <? } ?>
                        </select>
                    </div>
                    <? if (!isset($listdata)) { ?>
                        <div class="form-group col-md-3">
                            <label><b> Password</b> <small style="color: red">*</small></label>
                            <input type="password" class="form-control" name="passwordA" id="passwordA" placeholder="Password">
                        </div>
                        <div class="form-group col-md-3">
                            <label><b> Confirm Password</b> <small style="color: red">*</small></label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                        </div>
                        <div class="form-group col-md-4">
                            <label><b> Random</b></label>
                            <input type="text" class="form-control" name="random" id="random" placeholder="Random Password">
                        </div>
                        <div class="form-group col-md-2">
                            <br>
                            <button class="btn btn-raised btn-primary btn-round btn-simple waves-effect" type="button" onclick="fncRanpass(this)">Random Password</button>
                        </div>
                    <? } ?>
                    <div class="form-group col-md-12">
                        <hr>
                        <button class="btn btn-raised btn-primary btn-round btn-simple waves-effect" type="reset">RESET</button>
                        <button class="btn btn-raised btn-primary btn-round waves-effect float-right" type="submit">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>