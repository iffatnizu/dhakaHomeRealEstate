<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once APPPATH . 'controllers/siteConfig.php';
require_once APPPATH . 'controllers/dbConfig.php';

class Client extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper(array('url', 'site', 'cookie', 'form'));
        $this->load->database();
        $this->load->library(array('form_validation', 'email', 'session'));
        $this->load->model('model_client');
        $this->load->model('model_user');
    }

    public function index() {
        $this->clientList();
    }

    public function addClient() {
        $data['title'] = 'DhakaHome ERP Add Client';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            if (isset($_POST['submit'])) {

                $this->form_validation->set_rules('file-number', 'File Number', 'required');
                $this->form_validation->set_rules('first-name', 'First Name', 'required');
                $this->form_validation->set_rules('last-name', 'Last Name', 'required');
                $this->form_validation->set_rules('address', 'Address', 'required');
                $this->form_validation->set_rules('countryId', 'Country', 'required');
                $this->form_validation->set_rules('state', 'State', 'required');
                $this->form_validation->set_rules('zip', 'Zip', 'required');
                $this->form_validation->set_rules('cell-number', 'Cell Number', 'required');
                $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|callback_clientEmailAddressCheck');
                $this->form_validation->set_rules('comment', 'Comment', 'required');

                if ($this->form_validation->run() == TRUE) {
                    $i = $this->model_client->addClient($this->session->userdata('__dhakahomeERPUserID'));

                    if ($i == '1') {
                        $s['_success'] = true;
                        $this->session->set_userdata($s);
                        redirect(base_url() . siteConfig::CONTROLLER_CLIENT . siteConfig::METHOD_ADD_CLIENT);
                    }
                }
            }

            $data['country'] = getAllCountry();
//            $data['company'] = getAllCompany();

            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_ADD_CLIENT, $data, TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function clientEmailAddressCheck($email = "") {

        $check = $this->model_client->clientEmailAddressCheck($email);

        if ($check == '1') {
            $this->form_validation->set_message('clientEmailAddressCheck', 'Email Address Already Exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function clientList($startPage = '0') {
        $data['title'] = 'DhakaHome ERP Client List';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            //echo $this->model_client->getNumOfclientList();

            $perPage = '15';
            $this->load->library('pagination');
            $config['base_url'] = base_url() . siteConfig::CONTROLLER_CLIENT . siteConfig::METHOD_CLIENT_LIST;
            $config['total_rows'] = $this->model_client->getNumOfclientList();
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


            $data['clientList'] = $this->model_client->getClientList($startPage, $perPage);
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_CLIENT_LIST, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function allClient() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            echo $this->model_client->allClient();
        }
    }

    public function viewClient($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($id)) {
                $data['details'] = $this->model_client->getClientDetails($id);
//                $data['projectList'] = $this->model_client->getProjectByClient($id);
                $data['title'] = 'DhakaHome ERP Client Details';
                $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
                $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
                $page['content'] = $this->load->view(siteConfig::COMPONENT_CLIENT_DETAILS, '', TRUE);
                $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
                $this->load->view(siteConfig::SITE_MASTER, $page);
            } else {
                redirect(base_url());
            }
        } else {
            redirect(site_url());
        }
    }

    public function deleteClient($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($id)) {
                $d = $this->model_client->deleteClient($id, $this->session->userdata('__dhakahomeERPUserID'));
                if ($d == '1') {
                    $s['_delete'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_CLIENT . siteConfig::METHOD_CLIENT_LIST);
                } elseif ($d == '0') {
                    $s['_notdelete'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_CLIENT . siteConfig::METHOD_CLIENT_LIST);
                }
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url());
        }
    }

    public function editClient($id) {
        $data['title'] = 'DhakaHome ERP Edit Client';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            if (isset($_POST['submit'])) {

                $this->form_validation->set_rules('file-number', 'File Number', 'required');
                $this->form_validation->set_rules('first-name', 'First Name', 'required');
                $this->form_validation->set_rules('address', 'Address', 'required');
                $this->form_validation->set_rules('countryId', 'Country', 'required');
                $this->form_validation->set_rules('state', 'State', 'required');
                $this->form_validation->set_rules('zip', 'Zip', 'required');
                $this->form_validation->set_rules('cell-number', 'Cell Number', 'required');
                $this->form_validation->set_rules('e-mail', 'Email', 'required|valid_email');
                $this->form_validation->set_rules('comment', 'Comment', 'required');

                if ($this->form_validation->run() == TRUE) {
                    $i = $this->model_client->updateClient($id, $this->session->userdata('__dhakahomeERPUserID'));
                    if ($i == '1') {
                        $s['_success'] = true;
                        $this->session->set_userdata($s);
                        redirect(base_url() . siteConfig::CONTROLLER_CLIENT . siteConfig::METHOD_CLIENT_EDIT . $id);
                    }
                }
            }

            $details = $this->model_client->getClientDetails($id);

            $data['country'] = getAllCountry();
            $data['company'] = getAllCompany();

            if (!empty($details)) {
                $data['details'] = $details;
                $data['state'] = $this->model_user->getStateByCountry($details[dbConfig::TABLE_CLIENT_ATT_COUNTRY]);
                $data['city'] = $this->model_user->getCityByState($details[dbConfig::TABLE_CLIENT_ATT_STATE]);
            }
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_CLIENT_EDIT, $data, TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function getClient() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            echo $this->model_client->getClient($_POST['id']);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function sendMail() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($_POST['submit'])) {
                echo $this->model_client->sendMail($this->session->userdata('__dhakahomeERPUserID'));
            }
        } else {
            echo 'Please Login';
        }
    }

    public function sendMailSingleClient() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($_POST['submit'])) {
                echo $this->model_client->sendMailSingleClient($this->session->userdata('__dhakahomeERPUserID'));
            }
        } else {
            echo 'Please Login';
        }
    }

}
