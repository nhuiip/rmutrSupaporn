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
                <table class="table table-bordered table-hover dataTables" data-urladd="<?= site_url('product/form/' . $typeid); ?>">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th class="text-right">Price</th>
                            <? if($typeid == 2){ ?>
                            <th class="text-right">Quantity</th>
                            <? } ?>
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
                                    <td width="5%"><strong><?= "P" . str_pad($numrow, 3, "0", STR_PAD_LEFT); ?></strong></td>
                                    <td width="50%">
                                        <?= $value['pdt_name'] ?>
                                    </td>
                                    <td width="10%" class="text-info text-right">
                                        <i><?= number_format($value['pdt_price']); ?></i>
                                    </td>
                                    <? if($typeid == 2){ ?>
                                    <td width="10%" class="text-info text-right">
                                        <i><?=number_format($value['stock_quantity']);?></i>
                                    </td>
                                    <? } ?>
                                    <td width="10%">
                                        <?= $value['pdt_create'] . '<br />'; ?>
                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['pdt_create_date'])); ?></small>
                                    </td>
                                    <td width="10%">
                                        <center>
                                            <div class="dropdown">
                                                <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?= site_url('product/form/' . $typeid . '/' . $value['pdt_id']); ?>">Update Data</a>
                                                    <? if($typeid == 1){ ?>
                                                    <a class="dropdown-item" href="<?= site_url('stock/index/' . $typeid . '/' . $value['pdt_id']); ?>">Manage Stock</a>
                                                    <? } elseif($typeid == 2){ ?>
                                                    <a class="dropdown-item" href="<?= site_url('stock/form/' . $typeid . '/' . $value['pdt_id'].'/'.$value['stockid']); ?>">Manage Stock</a>
                                                    <? } ?>
                                                    <a class="dropdown-item text-danger" onclick="fncDelete(this)" data-url="<?= site_url('product/delete/' . $typeid . '/' . $value['pdt_id']); ?>">Delete</a>
                                                </div>
                                            </div>
                                        </center>
                                    </td>
                                    <td width="10%">
                                        <?= $value['pdt_lastedit'] . '<br />'; ?>
                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['pdt_lastedit_date'])); ?></small>
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