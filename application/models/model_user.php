<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_User extends CI_Model {

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

    public function dologin() {
        $this->db->where(DBConfig::TABLE_USER_ATT_USER_USERNAME, $_POST['userUserName']);
        $this->db->where(DBConfig::TABLE_USER_ATT_USER_PASSWORD, md5($_POST['userPassword']));
        $this->db->where(DBConfig::TABLE_USER_ATT_USER_IS_ACTIVE, '1');

        $result = $this->db->get(DBConfig::TABLE_USER)->row_array();

        if (empty($result)) {
            return '0';
        } else {
            $data[DBConfig::TABLE_USER_ATT_USER_LAST_LOGIN_TIME] = time();
            $this->db->where(DBConfig::TABLE_USER_ATT_USER_ID, $result[DBConfig::TABLE_USER_ATT_USER_ID]);
            $this->db->set($data);
            $this->db->update(DBConfig::TABLE_USER);
            return $result;
        }
    }

    public function userProfile($userId) {
        //$this->db->where(DBConfig::TABLE_USER_ATT_USER_ID, $userId);
        $sql = 'SELECT ' . dbConfig::TABLE_USER . '.*,' . dbConfig::TABLE_USER_PRIVILEDGE . '.' . dbConfig::TABLE_USER_PRIVILEDGE_ATT_NAME . ' FROM ' . dbConfig::TABLE_USER . ' LEFT JOIN ' . dbConfig::TABLE_USER_PRIVILEDGE . ' ON ' . dbConfig::TABLE_USER_PRIVILEDGE . '.' . dbConfig::TABLE_USER_PRIVILEDGE_ATT_ID . ' = ' . dbConfig::TABLE_USER . '.' . dbConfig::TABLE_USER_ATT_USER_PREVILEDGE . ' WHERE ' . dbConfig::TABLE_USER . '.' . dbConfig::TABLE_USER_ATT_USER_ID . ' = "' . $userId . '"  ';
        $result = $this->db->query($sql)->row_array();
        return $result;
    }

    public function getUserList() {
        $sql = 'SELECT ' . dbConfig::TABLE_USER . '.*,' . dbConfig::TABLE_USER_PRIVILEDGE . '.' . dbConfig::TABLE_USER_PRIVILEDGE_ATT_NAME . ' FROM ' . dbConfig::TABLE_USER . ' LEFT JOIN ' . dbConfig::TABLE_USER_PRIVILEDGE . ' ON ' . dbConfig::TABLE_USER_PRIVILEDGE . '.' . dbConfig::TABLE_USER_PRIVILEDGE_ATT_ID . ' = ' . dbConfig::TABLE_USER . '.' . dbConfig::TABLE_USER_ATT_USER_PREVILEDGE . ' ';
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function clientList() {
        return $this->db->get(DBConfig::TABLE_CLIENT)->result_array();
    }

    public function getStateByCountry($id) {
        $this->db->select(dbConfig::TABLE_STATES_ATT_STATE_NAME);
        $this->db->select(dbConfig::TABLE_STATES_ATT_STATE_SHORT_NAME);
        $this->db->where(dbConfig::TABLE_STATES_ATT_COUNTRY_ID, $id);

        return json_encode($this->db->get(dbConfig::TABLE_STATES)->result_array());
    }

    public function getCityByState($shortName) {

        $this->db->select(dbConfig::TABLE_CITY_ATT_CITY_ID);
        $this->db->select(dbConfig::TABLE_CITY_ATT_CITY_NAME);
        $this->db->where(dbConfig::TABLE_CITY_ATT_STATE_SHORT_NAME, $shortName);

        return json_encode($this->db->get(dbConfig::TABLE_CITY)->result_array());
    }

    public function updateProfile($userId) {
        $data[dbConfig::TABLE_USER_ATT_USER_FIRSTNAME] = $this->input->post('first-name');
        $data[dbConfig::TABLE_USER_ATT_USER_LASTNAME] = $this->input->post('last-name');
        $data[dbConfig::TABLE_USER_ATT_USER_EMAIL] = $this->input->post('email');

        $this->db->set($data);
        $this->db->where(dbConfig::TABLE_USER_ATT_USER_ID, $userId);
        $i = $this->db->update(dbConfig::TABLE_USER);

        if ($i) {

            return '1';
        }
    }

    public function changePassword($userId) {
        $this->db->where(dbConfig::TABLE_USER_ATT_USER_ID, $userId);
        $this->db->where(dbConfig::TABLE_USER_ATT_USER_PASSWORD, md5($this->input->post('old-password')));

        $r = $this->db->get(dbConfig::TABLE_USER)->row_array();

        if (!empty($r)) {
            $data[dbConfig::TABLE_USER_ATT_USER_PASSWORD] = md5($this->input->post('new-password'));

            $this->db->set($data);
            $this->db->where(dbConfig::TABLE_USER_ATT_USER_ID, $userId);
            $i = $this->db->update(dbConfig::TABLE_USER);

            if ($i) {
                return '1';
            }
        } else {
            return '0';
        }
    }

    public function userEmailAddressCheck($email = "") {
        $this->db->where(DBConfig::TABLE_USER_ATT_USER_EMAIL, $email);
        $query = $this->db->get(DBConfig::TABLE_USER);

        if ($query->num_rows() == 1) {
            return '1';
        } else {
            return '0';
        }
    }

    public function userNameCheck($name = "") {
        $this->db->where(DBConfig::TABLE_USER_ATT_USER_USERNAME, $name);
        $query = $this->db->get(DBConfig::TABLE_USER);

        if ($query->num_rows() == 1) {
            return '1';
        } else {
            return '0';
        }
    }

    public function addUser($userId) {
        $data[dbConfig::TABLE_USER_ATT_USER_FIRSTNAME] = $this->input->post('first-name');
        $data[dbConfig::TABLE_USER_ATT_USER_LASTNAME] = $this->input->post('last-name');
        $data[dbConfig::TABLE_USER_ATT_USER_USERNAME] = $this->input->post('user-name');
        $data[dbConfig::TABLE_USER_ATT_USER_PASSWORD] = md5($this->input->post('password'));
        $data[dbConfig::TABLE_USER_ATT_USER_EMAIL] = $this->input->post('email');
        $data[dbConfig::TABLE_USER_ATT_USER_PREVILEDGE] = $this->input->post('priviledge');
        $data[dbConfig::TABLE_USER_ATT_USER_IS_ACTIVE] = "1";

        $query = $this->db->insert(DBConfig::TABLE_USER, $data);
        $lastId = $this->db->insert_id();

        if ($query) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> created a user <a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $lastId . '">' . $this->input->post('first-name') . ' ' . $this->input->post('last-name') . '</a> ';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            return '1';
        }
    }

    public function updateUser($userId, $editorId) {
        $data[dbConfig::TABLE_USER_ATT_USER_FIRSTNAME] = $this->input->post('first-name');
        $data[dbConfig::TABLE_USER_ATT_USER_LASTNAME] = $this->input->post('last-name');
        $data[dbConfig::TABLE_USER_ATT_USER_PREVILEDGE] = $this->input->post('priviledge');

        $this->db->set($data);
        $this->db->where(dbConfig::TABLE_USER_ATT_USER_ID, $userId);

        $query = $this->db->update(DBConfig::TABLE_USER);

        if ($query) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $editorId . '">' . getUserNameById($editorId) . '</a> edited a user <a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . $this->input->post('first-name') . ' ' . $this->input->post('last-name') . '</a> ';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            return '1';
        }
    }

    public function getActivity($startPage = '', $perPage = '', $userId = 0) {

        $sql = 'SELECT * FROM ' . dbConfig::TABLE_LOG . ' ORDER BY ' . dbConfig::TABLE_LOG_ATT_TIME . ' DESC LIMIT ' . $startPage . ',' . $perPage . ' ';

        $result = $this->db->query($sql)->result_array();

        $data = array();

        foreach ($result as $row) {
            $row['date'] = date("y-m-d h:i:s", $row[dbConfig::TABLE_LOG_ATT_TIME]);
            array_push($data, $row);
        }

        usort($data, 'shortUserFeed');

        return $data;
    }

    public function getNumOfActivity() {
        $result = $this->db->get(dbConfig::TABLE_LOG)->num_rows();
        return $result;
    }

    public function getEmailTypeName($id) {
        if ($id == '1') {
            return 'Client';
        } elseif ($id == '2') {
            return 'Company';
        } elseif ($id == '3') {
            return 'Project';
        }
    }

}
