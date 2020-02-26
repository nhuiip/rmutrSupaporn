<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin_model", "admin");
    }

    public function index()
    {

        $condition = array();
        $condition['fide'] = "*";
        $condition['orderby'] = "ad_fullname ASC";
        $data['listdata'] = $this->admin->listData($condition);

        $this->template->js(array(
            base_url('assets/bundles/datatablescripts.bundle'),
            base_url('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min'),
            base_url('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min'),
            base_url('assets/plugins/jquery-datatable/buttons/buttons.html5.min'),
            base_url('assets/js/dataTables')
        ));

        $data['header'] = 'Manage User';
        $this->template->title('Manage User');
        $this->template->backend('admin/main', $data);
    }

    public function form($id = '')
    {
        if (!empty($id)) {
            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('ad_id' => $id);
            $data['listdata'] = $this->admin->listData($condition);

            $data['header'] = 'Update User';
            $this->template->title('Update User');
            if (count($data['listdata']) == 0) {
                show_404();
                die;
            }
        } else {
            $data['header'] = 'Insert User';
            $this->template->title('Insert User');
        }

        $data['Role'] = array('Administrator', 'Officer');
        $data['formcrf'] = $this->tokens->token('formcrf');
        $this->template->backend('admin/form', $data);
    }

    public function checkEmail($id = '')
    {
        // input
        $ad_email = $this->input->post('ad_email');
        if (!empty($ad_email)) {
            // check for update form
            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "ad_id";
                $condition['where'] = array('ad_id !=' => $id, 'ad_email' => $ad_email);
                $listdata = $this->admin->listData($condition);
                if (count($listdata) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
            // check for insert form
            else {
                $condition = array();
                $condition['fide'] = "ad_id";
                $condition['where'] = array('ad_email' => $ad_email);
                $listdata = $this->admin->listData($condition);
                if (count($listdata) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        }
    }

    public function create()
    {

        if ($this->tokens->verify('formcrf')) {
            $data = array(
                'position' => $this->input->post('position'),
                'ad_fullname' => $this->input->post('ad_fullname'),
                'ad_email' => $this->input->post('ad_email'),
                'ad_password' => md5($this->input->post('passwordA')),
                'ad_create' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'ad_create_date' => date('Y-m-d H:i:s'),
            );
            $this->admin->insertData($data);
            $result = array(
                'error' => false,
                'title' => "Success",
                'msg' => "Insert data success",
                'url' => site_url('admin/index')
            );
            echo json_encode($result);
        }
    }

    public function update($id)
    {

        if ($this->tokens->verify('formcrf')) {
            $data = array(
                'ad_id' => $id,
                'position' => $this->input->post('position'),
                'ad_fullname' => $this->input->post('ad_fullname'),
                'ad_email' => $this->input->post('ad_email'),
                'ad_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'ad_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $id = $this->admin->updateData($data);
            $result = array(
                'error' => false,
                'title' => "Success",
                'msg' => "Update data success",
                'url' => site_url('admin/index')
            );
            echo json_encode($result);
        }
    }

    public function delete($id)
    {
        $data = array(
            'ad_id' => $id,
        );
        $id = $this->admin->deleteData($data);
        header("location:" . site_url('admin/index'));
    }

    public function formRepass($id)
    {
        if (!empty($id)) {
            $condition = array();
            $condition['fide'] = "ad_id";
            $condition['where'] = array('ad_id' => $id);
            $listdata = $this->admin->listData($condition);
            if (count($listdata) == 0) {
                show_404();
                die;
            } else {
                $data['id'] = $listdata[0]['ad_id'];
                $data['header'] = 'Change password User';
                $data['formcrf'] = $this->tokens->token('formcrf');
                $this->template->title('Change password User');
                $this->template->backend('admin/formRepass', $data);
            }
        } else {
            show_404();
            die;
        }
    }

    public function rePass($id)
    {
        $data = array(
            'ad_id' => $id,
            'ad_password' => md5($this->input->post('passwordA')),
            'ad_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
            'ad_lastedit_date' => date('Y-m-d H:i:s'),
        );
        $id = $this->admin->updateData($data);
        $result = array(
            'error' => false,
            'title' => "Success",
            'msg' => "Change password success",
            'url' => site_url('admin/index')
        );
        echo json_encode($result);
    }
}
