<? 
switch ($typeid) {
    case 1:
        $typename = 'Uniform';
        break;
    case 2:
        $typename = 'Accessories';
        break;
    default:
        $typename = '';
}
?>
<?
if (isset($listdata) && count($listdata) != 0) {
    foreach ($listdata as $key => $value) {
        $id = $value['stock_id'];
        $stock_text = $value['stock_text'];
        $stock_quantity = $value['stock_quantity'];
    }
    $actionUrl = site_url('stock/update/'.$typeid.'/'.$pdtid.'/'.$id);
    $checkstock = site_url('stock/checkstock/'.$pdtid.'/'.$id);
} else {
    $actionUrl = site_url('stock/create/'.$typeid.'/'.$pdtid);
    $checkstock = site_url('stock/checkstock/'.$pdtid);
}
?>
<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2><?= $header; ?></h2>
            <ul class="breadcrumb padding-0">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard/index'); ?>"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('product/index/'.$typeid); ?>">Manage <?= $typename;?></a></li>
                <?if($typeid == 1){ ?>
                <li class="breadcrumb-item"><a href="<?= site_url('stock/index/'.$typeid.'/'.$pdtid); ?>">Manage Stock</a></li>
                <? } ?>
                <li class="breadcrumb-item active"><?= $header; ?></li>
            </ul>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <form action="<?= $actionUrl; ?>" method="post" enctype="multipart/form-data" name="formStock<?=$typeid;?>" id="formStock<?=$typeid;?>" novalidate>
            <div class="body row">
                <input type="hidden" name="formcrf" id="formcrf" value="<? if (isset($formcrf)) {echo $formcrf; } ?>">
                    <div class="form-group col-md-4">
                        <label><b>Product Name</b> <small style="color: red">*</small></label>
                        <input type="text" class="form-control" placeholder="Product Name" value="<? if (isset($pdtname)) {echo $pdtname;} ?>" readonly>
                    </div>
                    <div class="form-group col-md-8"></div>
                    <?if($typeid == 1){ ?>
                    <div class="form-group col-md-4">
                        <label><b>Size</b> <small style="color: red">*</small></label>
                        <input type="text" class="form-control" placeholder="Size" name="stock_text" id="stock_text" value="<? if (isset($stock_text)) {echo $stock_text;} ?>" data-url="<?=$checkstock;?>">
                    </div>
                    <? } ?>
                    <div class="form-group col-md-4">
                        <label><b>Quantity</b> <small style="color: red">*</small></label>
                        <input type="number" class="form-control" placeholder="Quantity" name="stock_quantity" id="stock_quantity" value="<? if (isset($stock_quantity)) {echo $stock_quantity;} ?>" <?if(!empty($id)){echo 'readonly';}?>>
                    </div>
                    <?if(!empty($id)){ ?>
                    <div class="form-group col-md-4">
                        <label><b>Add quantity</b></label>
                        <input type="number" class="form-control" placeholder="Add quantity" name="add_stock_quantity" id="add_stock_quantity" value="0">
                    </div>
                    <? } ?>
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