<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'controllers/siteConfig.php';
require_once APPPATH . 'controllers/dbConfig.php';

class Commercial extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper(array('url', 'site', 'cookie', 'form', 'commercial'));
        $this->load->database();
        $this->load->library(array('form_validation', 'email', 'session'));
        $this->load->model('model_commercial');
        $this->load->model('model_company');
        $this->load->model('model_project');
        $this->load->model('model_client');
    }

    public function index() {
        $this->commercialList();
    }

    public function addCommercial($step = '') {
        $data['title'] = 'DhakaHome ERP Add Plot';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {



            if ($step == "") {
                redirect(siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_ADD_COMMMERCIAL . 'step1/');
            }

            $data['submit'] = '0';
            $data['company'] = getAllCompany();
            $data['country'] = getAllCountry();
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);

            if ($step == 'step1') {

                if (isset($_POST['submit'])) {
                    $data['submit'] = '1';
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

                            $sdata['_setCompany'] = $_POST['company'];
                            $sdata['_setCompanyId'] = getCompanyIdByName($_POST['company']);
                            $this->session->set_userdata($sdata);
                            redirect(base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_ADD_COMMMERCIAL . 'step2/');
                        }
                    }
                }

                $page['content'] = $this->load->view(siteConfig::COMPONENT_ADD_COMMERCIAL, $data, TRUE);
            } elseif ($step == 'step2') {
                if (isset($_POST['submit'])) {
                    $data['submit'] = '2';
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

                            $sodata['_setProject'] = $_POST['project-name'];
                            $sodata['_setProjectId'] = getProjectIdByName($_POST['project-name']);
                            $this->session->set_userdata($sodata);

                            redirect(base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_ADD_COMMMERCIAL . 'step3/');
                        }
                    }
                }
                $data['type'] = getProjectType();
                $data['project'] = getProjectByCompany($this->session->userdata('_setCompanyId'));
                $page['content'] = $this->load->view(siteConfig::COMPONENT_ADD_COMMERCIAL_STEP2, $data, TRUE);
            } elseif ($step == 'step3') {
                //echo $this->session->userdata("_companyName");
                if (isset($_POST['submit'])) {
                    $data['submit'] = '3';

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
                            $sedata['_setClient'] = getClientName($_POST['email']);
                            $sedata['_setClientId'] = getClientIdByName($_POST['email']);
                            $sedata['_setClientName'] = $_POST['first-name'] . ' ' . $_POST['last-name'];
                            $this->session->set_userdata($sedata);
                            redirect(base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_ADD_COMMMERCIAL . 'step4/');
                        }
                    }
                }
                $data['client'] = $this->model_client->clientList();
                $page['content'] = $this->load->view(siteConfig::COMPONENT_ADD_COMMERCIAL_STEP3, $data, TRUE);
            } elseif ($step == 'step4') {

                if ($this->session->userdata('_setCompany') && $this->session->userdata('_setCompanyId') && $this->session->userdata('_setProject') && $this->session->userdata('_setProjectId')) {

                    $data['project'] = getProjectByCompany($this->session->userdata('_setCompanyId'));

                    //debugPrint($_POST);

                    if (isset($_POST['submit'])) {
                        $data['submit'] = '4';
                        $this->form_validation->set_rules('commercial-name', 'Commercial Name', 'required|callback_commercialNameCheck');
                        $this->form_validation->set_rules('commercial-address', 'Commercial Address', 'required');
                        $this->form_validation->set_rules('commercial-floor', 'Commercial Block', 'required');
                        $this->form_validation->set_rules('commercial-size', 'Commercial Facing', 'required');
                        $this->form_validation->set_rules('commercial-project', 'Project', 'required');

                        if (!isset($_POST['markAsCompany'])) {
                            $this->form_validation->set_rules('commercial-seller', 'Commercial Seller', 'required');
                        }

                        $this->form_validation->set_rules('commercial-asking-price', 'Commercial Asking Price', 'required');
                        $this->form_validation->set_rules('commercial-asking-min-price', 'Commercial Asking Minimum Price ', 'required');
                        $this->form_validation->set_rules('commercial-currency', 'Commercial Currency', 'required');
                        $this->form_validation->set_rules('commercial-condition', 'Commercial Condition', 'required');
                        $this->form_validation->set_rules('commercial-status', 'Commercial Status', 'required');
                        $this->form_validation->set_rules('commercial-comment', 'Commercial Comment', 'required');

                        if ($this->form_validation->run() == TRUE) {

                            $i = $this->model_commercial->addCommercial($this->session->userdata('__dhakahomeERPUserID'));


                            if ($i == '1') {

                                $s['_setCompany'] = FALSE;
                                $s['_setCompanyId'] = FALSE;
                                $s['_setClient'] = FALSE;
                                $s['_setClientId'] = FALSE;
                                $s['_setProject'] = FALSE;
                                $s['_setProjectId'] = FALSE;

                                $this->session->unset_userdata($s);

                                $ss['_success'] = true;
                                $this->session->set_userdata($ss);

                                redirect(base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_ADD_COMMMERCIAL . 'step1/');
                            }
                        }
                    }

                    $data['floor'] = getCommercialFloor();
                    $data['size'] = getCommercialSize();
                    $data['currency'] = getCurrency();
                    $data['condition'] = getCondition();
                    $data['status'] = getCommercialStatus();

                    $page['content'] = $this->load->view(siteConfig::COMPONENT_ADD_COMMERCIAL_STEP4, $data, TRUE);
                } else {
                    redirect(base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_ADD_COMMMERCIAL . 'step1/');
                }
            }



            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER . siteConfig::METHOD_USER_INDEX));
        }
    }

    public function allCommercial() {
        
    }

    public function viewCommercial($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $id = decode($id);

            if (isset($id) && is_numeric($id)) {
                $data['details'] = $this->model_commercial->getCommercialDetails($id);
                $data['title'] = 'DhakaHome ERP Commmercial Sell';
                $data['sellHistory'] = $this->model_commercial->getSellHistory($id);
                $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
                $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
                $page['content'] = $this->load->view(siteConfig::COMPONENT_COMMERCIAL_DETAILS, '', TRUE);
                $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
                $this->load->view(siteConfig::SITE_MASTER, $page);
            } else {
                redirect(site_url(siteConfig::CONTROLLER_USER));
            }
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER));
        }
    }

    public function editCommercial($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $id = decode($id);

            if (isset($id) && is_numeric($id)) {
                $details = $this->model_commercial->getCommercialDetails($id);
                $data['floor'] = getCommercialFloor();
                $data['size'] = getCommercialSize();
                $data['currency'] = getCurrency();
                $data['condition'] = getCondition();
                $data['status'] = getCommercialStatus();
                $data['project'] = $this->model_commercial->getProjectByCommercial($details[dbConfig::TABLE_COMMERCIAL_ATT_ID]);

                if (isset($_POST['submit'])) {
                    $this->form_validation->set_rules('commercial-name', 'Commercial Name', 'required');
                    $this->form_validation->set_rules('commercial-address', 'Commercial Address', 'required');
                    $this->form_validation->set_rules('commercial-floor', 'Commercial Block', 'required');
                    $this->form_validation->set_rules('commercial-size', 'Commercial Facing', 'required');
                    $this->form_validation->set_rules('commercial-project', 'Project', 'required');

                    if (!isset($_POST['markAsCompany'])) {
                        $this->form_validation->set_rules('commercial-seller', 'Commercial Seller', 'required');
                    }

                    $this->form_validation->set_rules('commercial-asking-price', 'Commercial Asking Price', 'required');
                    $this->form_validation->set_rules('commercial-asking-min-price', 'Commercial Asking Minimum Price ', 'required');
                    $this->form_validation->set_rules('commercial-currency', 'Commercial Currency', 'required');
                    $this->form_validation->set_rules('commercial-condition', 'Commercial Condition', 'required');
                    $this->form_validation->set_rules('commercial-status', 'Commercial Status', 'required');
                    $this->form_validation->set_rules('commercial-comment', 'Commercial Comment', 'required');
                    if ($this->form_validation->run() == TRUE) {
                        $i = $this->model_commercial->updateCommercial($id, $this->session->userdata('__dhakahomeERPUserID'), $details[dbConfig::TABLE_COMMERCIAL_ATT_SELLER_ID]);
                        if ($i == '1') {
                            $ss['_success'] = true;
                            $this->session->set_userdata($ss);
                            redirect(base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_EDIT_COMMMERCIAL . encode($id));
                        }
                    }
                }

                $data['details'] = $details;
                $data['title'] = 'DhakaHome ERP Edit Commmercial';
                $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
                $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
                $page['content'] = $this->load->view(siteConfig::COMPONENT_COMMERCIAL_EDIT, '', TRUE);
                $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
                $this->load->view(siteConfig::SITE_MASTER, $page);
            } else {
                redirect(site_url(siteConfig::CONTROLLER_USER));
            }
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER));
        }
    }

    public function deleteCommercial($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $id = decode($id);
            if (isset($id) && is_numeric($id)) {
                $d = $this->model_commercial->deleteCommercial($id, $this->session->userdata('__dhakahomeERPUserID'));
                if ($d == '1') {
                    $s['_delete'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_LIST_COMMMERCIAL);
                } elseif ($d == '0') {
                    $s['_notdelete'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_LIST_COMMMERCIAL);
                }
            } else {
                redirect(site_url(siteConfig::CONTROLLER_USER));
            }
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER));
        }
    }

    public function setCompany() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            if (isset($_POST['submit'])) {

                if ($_POST['typename'] == '_NA') {
                    $data['_setCompany'] = '_NA';
                    $data['_setCompanyId'] = 'COMPANY_NOT_APPLICABLE';
                } else {
                    $data['_setCompany'] = $_POST['typename'];
                    $data['_setCompanyId'] = getCompanyIdByName($_POST['typename']);
                }

                $this->session->set_userdata($data);

                echo '1';
            }
        } else {
            echo 'Please Login';
        }
    }

    public function setClient() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            if (isset($_POST['submit'])) {
                if ($_POST['typename'] == '_NA') {
                    $data['_setClient'] = '_NA';
                    $data['_setClientId'] = 'CLIENT_NOT_APPLICABLE';
                } else {
                    $data['_setClient'] = getClientName($_POST['typename']);
                    $data['_setClientId'] = getClientIdByName($_POST['typename']);
                }
                $this->session->set_userdata($data);
                echo '1';
            }
        } else {
            echo 'Please Login';
        }
    }

    public function setProject() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            if (isset($_POST['submit'])) {
                if ($_POST['typename'] == '_NA') {
                    $data['_setProject'] = '_NA';
                    $data['_setProjectId'] = 'PROJECT_NOT_APPLICABLE';
                } else {
                    $data['_setProject'] = $_POST['typename'];
                    $data['_setProjectId'] = getProjectIdByName($_POST['typename']);
                }
                $this->session->set_userdata($data);
                echo '1';
            }
        } else {
            echo 'Please Login';
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

    public function clientEmailAddressCheck($email = "") {

        $check = $this->model_client->clientEmailAddressCheck($email);

        if ($check == '1') {
            $this->form_validation->set_message('clientEmailAddressCheck', 'Email Address Already Exist');
            return FALSE;
        } else {
            return TRUE;
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

    public function commercialNameCheck($name) {
        $check = $this->model_commercial->commercialNameCheck($name);

        if ($check == '1') {
            $this->form_validation->set_message('commercialNameCheck', 'Commercial Name Already Exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function commercialList($startPage = 0) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $data['title'] = 'DhakaHome ERP Commercial List';

            $perPage = '15';
            $this->load->library('pagination');
            $config['base_url'] = base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_LIST_COMMMERCIAL;
            $config['total_rows'] = $this->model_commercial->getNumOfCommercialList();
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


            $data['commercialList'] = $this->model_commercial->getCommercialList($startPage, $perPage);
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_COMMERCIAL_LIST, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER));
        }
    }

    public function sentMailToMultipleCommercial() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($_POST['submit'])) {
                echo $this->model_commercial->sentMailToMultipleCommercial($this->session->userdata('__dhakahomeERPUserID'));
            }
        } else {
            echo 'Please Login';
        }
    }

    public function sentMailToCommercial() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            if (isset($_POST['submit'])) {
                echo $this->model_commercial->sentMailToCommercial($this->session->userdata('__dhakahomeERPUserID'));
            }
        } else {
            echo 'Please Login';
        }
    }

    public function sellCommercial($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $id = decode($id);

            if (isset($id) && is_numeric($id)) {
                $data['details'] = $this->model_commercial->getCommercialDetails($id);
                $data['title'] = 'DhakaHome ERP Commmercial Sell';
                if (isset($_POST['submit'])) {
                    $this->form_validation->set_rules('company', 'Company', 'required');
                    $this->form_validation->set_rules('client', 'Client', 'required');
                    $this->form_validation->set_rules('project', 'Project', 'required');
                    $this->form_validation->set_rules('comment', 'Commment', 'required');

                    if (isset($_POST['markAsInstallmentSales'])) {
                        $this->form_validation->set_rules('sub-total', 'Sub total', 'required|numeric');
                        $this->form_validation->set_rules('down-payment', 'Down payment', 'required|numeric');
                        $this->form_validation->set_rules('installment-period', 'Installment period', 'required|numeric');
                        $this->form_validation->set_rules('monthly-payment', 'Monthly payment', 'required|numeric');
                    }

                    if ($this->form_validation->run() == TRUE) {
                        $i = $this->model_commercial->sellCommercial($id, $this->session->userdata('__dhakahomeERPUserID'));

                        if ($i == '1') {
                            $ss['_success'] = true;
                            $this->session->set_userdata($ss);
                            redirect(base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_SELL_COMMMERCIAL . encode($id));
                        }
                    }
                }
                $data['company'] = getAllCompany();
                $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
                $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
                $page['content'] = $this->load->view(siteConfig::COMPONENT_COMMERCIAL_SELL, '', TRUE);
                $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
                $this->load->view(siteConfig::SITE_MASTER, $page);
            } else {
                redirect(site_url(siteConfig::CONTROLLER_USER));
            }
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER));
        }
    }

}
