<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_Common extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('email');

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';

        $this->email->initialize($config);
    }

    public function getAllCountry() {
        //echo 'akram';
        $this->db->select(dbConfig::TABLE_COUNTRY_ATT_COUNTRY_ID);
        $this->db->select(dbConfig::TABLE_COUNTRY_ATT_COUNTRY_NAME);
        return $this->db->get(dbConfig::TABLE_COUNTRY)->result_array();
    }

    public function getAllCompany() {
        $this->db->select(dbConfig::TABLE_COMPANY_ATT_ID);
        $this->db->select(dbConfig::TABLE_COMPANY_ATT_NAME);
        return $this->db->get(dbConfig::TABLE_COMPANY)->result_array();
    }

    public function getAllClients() {
        $this->db->select(dbConfig::TABLE_CLIENT_ATT_EMAIL);
        return $this->db->get(dbConfig::TABLE_CLIENT)->result_array();
    }
    
    public function getClientByCompany($companyId) {
        $this->db->select(dbConfig::TABLE_CLIENT_ATT_EMAIL);
        $this->db->where(dbConfig::TABLE_CLIENT_ATT_COMPANY,$companyId);
        $this->db->where(dbConfig::TABLE_CLIENT_ATT_IS_DELETE,'0');
        return $this->db->get(dbConfig::TABLE_CLIENT)->result_array();
    }

    public function getAllProject() {
        $this->db->select(dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME);
        return $this->db->get(dbConfig::TABLE_PROJECT)->result_array();
    }

    public function getProjectType() {
        return $this->db->get(dbConfig::TABLE_PROJECT_TYPE)->result_array();
    }

    public function getAllPriviledge() {
        return $this->db->get(dbConfig::TABLE_USER_PRIVILEDGE)->result_array();
    }

    public function getUserNameById($userId) {
        $this->db->where(dbConfig::TABLE_USER_ATT_USER_ID, $userId);
        $r = $this->db->get(dbConfig::TABLE_USER)->row_array();

        return $r[dbConfig::TABLE_USER_ATT_USER_USERNAME];
    }
    
    public function getCompanyIdByName($name) {
        $this->db->where(dbConfig::TABLE_COMPANY_ATT_NAME, $name);
        $r = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

        return $r[dbConfig::TABLE_COMPANY_ATT_ID];
    }
    
    public function getProjectIdByName($name) {
        $this->db->where(dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME, $name);
        $r = $this->db->get(dbConfig::TABLE_PROJECT)->row_array();

        return $r[dbConfig::TABLE_PROJECT_ATT_ID];
    }
    
    public function getProjectByCompany($companyId) {
        $this->db->where(dbConfig::TABLE_PROJECT_ATT_IS_DELETE, '0');
        $this->db->where(dbConfig::TABLE_PROJECT_ATT_COMPANY_ID,$companyId);
        $r = $this->db->get(dbConfig::TABLE_PROJECT)->result_array();

        return $r;
    }
    
    public function getClientIdByName($email) {
        $this->db->where(dbConfig::TABLE_CLIENT_ATT_EMAIL, $email);
        $r = $this->db->get(dbConfig::TABLE_CLIENT)->row_array();

        return $r[dbConfig::TABLE_CLIENT_ATT_ID];
    }
    
    public function getClientName($email) {
        $this->db->where(dbConfig::TABLE_CLIENT_ATT_EMAIL, $email);
        $r = $this->db->get(dbConfig::TABLE_CLIENT)->row_array();

        return $r[dbConfig::TABLE_CLIENT_ATT_FIRST_NAME]." ".$r[dbConfig::TABLE_CLIENT_ATT_LAST_NAME];
    }
    
    public function getCurrency()
    {
        $r = $this->db->get(dbConfig::TABLE_CURRENCY)->result_array();

        return $r;
    }

}
