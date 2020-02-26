<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <? if (count($listuniform) != 0 || count($listacces) != 0) { ?>
            <div class="card">
                <div class="header">
                    <h2><strong>มหาวิทยาลัยเทคโนโลยีราชมงคลรัตนโกสินทร์</strong> วิทยาเขต วังไกลกังวล
                        <small>รายการสินค้า<code>: </code> เลือกรายการสินค้าด้านล่าง</small>
                    </h2>
                </div>
                <div class="body row">
                    <div class="col-md-12">
                        <form id="#" method="POST" class="row" action="<?= site_url('extra/setCookie'); ?>" novalidate>
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
                            <br>
                    </div>
                    <div class="col-md-6 col-sm-6"></div>
                    <div class="col-md-6 col-sm-6 text-right">
                        <button class="btn btn-primary btn-round" type="submit">เลือกสินค้า</button>
                    </div>
                    </form>
                </div>
            </div>
        <? } ?>
        <? if (count($this->cart->contents()) != 0) { ?>
            <form action="<?= site_url('extra/orders') ?>" method="post" enctype="multipart/form-data" id="formExtra" novalidate>
                <div class="card">
                    <div class="header">
                        <h2><strong>รายการเครื่องแบบที่เลือก</strong>
                            <small>ระบบสั่งซื้อเครื่องแบบนักศึกษาใหม่<code>: </code> กรุณาตรวจสอบข้อมูลส่วนตัวของท่าน และ เลือกไซต์เครื่องแบบให้ถูกต้องก่อนทำการกดสั่งซื้อ</small>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control stdno" placeholder="กรอกรหัสนักศึกษา" name="std_number" id="std_number" data-url="<?= site_url('extra/getData'); ?>" onkeyup="fncGetdata(this)">
                                <input type="hidden" name="std_id" id="std_id">
                            </div>
                            <div id="getData" class="col-md-12"></div>
                        </div>
                        <hr style="margin: 0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>#</th>
                                        <th>รายการ</th>
                                        <th class="text-right">จำนวน</th>
                                        <th class="text-right">ราคา/หน่วย</th>
                                        <th class="text-right">ราคารวม</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? foreach ($this->cart->contents() as $items) { ?>
                                        <tr>
                                            <td width="5%">
                                                <a href="<?= site_url('extra/deleteCart/' . $items['rowid']); ?>"><i class="material-icons">cancel</i></a>
                                            </td>
                                            <td width="5%"><?= "PDT" . str_pad($items['id'], 3, "0", STR_PAD_LEFT); ?></td>
                                            <td width="40%"><?= $items['name']; ?></td>
                                            <td width="10%" class="text-right">
                                                <input type="number" class="form-control text-center" value="<?= number_format($items['qty']); ?>" onchange="fncChangeUnit(this)" data-url="<?= site_url('extra/updateQty/' . $items['rowid']); ?>" data-pdtid="<?= $items['id']; ?>" min="1">
                                            </td>
                                            <td width="10%" class="text-right text-info"><?= number_format($items['price']); ?></td>
                                            <td width="10%" class="text-right text-info"><label class="subtotal<?= $items['id']; ?>"><?= number_format($items['subtotal']); ?></label></td>
                                            <td width="20%">
                                                <? if ($items['type'] == 1) {
                                                    $this->db->select("stock_id, stock_text");
                                                    $this->db->where(array('pdt_id' => $items['type']));
                                                    $query = $this->db->get('tb_productstock');
                                                    $listsize = $query->result_array();
                                                ?>
                                                    <select onchange="fncChangeSize(this)" data-url="<?= site_url('extra/updateSize/' . $items['rowid']); ?>" class="form-control show-tick" name="stock_id[]" id="stock_id<?= $value['pdt_id']; ?>" required>
                                                        <option value="noselect">เลือกไซต์</option>
                                                        <? foreach ($listsize as $key => $v) { ?>
                                                            <option value="<?= $v['stock_text']; ?>" <? if ($v['stock_text'] == $items['options']) {echo 'selected';} ?>><?= $v['stock_text']; ?></option>
                                                        <? } ?>
                                                    </select>
                                                <? } elseif ($items['type'] == 2) {
                                                    $this->db->select("stock_id");
                                                    $this->db->where(array('pdt_id' => $items['type']));
                                                    $query = $this->db->get('tb_productstock');
                                                    $listsize = $query->result_array();
                                                ?>
                                                <? } ?>
                                            </td>
                                        </tr>
                                    <? } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <!-- <hr> -->
                                <p class="m-b-0">ราคารวม:</p>
                                <h3 class="m-b-0 m-t-10"><strong class="text-danger orderTotal"><?= number_format($this->cart->total()); ?></strong> บาท</h3>
                            </div>
                            <!-- hide input -->
                            <div class="hidden-print col-md-12 text-right">
                                <hr>
                                <a href="<?= site_url('extra/cancleorders'); ?>"><button class="btn btn-danger btn-round" type="button">ยกเลิก</button></a>
                                <button class="btn btn-primary btn-round" type="submit">สั่งซื้อ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <? } ?>
    </div>
</div>