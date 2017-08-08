<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'controllers/siteConfig.php';
require_once APPPATH . 'controllers/dbConfig.php';

class Plot extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper(array('url', 'site', 'cookie', 'form', 'plot'));
        $this->load->database();
        $this->load->library(array('form_validation', 'email', 'session'));
        $this->load->model('model_plot');
        $this->load->model('model_company');
        $this->load->model('model_project');
        $this->load->model('model_client');
    }

    public function index() {
        $this->addPlot();
    }

    public function addPlot($step = '') {
        $data['title'] = 'DhakaHome ERP Add Plot';
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {



            if ($step == "") {
                redirect(siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_ADD_PLOT . 'step1/');
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
                            redirect(base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_ADD_PLOT . 'step2/');
                        }
                    }
                }

                $page['content'] = $this->load->view(siteConfig::COMPONENT_ADD_PLOT, $data, TRUE);
            } elseif ($step == 'step2') {
                //echo $this->session->userdata("_setCompanyId");
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

                            redirect(base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_ADD_PLOT . 'step3/');
                        }
                    }
                }
                $data['type'] = getProjectType();
                $data['project'] = getProjectByCompany($this->session->userdata('_setCompanyId'));
                $page['content'] = $this->load->view(siteConfig::COMPONENT_ADD_PLOT_STEP2, $data, TRUE);
            } elseif ($step == 'step3') {

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
                            redirect(base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_ADD_PLOT . 'step4/');
                        }
                    }
                }
                $data['client'] = $this->model_client->clientList();
                $page['content'] = $this->load->view(siteConfig::COMPONENT_ADD_PLOT_STEP3, $data, TRUE);
            } elseif ($step == 'step4') {

                if ($this->session->userdata('_setCompany') && $this->session->userdata('_setCompanyId') && $this->session->userdata('_setProject') && $this->session->userdata('_setProjectId')) {

                    $data['project'] = getProjectByCompany($this->session->userdata('_setCompanyId'));

                    //debugPrint($_POST);

                    if (isset($_POST['submit'])) {
                        $data['submit'] = '4';
                        $this->form_validation->set_rules('plot-name', 'Plot Name', 'required|callback_plotNameCheck');
                        $this->form_validation->set_rules('plot-address', 'Plot Address', 'required');
                        $this->form_validation->set_rules('plot-block', 'Plot Block', 'required');
                        $this->form_validation->set_rules('plot-facing', 'Plot Facing', 'required');
                        $this->form_validation->set_rules('plot-project', 'Project', 'required');

                        if (!isset($_POST['markAsCompany'])) {
                            $this->form_validation->set_rules('plot-seller', 'Plot Seller', 'required');
                        }

                        $this->form_validation->set_rules('plot-asking-price', 'Plot Asking Price', 'required');
                        $this->form_validation->set_rules('plot-asking-min-price', 'Plot Asking Minimum Price ', 'required');
                        $this->form_validation->set_rules('plot-currency', 'Plot Currency', 'required');
                        $this->form_validation->set_rules('plot-condition', 'Plot Condition', 'required');
                        $this->form_validation->set_rules('plot-status', 'Plot Status', 'required');
                        $this->form_validation->set_rules('plot-comment', 'Plot Comment', 'required');

                        if ($this->form_validation->run() == TRUE) {

                            $i = $this->model_plot->addPlot($this->session->userdata('__dhakahomeERPUserID'));


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

                                redirect(base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_ADD_PLOT . 'step1/');
                            }
                        }
                    }

                    $data['block'] = getPlotBlock();
                    $data['facing'] = getPlotFacing();
                    $data['currency'] = getCurrency();
                    $data['condition'] = getCondition();
                    $data['status'] = getPlotStatus();

                    $page['content'] = $this->load->view(siteConfig::COMPONENT_ADD_PLOT_STEP4, $data, TRUE);
                } else {
                    redirect(base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_ADD_PLOT . 'step1/');
                }
            }



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

    public function plotNameCheck($name) {
        $check = $this->model_plot->plotNameCheck($name);

        if ($check == '1') {
            $this->form_validation->set_message('plotNameCheck', 'Plot Name Already Exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function getAddCompanyForm() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            $output = $this->load->view(siteConfig::COMPONENT_COMPANY_ADD_FORM);
            echo $output;
        } else {
            echo 'Please Login';
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

    public function plotList($startPage = 0) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $data['title'] = 'DhakaHome ERP Plot List';

            $perPage = '15';
            $this->load->library('pagination');
            $config['base_url'] = base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_LIST_PLOT;
            $config['total_rows'] = $this->model_plot->getNumOfPlotList();
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


            $data['plotList'] = $this->model_plot->getPlotList($startPage, $perPage);
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_PLOT_LIST, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER));
        }
    }

    public function viewPlot($id) {
        //echo decode($id);
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $id = decode($id);

            if (isset($id) && is_numeric($id)) {
                $data['details'] = $this->model_plot->getPlotDetails($id);
                $data['title'] = 'DhakaHome ERP Plot Details';
                $data['sellHistory'] = $this->model_plot->getSellHistory($id);
                $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
                $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
                $page['content'] = $this->load->view(siteConfig::COMPONENT_PLOT_DETAILS, '', TRUE);
                $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
                $this->load->view(siteConfig::SITE_MASTER, $page);
            } else {
                redirect(site_url(siteConfig::CONTROLLER_USER));
            }
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER));
        }
    }

    public function deletePlot($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $id = decode($id);
            if (isset($id) && is_numeric($id)) {
                $d = $this->model_plot->deletePlot($id, $this->session->userdata('__dhakahomeERPUserID'));
                if ($d == '1') {
                    $s['_delete'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_LIST_PLOT);
                } elseif ($d == '0') {
                    $s['_notdelete'] = true;
                    $this->session->set_userdata($s);
                    redirect(base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_LIST_PLOT);
                }
            } else {
                redirect(site_url(siteConfig::CONTROLLER_USER));
            }
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER));
        }
    }

    public function editPlot($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $data['title'] = 'DhakaHome ERP Edit Apartment';

            $data['block'] = getPlotBlock();
            $data['facing'] = getPlotFacing();
            $data['currency'] = getCurrency();
            $data['condition'] = getCondition();
            $data['status'] = getPlotStatus();

            $id = decode($id);
            $details = $this->model_plot->getPlotDetails($id);
            if (isset($id) && is_numeric($id)) {
                if (isset($_POST['submit'])) {
                    $this->form_validation->set_rules('plot-name', 'Plot Name', 'required');
                    $this->form_validation->set_rules('plot-address', 'Plot Address', 'required');
                    $this->form_validation->set_rules('plot-block', 'Plot Block', 'required');
                    $this->form_validation->set_rules('plot-facing', 'Plot Facing', 'required');
                    $this->form_validation->set_rules('plot-project', 'Project', 'required');

                    if (!isset($_POST['markAsCompany'])) {
                        $this->form_validation->set_rules('plot-seller', 'Plot Seller', 'required');
                    }

                    $this->form_validation->set_rules('plot-asking-price', 'Plot Asking Price', 'required');
                    $this->form_validation->set_rules('plot-asking-min-price', 'Plot Asking Minimum Price ', 'required');
                    $this->form_validation->set_rules('plot-currency', 'Plot Currency', 'required');
                    $this->form_validation->set_rules('plot-condition', 'Plot Condition', 'required');
                    $this->form_validation->set_rules('plot-status', 'Plot Status', 'required');
                    $this->form_validation->set_rules('plot-comment', 'Plot Comment', 'required');
                    if ($this->form_validation->run() == TRUE) {
                        $i = $this->model_plot->updatePlot($id, $this->session->userdata('__dhakahomeERPUserID'), $details[dbConfig::TABLE_PLOT_ATT_PLOT_SELLER_ID]);
                        if ($i == '1') {
                            $ss['_success'] = true;
                            $this->session->set_userdata($ss);
                            redirect(base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_EDIT_PLOT . encode($id));
                        }
                    }
                }

                $data['details'] = $details;
                $data['project'] = $this->model_plot->getProjectByPlot($details[dbConfig::TABLE_PLOT_ATT_PLOT_ID]);
                $data['seller'] = $this->model_plot->getPlotSeller($details[dbConfig::TABLE_PLOT_ATT_PLOT_ID]);
                $data['title'] = 'DhakaHome ERP Plot Details';
                $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
                $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
                $page['content'] = $this->load->view(siteConfig::COMPONENT_PLOT_EDIT, '', TRUE);
                $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
                $this->load->view(siteConfig::SITE_MASTER, $page);
            } else {
                redirect(site_url(siteConfig::CONTROLLER_USER));
            }
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER));
        }
    }

    public function sentMailToPlot() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            if (isset($_POST['submit'])) {

                echo $this->model_plot->sentMailToPlot($this->session->userdata('__dhakahomeERPUserID'));
            }
        } else {
            echo 'Please Login';
        }
    }

    public function sentMailToMultiplePlot() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            if (isset($_POST['submit'])) {

                echo $this->model_plot->sentMailToMultiplePlot($this->session->userdata('__dhakahomeERPUserID'));
            }
        } else {
            echo 'Please Login';
        }
    }

    public function sellPlot($id) {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {
            $id = decode($id);

            if (isset($id) && is_numeric($id)) {
                $data['details'] = $this->model_plot->getPlotDetails($id);
                $data['title'] = 'DhakaHome ERP Plot Sell';
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
                        $i = $this->model_plot->sellPlot($id, $this->session->userdata('__dhakahomeERPUserID'));

                        if ($i == '1') {
                            $ss['_success'] = true;
                            $this->session->set_userdata($ss);
                            redirect(base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_SELL_PLOT . encode($id));
                        }
                    }
                }
                $data['company'] = getAllCompany();
                $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
                $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
                $page['content'] = $this->load->view(siteConfig::COMPONENT_PLOT_SELL, '', TRUE);
                $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
                $this->load->view(siteConfig::SITE_MASTER, $page);
            } else {
                redirect(site_url(siteConfig::CONTROLLER_USER));
            }
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER));
        }
    }

    public function getCompanyProjectNclient() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            if (isset($_POST['submit'])) {

                echo $this->model_plot->getCompanyProjectNclient();
            }
        } else {
            echo 'Please Login';
        }
    }

}
