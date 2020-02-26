<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Student extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("student_model", "student");
        $this->load->model("department_model", "department");
        $this->load->library('csvimport');
    }

    public function index($id = "")
    {
        if (!empty($id)) {
            $condition = array();
            $condition['fide'] = "tb_student.*, stdtype_text, sex_text, CONCAT(ad_fullname) AS std_create,  CONCAT(ad_fullname) AS std_lastedit";
            $condition['where'] = array('tb_student.dept_id' => $id);
            $condition['orderby'] = "std_number ASC";
            $data['listdata'] = $this->student->listData($condition);

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
            $data['header'] = 'Manage Student';
            $this->template->title('Manage Student');
            $this->template->backend('student/main', $data);
        } else {
            show_404();
        }
    }

    public function form($deptid = "", $id = '')
    {
        if (!empty($deptid)) {
            $condition = array();
            $condition['fide'] = "dept_name";
            $condition['where'] = array('dept_id' => $deptid);
            $deptname = $this->department->listData($condition);

            $condition = array();
            $condition['fide'] = "*";
            $condition['orderby'] = "sex_text ASC";
            $data['listSex'] = $this->student->listSex($condition);

            $condition = array();
            $condition['fide'] = "*";
            $condition['orderby'] = "stdtype_text ASC";
            $data['listStdtype'] = $this->student->listStdtype($condition);

            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "tb_student.*";
                $condition['where'] = array('tb_student.std_id' => $id);
                $data['listdata'] = $this->student->listData($condition);

                $data['header'] = 'Update Student';
                $this->template->title('Update Student');
                if (count($data['listdata']) == 0) {
                    show_404();
                    die;
                }
            } else {
                $data['header'] = 'Insert Student';
                $this->template->title('Insert Student');
            }

            $data['deptid'] =  $deptid;
            $data['deptname'] =  $deptname[0]['dept_name'];
            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('student/form', $data);
        } else {
            show_404();
        }
    }

    public function checkStdnumber($id = '')
    {
        // input
        $std_number = $this->input->post('std_number');
        // $std_number = 'เทคโนโลยีวิศวกรรมคอมพิวเตอร์';
        if (!empty($std_number)) {
            // check for update form
            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "std_id";
                $condition['where'] = array('std_id !=' => $id, 'std_number' => $std_number);
                $listdata = $this->student->listData($condition);
                if (count($listdata) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
            // check for insert form
            else {
                $condition = array();
                $condition['fide'] = "std_id";
                $condition['where'] = array('std_number' => $std_number);
                $listdata = $this->student->listData($condition);
                if (count($listdata) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        }
    }

    public function checkIDcard($id = '')
    {
        // input
        $std_indent = $this->input->post('std_indent');
        // $std_number = 'เทคโนโลยีวิศวกรรมคอมพิวเตอร์';
        if (!empty($std_indent)) {
            // check for update form
            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "std_id";
                $condition['where'] = array('std_id !=' => $id, 'std_indent' => $std_indent);
                $listdata = $this->student->listData($condition);
                if (count($listdata) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
            // check for insert form
            else {
                $condition = array();
                $condition['fide'] = "std_id";
                $condition['where'] = array('std_indent' => $std_indent);
                $listdata = $this->student->listData($condition);
                if (count($listdata) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        }
    }

    public function create($deptid = '')
    {
        if ($this->tokens->verify('formcrf') && !empty($deptid)) {
            $data = array(
                'dept_id' => $deptid,
                'stdtype_id' => $this->input->post('stdtype_id'),
                'sex_id' => $this->input->post('sex_id'),
                'std_indent' => $this->input->post('std_indent'),
                'std_number' => $this->input->post('std_number'),
                'std_title' => $this->input->post('std_title'),
                'std_fname' => $this->input->post('std_fname'),
                'std_lname' => $this->input->post('std_lname'),
                'std_tel' => $this->input->post('std_tel'),
                'std_emergency_name' => $this->input->post('std_emergency_name'),
                'std_emergency_tel' => $this->input->post('std_emergency_tel'),
                'std_emergency_con' => $this->input->post('std_emergency_con'),
                'std_create' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'std_create_date' => date('Y-m-d H:i:s'),
                'std_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'std_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->student->insertData($data);
            $result = array(
                'error' => false,
                'title' => "Success",
                'msg' => "Insert data success",
                'url' => site_url('student/index/' . $deptid)
            );
            echo json_encode($result);
        }
    }

    public function update($deptid = '', $id)
    {

        if ($this->tokens->verify('formcrf') && !empty($deptid)) {
            $data = array(
                'std_id' => $id,
                'dept_id' => $deptid,
                'stdtype_id' => $this->input->post('stdtype_id'),
                'sex_id' => $this->input->post('sex_id'),
                'std_indent' => $this->input->post('std_indent'),
                'std_number' => $this->input->post('std_number'),
                'std_title' => $this->input->post('std_title'),
                'std_fname' => $this->input->post('std_fname'),
                'std_lname' => $this->input->post('std_lname'),
                'std_tel' => $this->input->post('std_tel'),
                'std_emergency_name' => $this->input->post('std_emergency_name'),
                'std_emergency_tel' => $this->input->post('std_emergency_tel'),
                'std_emergency_con' => $this->input->post('std_emergency_con'),
                'std_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                'std_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $id = $this->student->updateData($data);
            $result = array(
                'error' => false,
                'title' => "Success",
                'msg' => "Update data success",
                'url' => site_url('student/index/' . $deptid)
            );
            echo json_encode($result);
        }
    }

    public function delete($deptid, $id)
    {
        $data = array(
            'std_id' => $id,
        );
        $id = $this->student->deleteData($data);
        header("location:" . site_url('student/index/' . $deptid));
    }

    public function formImport($deptid = "")
    {
        if (!empty($deptid)) {
            $condition = array();
            $condition['fide'] = "dept_name";
            $condition['where'] = array('dept_id' => $deptid);
            $deptname = $this->department->listData($condition);

            $data['deptid'] =  $deptid;
            $data['deptname'] =  $deptname[0]['dept_name'];
            $data['formcrf'] = $this->tokens->token('formcrf');
            $data['header'] = 'Import Student Data';
            $this->template->title('Import Student Data');
            $this->template->backend('student/formImport', $data);
        } else {
            show_404();
        }
    }

    public function importData($deptid = "")
    {
        $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
        if (!empty($file_data)) { 
            for($i=0;$i < count($file_data);$i++){
                 if(isset($file_data[$i]['studentNumber'])){$studentNumber = $file_data[$i]['studentNumber'];}else{ $studentNumber = '';}
                 if(isset($file_data[$i]['nameTitle'])){$nameTitle = $file_data[$i]['nameTitle'];}else{ $nameTitle = '';}
                 if(isset($file_data[$i]['fName'])){$fName = $file_data[$i]['fName'];}else{ $fName = '';}
                 if(isset($file_data[$i]['lNname'])){$lNname = $file_data[$i]['lNname'];}else{ $lNname = '';}
                 if(isset($file_data[$i]['Course'])){$Course = $file_data[$i]['Course'];}else{ $Course = '';}
                 if(isset($file_data[$i]['Sex'])){$Sex = $file_data[$i]['Sex'];}else{ $Sex = '';}
                $checkval = array(
                    $studentNumber,
                    $nameTitle, 
                    $fName, 
                    $lNname, 
                    $Course, 
                    $Sex, 
                );
                if(!in_array('', $checkval)){
                    // check db
                    $condition = array();
                    $condition['fide'] = "tb_student.std_id,";
                    $condition['where'] = array('tb_student.std_number' => $file_data[$i]['studentNumber']);
                    $listdata = $this->student->listData($condition);
                    // indsert
                    if(count($listdata) == 0){
                        $data = array(
                            'dept_id' => $deptid,
                            'stdtype_id' => $file_data[$i]['Course'],
                            'sex_id' => $file_data[$i]['Sex'],
                            'std_indent' => $file_data[$i]['idCard'],
                            'std_number' => $file_data[$i]['studentNumber'],
                            'std_title' => $file_data[$i]['nameTitle'],
                            'std_fname' => $file_data[$i]['fName'],
                            'std_lname' => $file_data[$i]['lNname'],
                            'std_tel' => $file_data[$i]['studentMobile'],
                            'std_emergency_name' => $file_data[$i]['personName'],
                            'std_emergency_tel' => $file_data[$i]['personMobile'],
                            'std_emergency_con' => $file_data[$i]['personRelated'],
                            'std_create' => $this->encryption->decrypt($this->input->cookie('sysli')),
                            'std_create_date' => date('Y-m-d H:i:s'),
                            'std_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                            'std_lastedit_date' => date('Y-m-d H:i:s'),
                        );
                        $this->student->insertData($data);
                    } 
                    // update
                    elseif(count($listdata) == 1){
                        $data = array(
                            'std_id' => $listdata[0]['std_id'],
                            'dept_id' => $deptid,
                            'stdtype_id' => $file_data[$i]['Course'],
                            'sex_id' => $file_data[$i]['Sex'],
                            'std_indent' => $file_data[$i]['idCard'],
                            'std_number' => $file_data[$i]['studentNumber'],
                            'std_title' => $file_data[$i]['nameTitle'],
                            'std_fname' => $file_data[$i]['fName'],
                            'std_lname' => $file_data[$i]['lNname'],
                            'std_tel' => $file_data[$i]['studentMobile'],
                            'std_emergency_name' => $file_data[$i]['personName'],
                            'std_emergency_tel' => $file_data[$i]['personMobile'],
                            'std_emergency_con' => $file_data[$i]['personRelated'],
                            'std_lastedit' => $this->encryption->decrypt($this->input->cookie('sysli')),
                            'std_lastedit_date' => date('Y-m-d H:i:s'),
                        );
                        $id = $this->student->updateData($data);
                    }
                }
            }
            $result = array(
                'error' => false,
                'title' => "Success",
                'msg' => "Import data success",
                'url' => site_url('student/index/' . $deptid)
            );
            echo json_encode($result);
        }
    }
}
