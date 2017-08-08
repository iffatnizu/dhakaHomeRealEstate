<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_Project extends CI_Model {

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

    public function addProject($userId) {

        $data[dbConfig::TABLE_PROJECT_ATT_COMPANY_ID] = $this->input->post('company');
        
        $data[dbConfig::TABLE_PROJECT_ATT_USER_ID] = $userId;
        $data[dbConfig::TABLE_PROJECT_ATT_PROJECT_TYPE_ID] = $this->input->post('project-type');
        $data[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME] = $this->input->post('project-name');
        $data[dbConfig::TABLE_PROJECT_ATT_PROJECT_EMAIL] = $this->input->post('project-email');
        $data[dbConfig::TABLE_PROJECT_ATT_PROJECT_DETAILS] = $this->input->post('project-details');
        $data[dbConfig::TABLE_PROJECT_ATT_PROJECT_COUNTRY] = $this->input->post('countryId');
        $data[dbConfig::TABLE_PROJECT_ATT_PROJECT_STATE] = $this->input->post('state');
        $data[dbConfig::TABLE_PROJECT_ATT_PROJECT_CITY] = $this->input->post('city');
        $data[dbConfig::TABLE_PROJECT_ATT_ADDED_TIME] = time();

        $i = $this->db->insert(dbConfig::TABLE_PROJECT, $data);
        $lastId = $this->db->insert_id();

        if ($i) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> added a project <a href="' . base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_VIEW_PROJECT . $lastId . '">' . $this->input->post('project-name') . '</a> ';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            return '1';
        }
    }

    public function getNumOfProjectList() {
        return $this->db->get(dbConfig::TABLE_PROJECT)->num_rows();
    }

    public function getProjectList($startPage = '', $perPage = '') {
        $sql = 'SELECT ' . dbConfig::TABLE_PROJECT . '.*,' . dbConfig::TABLE_COUNTRY . '.' . dbConfig::TABLE_COUNTRY_ATT_COUNTRY_NAME . ',' . dbConfig::TABLE_STATES . '.' . dbConfig::TABLE_STATES_ATT_STATE_NAME . ',' . dbConfig::TABLE_CITY . '.' . dbConfig::TABLE_CITY_ATT_CITY_NAME . ',' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_NAME . ',' . dbConfig::TABLE_PROJECT_TYPE . '.' . dbConfig::TABLE_PROJECT_TYPE_ATT_NAME . '
                FROM ' . dbConfig::TABLE_PROJECT . ' 
                LEFT JOIN ' . dbConfig::TABLE_COUNTRY . ' ON ' . dbConfig::TABLE_COUNTRY . '.' . dbConfig::TABLE_COUNTRY_ATT_COUNTRY_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_COUNTRY . ' 
                LEFT JOIN ' . dbConfig::TABLE_STATES . ' ON ' . dbConfig::TABLE_STATES . '.' . dbConfig::TABLE_STATES_ATT_STATE_SHORT_NAME . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_STATE . ' 
                LEFT JOIN ' . dbConfig::TABLE_CITY . ' ON ' . dbConfig::TABLE_CITY . '.' . dbConfig::TABLE_CITY_ATT_CITY_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_CITY . ' 
                LEFT JOIN ' . dbConfig::TABLE_COMPANY . ' ON ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_COMPANY_ID . ' 
                
                LEFT JOIN ' . dbConfig::TABLE_PROJECT_TYPE . ' ON ' . dbConfig::TABLE_PROJECT_TYPE . '.' . dbConfig::TABLE_PROJECT_TYPE_ATT_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_TYPE_ID . ' 
                WHERE  ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_IS_DELETE . ' = "0"
                ORDER BY  ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_ID . ' DESC
                LIMIT ' . $startPage . ',' . $perPage . '
               ';
        //echo $sql;
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    public function getProjectDetails($id) {
        $sql = 'SELECT ' . dbConfig::TABLE_PROJECT . '.*,' . dbConfig::TABLE_COUNTRY . '.' . dbConfig::TABLE_COUNTRY_ATT_COUNTRY_NAME . ',' . dbConfig::TABLE_STATES . '.' . dbConfig::TABLE_STATES_ATT_STATE_NAME . ',' . dbConfig::TABLE_CITY . '.' . dbConfig::TABLE_CITY_ATT_CITY_NAME . ',' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_NAME . ',' . dbConfig::TABLE_PROJECT_TYPE . '.' . dbConfig::TABLE_PROJECT_TYPE_ATT_NAME . '
                FROM ' . dbConfig::TABLE_PROJECT . ' 
                LEFT JOIN ' . dbConfig::TABLE_COUNTRY . ' ON ' . dbConfig::TABLE_COUNTRY . '.' . dbConfig::TABLE_COUNTRY_ATT_COUNTRY_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_COUNTRY . ' 
                LEFT JOIN ' . dbConfig::TABLE_STATES . ' ON ' . dbConfig::TABLE_STATES . '.' . dbConfig::TABLE_STATES_ATT_STATE_SHORT_NAME . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_STATE . ' 
                LEFT JOIN ' . dbConfig::TABLE_CITY . ' ON ' . dbConfig::TABLE_CITY . '.' . dbConfig::TABLE_CITY_ATT_CITY_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_CITY . ' 
                LEFT JOIN ' . dbConfig::TABLE_COMPANY . ' ON ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_COMPANY_ID . '                 
                LEFT JOIN ' . dbConfig::TABLE_PROJECT_TYPE . ' ON ' . dbConfig::TABLE_PROJECT_TYPE . '.' . dbConfig::TABLE_PROJECT_TYPE_ATT_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_TYPE_ID . ' 
                WHERE  ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_ID . ' = "' . $id . '" AND ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_IS_DELETE . ' = "0"
               ';
        //echo $sql;
        $result = $this->db->query($sql)->row_array();

        return $result;
    }

    public function deleteProject($id, $userId) {

        $this->db->where(dbConfig::TABLE_PLOT_ATT_PLOT_PROJECT_ID, $id);
        $c = $this->db->get(dbConfig::TABLE_PLOT)->num_rows();

        if (!empty($c)) {
            return '0';
        }
        
        $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_PROJECT_ID, $id);
        $c1 = $this->db->get(dbConfig::TABLE_APARTMENT)->num_rows();

        if (!empty($c1)) {
            return '0';
        }
        
        $this->db->where(dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID, $id);
        $c2 = $this->db->get(dbConfig::TABLE_COMMERCIAL)->num_rows();

        if (!empty($c2)) {
            return '0';
        }

        $this->db->where(dbConfig::TABLE_PROJECT_ATT_ID, $id);
        $r = $this->db->get(dbConfig::TABLE_PROJECT)->row_array();

        $data[dbConfig::TABLE_PROJECT_ATT_IS_DELETE] = '1';
        $this->db->set($data);
        $this->db->where(dbConfig::TABLE_PROJECT_ATT_ID, $id);
        $d = $this->db->update(dbConfig::TABLE_PROJECT);

        if ($d) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> deleted a project <b>' . $r[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME] . '</b>';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            return '1';
        }
    }

    public function updateProject($userId, $id) {
        $data[dbConfig::TABLE_PROJECT_ATT_COMPANY_ID] = $this->input->post('company');
        
        $data[dbConfig::TABLE_PROJECT_ATT_PROJECT_TYPE_ID] = $this->input->post('project-type');
        $data[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME] = $this->input->post('project-name');
        $data[dbConfig::TABLE_PROJECT_ATT_PROJECT_DETAILS] = $this->input->post('project-details');
        $data[dbConfig::TABLE_PROJECT_ATT_PROJECT_COUNTRY] = $this->input->post('countryId');
        $data[dbConfig::TABLE_PROJECT_ATT_PROJECT_STATE] = $this->input->post('state');
        $data[dbConfig::TABLE_PROJECT_ATT_PROJECT_CITY] = $this->input->post('city');

        $this->db->set($data);
        $this->db->where(dbConfig::TABLE_PROJECT_ATT_ID, $id);
        //$this->db->where(dbConfig::TABLE_PROJECT_ATT_USER_ID, $userId);
        $this->db->where(dbConfig::TABLE_PROJECT_ATT_IS_DELETE, "0");

        $i = $this->db->update(dbConfig::TABLE_PROJECT);

        if ($i) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> edited a project <a href="' . base_url() . siteConfig::CONTROLLER_PROJECT . siteConfig::METHOD_VIEW_PROJECT . $id . '">' . $this->input->post('project-name') . '</a> ';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            return '1';
        }
    }

    public function getProjectType() {
        return $this->db->get(dbConfig::TABLE_PROJECT_TYPE)->result_array();
    }

    public function addProjectType() {
        $data[dbConfig::TABLE_PROJECT_TYPE_ATT_NAME] = $this->input->post('type-name');

        $i = $this->db->insert(dbConfig::TABLE_PROJECT_TYPE, $data);

        if ($i) {
            return '1';
        }
    }

    public function deleteProjectType() {
        if (!empty($_POST['checkId'])) {
            foreach ($_POST['checkId'] as $id) {

                $this->db->where(dbConfig::TABLE_PROJECT_ATT_PROJECT_TYPE_ID, $id);
                $r = $this->db->get(dbConfig::TABLE_PROJECT)->num_rows();

                if (empty($r)) {
                    $this->db->where(dbConfig::TABLE_PROJECT_TYPE_ATT_ID, $id);
                    $d = $this->db->delete(dbConfig::TABLE_PROJECT_TYPE);
                } else {
                    return '0';
                }
            }
            return '1';
        } else {
            return '0';
        }
    }

    public function updateProjectType() {
        if (!empty($_POST['checkId'])) {
            //debugPrint($_POST);
            foreach ($_POST['checkId'] as $id) {

                if ($_POST['project-type'][$id] != "") {
                    $data[dbConfig::TABLE_PROJECT_TYPE_ATT_NAME] = $_POST['project-type'][$id];
                    $this->db->set($data);
                    $this->db->where(dbConfig::TABLE_PROJECT_TYPE_ATT_ID, $id);
                    $this->db->update(dbConfig::TABLE_PROJECT_TYPE);
                }
            }

            return '1';
        }
    }

    public function projectEmailAddressCheck($email = "") {
        $this->db->where(DBConfig::TABLE_PROJECT_ATT_PROJECT_EMAIL, $email);
        $query = $this->db->get(DBConfig::TABLE_PROJECT);

        if ($query->num_rows() == 1) {
            return '1';
        } else {
            return '0';
        }
    }

    public function sendMail($userId) {
        //debugPrint($_POST);

        foreach ($_POST['id'] as $id) {

            $this->db->select(dbConfig::TABLE_PROJECT_ATT_PROJECT_EMAIL);
            $this->db->where(dbConfig::TABLE_PROJECT_ATT_ID, $id);

            $r = $this->db->get(dbConfig::TABLE_PROJECT)->row_array();

            if (!empty($r)) {

                $this->email->from('admin@dhakahome.com', 'Dhaka Home Administration');
                $this->email->to($r[dbConfig::TABLE_PROJECT_ATT_PROJECT_EMAIL]);
                $this->email->subject($this->input->post('subject'));
                $this->email->message($this->input->post('body'));

                $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_RECEIVE_ID] = $id;
                $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_USER_ID] = $userId;
                $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_EMAIL_TYPE] = '3';
                $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_TIME] = time();

                $this->db->insert(dbConfig::TABLE_EMAIL_STATUS, $data1);

                $this->email->send();

                //echo $this->email->print_debugger();
            }
        }

        return '1';
    }

    public function sentMailToSingleProject($userId) {
        $this->db->select(dbConfig::TABLE_PROJECT_ATT_PROJECT_EMAIL);
        $this->db->select(dbConfig::TABLE_PROJECT_ATT_ID);
        $this->db->where(dbConfig::TABLE_PROJECT_ATT_PROJECT_EMAIL, $_POST['email']);

        $r = $this->db->get(dbConfig::TABLE_PROJECT)->row_array();

        if (!empty($r)) {

            $this->email->from('admin@dhakahome.com', 'Dhaka Home Administration');
            $this->email->to($r[dbConfig::TABLE_PROJECT_ATT_PROJECT_EMAIL]);
            $this->email->subject($this->input->post('subject'));
            $this->email->message($this->input->post('body'));

            $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_RECEIVE_ID] = $r[dbConfig::TABLE_PROJECT_ATT_ID];
            $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_USER_ID] = $userId;
            $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_EMAIL_TYPE] = '3';
            $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_TIME] = time();

            $this->db->insert(dbConfig::TABLE_EMAIL_STATUS, $data1);

            $this->email->send();

            //echo $this->email->print_debugger();

            return '1';
        }
    }

    public function getProjectByCompany($name) {
        $this->db->select(dbConfig::TABLE_COMPANY_ATT_ID);
        $this->db->where(dbConfig::TABLE_COMPANY_ATT_NAME, $name);

        $r = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

        if (!empty($r)) {
            $this->db->select(dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME);
            $this->db->where(dbConfig::TABLE_PROJECT_ATT_COMPANY_ID, $r[dbConfig::TABLE_COMPANY_ATT_ID]);

            $re = $this->db->get(dbConfig::TABLE_PROJECT)->result_array();

            //echo $this->db->last_query();
            $v = '';
            foreach ($re as $r) {
                $v.="'" . $r[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME] . "',";
            }
            $v = substr($v, 0, (strlen($v) - 1));
            return $v;
        }
    }

}
