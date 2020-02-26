<?
if (isset($listdata) && count($listdata) != 0) {
    foreach ($listdata as $key => $value) {
        $id = $value['pack_id'];
        $sex_id = $value['sex_id'];
        $stdtype_id = $value['stdtype_id'];
    }
    $actionUrl = site_url('package/update/'.$deptid.'/'.$id);
} else {
    $actionUrl = site_url('package/create/'.$deptid);
}
?>
<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2><?= $header; ?></h2>
            <ul class="breadcrumb padding-0">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard/index'); ?>"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('package/index/'.$deptid); ?>">Manage Package</a></li>
                <li class="breadcrumb-item active"><?= $header; ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <form action="<?= $actionUrl; ?>" method="post" enctype="multipart/form-data" name="formPack" id="formPack" novalidate>
            <div class="body row">
                <input type="hidden" name="formcrf" id="formcrf" value="<? if (isset($formcrf)) {echo $formcrf; } ?>">
                    <div class="form-group col-md-4">
                        <label><b>Department Name</b> <small style="color: red">*</small></label>
                        <input type="text" class="form-control" placeholder="Faculty Name" value="<? if (isset($deptname)) {echo $deptname;} ?>" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label><b>Course</b> <small style="color: red">*</small></label>
                        <select class="form-control show-tick" name="stdtype_id" id="stdtype_id">
                            <option value="">Select Course</option>
                            <? foreach ($listStdtype as $key => $value) { ?>
                                <option value="<?= $value['stdtype_id'] ?>" <?PHP if (isset($stdtype_id) && $stdtype_id == $value['stdtype_id']) {echo 'selected';} ?>><?= $value['stdtype_text'] ?></option>
                            <? } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label><b>Sex</b> <small style="color: red">*</small></label>
                        <select class="form-control show-tick" name="sex_id" id="sex_id">
                            <option value="">Select Sex</option>
                            <? foreach ($listSex as $key => $value) { ?>
                                <option value="<?= $value['sex_id'] ?>" <?PHP if (isset($sex_id) && $sex_id == $value['sex_id']) {echo 'selected';} ?>><?= $value['sex_text'] ?></option>
                            <? } ?>
                        </select>
                    </div>
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