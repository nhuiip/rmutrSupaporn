<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Faculty extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("faculty_model", "faculty");
    }

    public function index()
    {

        $condition = array();
        $condition['fide'] = "fac_id, fac_name, fac_create_date, fac_lastedit_date, CONCAT(ad_fullname) AS fac_create,  CONCAT(ad_fullname) AS fac_lastedit";
        $condition['orderby'] = "fac_name ASC";
        $data['listdata'] = $this->faculty->listData($condition);

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

        $data['header'] = 'Manage Faculty';
        $this->template->title('Manage Faculty');
        $this->template->backend('faculty/main', $data);
    }

    public function form($id = '')
    {
        if (!empty($id)) {
            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('fac_id' => $id);
            $data['listdata'] = $this->faculty->listData($condition);

            $data['header'] = 'Update Faculty';
            $this->template->title('Update Faculty');
            if (count($data['listdata']) == 0) {
                show_404();
                die;
            }
        } else {
            $data['header'] = 'Insert Faculty';
            $this->template->title('Insert Faculty');
        }
        $data['formcrf'] = $this->tokens->token('formcrf');
        $this->template->backend('faculty/form', $data);
    }

    public function checkName($id = '')
    {
        // input
        $fac_name = $this->input->post('fac_name');
        if (!empty($fac_name)) {
            // check for update form
            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "fac_id";
                $condition['where'] = array('fac_id !=' => $id, 'fac_name' => $fac_name);
                $listdata = $this->faculty->listData($condition);
                if (count($listdata) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
            // check for insert form
            else {
                $condition = array();
                $condition['fide'] = "fac_id";
                $condition['where'] = array('fac_name' => $fac_name);
                $listdata = $this->faculty->listData($condition);
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
                'fac_name' => $this->input->post('fac_name'),
                'fac_create' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'fac_create_date' => date('Y-m-d H:i:s'),
                'fac_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'fac_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->faculty->insertData($data);
            $result = array(
                'error' => false,
                'title' => "Success",
                'msg' => "Insert data success",
                'url' => site_url('faculty/index')
            );
            echo json_encode($result);
        }
    }

    public function update($id)
    {

        if ($this->tokens->verify('formcrf')) {
            $data = array(
                'fac_id' => $id,
                'fac_name' => $this->input->post('fac_name'),
                'fac_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'fac_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $id = $this->faculty->updateData($data);
            $result = array(
                'error' => false,
                'title' => "Success",
                'msg' => "Update data success",
                'url' => site_url('faculty/index')
            );
            echo json_encode($result);
        }
    }

    public function delete($id)
    {
        $data = array(
            'fac_id' => $id,
        );
        $id = $this->faculty->deleteData($data);
        header("location:" . site_url('faculty/index'));
    }
}