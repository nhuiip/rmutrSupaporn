<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Package extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("package_model", "package");
        $this->load->model("department_model", "department");
    }

    public function index($id = "")
    {
        if (!empty($id)) {
            $condition = array();
            $condition['fide'] = "tb_package.*, CONCAT(dept_name) AS dept_id, CONCAT(ad_fullname) AS pack_create, CONCAT(ad_fullname) AS pack_lastedit, sex_text, stdtype_text";
            $condition['where'] = array('tb_package.dept_id' => $id);
            $condition['orderby'] = "tb_package.stdtype_id ASC, tb_package.sex_id";
            $data['listdata'] = $this->package->listData($condition);

            $condition = array();
            $condition['fide'] = "dept_name";
            $condition['where'] = array('dept_id' => $id);
            $deptname = $this->department->listData($condition);

            $this->template->js(array(
                base_url('assets/bundles/datatablescripts.bundle'),
                base_url('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min'),
                base_url('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min'),
                base_url('assets/plugins/jquery-datatable/buttons/buttons.html5.min'),
                base_url('assets/js/dataTables')
            ));

            $data['deptid'] =  $id;
            $data['deptname'] =  $deptname[0]['dept_name'];
            $data['header'] = 'Manage Package';
            $this->template->title('Manage Package');
            $this->template->backend('package/main', $data);
        } else {
            show_404();
        }
    }

    public function form($deptid = "", $id = "")
    {
        if (!empty($deptid)) {
            $condition = array();
            $condition['fide'] = "dept_name";
            $condition['where'] = array('dept_id' => $deptid);
            $deptname = $this->department->listData($condition);

            $condition = array();
            $condition['fide'] = "*";
            $condition['orderby'] = "sex_text ASC";
            $data['listSex'] = $this->package->listSex($condition);

            $condition = array();
            $condition['fide'] = "*";
            $condition['orderby'] = "stdtype_text ASC";
            $data['listStdtype'] = $this->package->listStdtype($condition);

            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "tb_package.*";
                $condition['where'] = array('pack_id' => $id);
                $data['listdata'] = $this->package->listData($condition);

                $data['header'] = 'Update Package';
                $this->template->title('Update Package');
                if (count($data['listdata']) == 0) {
                    show_404();
                    die;
                }
            } else {
                $data['header'] = 'Insert Package';
                $this->template->title('Insert Package');
            }

            $data['deptid'] =  $deptid;
            $data['deptname'] =  $deptname[0]['dept_name'];
            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('package/form', $data);
        } else {
            show_404();
        }
    }

    public function create($deptid = '')
    {
        if ($this->tokens->verify('formcrf') && !empty($deptid)) {
            $condition = array();
            $condition['fide'] = "tb_package.pack_id";
            $condition['where'] = array(
                'tb_package.dept_id' => $deptid,
                'tb_package.sex_id' => $this->input->post('sex_id'),
                'tb_package.stdtype_id' => $this->input->post('stdtype_id'),
            );

            $checks = $this->package->listData($condition);
            if (count($checks) == 0) {
                $data = array(
                    'dept_id' => $deptid,
                    'sex_id' => $this->input->post('sex_id'),
                    'stdtype_id' => $this->input->post('stdtype_id'),
                    'pack_create' => $this->encryption->decrypt($this->input->cookie('sysli')),
                    'pack_create_date' => date('Y-m-d H:i:s'),
                    'pack_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                    'pack_lastedit_date' => date('Y-m-d H:i:s'),
                );
                $this->package->insertData($data);

                $result = array(
                    'error' => false,
                    'title' => "Success",
                    'msg' => "Insert data success",
                    'url' => site_url('package/index/' . $deptid)
                );
                echo json_encode($result);
            } else {
                $result = array(
                    'error' => true,
                    'title' => "Warning",
                    'msg' => "This Package is already",
                );
                echo json_encode($result);
            }
        }
    }

    public function update($deptid = '', $id = '')
    {
        if ($this->tokens->verify('formcrf') && !empty($deptid) && $id) {
            $condition = array();
            $condition['fide'] = "tb_package.pack_id";
            $condition['where'] = array(
                'tb_package.pack_id !=' => $id,
                'tb_package.dept_id' => $deptid,
                'tb_package.sex_id' => $this->input->post('sex_id'),
                'tb_package.stdtype_id' => $this->input->post('stdtype_id'),
            );

            $checks = $this->package->listData($condition);
            if (count($checks) == 0) {
                $data = array(
                    'pack_id' => $id,
                    'dept_id' => $deptid,
                    'sex_id' => $this->input->post('sex_id'),
                    'stdtype_id' => $this->input->post('stdtype_id'),
                    'pack_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                    'pack_lastedit_date' => date('Y-m-d H:i:s'),
                );
                $this->package->updateData($data);

                $result = array(
                    'error' => false,
                    'title' => "Success",
                    'msg' => "Update data success",
                    'url' => site_url('package/index/' . $deptid)
                );
                echo json_encode($result);
            } else {
                $result = array(
                    'error' => true,
                    'title' => "Warning",
                    'msg' => "This Package is already",
                );
                echo json_encode($result);
            }
        }
    }

    public function delete($deptid,$id)
    {
        $data = array(
            'pack_id' => $id,
        );
        $id = $this->package->deleteData($data);
        header("location:" . site_url('package/index/'.$deptid));
    }
}
