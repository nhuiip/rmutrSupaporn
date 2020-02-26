<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2><?= $header; ?></h2>
            <ul class="breadcrumb padding-0">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard/index'); ?>"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item active"><?= $header; ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="row clearfix">
    <!-- <form method="post" id="import_csv" enctype="multipart/form-data" action="<?= site_url('student/importData/' . $deptid); ?>">
        <div class="form-group">
            <label>Select CSV File</label>
            <input type="file" name="csv_file" id="csv_file" required accept=".csv" />
        </div>
        <br />
        <button type="submit" name="import_csv" class="btn btn-info" id="import_csv_btn">Import CSV</button>
    </form> -->
    <div class="col-lg-12">
        <div class="card">
            <div class="header text-right">
                <small><i><?= $deptname; ?></i> :</small>
            </div>
            <div class="body table-responsive">
                <table class="table table-bordered table-hover dt-responsive nowrap dataExport" data-urladd="<?= site_url('student/form/' . $deptid); ?>" data-col="0,1,2,3,4,5,9,10,11,12" data-filename="studentList-<?= $deptname; ?>" data-urlImport="<?= site_url('student/formImport/' . $deptid); ?>">
                    <thead>
                        <tr>
                            <th>Student no.</th>
                            <th>ID Card</th>
                            <th>Name title</th>
                            <th>Fullname</th>
                            <th>Course</th>
                            <th>Sex</th>
                            <th>Inser Data</th>
                            <th></th>
                            <th>Last Edit</th>
                            <th class="none">Student Mobile no. :</th>
                            <th class="none">Person to notify in case of emergency :</th>
                            <th class="none">Mobile no. :</th>
                            <th class="none">Related as :</th>
                        </tr>
                    </thead>
                    <? if (count($listdata) != 0) { ?>
                        <tbody>
                            <?
                            foreach ($listdata as $key => $value) { ?>
                                <tr class="gradeX">
                                    <td width="10%"><?= $value['std_number']; ?></td>
                                    <td width="10%">
                                        <?= $value['std_indent'] ?>
                                    </td>
                                    <td width="10%">
                                        <?= $value['std_title'] ?>
                                    </td>
                                    <td width="15%">
                                        <?= $value['std_fname'] . ' ' . $value['std_lname'] ?>
                                    </td>
                                    <td width="10%"><?= $value['stdtype_text']; ?></td>
                                    <td width="10%"><?= $value['sex_text']; ?></td>
                                    <td width="15%">
                                        <?= $value['std_create'] . '<br />'; ?>
                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['std_create_date'])); ?></small>
                                    </td>
                                    <td width="5%">
                                        <center>
                                            <div class="dropdown">
                                                <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?= site_url('student/form/' . $deptid . '/' . $value['std_id']); ?>">Update Data</a>
                                                    <a class="dropdown-item text-danger" onclick="fncDelete(this)" data-url="<?= site_url('student/delete/' . $deptid . '/' . $value['std_id']); ?>">Delete</a>
                                                </div>
                                            </div>
                                        </center>
                                    </td>
                                    <td width="15%">
                                        <?= $value['std_lastedit'] . '<br />'; ?>
                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['std_lastedit_date'])); ?></small>
                                    </td>
                                    <td><?= $value['std_tel']; ?></td>
                                    <td><?= $value['std_emergency_name']; ?></td>
                                    <td><?= $value['std_emergency_tel']; ?></td>
                                    <td><?= $value['std_emergency_con']; ?></td>
                                </tr>
                            <? } ?>
                        </tbody>
                    <? } ?>
                </table>
            </div>
        </div>
    </div>
</div>