<?
if (isset($listdata) && count($listdata) != 0) {
    foreach ($listdata as $key => $value) {
        $id = $value['std_id'];
        $stdtype_id = $value['stdtype_id'];
        $sex_id = $value['sex_id'];
        $std_indent = $value['std_indent'];
        $std_number = $value['std_number'];
        $std_title = $value['std_title'];
        $std_fname = $value['std_fname'];
        $std_lname = $value['std_lname'];
        $std_tel = $value['std_tel'];
        $std_emergency_name = $value['std_emergency_name'];
        $std_emergency_tel = $value['std_emergency_tel'];
        $std_emergency_con = $value['std_emergency_con'];
    }
    $actionUrl = site_url('student/update/'.$deptid.'/'.$id);
    $checkStdnumber = site_url('student/checkStdnumber/'.$id);
    $checkIDcard = site_url('student/checkIDcard/'.$id);
} else {
    $actionUrl = site_url('student/create/'.$deptid);
    $checkStdnumber = site_url('student/checkStdnumber');
    $checkIDcard = site_url('student/checkIDcard');
}
?>
<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2><?= $header; ?></h2>
            <ul class="breadcrumb padding-0">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard/index'); ?>"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('student/index/'.$deptid); ?>"><?=$deptname;?></a></li>
                <li class="breadcrumb-item active"><?= $header; ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <form action="<?= $actionUrl; ?>" method="post" enctype="multipart/form-data" name="formStudent" id="formStudent" novalidate>
            <div class="body row">
                <input type="hidden" name="formcrf" id="formcrf" value="<? if (isset($formcrf)) {echo $formcrf; } ?>">
                    <div class="form-group col-md-4">
                        <label><b>Department Name</b> <small style="color: red">*</small></label>
                        <input type="text" class="form-control" placeholder="Department Name" name="dept_name" id="dept_name" value="<? if (isset($deptname)) {echo $deptname;} ?>" readonly>
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
                    <div class="form-group col-md-4">
                        <label><b>ID Card</b> <small style="color: red">*</small></label>
                        <input type="text" class="form-control idcard" name="std_indent" id="std_indent" value="<? if (isset($std_indent)) {echo $std_indent;} ?>" placeholder="Ex: 0 0000 00000 00 0" data-url="<?=$checkIDcard;?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label><b>Student Number</b> <small style="color: red">*</small></label>
                        <input type="text" class="form-control stdno" placeholder="Ex: 0000000000000" name="std_number" id="std_number" value="<? if (isset($std_number)) {echo $std_number;} ?>" data-url="<?=$checkStdnumber;?>">
                    </div>
                    <div class="form-group col-md-4"></div>
                    <div class="form-group col-md-4">
                        <label><b>Name Title</b> <small style="color: red">*</small></label>
                        <select class="form-control show-tick" name="std_title" id="std_title">
                            <option value="">Select Sex</option>
                            <option value="นาย" <?PHP if (isset($std_title) && $std_title == 'นาย') {echo 'selected';} ?>>นาย</option>
                            <option value="นาง" <?PHP if (isset($std_title) && $std_title == 'นาง') {echo 'selected';} ?>>นาง</option>
                            <option value="นางสาว" <?PHP if (isset($std_title) && $std_title == 'นางสาว') {echo 'selected';} ?>>นางสาว</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label><b>First name</b> <small style="color: red">*</small></label>
                        <input type="text" class="form-control" placeholder="First name" name="std_fname" id="std_fname" value="<? if (isset($std_fname)) {echo $std_fname;} ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label><b>Surname</b> <small style="color: red">*</small></label>
                        <input type="text" class="form-control" placeholder="Surname" name="std_lname" id="std_lname" value="<? if (isset($std_lname)) {echo $std_lname;} ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label><b>Student Mobile no.</b> </label>
                        <input type="text" class="form-control mobile" placeholder="Ex: 00-0000-0000" name="std_tel" id="std_tel" value="<? if (isset($std_tel)) {echo $std_tel;} ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label><b>Person to notify in case of emergency</b> </label>
                        <input type="text" class="form-control" placeholder="Mobile Number" name="std_emergency_name" id="std_emergency_name" value="<? if (isset($std_emergency_name)) {echo $std_emergency_name;} ?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label><b>Mobile no.</b> </label>
                        <input type="text" class="form-control mobile" placeholder="Ex: 00-0000-0000" name="std_emergency_tel" id="std_emergency_tel" value="<? if (isset($std_emergency_tel)) {echo $std_emergency_tel;} ?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label><b>Related as </b> </label>
                        <input type="text" class="form-control" placeholder="Related as" name="std_emergency_con" id="std_emergency_con" value="<? if (isset($std_emergency_con)) {echo $std_emergency_con;} ?>">
                    </div>
                    <div class="form-group col-md-2"></div>
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