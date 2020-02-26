<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Product extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("product_model", "product");
        $this->load->model("stock_model", "stock");
    }

    public function index($id = "")
    {

        if (!empty($id)) {
            $condition = array();
            $condition['fide'] = "CONCAT(ad_fullname) AS pdt_create,  CONCAT(ad_fullname) AS pdt_lastedit, tb_product.pdt_id, tb_product.type_id, pdt_name, pdt_price, pdt_create_date, pdt_lastedit_date, stockid, stock_quantity";
            // $condition['fide'] = "*";
            $condition['where'] = array('tb_product.type_id' => $id, 'pdt_delete_status' => 1);
            $condition['orderby'] = "pdt_name ASC";
            $data['listdata'] = $this->product->listData($condition);

            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('type_id' => $id);
            $typePdt = $this->product->listType($condition);

            $this->template->js(array(
                base_url('assets/bundles/datatablescripts.bundle'),
                base_url('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min'),
                base_url('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min'),
                base_url('assets/plugins/jquery-datatable/buttons/buttons.html5.min'),
                base_url('assets/js/dataTables')
            ));

            $data['typeid'] =  $id;
            $data['header'] = 'Manage ' . $typePdt[0]['type_name'];
            $this->template->title('Manage ' . $typePdt[0]['type_name']);
            $this->template->backend('product/main', $data);
        } else {
            show_404();
        }
    }

    public function form($typeid = "", $id = "")
    {
        if (!empty($typeid)) {
            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('type_id' => $typeid);
            $typePdt = $this->product->listType($condition);
            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "tb_product.*";
                $condition['where'] = array('tb_product.pdt_id' => $id, 'pdt_delete_status' => 1);
                $data['listdata'] = $this->product->listData($condition);

                $data['header'] = 'Update '.$typePdt[0]['type_name'];
                $this->template->title('Update '.$typePdt[0]['type_name']);
                if (count($data['listdata']) == 0) {
                    show_404();
                    die;
                }
            } else {
                $data['header'] = 'Insert '.$typePdt[0]['type_name'];
                $this->template->title('Insert '.$typePdt[0]['type_name']);
            }

            $data['typeid'] =  $typeid;
            $data['typename'] =  $typePdt[0]['type_name'];
            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('product/form', $data);
        } else {
            show_404();
        }
    }

    public function checkName($id = '')
    {
        // input
        $pdt_name = $this->input->post('pdt_name');
        // $pdt_name = 'เทคโนโลยีวิศวกรรมคอมพิวเตอร์';
        if (!empty($pdt_name)) {
            // check for update form
            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "tb_product.pdt_id";
                $condition['where'] = array('tb_product.pdt_id !=' => $id, 'pdt_name' => $pdt_name, 'pdt_delete_status' => 1);
                $listdata = $this->product->listData($condition);
                if (count($listdata) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
            // check for insert form
            else {
                $condition = array();
                $condition['fide'] = "tb_product.pdt_id";
                $condition['where'] = array('pdt_name' => $pdt_name, 'pdt_delete_status' => 1);
                $listdata = $this->product->listData($condition);
                if (count($listdata) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        }
    }

    public function create($typeid = '')
    {
        if ($this->tokens->verify('formcrf') && !empty($typeid)) {
            $data = array(
                'type_id' => $typeid,
                'pdt_name' => $this->input->post('pdt_name'),
                'pdt_price' => $this->input->post('pdt_price'),
                'pdt_create' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'pdt_create_date' => date('Y-m-d H:i:s'),
                'pdt_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'pdt_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $id = $this->product->insertData($data);

            // insert stock for Accessories
            if($typeid == 2){
                $data = array(
                    'pdt_id' => $id,
                    'stock_quantity' => 0,
                    'stock_create' => $this->encryption->decrypt($this->input->cookie('sysli')),
                    'stock_create_date' => date('Y-m-d H:i:s'),
                    'stock_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                    'stock_lastedit_date' => date('Y-m-d H:i:s'),
                );
                $stock = $this->stock->insertData($data);
                $datas = array(
                    'pdt_id' => $id,
                    'stockid' => $stock
                );
                $this->product->updateData($datas);
            }

            $result = array(
                'error' => false,
                'title' => "Success",
                'msg' => "Insert data success",
                'url' => site_url('product/index/'.$typeid)
            );
            echo json_encode($result);
        }
    }

    public function update($typeid ="",$id="")
    {

        if ($this->tokens->verify('formcrf') && !empty($typeid)) {
            $data = array(
                'pdt_id' => $id,
                'pdt_name' => $this->input->post('pdt_name'),
                'pdt_price' => $this->input->post('pdt_price'),
                'pdt_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'pdt_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->product->updateData($data);
            $result = array(
                'error' => false,
                'title' => "Success",
                'msg' => "Update data success",
                'url' => site_url('product/index/'.$typeid)
            );
            echo json_encode($result);
        }
    }

    public function delete($typeid,$id)
    {
        $data = array(
            'pdt_id' => $id,
            'pdt_delete_status' => 0,
        );
        $id = $this->product->updateData($data);
        header("location:" . site_url('product/index/'.$typeid));
    }
}
