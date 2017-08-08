<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . 'controllers/siteConfig.php';
require_once APPPATH . 'controllers/dbConfig.php';

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper(array('url', 'site', 'cookie', 'form'));
        $this->load->database();
        $this->load->library(array('form_validation', 'email', 'session'));
        $this->load->model('model_user');
        $this->load->model('model_client');
        $this->load->model('model_company');
        $this->load->model('model_project');
    }

    public function index() {
        $data['title'] = 'DhakaHome ERP';
        if (!$this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($_POST['submit'])) {
                $login = $this->model_user->dologin();
                //debugPrint($login);
                if ($login != '0') {
                    $session['__dhakahomeERPUserLogin'] = true;
                    $session['__dhakahomeERPUserID'] = $login[DBConfig::TABLE_USER_ATT_USER_ID];

                    $this->session->set_userdata($session);

                    redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_DASHBOARD));
                } else {
                    $session['_errorlUserLogin'] = true;
                    $this->session->set_userdata($session);
                    //redirect(base_url());
                }
            }
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_USER, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_DASHBOARD));
        }
    }

    public function dashboard($startPage=0) {
        $data['title'] = 'DhakaHome ERP Dashboard';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $perPage = '15';
            $this->load->library('pagination');
            $config['base_url'] = base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_DASHBOARD;
            $config['total_rows'] = $this->model_user->getNumOfActivity();
            $config['per_page'] = $perPage;


            $config['full_tag_open'] = '<ul class="pagination" style="margin-top:0px;margin-bottom:0px;float:right">';
            $config['full_tag_close'] = '</ul>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';

            $config['first_link'] = 'First';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';

            $config['next_link'] = '&raquo;';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '&laquo;';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';

            $config['last_link'] = 'Last';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '<li>';



            $this->pagination->initialize($config);
            
            $data['feed'] = $this->model_user->getActivity($startPage, $perPage,$this->session->userdata('__dhakahomeERPUserLogin'));
            //$data['clientList'] = $this->model_client->getClientList('0', '5');
            //$data['companyList'] = $this->model_company->getCompanyList('0', '5');
            //$data['projectList'] = $this->model_project->getProjectList('0', '5');
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_USER_DASHBOARD, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function logout() {
        $session['__dhakahomeERPUserLogin'] = FALSE;
        $session['__dhakahomeERPUserID'] = FALSE;
        $this->session->unset_userdata($session);

        redirect(site_url(siteConfig::CONTROLLER_USER));
    }

    public function profile() {
        $data['title'] = 'DhakaHome ERP User Profile';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $userId = $this->session->userdata('__dhakahomeERPUserID');
            $data['userProfile'] = $this->model_user->userProfile($userId);
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_USER_PROFILE, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function getState() {
        if (!empty($_POST)) {
            echo $this->model_user->getStateByCountry($this->input->post('id'));
        }
    }

    public function getCity() {
        if (!empty($_POST)) {
            echo $this->model_user->getCityByState($this->input->post('id'));
        }
    }

    public function editProfile() {
        $data['title'] = 'DhakaHome ERP Edit Profile';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            $userId = $this->session->userdata('__dhakahomeERPUserID');

            if (isset($_POST['submit'])) {
                $this->form_validation->set_rules('first-name', 'First Name', 'required');
                $this->form_validation->set_rules('last-name', 'Last Name', 'required');
                $this->form_validation->set_rules('email', 'E-mail', 'required');

                if ($this->form_validation->run() == TRUE) {

                    $i = $this->model_user->updateProfile($userId);

                    if ($i == '1') {
                        $s['_success'] = true;
                        $this->session->set_userdata($s);
                        redirect(base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_EDIT_PROFILE);
                    }
                }
            }


            $data['userProfile'] = $this->model_user->userProfile($userId);
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_USER_EDIT_PROFILE, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function changePassword() {
        $data['title'] = 'DhakaHome ERP Change Password';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            $userId = $this->session->userdata('__dhakahomeERPUserID');

            if (isset($_POST['submit'])) {
                $this->form_validation->set_rules('old-password', 'Old Password', 'required');
                $this->form_validation->set_rules('new-password', 'New Password', 'required|matches[connew-password]');
                $this->form_validation->set_rules('connew-password', 'Confirm New Password', 'required');

                if ($this->form_validation->run() == TRUE) {

                    $i = $this->model_user->changePassword($userId);

                    if ($i == '1') {
                        $s['_success'] = true;
                        $this->session->set_userdata($s);
                        redirect(base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_CHANGE_PASSWORD);
                    } elseif ($i == '0') {
                        $s['_error'] = true;
                        $this->session->set_userdata($s);
                        redirect(base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_CHANGE_PASSWORD);
                    }
                }
            }


            $data['userProfile'] = $this->model_user->userProfile($userId);
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_USER_CHANGE_PASSWORD, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function userList() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $data['title'] = 'DhakaHome ERP User List';
            $data['userList'] = $this->model_user->getUserList();
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_USER_LIST, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }
    
    public function viewProfile($userId)
    {
        $data['title'] = 'DhakaHome ERP User Profile';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            //$userId = $this->session->userdata('__dhakahomeERPUserID');
            $data['userProfile'] = $this->model_user->userProfile($userId);
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_USER_DETAILS, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }
    
    public function addUser() {
        $data['title'] = 'DhakaHome ERP Edit Profile';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            if (isset($_POST['submit'])) {
                $this->form_validation->set_rules('first-name', 'First Name', 'required');
                $this->form_validation->set_rules('last-name', 'Last Name', 'required');
                $this->form_validation->set_rules('user-name', 'User Name', 'required|callback_userNameCheck');
                $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|callback_userEmailAddressCheck');
                $this->form_validation->set_rules('password', 'Password', 'required');
                $this->form_validation->set_rules('priviledge', 'Priviledge', 'required');

                if ($this->form_validation->run() == TRUE) {

                    $i = $this->model_user->addUser($this->session->userdata('__dhakahomeERPUserID'));

                    if ($i == '1') {
                        $s['_success'] = true;
                        $this->session->set_userdata($s);
                        redirect(base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_ADD);
                    }
                }
            }
            $data['priviledge'] = getAllPriviledge();
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_USER_ADD, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }
    
    public function userEmailAddressCheck($email = "") {

        $check = $this->model_user->userEmailAddressCheck($email);

        if ($check == '1') {
            $this->form_validation->set_message('userEmailAddressCheck', 'Email Address Already Exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function userNameCheck($name = "") {

        $check = $this->model_user->userNameCheck($name);

        if ($check == '1') {
            $this->form_validation->set_message('userNameCheck', 'Name Already Exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function profileEdit($userId)
    {
        $data['title'] = 'DhakaHome ERP Edit Profile';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            if (isset($_POST['submit'])) {
                $this->form_validation->set_rules('first-name', 'First Name', 'required');
                $this->form_validation->set_rules('last-name', 'Last Name', 'required');
                
                $this->form_validation->set_rules('priviledge', 'Priviledge', 'required');

                if ($this->form_validation->run() == TRUE) {

                    $i = $this->model_user->updateUser($userId,$this->session->userdata('__dhakahomeERPUserID'));

                    if ($i == '1') {
                        $s['_success'] = true;
                        $this->session->set_userdata($s);
                        redirect(base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_PROFILE_EDIT.$userId);
                    }
                }
            }
            $data['userProfile'] = $this->model_user->userProfile($userId);
            $data['priviledge'] = getAllPriviledge();
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_USER_PROFILE_EDIT, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

}
