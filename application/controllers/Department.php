<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Department extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("faculty_model", "faculty");
        $this->load->model("department_model", "department");
    }

    public function index($id = "")
    {

        if (!empty($id)) {
            $condition = array();
            $condition['fide'] = "dept.fac_id, fac_name, dept_id, dept_name, dept_create_date, dept_lastedit_date, CONCAT(ad_fullname) AS dept_create,  CONCAT(ad_fullname) AS dept_lastedit";
            $condition['where'] = array('dept.fac_id' => $id);
            $condition['orderby'] = "dept_name ASC";
            $data['listdata'] = $this->department->listData($condition);

            $condition = array();
            $condition['fide'] = "fac_name";
            $condition['where'] = array('fac_id' => $id);
            $facname = $this->faculty->listData($condition);

            // get list for dev
            // echo '<pre>';
            // print_r($data['listdata']);
            // echo '</pre>';
            // die;

            $this->template->js(array(
                base_url('assets/bundles/datatablescripts.bundle'),
                base_url('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min'),
                base_url('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min'),
                base_url('assets/plugins/jquery-datatable/buttons/buttons.html5.min'),
                base_url('assets/js/dataTables')
            ));

            $data['facid'] =  $id;
            $data['facname'] =  $facname[0]['fac_name'];
            $data['header'] = 'Manage Department';
            $this->template->title('Manage Department');
            $this->template->backend('department/main', $data);
        } else {
            show_404();
        }
    }

    public function form($facid="", $id = '')
    {
        if (!empty($facid)) {
            $condition = array();
            $condition['fide'] = "fac_name";
            $condition['where'] = array('fac_id' => $facid);
            $facname = $this->faculty->listData($condition);
            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('dept_id' => $id);
                $data['listdata'] = $this->department->listData($condition);

                $data['header'] = 'Update Department';
                $this->template->title('Update Department');
                if (count($data['listdata']) == 0) {
                    show_404();
                    die;
                }
            } else {
                $data['header'] = 'Insert Department';
                $this->template->title('Insert Department');
            }

            $data['facid'] =  $facid;
            $data['facname'] =  $facname[0]['fac_name'];
            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('department/form', $data);
        } else {
            show_404();
        }
    }

    public function checkName($id = '')
    {
        // input
        $dept_name = $this->input->post('dept_name');
        // $dept_name = 'เทคโนโลยีวิศวกรรมคอมพิวเตอร์';
        if (!empty($dept_name)) {
            // check for update form
            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "dept_id";
                $condition['where'] = array('dept_id !=' => $id, 'dept_name' => $dept_name);
                $listdata = $this->department->listData($condition);
                if (count($listdata) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
            // check for insert form
            else {
                $condition = array();
                $condition['fide'] = "dept_id";
                $condition['where'] = array('dept_name' => $dept_name);
                $listdata = $this->department->listData($condition);
                if (count($listdata) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        }
    }

    public function create($facid = '')
    {
        if ($this->tokens->verify('formcrf') && !empty($facid)) {
            $data = array(
                'fac_id' => $facid,
                'dept_name' => $this->input->post('dept_name'),
                'dept_create' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'dept_create_date' => date('Y-m-d H:i:s'),
                'dept_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'dept_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->department->insertData($data);
            $result = array(
                'error' => false,
                'title' => "Success",
                'msg' => "Insert data success",
                'url' => site_url('department/index/'.$facid)
            );
            echo json_encode($result);
        }
    }

    public function update($facid = '',$id)
    {

        if ($this->tokens->verify('formcrf') && !empty($facid)) {
            $data = array(
                'dept_id' => $id,
                'dept_name' => $this->input->post('dept_name'),
                'dept_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'dept_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $id = $this->department->updateData($data);
            $result = array(
                'error' => false,
                'title' => "Success",
                'msg' => "Update data success",
                'url' => site_url('department/index/'.$facid)
            );
            echo json_encode($result);
        }
    }

    public function delete($facid,$id)
    {
        $data = array(
            'dept_id' => $id,
        );
        $id = $this->department->deleteData($data);
        header("location:" . site_url('department/index/'.$facid));
    }
}
