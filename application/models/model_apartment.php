<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_Apartment extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('email');

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';

        $this->email->initialize($config);
    }

    public function getApartmentSize() {
        return $this->db->get(dbConfig::TABLE_APARTMENT_SIZE)->result_array();
    }

    public function getApartmentFloor() {
        return $this->db->get(dbConfig::TABLE_APARTMENT_FLOOR)->result_array();
    }

    public function getApartmentFacing() {
        return $this->db->get(dbConfig::TABLE_APARTMENT_FACING)->result_array();
    }

    public function getApartmentCondition() {
        return $this->db->get(dbConfig::TABLE_APARTMENT_CONDITION)->result_array();
    }

    public function getApartmentBed() {
        return $this->db->get(dbConfig::TABLE_APARTMENT_BED)->result_array();
    }

    public function getApartmentBath() {
        return $this->db->get(dbConfig::TABLE_APARTMENT_BATH)->result_array();
    }

    public function getApartmentStatus() {
        return $this->db->get(dbConfig::TABLE_APARTMENT_STATUS)->result_array();
    }

    public function addApartment($userId) {
        $sellerId = 0;
        $markAsCompanay = 0;

        if (isset($_POST['markAsCompany'])) {
            $sellerId = $this->session->userdata('_setCompanyId');
            $markAsCompanay = 1;
        } else {
            $sellerId = $this->input->post('apartment-seller');
        }
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_NAME] = $this->input->post('apartment-name');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ADDRESS] = $this->input->post('apartment-address');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SIZE] = $this->input->post('apartment-size');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_FLOOR] = $this->input->post('apartment-floor');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_FACING] = $this->input->post('apartment-facing');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_BED] = $this->input->post('apartment-bed');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_BATH] = $this->input->post('apartment-bath');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_PROJECT_ID] = $this->input->post('apartment-project');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SELLER_ID] = $sellerId;
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ASKING_PRICE] = $this->input->post('apartment-asking-price');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ASKING_MIN_PRICE] = $this->input->post('apartment-asking-min-price');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_CURRENCY] = $this->input->post('apartment-currency');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_CONDITION] = $this->input->post('apartment-condition');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_STATUS] = $this->input->post('apartment-status');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_COMMENT] = $this->input->post('apartment-comment');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_MARK_AS_COMPANY] = $markAsCompanay;

        $i = $this->db->insert(dbConfig::TABLE_APARTMENT, $data);

        $lastId = $this->db->insert_id();

        if ($i) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> added an apartment <a href="' . base_url() . siteConfig::CONTROLLER_APARTMENT . siteConfig::METHOD_APARTMENT_VIEW_APARTMENT . encode($lastId) . '">' . $this->input->post('apartment-name') . '</a> ';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            return '1';
        }
    }

    public function getNumOfApartmentList() {
        $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_IS_DELETE, '0');
        return $this->db->get(dbConfig::TABLE_APARTMENT)->num_rows();
    }

    public function getApartmentList($startPage = '', $perPage = '') {
        $sql = 'SELECT ' . dbConfig::TABLE_APARTMENT . '.*,' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME . ',' . dbConfig::TABLE_APARTMENT_SIZE . '.' . dbConfig::TABLE_APARTMENT_SIZE_ATT_SIZE_VALUE . ',' . dbConfig::TABLE_APARTMENT_FLOOR . '.' . dbConfig::TABLE_APARTMENT_FLOOR_ATT_FLOOR_NAME . ',' . dbConfig::TABLE_APARTMENT_FACING . '.' . dbConfig::TABLE_APARTMENT_FACING_ATT_FACE_NAME . ',' . dbConfig::TABLE_APARTMENT_BED . '.' . dbConfig::TABLE_APARTMENT_BED_ATT_BED_VALUE . ',' . dbConfig::TABLE_APARTMENT_BATH . '.' . dbConfig::TABLE_APARTMENT_BATH_ATT_BATH_VALUE . ',' . dbConfig::TABLE_CURRENCY . '.' . dbConfig::TABLE_CURRENCY_ATT_CURRENCY_CODE . ',' . dbConfig::TABLE_APARTMENT_STATUS . '.' . dbConfig::TABLE_APARTMENT_STATUS_ATT_STATUS_NAME . ',' . dbConfig::TABLE_APARTMENT_CONDITION . '.' . dbConfig::TABLE_APARTMENT_CONDITION_ATT_CONDITION_NAME . '
                FROM ' . dbConfig::TABLE_APARTMENT . ' 
                LEFT JOIN ' . dbConfig::TABLE_PROJECT . ' ON ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_PROJECT_ID . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_SIZE . ' ON ' . dbConfig::TABLE_APARTMENT_SIZE . '.' . dbConfig::TABLE_APARTMENT_SIZE_ATT_SIZE_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SIZE . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_FLOOR . ' ON ' . dbConfig::TABLE_APARTMENT_FLOOR . '.' . dbConfig::TABLE_APARTMENT_FLOOR_ATT_FLOOR_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_FLOOR . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_FACING . ' ON ' . dbConfig::TABLE_APARTMENT_FACING . '.' . dbConfig::TABLE_APARTMENT_FACING_ATT_FACE_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_FACING . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_BED . ' ON ' . dbConfig::TABLE_APARTMENT_BED . '.' . dbConfig::TABLE_APARTMENT_BED_ATT_BED_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_BED . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_BATH . ' ON ' . dbConfig::TABLE_APARTMENT_BATH . '.' . dbConfig::TABLE_APARTMENT_BATH_ATT_BATH_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_BATH . ' 
                LEFT JOIN ' . dbConfig::TABLE_CURRENCY . ' ON ' . dbConfig::TABLE_CURRENCY . '.' . dbConfig::TABLE_CURRENCY_ATT_CURRENCY_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_CURRENCY . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_STATUS . ' ON ' . dbConfig::TABLE_APARTMENT_STATUS . '.' . dbConfig::TABLE_APARTMENT_STATUS_ATT_STATUS_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_STATUS . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_CONDITION . ' ON ' . dbConfig::TABLE_APARTMENT_CONDITION . '.' . dbConfig::TABLE_APARTMENT_CONDITION_ATT_CONDITION_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_CONDITION . ' 
                WHERE  ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_IS_DELETE . ' = "0"
                ORDER BY  ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID . ' DESC
                LIMIT ' . $startPage . ',' . $perPage . '
               ';
        //echo $sql;
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    public function getApartmentDetails($id) {
        $sql = 'SELECT ' . dbConfig::TABLE_APARTMENT . '.*,' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME . ',' . dbConfig::TABLE_APARTMENT_SIZE . '.' . dbConfig::TABLE_APARTMENT_SIZE_ATT_SIZE_VALUE . ',' . dbConfig::TABLE_APARTMENT_FLOOR . '.' . dbConfig::TABLE_APARTMENT_FLOOR_ATT_FLOOR_NAME . ',' . dbConfig::TABLE_APARTMENT_FACING . '.' . dbConfig::TABLE_APARTMENT_FACING_ATT_FACE_NAME . ',' . dbConfig::TABLE_APARTMENT_BED . '.' . dbConfig::TABLE_APARTMENT_BED_ATT_BED_VALUE . ',' . dbConfig::TABLE_APARTMENT_BATH . '.' . dbConfig::TABLE_APARTMENT_BATH_ATT_BATH_VALUE . ',' . dbConfig::TABLE_CURRENCY . '.' . dbConfig::TABLE_CURRENCY_ATT_CURRENCY_CODE . ',' . dbConfig::TABLE_APARTMENT_STATUS . '.' . dbConfig::TABLE_APARTMENT_STATUS_ATT_STATUS_NAME . ',' . dbConfig::TABLE_APARTMENT_CONDITION . '.' . dbConfig::TABLE_APARTMENT_CONDITION_ATT_CONDITION_NAME . '
                FROM ' . dbConfig::TABLE_APARTMENT . ' 
                LEFT JOIN ' . dbConfig::TABLE_PROJECT . ' ON ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_PROJECT_ID . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_SIZE . ' ON ' . dbConfig::TABLE_APARTMENT_SIZE . '.' . dbConfig::TABLE_APARTMENT_SIZE_ATT_SIZE_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SIZE . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_FLOOR . ' ON ' . dbConfig::TABLE_APARTMENT_FLOOR . '.' . dbConfig::TABLE_APARTMENT_FLOOR_ATT_FLOOR_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_FLOOR . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_FACING . ' ON ' . dbConfig::TABLE_APARTMENT_FACING . '.' . dbConfig::TABLE_APARTMENT_FACING_ATT_FACE_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_FACING . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_BED . ' ON ' . dbConfig::TABLE_APARTMENT_BED . '.' . dbConfig::TABLE_APARTMENT_BED_ATT_BED_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_BED . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_BATH . ' ON ' . dbConfig::TABLE_APARTMENT_BATH . '.' . dbConfig::TABLE_APARTMENT_BATH_ATT_BATH_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_BATH . ' 
                LEFT JOIN ' . dbConfig::TABLE_CURRENCY . ' ON ' . dbConfig::TABLE_CURRENCY . '.' . dbConfig::TABLE_CURRENCY_ATT_CURRENCY_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_CURRENCY . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_STATUS . ' ON ' . dbConfig::TABLE_APARTMENT_STATUS . '.' . dbConfig::TABLE_APARTMENT_STATUS_ATT_STATUS_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_STATUS . ' 
                LEFT JOIN ' . dbConfig::TABLE_APARTMENT_CONDITION . ' ON ' . dbConfig::TABLE_APARTMENT_CONDITION . '.' . dbConfig::TABLE_APARTMENT_CONDITION_ATT_CONDITION_ID . ' = ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_CONDITION . ' 
                WHERE  ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_IS_DELETE . ' = "0" 
                AND  ' . dbConfig::TABLE_APARTMENT . '.' . dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID . ' = "' . $id . '"
               ';
        //echo $sql;
        $result = $this->db->query($sql)->row_array();
        $result['seller'] = $this->getApartmentSeller($id);

        return $result;
    }

    public function getApartmentSeller($apartmentId) {
        $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID, $apartmentId);
        $r = $this->db->get(dbConfig::TABLE_APARTMENT)->row_array();

        if ($r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_MARK_AS_COMPANY] == '1') {
            $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SELLER_ID]);
            $r2 = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

            return $r2[dbConfig::TABLE_COMPANY_ATT_NAME];
        } elseif ($r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_MARK_AS_COMPANY] == '0') {
            $this->db->where(dbConfig::TABLE_CLIENT_ATT_ID, $r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SELLER_ID]);
            $r2 = $this->db->get(dbConfig::TABLE_CLIENT)->row_array();

            return $r2[dbConfig::TABLE_CLIENT_ATT_FIRST_NAME] . ' ' . $r2[dbConfig::TABLE_CLIENT_ATT_LAST_NAME];
        }
    }

    public function deleteApartment($apartmentId, $userId) {
        $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID, $apartmentId);
        $r = $this->db->get(dbConfig::TABLE_APARTMENT)->row_array();

        if ($r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_BUYER_ID] == '0') {

            $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_IS_DELETE] = '1';
            $this->db->set($data);
            $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID, $apartmentId);
            $d = $this->db->update(dbConfig::TABLE_APARTMENT);

            if ($d) {

                $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> deleted an apartment <b>' . $r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_NAME] . '</b>';
                $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
                $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
                $this->db->insert(dbConfig::TABLE_LOG, $data1);

                return '1';
            }
        } else {
            return '0';
        }
    }

    public function getProjectByCompany($apartmentId) {
        $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID, $apartmentId);
        $r = $this->db->get(dbConfig::TABLE_APARTMENT)->row_array();

        $this->db->where(dbConfig::TABLE_PROJECT_ATT_ID, $r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_PROJECT_ID]);
        $r2 = $this->db->get(dbConfig::TABLE_PROJECT)->row_array();

        if (!empty($r2)) {
            $this->db->where(dbConfig::TABLE_PROJECT_ATT_COMPANY_ID, $r2[dbConfig::TABLE_PROJECT_ATT_COMPANY_ID]);
            $r3 = $this->db->get(dbConfig::TABLE_PROJECT)->result_array();

            return $r3;
        }
    }

    public function updateApartment($apartmentId, $userId, $seller) {
        $sellerId = 0;
        $markAsCompanay = 0;

        if (isset($_POST['markAsCompany'])) {
            $sellerId = $seller;
            $markAsCompanay = 1;
        } else {
            $sellerId = $this->input->post('apartment-seller');
        }
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_NAME] = $this->input->post('apartment-name');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ADDRESS] = $this->input->post('apartment-address');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SIZE] = $this->input->post('apartment-size');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_FLOOR] = $this->input->post('apartment-floor');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_FACING] = $this->input->post('apartment-facing');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_BED] = $this->input->post('apartment-bed');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_BATH] = $this->input->post('apartment-bath');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_PROJECT_ID] = $this->input->post('apartment-project');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SELLER_ID] = $sellerId;
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ASKING_PRICE] = $this->input->post('apartment-asking-price');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ASKING_MIN_PRICE] = $this->input->post('apartment-asking-min-price');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_CURRENCY] = $this->input->post('apartment-currency');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_CONDITION] = $this->input->post('apartment-condition');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_STATUS] = $this->input->post('apartment-status');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_COMMENT] = $this->input->post('apartment-comment');
        $data[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_MARK_AS_COMPANY] = $markAsCompanay;

        $this->db->set($data);
        $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID, $apartmentId);
        $i = $this->db->update(dbConfig::TABLE_APARTMENT);

        if ($i) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> edited an apartment <a href="' . base_url() . siteConfig::CONTROLLER_APARTMENT . siteConfig::METHOD_APARTMENT_VIEW_APARTMENT . encode($apartmentId) . '">' . $this->input->post('apartment-name') . '</a> ';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            return '1';
        }
    }

    public function sentMailToApartment($usrId) {
        $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID, decode($_POST['id']));
        $r = $this->db->get(dbConfig::TABLE_APARTMENT)->row_array();

        $this->db->where(dbConfig::TABLE_PROJECT_ATT_ID, $r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_PROJECT_ID]);
        $r2 = $this->db->get(dbConfig::TABLE_PROJECT)->row_array();

        $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $r2[dbConfig::TABLE_PROJECT_ATT_COMPANY_ID]);
        $r3 = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

        if (!empty($r3)) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $usrId . '">' . getUserNameById($usrId) . '</a> send mail to <a href="' . base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_VIEW_COMPANY . $r3[dbConfig::TABLE_COMPANY_ATT_ID] . '">' . $r3[dbConfig::TABLE_COMPANY_ATT_NAME] . '</a> about the apartment <a href="' . base_url() . siteConfig::CONTROLLER_APARTMENT . siteConfig::METHOD_APARTMENT_VIEW_APARTMENT . encode($r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID]) . '">' . $r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_NAME] . '</a>';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            $this->email->from('admin@dhakahome.com', 'Dhaka Home Administration');
            $this->email->to($r3[dbConfig::TABLE_COMPANY_ATT_EMAIL]);
            $this->email->subject($this->input->post('subject'));
            $this->email->message($this->input->post('body'));

            $this->email->send();

            //echo $this->email->print_debugger();

            return '1';
        }
    }

    public function sentMailToMultipleApartment($usrId) {

        foreach ($_POST['id'] as $id) {
            $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID, decode($id));
            $r = $this->db->get(dbConfig::TABLE_APARTMENT)->row_array();

            $this->db->where(dbConfig::TABLE_PROJECT_ATT_ID, $r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_PROJECT_ID]);
            $r2 = $this->db->get(dbConfig::TABLE_PROJECT)->row_array();

            $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $r2[dbConfig::TABLE_PROJECT_ATT_COMPANY_ID]);
            $r3 = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

            if (!empty($r3)) {

                $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $usrId . '">' . getUserNameById($usrId) . '</a> send mail to <a href="' . base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_VIEW_COMPANY . $r3[dbConfig::TABLE_COMPANY_ATT_ID] . '">' . $r3[dbConfig::TABLE_COMPANY_ATT_NAME] . '</a> about the apartment <a href="' . base_url() . siteConfig::CONTROLLER_APARTMENT . siteConfig::METHOD_APARTMENT_VIEW_APARTMENT . encode($r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID]) . '">' . $r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_NAME] . '</a>';
                $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
                $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
                $this->db->insert(dbConfig::TABLE_LOG, $data1);

                $this->email->from('admin@dhakahome.com', 'Dhaka Home Administration');
                $this->email->to($r3[dbConfig::TABLE_COMPANY_ATT_EMAIL]);
                $this->email->subject($this->input->post('subject'));
                $this->email->message($this->input->post('body'));
                $this->email->send();





                //echo $this->email->print_debugger();
            }
        }
        return '1';
    }

    public function apartmentNameCheck($name) {
        $this->db->where(DBConfig::TABLE_APARTMENT_ATT_APARTMENT_NAME, $name);
        $query = $this->db->get(DBConfig::TABLE_APARTMENT);

        if ($query->num_rows() == 1) {
            return '1';
        } else {
            return '0';
        }
    }

    public function getSellHistory($id) {
        $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID, $id);
        $r = $this->db->get(dbConfig::TABLE_SOLD_APARTMENT)->result_array();

        $data = array();

        foreach ($r as $row) {
            $row['buyer'] = getBuyerName($row[dbConfig::TABLE_SOLD_APARTMENT_ATT_COMPANY_ID]);
            $row['seller'] = getSellerName($row[dbConfig::TABLE_SOLD_APARTMENT_ATT_SELLER_ID]);
            $row['project'] = getProjectName($row[dbConfig::TABLE_SOLD_APARTMENT_ATT_OLD_PROJECT_ID]);
            array_push($data, $row);
        }

        return $data;
    }

    public function sellApartment($id, $userId) {
        $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $this->input->post('company'));
        $r = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

        $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID, $id);
        $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_IS_DELETE, '0');
        $r2 = $this->db->get(dbConfig::TABLE_APARTMENT)->row_array();

        if (!empty($r2)) {

            //$data1[dbConfig::TABLE_PLOT_ATT_PLOT_BUYER_ID]= $this->input->post('company');
            $data2[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SELLER_ID] = $this->input->post('company');
            $data2[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_PROJECT_ID] = $this->input->post('project');
            $data2[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_STATUS] = '1';
            $this->db->set($data2);
            $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID, $id);
            $this->db->update(dbConfig::TABLE_APARTMENT);

            $data[dbConfig::TABLE_SOLD_APARTMENT_ATT_APARTMENT_ID] = $id;
            $data[dbConfig::TABLE_SOLD_APARTMENT_ATT_COMPANY_ID] = $this->input->post('company');
            $data[dbConfig::TABLE_SOLD_APARTMENT_ATT_CLIENT_ID] = $this->input->post('client');
            $data[dbConfig::TABLE_SOLD_APARTMENT_ATT_PROJECT_ID] = $this->input->post('project');
            $data[dbConfig::TABLE_SOLD_APARTMENT_ATT_COMMENT] = $this->input->post('comment');
            $data[dbConfig::TABLE_SOLD_APARTMENT_ATT_SELLER_ID] = $r2[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SELLER_ID];
            $data[dbConfig::TABLE_SOLD_APARTMENT_ATT_OLD_PROJECT_ID] = $r2[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_PROJECT_ID];
            $data[dbConfig::TABLE_SOLD_APARTMENT_ATT_TIME] = time();

            if (isset($_POST['markAsInstallmentSales'])) {
                $data[dbConfig::TABLE_SOLD_APARTMENT_ATT_SUBTOTAL] = $this->input->post('sub-total');
                $data[dbConfig::TABLE_SOLD_APARTMENT_ATT_DOWN_PAYMENT] = $this->input->post('down-payment');
                $data[dbConfig::TABLE_SOLD_APARTMENT_ATT_INSTALLMENT_PERIOD] = $this->input->post('installment-period');
                $data[dbConfig::TABLE_SOLD_APARTMENT_ATT_MONTH_PAYMENT] = $this->input->post('monthly-payment');
                $data[dbConfig::TABLE_SOLD_APARTMENT_ATT_IS_INSTALLMENT_SALE] = '1';
            }

            $i = $this->db->insert(dbConfig::TABLE_SOLD_APARTMENT, $data);

            if ($i) {
                $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> sold an apartment <a href="' . base_url() . siteConfig::CONTROLLER_APARTMENT . siteConfig::METHOD_APARTMENT_VIEW_APARTMENT . encode($r2[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID]) . '">' . $r2[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_NAME] . '</a>(' . getProjectName($r2[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_PROJECT_ID]) . ',' . getCompanyName($r2[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_SELLER_ID]) . ') to <a href="' . base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_VIEW_COMPANY . $r[dbConfig::TABLE_COMPANY_ATT_ID] . '">' . $r[dbConfig::TABLE_COMPANY_ATT_NAME] . '</a> ';
                $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
                $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
                $this->db->insert(dbConfig::TABLE_LOG, $data1);
                return '1';
            }
        }
    }

    public function getApartmentName($id) {
        $this->db->where(dbConfig::TABLE_APARTMENT_ATT_APARTMENT_ID, $id);
        $r = $this->db->get(dbConfig::TABLE_APARTMENT)->row_array();

        return $r[dbConfig::TABLE_APARTMENT_ATT_APARTMENT_NAME];
    }

}
