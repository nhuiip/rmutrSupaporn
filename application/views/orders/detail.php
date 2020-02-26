<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2><?= $header; ?></h2>
            <ul class="breadcrumb padding-0">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard/index'); ?>"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('orders/index/' . $deptid); ?>">Manage Orders</a></li>
                <li class="breadcrumb-item active"><?= $header; ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(32px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <li class="text-right"><a href="<?=site_url('orders/invoices/'.$ordersid);?>" target="_blank"><i class="material-icons">print</i> Print Invoices</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <p class="m-b-0"><strong>คณะ: </strong> <?= $facname; ?></p>
                        <p class="m-b-0"><strong>สาขา: </strong> <?= $deptname; ?></p>
                    </div>
                    <div class="col-md-6 col-sm-6 text-right">
                        <p class="m-b-0"><strong>รหัสนักศึกษา: </strong> <?= $listdata[0]['std_number']; ?></p>
                        <p class="m-b-0"><strong>ชื่อเต็ม: </strong> <?= $listdata[0]['std_title'] . ' ' . $listdata[0]['std_fname'] . ' ' . $listdata[0]['std_lname']; ?></p>
                        <p class="m-b-0"><strong>หลักสูตร: </strong> <?= $listdata[0]['stdtype_text']; ?> <strong>เพศ: </strong> <?= $listdata[0]['sex_text']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <hr style="margin-bottom: 0;">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Size</th>
                                    <th class="text-right">Unit Cost</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <? if (count($listdata) != 0) { ?>
                                <tbody>
                                    <? $numrow = 1;
                                    foreach ($listdata as $key => $value) { ?>
                                        <tr>
                                            <td width="5%"><?= str_pad($numrow, 3, "0", STR_PAD_LEFT); ?></td>
                                            <td width="65%"><?= $value['pdt_name']; ?></td>
                                            <td width="10%" class="text-right text-info"><?= $value['size']; ?></td>
                                            <td width="10%" class="text-right"><?= number_format($value['quantity']); ?></td>
                                            <td width="10%" class="text-right text-info"><?= number_format($value['total']); ?></td>
                                        </tr>
                                    <? $numrow++;
                                    } ?>
                                </tbody>
                            <? } ?>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <p class="m-b-0">Total:</p>
                        <h3 class="m-b-0 m-t-0">Baht <strong class="text-danger"><?= number_format($orderstotal) ?></strong></h3>
                        <p class="m-b-0">Date: <?= date('d/m/Y h:i A', strtotime($ordersdate)); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>