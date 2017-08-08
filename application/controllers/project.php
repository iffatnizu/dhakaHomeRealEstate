<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'controllers/siteConfig.php';
require_once APPPATH . 'controllers/dbConfig.php';

class Project extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper(array('url', 'site', 'cookie', 'form'));
        $this->load->database();
        $this->load->library(array('form_validation', 'email', 'session'));
        $this->load->model('model_project');
        $this->load->model('model_user');
        $this->load->model('model_client');
    }

    public function index() {
        $this->projectList();
    }

    public function addProject() {
        $data['title'] = 'DhakaHome ERP Add Project';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($_POST['submit'])) {
                $this->form_validation->set_rules('company', 'Company', 'required');

                $this->form_validation->set_rules('project-type', 'Project Type', 'required');
                $this->form_validation->set_rules('project-name', 'Project Name', 'required');
                $this->form_validation->set_rules('project-email', 'Project E-mail', 'required|valid_email|callback_projectEmailAddressCheck');
                $this->form_validation->set_rules('project-details', 'Project Details', 'required');
                $this->form_validation->set_rules('countryId', 'Country', 'required');
                $this->form_validation->set_rules('state', 'State', 'required');
                $this->form_validation->set_rules('city', 'City', 'required');

                if ($this->form_validation->run() == TRUE) {
                    $i = $this->model_project->addProject($this->session->userdata('__dhakahomeERPUserID'));

                    if ($i == '1') {
                        $s['_success'] = true;
                        $this->session->set_userdata($s);
                        redirect(base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_ADD_PROJECT);
                    }
                }
            }
            $data['country'] = getAllCountry();
            $data['company'] = getAllCompany();
            $data['type'] = getProjectType();
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_ADD_PROJECT, $data, TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function projectEmailAddressCheck($email = "") {
        $check = $this->model_project->projectEmailAddressCheck($email);

        if ($check == '1') {
            $this->form_validation->set_message('projectEmailAddressCheck', 'Email Address Already Exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function projectList($startPage = '0') {
        $data['title'] = 'DhakaHome ERP Project List';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            $perPage = '15';
            $this->load->library('pagination');
            $config['base_url'] = base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_PROJECT_LIST;
            $config['total_rows'] = $this->model_project->getNumOfProjectList();
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


            $data['projectList'] = $this->model_project->getProjectList($startPage, $perPage);
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_PROJECT_LIST, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function viewProject($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($id)) {
                $data['details'] = $this->model_project->getProjectDetails($id);
                $data['title'] = 'DhakaHome ERP Project Details';
                $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
                $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
                $page['content'] = $this->load->view(siteConfig::COMPONENT_PROJECT_DETAILS, '', TRUE);
                $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
                $this->load->view(siteConfig::SITE_MASTER, $page);
            } else {
                redirect(base_url());
            }
        } else {
            redirect(site_url());
        }
    }

    public function deleteProject($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($id)) {
                $d = $this->model_project->deleteProject($id, $this->session->userdata('__dhakahomeERPUserID'));
                if ($d == '1') {
                    $s['_delete'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_PROJECT_LIST);
                } elseif ($d == '0') {
                    $s['_notdelete'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_PROJECT_LIST);
                }
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url());
        }
    }

    public function editProject($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $data['title'] = 'DhakaHome ERP Edit Project';
            $details = $this->model_project->getProjectDetails($id);

            if (!empty($details)) {

                if (isset($_POST['submit'])) {
                    $this->form_validation->set_rules('company', 'Company', 'required');

                    $this->form_validation->set_rules('project-type', 'Project Type', 'required');
                    $this->form_validation->set_rules('project-name', 'Project Name', 'required');
                    $this->form_validation->set_rules('project-details', 'Project Details', 'required');
                    $this->form_validation->set_rules('countryId', 'Country', 'required');
                    $this->form_validation->set_rules('state', 'State', 'required');
                    $this->form_validation->set_rules('city', 'City', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        $i = $this->model_project->updateProject($this->session->userdata('__dhakahomeERPUserID'), $id);

                        if ($i == '1') {
                            $s['_success'] = true;
                            $this->session->set_userdata($s);
                            redirect(base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_PROJECT_EDIT . $id);
                        }
                    }
                }

                $data['details'] = $details;
                $data['state'] = $this->model_user->getStateByCountry($details[dbConfig::TABLE_PROJECT_ATT_PROJECT_COUNTRY]);
                $data['city'] = $this->model_user->getCityByState($details[dbConfig::TABLE_PROJECT_ATT_PROJECT_STATE]);
                //$data['client'] = $this->model_client->getClient($details[dbConfig::TABLE_PROJECT_ATT_COMPANY_ID]);
            }

            $data['country'] = getAllCountry();
            $data['company'] = getAllCompany();
            $data['type'] = getProjectType();

            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_PROJECT_EDIT, $data, TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(base_url());
        }
    }

    public function manageType() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $data['title'] = 'DhakaHome ERP Manage Project Type';

            if (isset($_POST['add-submit'])) {
                $this->form_validation->set_rules('type-name', 'Project Type Name', 'required');

                if ($this->form_validation->run() == TRUE) {
                    $i = $this->model_project->addProjectType();

                    if ($i == '1') {
                        $s['_addsuccess'] = true;
                        $this->session->set_userdata($s);
                        redirect(base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_PROJECT_MANAGE_TYPE);
                    }
                }
            } elseif (isset($_POST['update-submit'])) {
                //debugPrint($_POST);
                $i = $this->model_project->updateProjectType();

                if ($i == '1') {
                    $s['_upsuccess'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_PROJECT_MANAGE_TYPE);
                } else {
                    $s['_upfail'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_PROJECT_MANAGE_TYPE);
                }
            } elseif (isset($_POST['delete-submit'])) {
                $i = $this->model_project->deleteProjectType();

                if ($i == '1') {
                    $s['_delsuccess'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_PROJECT_MANAGE_TYPE);
                } elseif ($i == '0') {
                    $s['_delfail'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_PROJECT_MANAGE_TYPE);
                }
            }

            $data['typeList'] = $this->model_project->getProjectType();
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_PROJECT_MANAGE_TYPE, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(base_url());
        }
    }

    public function sendMail() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($_POST['submit'])) {
                echo $this->model_project->sendMail($this->session->userdata('__dhakahomeERPUserID'));
            }
        } else {
            echo 'Please Login';
        }
    }

    public function sentMailToSingleProject() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($_POST['submit'])) {
                echo $this->model_project->sentMailToSingleProject($this->session->userdata('__dhakahomeERPUserID'));
            }
        } else {
            echo 'Please Login';
        }
    }

    public function getProjectByCompany() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($_POST['submit'])) {
                echo $this->model_project->getProjectByCompany($_POST['typename']);
            }
        } else {
            echo 'Please Login';
        }
    }

}
