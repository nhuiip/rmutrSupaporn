<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Detailpackage extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("package_model", "package");
        $this->load->model("product_model", "product");
        $this->load->model("department_model", "department");
        $this->load->model("detailpackage_model", "detailpackage");
    }

    public function index($packid = "")
    {
        if (!empty($packid)) {
            $condition = array();
            $condition['fide'] = "tb_package.*,tb_department.dept_name, tb_studenttype.stdtype_text, tb_studentsex.sex_text";
            $condition['where'] = array('tb_package.pack_id' => $packid);
            $datalist = $this->package->listData($condition);

            $condition = array();
            $condition['fide'] = "tb_packagedetail.*, pdt_name, pdt_price, CONCAT(ad_fullname) AS create_id, CONCAT(ad_fullname) AS lastedit_id";
            $condition['where'] = array('tb_packagedetail.pack_id' => $packid);
            $condition['orderby'] = "type_id ASC, pdt_name asc";
            $data['listdata'] = $this->detailpackage->listData($condition);

            if (count($data['listdata']) != 0) {
                foreach ($data['listdata'] as $key => $v) {
                    $pdtid[$key] = $v['pdt_id'];
                }
            }

            if (count($datalist) != 0) {

                $condition = array();
                $condition['fide'] = "tb_product.pdt_id, pdt_name, pdt_price";
                $condition['where'] = array('tb_product.type_id' => 1, 'pdt_delete_status' => 1);
                if (isset($pdtid) && count($pdtid) != 0) {
                    $condition['where_not_in']['filde'] = 'tb_product.pdt_id';
                    $condition['where_not_in']['value'] = $pdtid;
                }
                $condition['orderby'] = "pdt_name ASC";
                $data['listuniform'] = $this->product->listData($condition);

                $condition = array();
                $condition['fide'] = "tb_product.pdt_id, pdt_name, pdt_price";
                $condition['where'] = array('tb_product.type_id' => 2, 'pdt_delete_status' => 1);
                if (isset($pdtid) && count($pdtid) != 0) {
                    $condition['where_not_in']['filde'] = 'tb_product.pdt_id';
                    $condition['where_not_in']['value'] = $pdtid;
                }
                $condition['orderby'] = "pdt_name ASC";
                $data['listacces'] = $this->product->listData($condition);

                $condition = array();
                $condition['fide'] = "tb_product.pdt_id, pdt_name, pdt_price";
                $condition['where'] = array('tb_product.type_id' => 3, 'pdt_delete_status' => 1);
                if (isset($pdtid) && count($pdtid) != 0) {
                    $condition['where_not_in']['filde'] = 'tb_product.pdt_id';
                    $condition['where_not_in']['value'] = $pdtid;
                }
                $condition['orderby'] = "pdt_name ASC";
                $data['listfee'] = $this->product->listData($condition);

                $this->template->js(array(
                    base_url('assets/bundles/datatablescripts.bundle'),
                    base_url('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min'),
                    base_url('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min'),
                    base_url('assets/plugins/jquery-datatable/buttons/buttons.html5.min'),
                    base_url('assets/js/dataTables')
                ));

                $data['packid'] =  $packid;
                $data['deptname'] =  $datalist[0]['dept_name'];
                $data['stdtypetext'] =  $datalist[0]['stdtype_text'];
                $data['sextext'] =  $datalist[0]['sex_text'];
                $data['header'] = 'Set Package';
                $data['formcrf'] = $this->tokens->token('formcrf');
                $this->template->title('Set Package');
                $this->template->backend('package/mainDetail', $data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }
    public function addProduct($packid = "")
    {
        if ($this->tokens->verify('formcrf') && !empty($packid)) {
            foreach ($this->input->post('optgroup') as $key => $value) {
                $data = array(
                    'pack_id' => $packid,
                    'pdt_id' => $value,
                    'quantity' => 1,
                    'create_id' => $this->encryption->decrypt($this->input->cookie('sysli')),
                    'create_date' => date('Y-m-d H:i:s'),
                    'lastedit_id' => $this->encryption->decrypt($this->input->cookie('sysli')),
                    'lastedit_date' => date('Y-m-d H:i:s'),
                );
                $this->detailpackage->insertData($data);
            }
        }
        $result = array(
            'error' => false,
            'title' => "Success",
            'msg' => "add Product success",
            'url' => site_url('detailpackage/index/' . $packid)
        );
        echo json_encode($result);
    }

    public function update($packid = "", $pdtid = "")
    {
        if(!empty($packid) && $pdtid){
            $data = array(
                'pack_id' => $packid,
                'pdt_id' => $pdtid,
                'quantity' => $this->input->post('unit'),
            );
        }
        $this->detailpackage->updateData($data);
        $result = array(
            'error' => false,
            'title' => "Success",
            'msg' => "update Unit success",
            'url' => site_url('detailpackage/index/' . $packid)
        );
        echo json_encode($result);
    }

    public function delete($packid,$pdtid)
    {
        $data = array(
            'pack_id' => $packid,
            'pdt_id' => $pdtid,
        );
        $id = $this->detailpackage->deleteData($data);
        header("location:" . site_url('detailpackage/index/'.$packid));
    }
}
