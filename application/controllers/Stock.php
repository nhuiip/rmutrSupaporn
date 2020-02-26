<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Stock extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("product_model", "product");
        $this->load->model("stock_model", "stock");
    }

    public function index($typeid = "", $id = "")
    {
        if (!empty($typeid) && !empty($id) && $typeid == 1) {
            
            $condition = array();
            $condition['fide'] = "tb_productstock.*, tb_product.pdt_name,tb_product.pdt_id, CONCAT(ad_fullname) AS stock_create, CONCAT(ad_fullname) AS stock_lastedit";
            $condition['where'] = array('tb_productstock.pdt_id' => $id);
            $data['listdata'] = $this->stock->listData($condition);

            $condition = array();
            $condition['fide'] = "pdt_name";
            $condition['where'] = array('tb_product.pdt_id' => $id, 'pdt_delete_status' => 1);
            $pdt = $this->product->listData($condition);

            $this->template->js(array(
                base_url('assets/bundles/datatablescripts.bundle'),
                base_url('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min'),
                base_url('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min'),
                base_url('assets/plugins/jquery-datatable/buttons/buttons.html5.min'),
                base_url('assets/js/dataTables')
            ));

            $data['typeid'] =  $typeid;
            $data['pdtid'] =  $id;
            $data['pdtname'] =  $pdt[0]['pdt_name'];
            $data['header'] = 'Manage Stock';
            $this->template->title('Manage Stock');
            $this->template->backend('product/mainStock', $data);
        } else {
            show_404();
        }
    }

    public function form($typeid = "", $pdtid = "", $id = "")
    {
        if (!empty($typeid) && !empty($pdtid)) {
            if(!empty($id)){
                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('tb_productstock.stock_id' => $id);
                $data['listdata'] = $this->stock->listData($condition);
                if(count($data['listdata']) != 0){
                    $data['header'] = 'Update Stock';
                    $this->template->title('Update Stock');
                } else {
                    show_404();
                }
            } else {
                $data['header'] = 'Insert Stock';
                $this->template->title('Insert Stock');
            }

            $condition = array();
            $condition['fide'] = "pdt_name";
            $condition['where'] = array('tb_product.pdt_id' => $pdtid, 'pdt_delete_status' => 1);
            $pdt = $this->product->listData($condition);

            $data['typeid'] =  $typeid;
            $data['pdtid'] =  $pdtid;
            $data['pdtname'] =  $pdt[0]['pdt_name'];
            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('product/formStock', $data);

        }
    }

    public function checkstock($pdtid = "", $id = "")
    {
        // input
        $stock_text = $this->input->post('stock_text');
        // $stock_text = 'S';
        if (!empty($stock_text)) {
            // check for update form
            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "stock_id";
                $condition['where'] = array('stock_id !=' => $id, 'stock_text' => $stock_text, 'tb_productstock.pdt_id' => $pdtid);
                $listdata = $this->stock->listData($condition);
                if (count($listdata) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
            // check for insert form
            else {
                $condition = array();
                $condition['fide'] = "stock_id";
                $condition['where'] = array('stock_text' => $stock_text, 'tb_productstock.pdt_id' => $pdtid);
                $listdata = $this->stock->listData($condition);
                if (count($listdata) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        }
    }

    public function create($typeid = '', $pdtid = "")
    {
        if ($this->tokens->verify('formcrf') && !empty($typeid) && !empty($pdtid)) {
            $data = array(
                'pdt_id' => $pdtid,
                'stock_text' => $this->input->post('stock_text'),
                'stock_quantity' => $this->input->post('stock_quantity'),
                'stock_create' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'stock_create_date' => date('Y-m-d H:i:s'),
                'stock_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'stock_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->stock->insertData($data);
            $result = array(
                'error' => false,
                'title' => "Success",
                'msg' => "Insert data success",
                'url' => site_url('stock/index/'.$typeid.'/'.$pdtid)
            );
            echo json_encode($result);
        }
    }

    public function update($typeid = "", $pdtid = "", $id)
    {
        if ($this->tokens->verify('formcrf') && !empty($typeid) && !empty($pdtid) && !empty($id)) {
            if($typeid == 1){
                $data = array(
                    'stock_id' => $id,
                    'stock_text' => $this->input->post('stock_text'),
                    'stock_quantity' => $this->input->post('stock_quantity')+$this->input->post('add_stock_quantity'),
                    'stock_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                    'stock_lastedit_date' => date('Y-m-d H:i:s'),
                );
                $url = site_url('stock/index/'.$typeid.'/'.$pdtid);
            } elseif($typeid == 2){
                $data = array(
                    'stock_id' => $id,
                    'stock_quantity' => $this->input->post('stock_quantity')+$this->input->post('add_stock_quantity'),
                    'stock_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                    'stock_lastedit_date' => date('Y-m-d H:i:s'),
                );
                $url = site_url('product/index/'.$typeid);
            }
            $id = $this->stock->updateData($data);
            $result = array(
                'error' => false,
                'title' => "Success",
                'msg' => "Update data success",
                'url' => $url
            );
            echo json_encode($result);
        }
    }

    public function delete($typeid,$pdtid,$id)
    {
        $data = array(
            'stock_id' => $id,
        );
        $id = $this->stock->deleteData($data);
        header("location:" . site_url('stock/index/'.$typeid.'/'.$pdtid));
    }
}
