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
            <div class="body table-responsive">
                <table class="table table-bordered table-hover dataTables" data-urladd="<?= site_url('faculty/form'); ?>">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Faculty Name</th>
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
                                    <td width="5%"><strong><?= "F" . str_pad($numrow, 3, "0", STR_PAD_LEFT); ?></strong></td>
                                    <td width="65%">
                                        <?= $value['fac_name'] ?>
                                    </td>
                                    <td width="10%">
                                        <?=$value['fac_create'] . '<br />';?>
                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?=date('d/m/Y h:i A', strtotime($value['fac_create_date']));?></small>
                                    </td>
                                    <td width="10%">
                                        <center>
                                            <div class="dropdown">
                                                <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?= site_url('faculty/form/' . $value['fac_id']); ?>">Update Data</a>
                                                    <a class="dropdown-item" href="<?= site_url('department/index/' . $value['fac_id']); ?>">Manage Department</a>
                                                    <a class="dropdown-item text-danger" onclick="fncDelete(this)" data-url="<?= site_url('faculty/delete/' . $value['fac_id']); ?>">Delete</a>
                                                </div>
                                            </div>
                                        </center>
                                    </td>
                                    <td width="10%">
                                    <?=$value['fac_lastedit'] . '<br />';?>
                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?=date('d/m/Y h:i A', strtotime($value['fac_lastedit_date']));?></small>
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