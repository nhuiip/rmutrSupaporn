<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2><strong>มหาวิทยาลัยเทคโนโลยีราชมงคลรัตนโกสินทร์</strong> วิทยาเขต วังไกลกังวล
                    <small>ระบบสั่งซื้อเครื่องแบบนักศึกษาใหม่<code>: </code> กรุณากรอกรหัสนักศึกษาด้านล่างเพื่อค้นหาชุดเครื่องแบบของท่าน</small>
                </h2>
            </div>
            <div class="body">
                <form id="findnumber" method="POST" class="row" action="<?= site_url('main/getnumber'); ?>" novalidate>
                    <div class="form-group col-md-10">
                        <input type="text" class="form-control stdno" placeholder="กรอกรหัสนักศึกษา" name="std_number" id="std_number" value="<? if (isset($stdnumber)) {echo $stdnumber;} ?>" data-url="<?= site_url('main/findstdnumber'); ?>">
                    </div>
                    <div class="form-group col-md-2">
                        <button class="btn btn-primary btn-block btn-round margin-0">ค้นหา</button>
                    </div>
                </form>
            </div>
        </div>

        <? if (isset($dataStd)) { ?>
        <form action="<?= site_url('main/orders') ?>" method="post" enctype="multipart/form-data" id="formOders" novalidate>
            <div class="card">
                <div class="header">
                    <h2><strong>รายการเครื่องแบบ</strong>
                        <small>ระบบสั่งซื้อเครื่องแบบนักศึกษาใหม่<code>: </code> กรุณาตรวจสอบข้อมูลส่วนตัวของท่าน และ เลือกไซต์เครื่องแบบให้ถูกต้องก่อนทำการกดสั่งซื้อ</small>
                    </h2>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <p class="m-b-0"><strong>รหัสนักศึกษา: </strong> <?= $dataStd[0]['std_number']; ?></p>
                            <p class="m-b-0"><strong>ชื่อเต็ม: </strong> <?= $dataStd[0]['std_title'] . ' ' . $dataStd[0]['std_fname'] . ' ' . $dataStd[0]['std_lname']; ?></p>
                        </div>
                        <div class="col-md-6 col-sm-6 text-right">
                            <p class="m-b-0"><strong>สาขา: </strong> <?= $dataStd[0]['dept_name']; ?></p>
                            <p class="m-b-0"><strong>หลักสูตร: </strong> <?= $dataStd[0]['stdtype_text']; ?></p>
                            <p><strong>เพศ: </strong> <?= $dataStd[0]['sex_text']; ?></p>
                        </div>
                    </div>
                    <? if (isset($dataPdt)) { ?>
                        <div id="alertsize"></div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รายการ</th>
                                        <th class="text-right">จำนวน</th>
                                        <th class="text-right">ราคา/หน่วย</th>
                                        <th class="text-right">ราคารวม</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? $numrow = 1;
                                    foreach ($dataPdt as $key => $value) {
                                        $total = $value['pdt_price'] * $value['quantity'];
                                        $totals[$key] = $total;
                                    ?>
                                        <tr>
                                            <td width="5%">
                                                <?= "PDT" . str_pad($numrow, 3, "0", STR_PAD_LEFT); ?>
                                            </td>
                                            <td width="50%">
                                                <?= $value['pdt_name']; ?>
                                                <input type="hidden" name="pdt_id[]" value="<?= $value['pdt_id']; ?>">
                                                <input type="hidden" name="type_id[]" value="<?= $value['type_id']; ?>">
                                            </td>
                                            <td width="5%" class="text-right">
                                                <?= number_format($value['quantity']); ?>
                                                <input type="hidden" name="quantity[]" value="<?= $value['quantity']; ?>">
                                            </td>
                                            <td width="10%" class="text-right text-info">
                                                <?= number_format($value['pdt_price']); ?>
                                            </td>
                                            <td width="10%" class="text-right text-info">
                                                <?= number_format($value['pdt_price'] * $value['quantity']); ?>
                                                <input type="hidden" name="total[]" value="<?= $value['pdt_price'] * $value['quantity']; ?>">
                                            </td>
                                            <td width="20%">
                                                <? if ($value['type_id'] == 1) {
                                                    $this->db->select("stock_id, stock_text");
                                                    $this->db->where(array('pdt_id' => $value['pdt_id']));
                                                    $query = $this->db->get('tb_productstock');
                                                    $listsize = $query->result_array();
                                                ?>
                                                    <select class="form-control show-tick" name="stock_id[]" id="stock_id<?=$value['pdt_id'];?>" required>
                                                        <option value="noselect">เลือกไซต์</option>
                                                        <? foreach ($listsize as $key => $v) { ?>
                                                            <option value="<?= $v['stock_id']; ?>"><?= $v['stock_text']; ?></option>
                                                        <? } ?>
                                                    </select>
                                                <? } elseif($value['type_id'] == 2) {
                                                    $this->db->select("stock_id");
                                                    $this->db->where(array('pdt_id' => $value['pdt_id']));
                                                    $query = $this->db->get('tb_productstock');
                                                    $listsize = $query->result_array();
                                                ?>
                                                    <input type="hidden" name="stock_id[]" value="<?= $listsize[0]['stock_id']; ?>">
                                                <? } else { ?>
                                                    <input type="hidden" name="stock_id[]" value="<?= NULL; ?>">
                                                <? } ?>
                                            </td>
                                        </tr>
                                    <? $numrow++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <!-- <hr> -->
                                <p class="m-b-0">ราคารวม:</p>
                                <h3 class="m-b-0 m-t-10"><strong class="text-danger"><? if(!empty($totals)){echo number_format(array_sum ( $totals ));} else { echo 0;}?></strong> บาท</h3>
                            </div>
                            <!-- hide input -->
                            <input type="hidden" name="std_id" id="std_id" value="<?= $dataStd[0]['std_id']; ?>">
                            <input type="hidden" name="orders_total" id="orders_total" value="<?= array_sum ( $totals ); ?>">
                            <div class="hidden-print col-md-12 text-right">
                                <hr>
                                <a href="<?=site_url('main/cancleorders');?>"><button class="btn btn-danger btn-round" type="button">ยกเลิก</button></a>
                                <button class="btn btn-primary btn-round" type="submit">สั่งซื้อ</button>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
        </form>
        <? } ?>
    </div>
</div>