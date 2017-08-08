<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'controllers/siteConfig.php';
require_once APPPATH . 'controllers/dbConfig.php';

class Company extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper(array('url', 'site', 'cookie', 'form'));
        $this->load->database();
        $this->load->library(array('form_validation', 'email', 'session'));
        $this->load->model('model_company');
        $this->load->model('model_user');
    }

    public function index() {
        $this->companyList();
    }

    public function companyList($startPage = '0') {
        $data['title'] = 'DhakaHome ERP Company List';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            $perPage = '15';
            $this->load->library('pagination');
            $config['base_url'] = base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_COMPANY_LIST;
            $config['total_rows'] = $this->model_company->getNumOfCompanyList();
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

            $data['companyList'] = $this->model_company->getCompanyList($startPage, $perPage);
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_COMPANY_LIST, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function addCompany() {
        $data['title'] = 'DhakaHome ERP Add Company';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            if (isset($_POST['submit'])) {
                $this->form_validation->set_rules('company', 'Company', 'required');
                $this->form_validation->set_rules('address', 'Address', 'required');
                $this->form_validation->set_rules('countryId', 'Country', 'required');
                $this->form_validation->set_rules('state', 'State', 'required');
                $this->form_validation->set_rules('city', 'City', 'required');
                $this->form_validation->set_rules('zip', 'Zip', 'required');
                $this->form_validation->set_rules('cell-number', 'Cell Number', 'required');
                $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|callback_companyEmailAddressCheck');
                $this->form_validation->set_rules('contact-person', 'Contact Person', 'required');
                $this->form_validation->set_rules('contact-person-number', 'Contact Person Number', 'required');

                if ($this->form_validation->run() == TRUE) {
                    $i = $this->model_company->addCompany($this->session->userdata('__dhakahomeERPUserID'));

                    if ($i == '1') {
                        $s['_success'] = true;
                        $this->session->set_userdata($s);
                        redirect(base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_ADD_COMPANY);
                    }
                }
            }

            $data['country'] = getAllCountry();
            $data['company'] = getAllCompany();

            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_ADD_COMPANY, $data, TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function companyEmailAddressCheck($email = "") {
        $check = $this->model_company->companyEmailAddressCheck($email);

        if ($check == '1') {
            $this->form_validation->set_message('companyEmailAddressCheck', 'Email Address Already Exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function allCompany() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            echo $this->model_company->allCompany();
        }
    }

    public function viewCompany($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($id)) {
                $data['details'] = $this->model_company->getCompanyDetails($id);
                $data['projectList'] = $this->model_company->getCompanyProject($id);
                $data['title'] = 'DhakaHome ERP Company Details';
                $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
                $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
                $page['content'] = $this->load->view(siteConfig::COMPONENT_COMPANY_DETAILS, '', TRUE);
                $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
                $this->load->view(siteConfig::SITE_MASTER, $page);
            } else {
                redirect(base_url());
            }
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function deleteCompany($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($id)) {
                $d = $this->model_company->deleteCompany($id, $this->session->userdata('__dhakahomeERPUserID'));
                if ($d == '1') {
                    $s['_delete'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_COMPANY_LIST);
                } elseif ($d == '0') {
                    $s['_notdelete'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_COMPANY_LIST);
                }
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url());
        }
    }

    public function editCompany($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($id)) {
                if (isset($_POST['submit'])) {
                    $this->form_validation->set_rules('company', 'Company', 'required');
                    $this->form_validation->set_rules('address', 'Address', 'required');
                    $this->form_validation->set_rules('countryId', 'Country', 'required');
                    $this->form_validation->set_rules('state', 'State', 'required');
                    $this->form_validation->set_rules('city', 'City', 'required');
                    $this->form_validation->set_rules('zip', 'Zip', 'required');
                    $this->form_validation->set_rules('cell-number', 'Cell Number', 'required');
                    $this->form_validation->set_rules('contact-person', 'Contact Person', 'required');
                    $this->form_validation->set_rules('contact-person-number', 'Contact Person Number', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        $i = $this->model_company->updateCompany($id, $this->session->userdata('__dhakahomeERPUserID'));

                        if ($i == '1') {
                            $s['_success'] = true;
                            $this->session->set_userdata($s);
                            redirect(base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_COMPANY_EDIT . $id);
                        }
                    }
                }
                $details = $this->model_company->getCompanyDetails($id);
                if (!empty($details)) {
                    $data['country'] = getAllCountry();
                    $data['details'] = $details;
                    $data['state'] = $this->model_user->getStateByCountry($details[dbConfig::TABLE_COMPANY_ATT_COUNTRY]);
                    $data['city'] = $this->model_user->getCityByState($details[dbConfig::TABLE_COMPANY_ATT_STATE]);
                }
                $data['title'] = 'DhakaHome ERP Edit Company';
                $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
                $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
                $page['content'] = $this->load->view(siteConfig::COMPONENT_COMPANY_EDIT, '', TRUE);
                $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
                $this->load->view(siteConfig::SITE_MASTER, $page);
            } else {
                redirect(base_url());
            }
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function sendMail() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($_POST['submit'])) {
                echo $this->model_company->sendMail($this->session->userdata('__dhakahomeERPUserID'));
            }
        } else {
            echo 'Please Login';
        }
    }

    public function sendMailSingleCompany() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($_POST['submit'])) {
                echo $this->model_company->sendMailSingleCompany($this->session->userdata('__dhakahomeERPUserID'));
            }
        } else {
            echo 'Please Login';
        }
    }

}
