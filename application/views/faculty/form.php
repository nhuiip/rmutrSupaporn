<?
if (isset($listdata) && count($listdata) != 0) {
    foreach ($listdata as $key => $value) {
        $id = $value['fac_id'];
        $fac_name = $value['fac_name'];
    }
    $actionUrl = site_url('faculty/update/' . $id);
    $checkName = site_url('faculty/checkName/' . $id);
} else {
    $actionUrl = site_url('faculty/create');
    $checkName = site_url('faculty/checkName');
}
?>
<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2><?= $header; ?></h2>
            <ul class="breadcrumb padding-0">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard/index'); ?>"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('faculty/index'); ?>">Manage Faculty</a></li>
                <li class="breadcrumb-item active"><?= $header; ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <form action="<?= $actionUrl; ?>" method="post" enctype="multipart/form-data" name="formFaculty" id="formFaculty" novalidate>
                <div class="body row">
                <input type="hidden" name="formcrf" id="formcrf" value="<? if (isset($formcrf)) {echo $formcrf; } ?>">
                    <div class="form-group col-md-12">
                        <label><b>Faculty Name</b> <small style="color: red">*</small></label>
                        <input type="text" class="form-control" placeholder="Faculty Name" name="fac_name" id="fac_name" value="<? if (isset($fac_name)) {echo $fac_name;} ?>" data-url="<?=$checkName;?>">
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