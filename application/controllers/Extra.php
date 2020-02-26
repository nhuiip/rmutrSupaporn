<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Extra extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("student_model", "student");
        $this->load->model("product_model", "product");
        $this->load->model("orders_model", "orders");
        $this->load->library('cart');
    }

    public function index()
    {
        $cartData = $this->cart->contents();
        if (isset($cartData) && count($cartData) != 0) {
            $pdtid = array();
            $i = 0;
            foreach ($cartData as $key => $value) {
                $pdtid[$i] = $value['id'];
                $i++;
            }
        }
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

        $this->template->title('ระบบสั่งซื้อเครื่องแบบนักศึกษาใหม่');
        $this->template->frontend('main/mainExtra', $data);
    }

    public function setCookie()
    {
        $condition = array();
        $condition['fide'] = "tb_product.*";
        $condition['where'] = array('pdt_delete_status' => 1);
        $condition['where_in']['filde'] = 'tb_product.pdt_id';
        $condition['where_in']['value'] = $this->input->post('optgroup');
        $condition['orderby'] = "tb_product.type_id ASC, tb_product.pdt_name ASC";
        $listData = $this->product->listData($condition);

        foreach ($listData as $key => $value) {
            if ($value['type_id'] == 1) {
                $data = array(
                    'id'      => $value['pdt_id'],
                    'type'    => $value['type_id'],
                    'qty'     => 1,
                    'name'    => $value['pdt_name'],
                    'price'   => $value['pdt_price'],
                    'options' => 'noselect'
                );
            } else {
                $data = array(
                    'id'      => $value['pdt_id'],
                    'type'    => $value['type_id'],
                    'qty'     => 1,
                    'name'    => $value['pdt_name'],
                    'price'   => $value['pdt_price'],
                    'options' => NULL
                );
            }

            $this->cart->insert($data);
        }
        header("location:" . site_url('extra/index'));
    }

    public function updateSize($rowid)
    {
        // input
        // $rowid = $this->input->post('rowid');
        $options = $this->input->post('val');
        // $rowid = 'b43f9620de09fffd0c3966575f28da09';
        // $options = 'S';
        if (!empty($rowid) && !empty($options)) {

            $data = array(
                'rowid' => $rowid,
                'options'   => $options
            );
            $this->cart->update($data);

            echo "true";
            die;
        } else {
            echo "false";
            die;
        }
    }

    public function updateQty($rowid)
    {
        $qty = $this->input->post('val');
        if (!empty($rowid) && !empty($qty)) {

            $data = array(
                'rowid' => $rowid,
                'qty'   => $qty
            );
            $this->cart->update($data);

            $result = array(
                'subtotal' => $this->cart->contents()[$rowid]['subtotal'],
                'total' => $this->cart->total()
            );
            echo json_encode($result);
            die;
        } else {
            echo "false";
            die;
        }
    }

    public function deleteCart($rowid)
    {
        $this->cart->remove($rowid);
        header("location:" . site_url('extra/index'));
    }

    public function cancleorders()
    {
        $this->cart->destroy();
        header("location:" . site_url('extra/index'));
    }

    public function getData()
    {
        $std_number = $this->input->post('val');
        if (!empty($std_number)) {
            $condition = array();
            $condition['fide'] = "tb_student.std_id, tb_student.dept_id, tb_student.stdtype_id, tb_student.sex_id, std_number, std_title, std_fname, std_lname, dept_name, stdtype_text, sex_text";
            $condition['where'] = array('std_number' => $std_number);
            $dataStd = $this->student->listData($condition);
            if (count($dataStd) != 0) {
                $result = array(
                    'stdid' => $dataStd[0]['std_id'],
                    'stdnumber' => $dataStd[0]['std_number'],
                    'fullname' => $dataStd[0]['std_title'] . ' ' . $dataStd[0]['std_fname'] . ' ' . $dataStd[0]['std_lname'],
                    'deptname' => $dataStd[0]['dept_name'],
                    'stdtypetext' => $dataStd[0]['stdtype_text'],
                    'sextext' => $dataStd[0]['sex_text'],
                );
                echo json_encode($result);
                die;
            } else {
                echo "false";
                die;
            }
        } else {
            echo "false";
            die;
        }
    }

    public function orders()
    {
        $cartData = $this->cart->contents();
        if (isset($cartData) && count($cartData) != 0) {
            $options = array();
            $i = 0;
            foreach ($cartData as $key => $value) {
                $options[$i] = $value['options'];
                $i++;
            }
        }
        if (in_array('noselect', $options)) {
            $result = array(
                'error' => true,
                'title' => "Warning",
                'msg' => "กรุณาเลือกไซต์เครื่องแบบให้ครบถ้วน",
            );
            echo json_encode($result);
            die;
        }
        // add order
        $data = array(
            'std_id' => 1,
            'orders_total' => $this->cart->total(),
            'orders_date' => date('Y-m-d H:i:s'),
            'orders_status' => 1,
            'orders_type' => 2,
            'orders_note' => '',
        );
        $id = $this->orders->insertOrder($data);
        //add detail
        foreach ($cartData as $key => $value) {
            $detail = array(
                'orders_id' => $id,
                'pdt_id' => $value['id'],
                'size' => $value['options'],
                'quantity' => $value['qty'],
                'total' => $value['subtotal'],
            );
            $this->orders->insertDetail($detail);
        }

        // ผ่าน
        $this->cart->destroy();
        $result = array(
            'error' => false,
            'url' => site_url('main/success'),
        );
        echo json_encode($result);
        die;
        header("location:" . site_url('extra/index'));
    }
    public function viewCart()
    {
        echo '<pre>';
        print_r($this->cart->contents());
        echo '</pre>';
        die;
    }
}
