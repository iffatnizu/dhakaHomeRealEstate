<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_Company extends CI_Model {

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

    public function addCompany($userId) {
        $data[dbConfig::TABLE_COMPANY_ATT_NAME] = $this->input->post('company');
        $data[dbConfig::TABLE_COMPANY_ATT_USER_ID] = $userId;
        $data[dbConfig::TABLE_COMPANY_ATT_ADDRESS] = $this->input->post('address');
        $data[dbConfig::TABLE_COMPANY_ATT_COUNTRY] = $this->input->post('countryId');
        $data[dbConfig::TABLE_COMPANY_ATT_STATE] = $this->input->post('state');
        $data[dbConfig::TABLE_COMPANY_ATT_CITY] = $this->input->post('city');
        $data[dbConfig::TABLE_COMPANY_ATT_ZIP] = $this->input->post('zip');
        $data[dbConfig::TABLE_COMPANY_ATT_CONTACT_NUMBER] = $this->input->post('cell-number');
        $data[dbConfig::TABLE_COMPANY_ATT_EMAIL] = $this->input->post('email');
        $data[dbConfig::TABLE_COMPANY_ATT_CONTACT_PERSON_NAME] = $this->input->post('contact-person');
        $data[dbConfig::TABLE_COMPANY_ATT_CONTACT_PERSON_NUMBER] = $this->input->post('contact-person-number');
        $data[dbConfig::TABLE_COMPANY_ATT_ADDED_TIME] = time();

        $i = $this->db->insert(dbConfig::TABLE_COMPANY, $data);

        $lastId = $this->db->insert_id();

        if ($i) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> added a company <a href="' . base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_VIEW_COMPANY . $lastId . '">' . $this->input->post('company') . '</a> ';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            return '1';
        }
    }

    public function updateCompany($id, $userId) {
        $data[dbConfig::TABLE_COMPANY_ATT_NAME] = $this->input->post('company');
        $data[dbConfig::TABLE_COMPANY_ATT_ADDRESS] = $this->input->post('address');
        $data[dbConfig::TABLE_COMPANY_ATT_COUNTRY] = $this->input->post('countryId');
        $data[dbConfig::TABLE_COMPANY_ATT_STATE] = $this->input->post('state');
        $data[dbConfig::TABLE_COMPANY_ATT_CITY] = $this->input->post('city');
        $data[dbConfig::TABLE_COMPANY_ATT_ZIP] = $this->input->post('zip');
        $data[dbConfig::TABLE_COMPANY_ATT_CONTACT_NUMBER] = $this->input->post('cell-number');
        $data[dbConfig::TABLE_COMPANY_ATT_CONTACT_PERSON_NAME] = $this->input->post('contact-person');
        $data[dbConfig::TABLE_COMPANY_ATT_CONTACT_PERSON_NUMBER] = $this->input->post('contact-person-number');

        $this->db->set($data);
        $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $id);
        $this->db->where(dbConfig::TABLE_COMPANY_ATT_IS_DELETE, "0");

        $i = $this->db->update(dbConfig::TABLE_COMPANY);

        if ($i) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> edited a company <a href="' . base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_VIEW_COMPANY . $id . '">' . $this->input->post('company') . '</a> ';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            return '1';
        }
    }

    public function allCompany() {

        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $aColumns = array('companyId', 'companyName', 'companyAddress', 'companyContactNumber', 'companyEmail');

        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = DBConfig::TABLE_COMPANY_ATT_ID;

        /* DB table to use */
        $sTable = DBConfig::TABLE_COMPANY;

        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
                    intval($_GET['iDisplayLength']);
        }


        /*
         * Ordering
         */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " .
                            ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }


        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mysql_real_escape_string($_GET['sSearch']) . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }

        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mysql_real_escape_string($_GET['sSearch_' . $i]) . "%' ";
            }
        }


        /*
         * SQL queries
         * Get data to display
         */
        $sQuery = "
		SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $aColumns)) . "`
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
		";
        //echo $sQuery;

        $rResult = mysql_query($sQuery);


        /* Data set length after filtering */
        $sQuery = "
		SELECT FOUND_ROWS()
	";
        $rResultFilterTotal = mysql_query($sQuery) or die(mysql_error());
        $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
        $iFilteredTotal = $aResultFilterTotal[0];

        /* Total data set length */
        $sQuery = "
		SELECT COUNT(`" . $sIndexColumn . "`)
		FROM   $sTable
	";
        $rResultTotal = mysql_query($sQuery) or die(mysql_error());
        $aResultTotal = mysql_fetch_array($rResultTotal);
        $iTotal = $aResultTotal[0];


        /*
         * Output
         */
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        while ($aRow = mysql_fetch_array($rResult)) {
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == "version") {
                    /* Special output formatting for 'version' column */
                    $row[] = ($aRow[$aColumns[$i]] == "0") ? '-' : $aRow[$aColumns[$i]];
                } else if ($aColumns[$i] != ' ') {
                    /* General output */
                    $row[] = $aRow[$aColumns[$i]];
                }
            }
            $row[5] = '<a href="' . base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_VIEW_COMPANY . $row[0] . '" class="btn btn-info">View</a>';


            $output['aaData'][] = $row;
        }

        //debugPrint($output);

        return json_encode($output);
    }

    public function getCompanyDetails($id) {
        $sql = 'SELECT ' . dbConfig::TABLE_COMPANY . '.*,' . dbConfig::TABLE_COUNTRY . '.' . dbConfig::TABLE_COUNTRY_ATT_COUNTRY_NAME . ',' . dbConfig::TABLE_STATES . '.' . dbConfig::TABLE_STATES_ATT_STATE_NAME . ',' . dbConfig::TABLE_CITY . '.' . dbConfig::TABLE_CITY_ATT_CITY_NAME . '
                FROM ' . dbConfig::TABLE_COMPANY . ' 
                LEFT JOIN ' . dbConfig::TABLE_COUNTRY . ' ON ' . dbConfig::TABLE_COUNTRY . '.' . dbConfig::TABLE_COUNTRY_ATT_COUNTRY_ID . ' = ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_COUNTRY . ' 
                LEFT JOIN ' . dbConfig::TABLE_STATES . ' ON ' . dbConfig::TABLE_STATES . '.' . dbConfig::TABLE_STATES_ATT_STATE_SHORT_NAME . ' = ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_STATE . ' 
                LEFT JOIN ' . dbConfig::TABLE_CITY . ' ON ' . dbConfig::TABLE_CITY . '.' . dbConfig::TABLE_CITY_ATT_CITY_ID . ' = ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_CITY . ' 
                WHERE ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_ID . ' = "' . $id . '" AND ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_IS_DELETE . ' = "0"   
               ';
        $result = $this->db->query($sql)->row_array();

        return $result;
    }

    public function getCompanyList($startPage = '', $perPage = '') {
        $sql = 'SELECT ' . dbConfig::TABLE_COMPANY . '.*,' . dbConfig::TABLE_COUNTRY . '.' . dbConfig::TABLE_COUNTRY_ATT_COUNTRY_NAME . ',' . dbConfig::TABLE_STATES . '.' . dbConfig::TABLE_STATES_ATT_STATE_NAME . ',' . dbConfig::TABLE_CITY . '.' . dbConfig::TABLE_CITY_ATT_CITY_NAME . '
                FROM ' . dbConfig::TABLE_COMPANY . ' 
                LEFT JOIN ' . dbConfig::TABLE_COUNTRY . ' ON ' . dbConfig::TABLE_COUNTRY . '.' . dbConfig::TABLE_COUNTRY_ATT_COUNTRY_ID . ' = ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_COUNTRY . ' 
                LEFT JOIN ' . dbConfig::TABLE_STATES . ' ON ' . dbConfig::TABLE_STATES . '.' . dbConfig::TABLE_STATES_ATT_STATE_SHORT_NAME . ' = ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_STATE . ' 
                LEFT JOIN ' . dbConfig::TABLE_CITY . ' ON ' . dbConfig::TABLE_CITY . '.' . dbConfig::TABLE_CITY_ATT_CITY_ID . ' = ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_CITY . ' 
                WHERE ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_IS_DELETE . ' = "0"
                ORDER BY  ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_ID . ' DESC
                LIMIT ' . $startPage . ',' . $perPage . '   
               ';
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    public function deleteCompany($id, $userId) {

        $this->db->where(dbConfig::TABLE_PROJECT_ATT_COMPANY_ID, $id);
        $n = $this->db->get(dbConfig::TABLE_PROJECT)->num_rows();

        if (empty($n)) {

            $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $id);
            $r = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

            $data[dbConfig::TABLE_COMPANY_ATT_IS_DELETE] = "1";
            $this->db->set($data);
            $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $id);
            $d = $this->db->update(dbConfig::TABLE_COMPANY);

            if ($d) {

                $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> deleted a company <b>' . $r[dbConfig::TABLE_COMPANY_ATT_NAME] . '</b>';
                $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
                $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
                $this->db->insert(dbConfig::TABLE_LOG, $data1);

                return '1';
            }
        } else {
            return '0';
        }
    }

    public function getNumOfCompanyList() {
        return $this->db->get(dbConfig::TABLE_COMPANY)->num_rows();
    }

    public function getCompanyProject($companyId) {
        $sql = 'SELECT ' . dbConfig::TABLE_PROJECT . '.*,' . dbConfig::TABLE_COUNTRY . '.' . dbConfig::TABLE_COUNTRY_ATT_COUNTRY_NAME . ',' . dbConfig::TABLE_STATES . '.' . dbConfig::TABLE_STATES_ATT_STATE_NAME . ',' . dbConfig::TABLE_CITY . '.' . dbConfig::TABLE_CITY_ATT_CITY_NAME . ',' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_NAME . ',' . dbConfig::TABLE_CLIENT . '.' . dbConfig::TABLE_CLIENT_ATT_FIRST_NAME . ',' . dbConfig::TABLE_CLIENT . '.' . dbConfig::TABLE_CLIENT_ATT_LAST_NAME . ',' . dbConfig::TABLE_PROJECT_TYPE . '.' . dbConfig::TABLE_PROJECT_TYPE_ATT_NAME . '
                FROM ' . dbConfig::TABLE_PROJECT . ' 
                LEFT JOIN ' . dbConfig::TABLE_COUNTRY . ' ON ' . dbConfig::TABLE_COUNTRY . '.' . dbConfig::TABLE_COUNTRY_ATT_COUNTRY_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_COUNTRY . ' 
                LEFT JOIN ' . dbConfig::TABLE_STATES . ' ON ' . dbConfig::TABLE_STATES . '.' . dbConfig::TABLE_STATES_ATT_STATE_SHORT_NAME . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_STATE . ' 
                LEFT JOIN ' . dbConfig::TABLE_CITY . ' ON ' . dbConfig::TABLE_CITY . '.' . dbConfig::TABLE_CITY_ATT_CITY_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_CITY . ' 
                LEFT JOIN ' . dbConfig::TABLE_COMPANY . ' ON ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_COMPANY_ID . ' 
                LEFT JOIN ' . dbConfig::TABLE_CLIENT . ' ON ' . dbConfig::TABLE_CLIENT . '.' . dbConfig::TABLE_CLIENT_ATT_ID . ' 
                LEFT JOIN ' . dbConfig::TABLE_PROJECT_TYPE . ' ON ' . dbConfig::TABLE_PROJECT_TYPE . '.' . dbConfig::TABLE_PROJECT_TYPE_ATT_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_TYPE_ID . ' 
                WHERE  ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_COMPANY_ID . ' = "' . $companyId . '" AND ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_IS_DELETE . ' = "0"
                ORDER BY  ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_ID . ' DESC
                
               ';
        //echo $sql;
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    public function companyEmailAddressCheck($email = "") {
        $this->db->where(DBConfig::TABLE_COMPANY_ATT_EMAIL, $email);
        $query = $this->db->get(DBConfig::TABLE_COMPANY);

        if ($query->num_rows() == 1) {
            return '1';
        } else {
            return '0';
        }
    }

    public function sendMail($userId) {
        //debugPrint($_POST);

        foreach ($_POST['id'] as $id) {

            $this->db->select(dbConfig::TABLE_COMPANY_ATT_EMAIL);
            $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $id);

            $r = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

            if (!empty($r)) {

                $this->email->from('admin@dhakahome.com', 'Dhaka Home Administration');
                $this->email->to($r[dbConfig::TABLE_COMPANY_ATT_EMAIL]);
                $this->email->subject($this->input->post('subject'));
                $this->email->message($this->input->post('body'));

                $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_RECEIVE_ID] = $id;
                $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_USER_ID] = $userId;
                $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_EMAIL_TYPE] = '2';
                $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_TIME] = time();

                $this->db->insert(dbConfig::TABLE_EMAIL_STATUS, $data1);

                $this->email->send();

                //echo $this->email->print_debugger();
            }
        }

        return '1';
    }

    public function sendMailSingleCompany($userId) {
        $this->db->select(dbConfig::TABLE_COMPANY_ATT_EMAIL);
        $this->db->select(dbConfig::TABLE_COMPANY_ATT_ID);
        $this->db->where(dbConfig::TABLE_COMPANY_ATT_EMAIL, $_POST['email']);

        $r = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

        if (!empty($r)) {

            $this->email->from('admin@dhakahome.com', 'Dhaka Home Administration');
            $this->email->to($r[dbConfig::TABLE_COMPANY_ATT_EMAIL]);
            $this->email->subject($this->input->post('subject'));
            $this->email->message($this->input->post('body'));

            $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_RECEIVE_ID] = $r[dbConfig::TABLE_COMPANY_ATT_ID];
            $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_USER_ID] = $userId;
            $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_EMAIL_TYPE] = '2';
            $data1[dbConfig::TABLE_EMAIL_STATUS_ATT_TIME] = time();

            $this->db->insert(dbConfig::TABLE_EMAIL_STATUS, $data1);

            $this->email->send();

            //echo $this->email->print_debugger();

            return '1';
        }
    }

}
