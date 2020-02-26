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
            <div class="header text-right">
                <a href="<?=base_url('assets/tempImport.csv');?>" download><small><i>Download template CSV</i> :</small></a>
            </div>
            <form action="<?=site_url('student/importData/'.$deptid);?>" method="post" enctype="multipart/form-data" name="formImport" id="formImport" novalidate>
            <div class="body row">
                <input type="hidden" name="formcrf" id="formcrf" value="<? if (isset($formcrf)) {echo $formcrf; } ?>">
                    <div class="form-group col-md-4">
                        <label><b>Department Name</b> <small style="color: red">*</small></label>
                        <input type="text" class="form-control" placeholder="Department Name" name="dept_name" id="dept_name" value="<? if (isset($deptname)) {echo $deptname;} ?>" readonly>
                    </div>
                    <div class="form-group col-md-8">
                        <label><b>Upload file</b> <small style="color: red">*</small></label>
                        <input type="file" class="form-control" name="csv_file" id="csv_file" required accept=".csv" />
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