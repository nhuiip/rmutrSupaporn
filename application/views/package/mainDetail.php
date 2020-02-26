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
            <div class="body">
                <form action="<?= site_url('detailpackage/addProduct/' . $packid) ?>" method="post" enctype="multipart/form-data" name="formSetupPack" id="formSetupPack" novalidate>
                    <input type="hidden" name="formcrf" id="formcrf" value="<? if (isset($formcrf)) {echo $formcrf; } ?>">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <button class="btn btn-primary btn-round" type="submit">Add Product</button>
                        </div>
                        <div class="col-md-6 col-sm-6 text-right">
                            <p class="m-b-0"><strong>Department: </strong> <?= $deptname; ?></p>
                            <p class="m-b-0"><strong>Course: </strong> <?= $stdtypetext; ?></p>
                            <p><strong>Sex: </strong> <?= $sextext; ?></p>
                        </div>
                    </div>
                    <div class="mt-40"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <? if (count($listuniform) != 0 || count($listacces) != 0 || count($listfee) != 0) { ?>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="checkall" onclick="calc();"> Select All
                                </label>
                                <select id="optgroup" name="optgroup[]" class="ms" multiple="multiple">
                                    <? if (count($listuniform) != 0) { ?>
                                        <optgroup label="Uniform">
                                            <? foreach ($listuniform as $key => $value) { ?>
                                                <option value="<?= $value['pdt_id']; ?>"><?= $value['pdt_name']; ?></option>
                                            <? } ?>
                                        </optgroup>
                                    <? } ?>
                                    <? if (count($listacces) != 0) { ?>
                                        <optgroup label="Accessories">
                                            <? foreach ($listacces as $key => $value) { ?>
                                                <option value="<?= $value['pdt_id']; ?>"><?= $value['pdt_name']; ?></option>
                                            <? } ?>
                                        </optgroup>
                                    <? } ?>
                                    <? if (count($listfee) != 0) { ?>
                                        <optgroup label="Fee">
                                            <? foreach ($listfee as $key => $value) { ?>
                                                <option value="<?= $value['pdt_id']; ?>"><?= $value['pdt_name']; ?></option>
                                            <? } ?>
                                        </optgroup>
                                    <? } ?>
                                </select>
                            <? } else { ?>
                                <p class="text-center">no more product for select</p>
                            <? } ?>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <br>
                        <!-- <div class="table-responsive"> -->
                        <table class="table table-bordered table-hover dataTable-nobtn">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th class="text-right">Unit</th>
                                    <th class="text-right">Unit Cost</th>
                                    <th class="text-right">Total</th>
                                    <th>Insert</th>
                                    <th>Lastedit</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <? if (count($listdata) != 0) { ?>
                                <tbody>
                                    <? $numrow= 1; foreach ($listdata as $key => $value) { 
                                        $total = $value['pdt_price']*$value['quantity'];
                                        $totals[$key] = $total;
                                    ?>
                                        <tr>
                                            <td width="5%"><?=str_pad($numrow, 3, "0", STR_PAD_LEFT); ?></td>
                                            <td><?=$value['pdt_name'];?></td>
                                            <td width="10%" class="text-right"><?=number_format($value['quantity']);?></td>
                                            <td width="10%" class="text-right text-info"><?=number_format($value['pdt_price']);?></td>
                                            <td width="10%" class="text-right text-info"><?=number_format($value['pdt_price']*$value['quantity']);?></td>
                                            <td width="10%">
                                                <?= $value['create_id'] . '<br />'; ?>
                                                <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['create_date'])); ?></small>
                                            </td>
                                            <td width="10%">
                                                <?= $value['lastedit_id'] . '<br />'; ?>
                                                <small class="text-muted"><i class="fa fa-clock-o"></i> <?= date('d/m/Y h:i A', strtotime($value['lastedit_date'])); ?></small>
                                            </td>
                                            <td width="5%" class="text-center"><button class="btn btn-warning" onclick="fncEditUnit(this)" data-url="<?= site_url('detailpackage/update/'.$value['pack_id'].'/'. $value['pdt_id']); ?>" data-pdtname="<?=$value['pdt_name'];?>" data-unit="<?=$value['quantity'];?>">Edit</button></td>
                                            <td width="5%" class="text-center"><button class="btn btn-danger" onclick="fncDelete(this)" data-url="<?= site_url('detailpackage/delete/'.$value['pack_id'].'/'. $value['pdt_id']); ?>">Delete</button></td>
                                        </tr>
                                    <? $numrow++; } ?>
                                </tbody>
                            <? } ?>
                        </table>
                        </div>
                    <!-- </div> -->
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <p class="m-b-0">Total:</p>
                        <h3 class="m-b-0 m-t-10">Baht <? if(!empty($totals)){echo number_format(array_sum ( $totals ));} else { echo 0;}?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>