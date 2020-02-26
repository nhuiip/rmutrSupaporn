<?
if (isset($listdata) && count($listdata) != 0) {
    foreach ($listdata as $key => $value) {
        $id = $value['pdt_id'];
        $pdt_name = $value['pdt_name'];
        $pdt_price = $value['pdt_price'];
    }
    $actionUrl = site_url('product/update/'.$typeid.'/'.$id);
    $checkName = site_url('product/checkName/'.$id);
} else {
    $actionUrl = site_url('product/create/'.$typeid);
    $checkName = site_url('product/checkName');
}
?>
<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2><?= $header; ?></h2>
            <ul class="breadcrumb padding-0">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard/index'); ?>"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('product/index/'.$typeid); ?>">Manage <?=$typename;?></a></li>
                <li class="breadcrumb-item active"><?= $header; ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <form action="<?= $actionUrl; ?>" method="post" enctype="multipart/form-data" name="formProduct" id="formProduct" novalidate>
            <div class="body row">
                <input type="hidden" name="formcrf" id="formcrf" value="<? if (isset($formcrf)) {echo $formcrf; } ?>">
                    <div class="form-group col-md-8">
                        <label><b>Product Name</b> <small style="color: red">*</small></label>
                        <input type="text" class="form-control" placeholder="Product Name" name="pdt_name" id="pdt_name" value="<? if (isset($pdt_name)) {echo $pdt_name;} ?>" data-url="<?=$checkName;?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label><b>Price</b> <small style="color: red">*</small></label>
                        <input type="number" class="form-control" placeholder="Price" name="pdt_price" id="pdt_price" value="<? if (isset($pdt_price)) {echo $pdt_price;} ?>">
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