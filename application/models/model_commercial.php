<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_Commercial extends CI_Model {

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

    public function getCommercialFloor() {
        return $this->db->get(dbConfig::TABLE_COMMERCIAL_FLOOR)->result_array();
    }

    public function getCommercialSize() {
        return $this->db->get(dbConfig::TABLE_COMMERCIAL_SIZE)->result_array();
    }

    public function getCondition() {
        return $this->db->get(dbConfig::TABLE_COMMERCIAL_CONDITION)->result_array();
    }

    public function getCommercialStatus() {
        return $this->db->get(dbConfig::TABLE_COMMERCIAL_STATUS)->result_array();
    }

    public function commercialNameCheck($name) {
        $this->db->where(DBConfig::TABLE_COMMERCIAL_ATT_NAME, $name);
        $query = $this->db->get(DBConfig::TABLE_COMMERCIAL);

        if ($query->num_rows() == 1) {
            return '1';
        } else {
            return '0';
        }
    }

    public function addCommercial($userId) {
        ///debugPrint($_POST);
        $sellerId = 0;
        $markAsCompanay = 0;
        if (isset($_POST['markAsCompany'])) {
            $sellerId = $this->session->userdata('_setCompanyId');
            $markAsCompanay = 1;
        } else {
            $sellerId = $this->input->post('commercial-seller');
        }
        $data[dbConfig::TABLE_COMMERCIAL_ATT_NAME] = $this->input->post('commercial-name');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_ADDRESS] = $this->input->post('commercial-address');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_FLOOR] = $this->input->post('commercial-floor');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_SIZE] = $this->input->post('commercial-size');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID] = $this->input->post('commercial-project');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_SELLER_ID] = $sellerId;
        $data[dbConfig::TABLE_COMMERCIAL_ATT_MARK_AS_COMPANY] = $markAsCompanay;
        $data[dbConfig::TABLE_COMMERCIAL_ATT_ASKING_PRICE] = $this->input->post('commercial-asking-price');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_MINIMUM_ASKING_PRICE] = $this->input->post('commercial-asking-min-price');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_CURRENCY] = $this->input->post('commercial-currency');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_CONDITION] = $this->input->post('commercial-condition');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_STATUS] = $this->input->post('commercial-status');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_COMMENTS] = $this->input->post('commercial-comment');

        $i = $this->db->insert(dbConfig::TABLE_COMMERCIAL, $data);

        $lastId = $this->db->insert_id();

        if ($i) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> added a commercial <a href="' . base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_VIEW_COMMMERCIAL . encode($lastId) . '">' . $this->input->post('commercial-name') . '</a> ';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            return '1';
        }
    }

    public function getNumOfCommercialList() {
        $this->db->where(dbConfig::TABLE_COMMERCIAL_ATT_IS_DELETE, '0');
        return $this->db->get(dbConfig::TABLE_COMMERCIAL)->num_rows();
    }

    public function getCommercialList($startPage = '', $perPage = '') {
        $sql = 'SELECT ' . dbConfig::TABLE_COMMERCIAL . '.*,' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME . ',' . dbConfig::TABLE_COMMERCIAL_FLOOR . '.' . dbConfig::TABLE_COMMERCIAL_FLOOR_ATT_VALUE . ',' . dbConfig::TABLE_COMMERCIAL_SIZE . '.' . dbConfig::TABLE_COMMERCIAL_SIZE_ATT_VALUE . ' as size,' . dbConfig::TABLE_CURRENCY . '.' . dbConfig::TABLE_CURRENCY_ATT_CURRENCY_CODE . ',' . dbConfig::TABLE_COMMERCIAL_STATUS . '.' . dbConfig::TABLE_COMMERCIAL_STATUS_ATT_STATUS_NAME . ',' . dbConfig::TABLE_COMMERCIAL_CONDITION . '.' . dbConfig::TABLE_COMMERCIAL_CONDITION_ATT_NAME . '
                FROM ' . dbConfig::TABLE_COMMERCIAL . ' 
                LEFT JOIN ' . dbConfig::TABLE_PROJECT . ' ON ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID . ' 
                LEFT JOIN ' . dbConfig::TABLE_COMMERCIAL_SIZE . ' ON ' . dbConfig::TABLE_COMMERCIAL_SIZE . '.' . dbConfig::TABLE_COMMERCIAL_SIZE_ATT_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_SIZE . ' 
                LEFT JOIN ' . dbConfig::TABLE_COMMERCIAL_FLOOR . ' ON ' . dbConfig::TABLE_COMMERCIAL_FLOOR . '.' . dbConfig::TABLE_COMMERCIAL_FLOOR_ATT_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_FLOOR . ' 
                LEFT JOIN ' . dbConfig::TABLE_COMMERCIAL_CONDITION . ' ON ' . dbConfig::TABLE_COMMERCIAL_CONDITION . '.' . dbConfig::TABLE_COMMERCIAL_CONDITION_ATT_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_CONDITION . ' 
                LEFT JOIN ' . dbConfig::TABLE_COMMERCIAL_STATUS . ' ON ' . dbConfig::TABLE_COMMERCIAL_STATUS . '.' . dbConfig::TABLE_COMMERCIAL_STATUS_ATT_STATUS_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_STATUS . ' 
                LEFT JOIN ' . dbConfig::TABLE_CURRENCY . ' ON ' . dbConfig::TABLE_CURRENCY . '.' . dbConfig::TABLE_CURRENCY_ATT_CURRENCY_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_CURRENCY . ' 
                WHERE  ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_IS_DELETE . ' = "0"
                ORDER BY  ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_ID . ' DESC
                LIMIT ' . $startPage . ',' . $perPage . '
               ';
        //echo $sql;
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    public function getCommercialDetails($id) {
        $sql = 'SELECT ' . dbConfig::TABLE_COMMERCIAL . '.*,' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME . ',' . dbConfig::TABLE_COMMERCIAL_FLOOR . '.' . dbConfig::TABLE_COMMERCIAL_FLOOR_ATT_VALUE . ',' . dbConfig::TABLE_COMMERCIAL_SIZE . '.' . dbConfig::TABLE_COMMERCIAL_SIZE_ATT_VALUE . '  as sizevalue,' . dbConfig::TABLE_CURRENCY . '.' . dbConfig::TABLE_CURRENCY_ATT_CURRENCY_CODE . ',' . dbConfig::TABLE_COMMERCIAL_STATUS . '.' . dbConfig::TABLE_COMMERCIAL_STATUS_ATT_STATUS_NAME . ',' . dbConfig::TABLE_COMMERCIAL_CONDITION . '.' . dbConfig::TABLE_COMMERCIAL_CONDITION_ATT_NAME . '
                FROM ' . dbConfig::TABLE_COMMERCIAL . ' 
                LEFT JOIN ' . dbConfig::TABLE_PROJECT . ' ON ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID . ' 
                LEFT JOIN ' . dbConfig::TABLE_COMMERCIAL_SIZE . ' ON ' . dbConfig::TABLE_COMMERCIAL_SIZE . '.' . dbConfig::TABLE_COMMERCIAL_SIZE_ATT_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_SIZE . ' 
                LEFT JOIN ' . dbConfig::TABLE_COMMERCIAL_FLOOR . ' ON ' . dbConfig::TABLE_COMMERCIAL_FLOOR . '.' . dbConfig::TABLE_COMMERCIAL_FLOOR_ATT_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_FLOOR . ' 
                LEFT JOIN ' . dbConfig::TABLE_COMMERCIAL_CONDITION . ' ON ' . dbConfig::TABLE_COMMERCIAL_CONDITION . '.' . dbConfig::TABLE_COMMERCIAL_CONDITION_ATT_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_CONDITION . ' 
                LEFT JOIN ' . dbConfig::TABLE_COMMERCIAL_STATUS . ' ON ' . dbConfig::TABLE_COMMERCIAL_STATUS . '.' . dbConfig::TABLE_COMMERCIAL_STATUS_ATT_STATUS_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_STATUS . ' 
                LEFT JOIN ' . dbConfig::TABLE_CURRENCY . ' ON ' . dbConfig::TABLE_CURRENCY . '.' . dbConfig::TABLE_CURRENCY_ATT_CURRENCY_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_CURRENCY . ' 
                WHERE  ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_IS_DELETE . ' = "0"
                AND  ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_ID . ' = "' . $id . '"
               ';
        //echo $sql;
        $result = $this->db->query($sql)->row_array();
        $result['seller'] = $this->getCommercialSeller($id);

        return $result;
    }

    public function getCommercialSeller($id) {
        $this->db->where(dbConfig::TABLE_COMMERCIAL_ATT_ID, $id);
        $r = $this->db->get(dbConfig::TABLE_COMMERCIAL)->row_array();

        //debugPrint($r);

        if (!empty($r)) {

            if ($r[dbConfig::TABLE_COMMERCIAL_ATT_MARK_AS_COMPANY] == '1') {
                $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $r[dbConfig::TABLE_COMMERCIAL_ATT_SELLER_ID]);
                $r2 = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

                return $r2[dbConfig::TABLE_COMPANY_ATT_NAME];
            } elseif ($r[dbConfig::TABLE_COMMERCIAL_ATT_MARK_AS_COMPANY] == '0') {
                $this->db->where(dbConfig::TABLE_CLIENT_ATT_ID, $r[dbConfig::TABLE_COMMERCIAL_ATT_SELLER_ID]);
                $r2 = $this->db->get(dbConfig::TABLE_CLIENT)->row_array();

                return $r2[dbConfig::TABLE_CLIENT_ATT_FIRST_NAME] . ' ' . $r2[dbConfig::TABLE_CLIENT_ATT_LAST_NAME];
            }
        }
    }

    public function deleteCommercial($id, $userId) {
        $this->db->where(dbConfig::TABLE_COMMERCIAL_ATT_ID, $id);
        $r = $this->db->get(dbConfig::TABLE_COMMERCIAL)->row_array();

        if ($r[dbConfig::TABLE_COMMERCIAL_ATT_BUYER_ID] == '0') {

            $data[dbConfig::TABLE_COMMERCIAL_ATT_IS_DELETE] = '1';
            $this->db->set($data);
            $this->db->where(dbConfig::TABLE_COMMERCIAL_ATT_ID, $id);
            $d = $this->db->update(dbConfig::TABLE_COMMERCIAL);

            if ($d) {

                $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> deleted a commercial <b>' . $r[dbConfig::TABLE_COMMERCIAL_ATT_NAME] . '</b>';
                $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
                $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
                $this->db->insert(dbConfig::TABLE_LOG, $data1);

                return '1';
            }
        } else {
            return '0';
        }
    }

    public function getProjectByCommercial($id) {
        $this->db->where(dbConfig::TABLE_COMMERCIAL_ATT_ID, $id);
        $r = $this->db->get(dbConfig::TABLE_COMMERCIAL)->row_array();

        $this->db->where(dbConfig::TABLE_PROJECT_ATT_ID, $r[dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID]);
        $r2 = $this->db->get(dbConfig::TABLE_PROJECT)->row_array();

        if (!empty($r2)) {
            $this->db->where(dbConfig::TABLE_PROJECT_ATT_COMPANY_ID, $r2[dbConfig::TABLE_PROJECT_ATT_COMPANY_ID]);
            $r3 = $this->db->get(dbConfig::TABLE_PROJECT)->result_array();

            return $r3;
        }
    }

    public function updateCommercial($id, $userId, $seller) {
        ///debugPrint($_POST);
        $sellerId = 0;
        $markAsCompanay = 0;
        if (isset($_POST['markAsCompany'])) {
            $sellerId = $seller;
            $markAsCompanay = 1;
        } else {
            $sellerId = $this->input->post('commercial-seller');
        }
        $data[dbConfig::TABLE_COMMERCIAL_ATT_NAME] = $this->input->post('commercial-name');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_ADDRESS] = $this->input->post('commercial-address');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_FLOOR] = $this->input->post('commercial-floor');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_SIZE] = $this->input->post('commercial-size');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID] = $this->input->post('commercial-project');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_SELLER_ID] = $sellerId;
        $data[dbConfig::TABLE_COMMERCIAL_ATT_MARK_AS_COMPANY] = $markAsCompanay;
        $data[dbConfig::TABLE_COMMERCIAL_ATT_ASKING_PRICE] = $this->input->post('commercial-asking-price');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_MINIMUM_ASKING_PRICE] = $this->input->post('commercial-asking-min-price');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_CURRENCY] = $this->input->post('commercial-currency');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_CONDITION] = $this->input->post('commercial-condition');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_STATUS] = $this->input->post('commercial-status');
        $data[dbConfig::TABLE_COMMERCIAL_ATT_COMMENTS] = $this->input->post('commercial-comment');

        $this->db->set($data);
        $this->db->where(dbConfig::TABLE_COMMERCIAL_ATT_ID, $id);
        $this->db->where(dbConfig::TABLE_COMMERCIAL_ATT_IS_DELETE, "0");
        $i = $this->db->update(dbConfig::TABLE_COMMERCIAL);

        if ($i) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> edited a commercial <a href="' . base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_VIEW_COMMMERCIAL . encode($id) . '">' . $this->input->post('commercial-name') . '</a> ';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            return '1';
        }
    }

    public function sentMailToMultipleCommercial($usrId) {
        foreach ($_POST['id'] as $id) {

            $sql = 'SELECT ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_ID . ',' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_NAME . ',' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_EMAIL . ',' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_COMPANY_ID . ',' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_ID . ',' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_NAME . ',' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID . '
                FROM ' . dbConfig::TABLE_COMMERCIAL . '
                LEFT JOIN ' . dbConfig::TABLE_PROJECT . ' ON ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID . '
                LEFT JOIN ' . dbConfig::TABLE_COMPANY . ' ON ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_COMPANY_ID . '
                WHERE ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_ID . ' = "' . decode($id) . '"
               ';
            //echo $sql;
            $r = $this->db->query($sql)->row_array();

            if (!empty($r)) {

                $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $usrId . '">' . getUserNameById($usrId) . '</a> send mail to <a href="' . base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_VIEW_COMPANY . $r[dbConfig::TABLE_COMPANY_ATT_ID] . '">' . $r[dbConfig::TABLE_COMPANY_ATT_NAME] . '</a> about the apartment <a href="' . base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_VIEW_COMMMERCIAL . encode($r[dbConfig::TABLE_COMMERCIAL_ATT_ID]) . '">' . $r[dbConfig::TABLE_COMMERCIAL_ATT_NAME] . '</a>';
                $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
                $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
                $this->db->insert(dbConfig::TABLE_LOG, $data1);

                $this->email->from('admin@dhakahome.com', 'Dhaka Home Administration');
                $this->email->to($r[dbConfig::TABLE_COMPANY_ATT_EMAIL]);
                $this->email->subject($this->input->post('subject'));
                $this->email->message($this->input->post('body'));
                $this->email->send();

                //echo $this->email->print_debugger();
            }
        }
        return '1';
    }

    public function sentMailToCommercial($usrId) {
        $sql = 'SELECT ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_ID . ',' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_NAME . ',' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_EMAIL . ',' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_COMPANY_ID . ',' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_ID . ',' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_NAME . ',' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID . '
                FROM ' . dbConfig::TABLE_COMMERCIAL . '
                LEFT JOIN ' . dbConfig::TABLE_PROJECT . ' ON ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_ID . ' = ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID . '
                LEFT JOIN ' . dbConfig::TABLE_COMPANY . ' ON ' . dbConfig::TABLE_COMPANY . '.' . dbConfig::TABLE_COMPANY_ATT_ID . ' = ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_COMPANY_ID . '
                WHERE ' . dbConfig::TABLE_COMMERCIAL . '.' . dbConfig::TABLE_COMMERCIAL_ATT_ID . ' = "' . decode($_POST['id']) . '"
               ';
        //echo $sql;
        $r = $this->db->query($sql)->row_array();

        if (!empty($r)) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $usrId . '">' . getUserNameById($usrId) . '</a> send mail to <a href="' . base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_VIEW_COMPANY . $r[dbConfig::TABLE_COMPANY_ATT_ID] . '">' . $r[dbConfig::TABLE_COMPANY_ATT_NAME] . '</a> about the apartment <a href="' . base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_VIEW_COMMMERCIAL . encode($r[dbConfig::TABLE_COMMERCIAL_ATT_ID]) . '">' . $r[dbConfig::TABLE_COMMERCIAL_ATT_NAME] . '</a>';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            $this->email->from('admin@dhakahome.com', 'Dhaka Home Administration');
            $this->email->to($r[dbConfig::TABLE_COMPANY_ATT_EMAIL]);
            $this->email->subject($this->input->post('subject'));
            $this->email->message($this->input->post('body'));
            $this->email->send();

            //echo $this->email->print_debugger();
            return '1';
        }
    }

    public function getSellHistory($id) {
        $this->db->where(dbConfig::TABLE_SOLD_COMMERCIAL_ATT_COMPANY_ID, $id);
        $r = $this->db->get(dbConfig::TABLE_SOLD_COMMERCIAL)->result_array();

        $data = array();

        foreach ($r as $row) {
            $row['buyer'] = getBuyerName($row[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_COMPANY_ID]);
            $row['seller'] = getSellerName($row[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_SELLER_ID]);
            $row['project'] = getProjectName($row[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_OLD_PROJECT_ID]);
            array_push($data, $row);
        }

        return $data;
    }

    public function sellCommercial($id, $userId) {
        $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $this->input->post('company'));
        $r = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

        $this->db->where(dbConfig::TABLE_COMMERCIAL_ATT_ID, $id);
        $this->db->where(dbConfig::TABLE_COMMERCIAL_ATT_IS_DELETE, '0');
        $r2 = $this->db->get(dbConfig::TABLE_COMMERCIAL)->row_array();

        if (!empty($r2)) {

            //$data1[dbConfig::TABLE_PLOT_ATT_PLOT_BUYER_ID]= $this->input->post('company');
            $data2[dbConfig::TABLE_COMMERCIAL_ATT_SELLER_ID] = $this->input->post('company');
            $data2[dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID] = $this->input->post('project');
            $data2[dbConfig::TABLE_COMMERCIAL_ATT_STATUS] = '1';
            $this->db->set($data2);
            $this->db->where(dbConfig::TABLE_COMMERCIAL_ATT_ID, $id);
            $this->db->update(dbConfig::TABLE_COMMERCIAL);

            $data[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_COMMERCIAL_ID] = $id;
            $data[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_COMPANY_ID] = $this->input->post('company');
            $data[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_CLIENT_ID] = $this->input->post('client');
            $data[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_PROJECT_ID] = $this->input->post('project');
            $data[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_COMMENT] = $this->input->post('comment');
            $data[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_SELLER_ID] = $r2[dbConfig::TABLE_COMMERCIAL_ATT_SELLER_ID];
            $data[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_OLD_PROJECT_ID] = $r2[dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID];
            $data[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_TIME] = time();

            if (isset($_POST['markAsInstallmentSales'])) {
                $data[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_SUBTOTAL] = $this->input->post('sub-total');
                $data[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_DOWN_PAYMENT] = $this->input->post('down-payment');
                $data[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_INSTALLMENT_PERIOD] = $this->input->post('installment-period');
                $data[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_MONTH_PAYMENT] = $this->input->post('monthly-payment');
                $data[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_IS_INSTALLMENT_SALE] = '1';
            }

            $i = $this->db->insert(dbConfig::TABLE_SOLD_COMMERCIAL, $data);

            if ($i) {
                $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> sold a commercial <a href="' . base_url() . siteConfig::CONTROLLER_COMMERCIAL . siteConfig::METHOD_COMMMERCIAL_VIEW_COMMMERCIAL . encode($r2[dbConfig::TABLE_COMMERCIAL_ATT_ID]) . '">' . $r2[dbConfig::TABLE_COMMERCIAL_ATT_NAME] . '</a>(' . getProjectName($r2[dbConfig::TABLE_COMMERCIAL_ATT_PROJECT_ID]) . ',' . getCompanyName($r2[dbConfig::TABLE_COMMERCIAL_ATT_SELLER_ID]) . ') to <a href="' . base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_VIEW_COMPANY . $r[dbConfig::TABLE_COMPANY_ATT_ID] . '">' . $r[dbConfig::TABLE_COMPANY_ATT_NAME] . '</a> ';
                $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
                $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
                $this->db->insert(dbConfig::TABLE_LOG, $data1);
                return '1';
            }
        }
    }

    public function getCommercialName($id) {
        $this->db->where(dbConfig::TABLE_COMMERCIAL_ATT_ID, $id);
        $r = $this->db->get(dbConfig::TABLE_COMMERCIAL)->row_array();

        return $r[dbConfig::TABLE_COMMERCIAL_ATT_NAME];
    }

}
