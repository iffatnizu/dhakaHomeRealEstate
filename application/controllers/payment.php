<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once APPPATH . 'controllers/siteConfig.php';
require_once APPPATH . 'controllers/dbConfig.php';

class Payment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'site', 'cookie', 'plot', 'apartment'));
        $this->load->database();
        $this->load->library(array('form_validation', 'email', 'session'));
        $this->load->model("model_payment");
    }

    public function index() {
        $this->allInvoices();
    }

    public function allInvoices() {
        
    }

    public function dueInvoices() {
        
    }

    public function paidPayment() {
        
    }

    public function duePayment() {
        if ($this->session->userdata('__dhakahomeERPUserLogin')) {

            $data['title'] = 'DhakaHome ERP Due Payment';
            $data['paymentplot'] = $this->model_payment->getPlotDue();
            $data['paymentapartment'] = $this->model_payment->getApartmentDue();
            $data['paymentcommercial'] = $this->model_payment->getCommercialDue();
            $page['header'] = $this->load->view(siteConfig::MOD_HEADER, $data, TRUE);
            $page['menu'] = $this->load->view(siteConfig::MOD_MENU, $data, TRUE);
            $page['content'] = $this->load->view(siteConfig::COMPONENT_DUE_PAYMENT, '', TRUE);
            $page['footer'] = $this->load->view(siteConfig::MOD_FOOTER, '', TRUE);
            $this->load->view(siteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url(siteConfig::CONTROLLER_USER));
        }
    }

}
