<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Main extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("student_model", "student");
        $this->load->model("package_model", "package");
        $this->load->model("stock_model", "stock");
        $this->load->model("orders_model", "orders");
        $this->load->model("detailpackage_model", "detailpackage");
    }

    public function index()
    {
        $data = array();
        if (!empty($this->input->cookie('stdnumber'))) {

            $std_number = $this->encryption->decrypt($this->input->cookie('stdnumber'));

            $condition = array();
            $condition['fide'] = "tb_student.std_id, tb_student.dept_id, tb_student.stdtype_id, tb_student.sex_id, std_number, std_title, std_fname, std_lname, dept_name, stdtype_text, sex_text";
            $condition['where'] = array('std_number' => $std_number);
            $data['dataStd'] = $this->student->listData($condition);

            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array(
                'tb_package.dept_id' => $data['dataStd'][0]['dept_id'],
                'tb_package.stdtype_id' => $data['dataStd'][0]['stdtype_id'],
                'tb_package.sex_id' => $data['dataStd'][0]['sex_id'],
            );
            $condition['orderby'] = "type_id ASC, pdt_name asc";
            $data['dataPdt'] = $this->detailpackage->listData($condition);
            $data['stdnumber'] = $std_number;
        }
        $this->template->title('ระบบสั่งซื้อเครื่องแบบนักศึกษาใหม่');
        $this->template->frontend('main/main', $data);
    }

    public function findstdnumber()
    {
        // input
        // $std_number = $this->input->post('std_number');
        $std_number = '2621031441301';
        if (!empty($std_number)) {
            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('std_number' => $std_number);
            $listdata = $this->student->listData($condition);
            if (count($listdata) == 0) {
                echo "false";
            } else {
                echo "true";
            }
        } else {
            echo "false";
        }
    }

    public function getnumber()
    {
        $std_number = $this->encryption->encrypt($this->input->post('std_number'));
        $cookie = array(
            'name'   => 'stdnumber',
            'value'  => $std_number,
            'expire' => '86500',
            'path'   => '/'
        );
        $this->input->set_cookie($cookie);
        header("location:" . site_url('main/index'));
    }
    public function orders()
    {

        if (in_array('noselect', $this->input->post('stock_id'))) {
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
            'std_id' => $this->input->post('std_id'),
            'orders_total' => $this->input->post('orders_total'),
            'orders_date' => date('Y-m-d H:i:s'),
            'orders_status' => 1,
            'orders_type' => 1,
            'orders_note' => '',
        );
        $id = $this->orders->insertOrder($data);

        // add detail order
        for ($i = 0; $i < count($this->input->post('pdt_id')); $i++) {
            // ตัดสต็อกด้วย
            if ($this->input->post('type_id')[$i] == 1 || $this->input->post('type_id')[$i] == 2) {
                // หา stock
                $condition = array();
                $condition['fide'] = "stock_text, stock_quantity";
                $condition['where'] = array('stock_id' => $this->input->post('stock_id')[$i]);
                $size = $this->stock->listData($condition);
                // มี stock ให้ตัด
                if (count($size) != 0) {
                    $detail = array(
                        'orders_id' => $id,
                        'pdt_id' => $this->input->post('pdt_id')[$i],
                        'size' => $size[0]['stock_text'],
                        'quantity' => $this->input->post('quantity')[$i],
                        'total' => $this->input->post('total')[$i],
                    );
                    $this->orders->insertDetail($detail);
                    $stock = array(
                        'stock_id' => $this->input->post('stock_id')[$i],
                        'stock_quantity' => $size[0]['stock_quantity'] - $this->input->post('quantity')[$i]
                    );
                    $this->orders->updateStock($stock);
                    // ไม่มีสต็อกให้ตัด
                } else {
                    $detail = array(
                        'orders_id' => $id,
                        'pdt_id' => $this->input->post('pdt_id')[$i],
                        'size' => NULL,
                        'quantity' => $this->input->post('quantity')[$i],
                        'total' => $this->input->post('total')[$i],
                    );
                    $this->orders->insertDetail($detail);
                }
                // ไม่ตัดสต็อก
            } else {
                $detail = array(
                    'orders_id' => $id,
                    'pdt_id' => $this->input->post('pdt_id')[$i],
                    'size' => NULL,
                    'quantity' => $this->input->post('quantity')[$i],
                    'total' => $this->input->post('total')[$i],
                );
                $this->orders->insertDetail($detail);
            }
        }

        // ผ่าน
        delete_cookie("stdnumber");
        $result = array(
            'error' => false,
            'url' => site_url('main/success'),
        );
        echo json_encode($result);
        die;
    }

    public function success()
    {
        $this->load->view('main/success');
    }

    public function cancleorders()
    {
        delete_cookie("stdnumber");
        header("location:" . site_url('main/index'));
    }
}
