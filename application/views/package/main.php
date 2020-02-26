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
    <div class="col-lg-12">
        <div class="card">
            <div class="header text-right">
                <small><i><?=$deptname;?></i> :</small>
            </div>
            <div class="body table-responsive">
                <table class="table table-bordered table-hover dataTables" data-urladd="<?= site_url('package/form/'.$deptid); ?>">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Department Name</th>
                            <th>Course</th>
                            <th>Sex</th>
                            <th>Inser Data</th>
                            <th></th>
                            <th>Last Edit</th>
                        </tr>
                    </thead>
                    <? if (count($listdata) != 0) { ?>
                        <tbody>
                            <? $numrow = 1;
                            foreach ($listdata as $key => $value) { ?>
                                <tr class="gradeX">
                                    <td width="5%"><strong><?= "D" . str_pad($numrow, 3, "0", STR_PAD_LEFT); ?></strong></td>
                                    <td width="45%">
                                        <?= $value['dept_id'] ?>
                                    </td>
                                    <td width="10%"><?= $value['stdtype_text'] ?></td>
                                    <td width="10%"><?= $value['sex_text'] ?></td>
                                    <td width="10%">
                                        <?= $value['pack_create'] . '<br />'; ?>
                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['pack_create_date'])); ?></small>
                                    </td>
                                    <td width="10%">
                                        <center>
                                            <div class="dropdown">
                                                <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?= site_url('package/form/'.$deptid.'/'. $value['pack_id']); ?>">Update Data</a>
                                                    <a class="dropdown-item" href="<?= site_url('detailpackage/index/'. $value['pack_id']); ?>">Set Package</a>
                                                    <a class="dropdown-item text-danger" onclick="fncDelete(this)" data-url="<?= site_url('package/delete/'.$deptid.'/'. $value['pack_id']); ?>">Delete</a>
                                                </div>
                                            </div>
                                        </center>
                                    </td>
                                    <td width="10%">
                                        <?= $value['pack_lastedit'] . '<br />'; ?>
                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['pack_lastedit_date'])); ?></small>
                                    </td>
                                </tr>
                            <? $numrow++;
                            } ?>
                        </tbody>
                </table>
            <? } ?>
            </div>
        </div>
    </div>
</div>