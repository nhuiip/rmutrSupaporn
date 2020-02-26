<?php

use Svg\Tag\StyleTag;

defined('BASEPATH') or exit('No direct script access allowed');
class Orders extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("orders_model", "orders");
        $this->load->model("student_model", "student");
        $this->load->model("department_model", "department");


        $this->load->library('pdf'); // 
    }

    public function index($id = '')
    {
        if (!empty($id)) {
            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('tb_student.dept_id' => $id);
            $condition['orderby'] = "tb_student.std_number ASC, orders_status ASC";
            $data['listdata'] = $this->orders->listData($condition);

            $condition = array();
            $condition['fide'] = "dept_name";
            $condition['where'] = array('dept_id' => $id);
            $deptname = $this->department->listData($condition);

            $this->template->css(array(
                'https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min',
            ));
            $this->template->js(array(
                base_url('assets/bundles/datatablescripts.bundle'),
                base_url('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min'),
                base_url('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min'),
                base_url('assets/plugins/jquery-datatable/buttons/buttons.html5.min'),
                base_url('assets/plugins/jquery-datatable/Responsive/js/dataTables.responsive.min'),
                base_url('assets/js/dataTables')
            ));

            $data['deptid'] =  $id;
            $data['deptname'] =  $deptname[0]['dept_name'];
            $data['header'] = 'Manage Orders';
            $this->template->title('Manage Orders');
            $this->template->backend('orders/main', $data);
        } else {
            show_404();
        }
    }

    public function detail($deptid = '', $id = '')
    {
        if (!empty($id)) {
            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('tb_ordersdetail.orders_id' => $id);
            $condition['orderby'] = "size DESC, pdt_name ASC";
            $data['listdata'] = $this->orders->listDetail($condition);
            if (count($data['listdata']) != 0) {
                $condition = array();
                $condition['fide'] = "dept_name, fac_name";
                $condition['where'] = array('dept_id' => $deptid);
                $deptname = $this->department->listData($condition);

                $this->template->css(array(
                    'https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min',
                ));
                $this->template->js(array(
                    base_url('assets/bundles/datatablescripts.bundle'),
                    base_url('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min'),
                    base_url('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min'),
                    base_url('assets/plugins/jquery-datatable/buttons/buttons.html5.min'),
                    base_url('assets/plugins/jquery-datatable/Responsive/js/dataTables.responsive.min'),
                    base_url('assets/js/dataTables')
                ));

                $data['deptid'] =  $deptid;
                $data['deptname'] =  $deptname[0]['dept_name'];
                $data['facname'] =  $deptname[0]['fac_name'];

                $data['ordersid'] = $id;
                $data['orderstotal'] = $data['listdata'][0]['orders_total'];
                $data['ordersdate'] = $data['listdata'][0]['orders_date'];

                $data['header'] = 'Detail Orders';
                $this->template->title('Detail Orders');
                $this->template->backend('orders/detail', $data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }


    public function changeExt($deptid, $id)
    {
        $data = array(
            'orders_id' => $id,
            'orders_status' => 2,
            'orders_note' => $this->input->post('note'),
        );
        $id = $this->orders->UpdateData($data);
        header("location:" . site_url('orders/index/' . $deptid));
    }

    public function changeSS($deptid, $id)
    {
        $data = array(
            'orders_id' => $id,
            'orders_status' => 3,
            'orders_note' => $this->input->post('note'),
        );
        $id = $this->orders->UpdateData($data);
        header("location:" . site_url('orders/index/' . $deptid));
    }

    public function invoices($id)
    {
        if (!empty($id)) {
            $data['listSet'] = $this->orders->listSetting();

            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('tb_ordersdetail.orders_id' => $id);
            $condition['orderby'] = "size DESC, pdt_name ASC";
            $data['listdetail'] = $this->orders->listDetail($condition);

            if (count($data['listdetail']) == 0) {
                show_404();
            } else {
                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('tb_student.std_id' => $data['listdetail'][0]['std_id']);
                $data['listStd'] = $this->student->listData($condition);

                if (count($data['listStd']) == 0) {
                    show_404();
                } else {
                    $this->load->view('orders/tempInvoices', $data);
                }
            }
        } else {
            show_404();
        }
    }

}
