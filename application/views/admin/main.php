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
                <table class="table table-bordered table-hover dataTables" data-urladd="<?= site_url('admin/form'); ?>">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email (User)</th>
                            <th>Inser Data</th>
                            <th>Last Edit</th>
                            <th></th>
                            <th>Last Login</th>
                        </tr>
                    </thead>
                    <? if (count($listdata) != 0) { ?>
                    <tbody>
                        <? $numrow = 1;
                        foreach ($listdata as $key => $value) { ?>
                            <tr class="gradeX">
                                <td width="10%"><strong><?= "A" . str_pad($numrow, 3, "0", STR_PAD_LEFT); ?></strong></td>
                                <td width="15%">
                                    <?= $value['ad_fullname'] ?><br />
                                    <small><?= $value['position'] ?></small>
                                </td>
                                <td width="20%"><?= $value['ad_email'] ?></td>
                                <td width="15%">
                                    <?
                                    if ($value['ad_create'] != 0) {
                                        $this->db->select("ad_fullname");
                                        $this->db->where("ad_id", $value['ad_create']);
                                        $ad_create = $this->db->get('tb_admin');
                                        $adcreate = $ad_create->result_array();

                                        if (count($adcreate) != 0) {
                                            echo $adcreate[0]['ad_fullname'].'<br />';
                                        }
                                    }
                                    ?>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <? if($value['ad_create_date'] != ''){ echo date('d/m/Y h:i A', strtotime($value['ad_create_date']));} ?></small>
                                </td>
                                <td width="15%">
                                    <?
                                    if ($value['ad_lastedit'] != 0) {
                                        $this->db->select("ad_fullname");
                                        $this->db->where("ad_id", $value['ad_lastedit']);
                                        $ad_lastedit = $this->db->get('tb_admin');
                                        $adlastedit = $ad_lastedit->result_array();

                                        if (count($adlastedit) != 0) {
                                            echo $adlastedit[0]['ad_fullname'].'<br />';
                                        }
                                    }
                                    ?>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i> <? if($value['ad_lastedit_date'] != ''){ echo date('d/m/Y h:i A', strtotime($value['ad_lastedit_date']));} ?></small>
                                </td>
                                <td width="10%">
                                    <center>
                                        <div class="dropdown">
                                            <?if($this->encryption->decrypt($this->input->cookie('sysp')) == 'Administrator' || $this->encryption->decrypt($this->input->cookie('sysp')) == 'Support'){ ?>
                                            <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                            <? }else{ ?>
                                            <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled="disabled">Action</button>
                                            <? } ?>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?= site_url('admin/form/' . $value['ad_id']); ?>">Update Data</a>
                                                <a class="dropdown-item" href="<?= site_url('admin/formRepass/' . $value['ad_id']); ?>">Change Password</a>
                                                <a class="dropdown-item text-danger" onclick="fncDelete(this)" data-url="<?= site_url('admin/delete/' . $value['ad_id']); ?>">Delete</a>
                                            </div>
                                        </div>
                                    </center>
                                </td>
                                <td width="15%" class="center"><? if($value['ad_lastlogin'] != ''){ echo date('d/m/Y h:i A', strtotime($value['ad_lastlogin']));} ?></td>
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