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
                <small><i><?= $deptname; ?></i> :</small>
            </div>
            <div class="body table-responsive">
                <table id="dataOrders" class="table table-bordered table-hover dt-responsive nowrap" data-col="0,1,2,3,4,5,6,8,9" data-filename="ordersList-<?= $deptname; ?>">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Course</th>
                            <th>Sex</th>
                            <th>Orders Date</th>
                            <th class="text-right">Total</th>
                            <th>Orders Type</th>
                            <th></th>
                            <th>Status</th>
                            <th class="none">Note</th>
                        </tr>
                    </thead>
                    <? if (count($listdata) != 0) { ?>
                        <tbody>
                            <? $numrow = 1;
                            foreach ($listdata as $key => $value) { ?>
                                <tr class="gradeX">
                                    <td width="15%">
                                        <?= $value['std_number'] ?>
                                    </td>
                                    <td width="30%">
                                        <?= $value['std_title'] . '' . $value['std_fname'] . '  ' . $value['std_lname'] ?>
                                    </td>
                                    <td width="5%"><?= $value['stdtype_text']; ?></td>
                                    <td width="5%"><?= $value['sex_text']; ?></td>
                                    <td width="10%"><?= date('d/m/Y h:i A', strtotime($value['orders_date'])); ?></td>
                                    <td width="10%" class="text-info text-right"><?= number_format($value['orders_total']) ?></td>
                                    <td width="10%" class="text-center">
                                        <?
                                        switch ($value['orders_type']) {
                                            case 1:
                                                $orders_type = '<span class="badge badge-default">Default</span>';
                                                break;
                                            case 2:
                                                $orders_type = '<span class="badge badge-info">Extra</span>';
                                                break;
                                            default:
                                                $orders_type = '';
                                        }
                                        ?>
                                        <?= $orders_type; ?>
                                    </td>
                                    <td width="10%">
                                        <center>
                                            <div class="dropdown">
                                                <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?= site_url('orders/detail/' . $deptid . '/' . $value['orders_id']); ?>">Orders Detail</a>
                                                    <a class="dropdown-item" href="<?=site_url('orders/invoices/'.$value['orders_id']);?>" target="_blank">Print Invoices</a>
                                                    <?if($value['orders_type'] == 2){ ?>
                                                        <a class="dropdown-item" onclick="fncChange(this)" data-status="Extend" data-url="<?= site_url('orders/cutStock/' . $deptid . '/' . $value['orders_id']); ?>" data-note="<?= $value['orders_note']; ?>">Cut Stock</a>
                                                    <? } ?>
                                                    <a class="dropdown-item text-warning" onclick="fncChange(this)" data-status="Extend" data-url="<?= site_url('orders/changeExt/' . $deptid . '/' . $value['orders_id']); ?>" data-note="<?= $value['orders_note']; ?>">Extend</a>
                                                    <a class="dropdown-item text-success" onclick="fncChange(this)" data-status="Success" data-url="<?= site_url('orders/changeSS/' . $deptid . '/' . $value['orders_id']); ?>" data-note="<?= $value['orders_note']; ?>">Success</a>
                                                    <a class="dropdown-item text-danger" onclick="fncDelete(this)" data-url="<?= site_url('orders/delete/' . $deptid . '/' . $value['orders_id']); ?>">Delete</a>
                                                </div>
                                            </div>
                                        </center>
                                    </td>
                                    <td width="10%" class="text-center">
                                        <?
                                        switch ($value['orders_status']) {
                                            case 1:
                                                $orders_status = '<span class="badge badge-warning">Warning</span>';
                                                // $orders_status = 'Warning';
                                                break;
                                            case 2:
                                                $orders_status = '<span class="badge badge-info">Extends</span>';
                                                // $orders_status = 'Extend';
                                                break;
                                            case 3:
                                                $orders_status = '<span class="badge badge-success">Successfull</span>';
                                                // $orders_status = 'Success';
                                                break;
                                            default:
                                                $orders_status = '';
                                        }
                                        ?>
                                        <?= $orders_status; ?>
                                    </td>
                                    <td><?= $value['orders_note']; ?></td>
                                </tr>
                            <? $numrow++;
                            } ?>
                        </tbody>
                    <? } ?>
                </table>
            </div>
        </div>
    </div>
</div>