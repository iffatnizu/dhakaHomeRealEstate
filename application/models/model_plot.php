<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_Plot extends CI_Model {

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

    public function getPlotBlock() {
        return $this->db->get(dbConfig::TABLE_PLOT_BLOCK)->result_array();
    }

    public function getPlotFacing() {
        return $this->db->get(dbConfig::TABLE_PLOT_FACING)->result_array();
    }

    public function getCondition() {
        return $this->db->get(dbConfig::TABLE_PLOT_CONDITION)->result_array();
    }

    public function getPlotStatus() {
        return $this->db->get(dbConfig::TABLE_PLOT_STATUS)->result_array();
    }

    public function addPlot($userId) {

        $sellerId = 0;
        $markAsCompanay = 0;
        if (isset($_POST['markAsCompany'])) {
            $sellerId = $this->session->userdata('_setCompanyId');
            $markAsCompanay = 1;
        } else {
            $sellerId = $this->input->post('plot-seller');
        }

        $data[dbConfig::TABLE_PLOT_ATT_PLOT_NAME] = $this->input->post('plot-name');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_ADDESS] = $this->input->post('plot-address');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_BLOCK] = $this->input->post('plot-block');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_FACING] = $this->input->post('plot-facing');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_PROJECT_ID] = $this->input->post('plot-project');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_SELLER_ID] = $sellerId;
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_ASKING_PRICE] = $this->input->post('plot-asking-price');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_ASKING_MIN_PRICE] = $this->input->post('plot-asking-min-price');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_CURRENCY] = $this->input->post('plot-currency');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_CONDITION] = $this->input->post('plot-condition');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_STATUS] = $this->input->post('plot-status');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_COMMENT] = $this->input->post('plot-comment');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_MARK_AS_COMPANY] = $markAsCompanay;

        $i = $this->db->insert(dbConfig::TABLE_PLOT, $data);

        $lastId = $this->db->insert_id();

        if ($i) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> added a plot <a href="' . base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_VIEW_PLOT . encode($lastId) . '">' . $this->input->post('plot-name') . '</a> ';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            return '1';
        }
    }

    public function getNumOfPlotList() {
        $this->db->where(dbConfig::TABLE_PLOT_ATT_PLOT_IS_DELETE, '0');
        return $this->db->get(dbConfig::TABLE_PLOT)->num_rows();
    }

    public function getPlotList($startPage = '', $perPage = '') {
        $sql = 'SELECT ' . dbConfig::TABLE_PLOT . '.*,' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME . ',' . dbConfig::TABLE_PLOT_BLOCK . '.' . dbConfig::TABLE_PLOT_BLOCK_ATT_BLOCK_NAME . ',' . dbConfig::TABLE_PLOT_FACING . '.' . dbConfig::TABLE_PLOT_FACING_ATT_FACE_NAME . ',' . dbConfig::TABLE_CURRENCY . '.' . dbConfig::TABLE_CURRENCY_ATT_CURRENCY_CODE . ',' . dbConfig::TABLE_PLOT_STATUS . '.' . dbConfig::TABLE_PLOT_STATUS_ATT_STATUS_NAME . ',' . dbConfig::TABLE_PLOT_CONDITION . '.' . dbConfig::TABLE_PLOT_CONDITION_ATT_CONDITION_NAME . '
                FROM ' . dbConfig::TABLE_PLOT . ' 
                LEFT JOIN ' . dbConfig::TABLE_PROJECT . ' ON ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_ID . ' = ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_PROJECT_ID . ' 
                LEFT JOIN ' . dbConfig::TABLE_PLOT_BLOCK . ' ON ' . dbConfig::TABLE_PLOT_BLOCK . '.' . dbConfig::TABLE_PLOT_BLOCK_ATT_BLOCK_ID . ' = ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_BLOCK . ' 
                LEFT JOIN ' . dbConfig::TABLE_PLOT_FACING . ' ON ' . dbConfig::TABLE_PLOT_FACING . '.' . dbConfig::TABLE_PLOT_FACING_ATT_FACE_ID . ' = ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_FACING . ' 
                LEFT JOIN ' . dbConfig::TABLE_PLOT_CONDITION . ' ON ' . dbConfig::TABLE_PLOT_CONDITION . '.' . dbConfig::TABLE_PLOT_CONDITION_ATT_CONDITION_ID . ' = ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_CONDITION . ' 
                LEFT JOIN ' . dbConfig::TABLE_PLOT_STATUS . ' ON ' . dbConfig::TABLE_PLOT_STATUS . '.' . dbConfig::TABLE_PLOT_STATUS_ATT_STATUS_ID . ' = ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_STATUS . ' 
                LEFT JOIN ' . dbConfig::TABLE_CURRENCY . ' ON ' . dbConfig::TABLE_CURRENCY . '.' . dbConfig::TABLE_CURRENCY_ATT_CURRENCY_ID . ' = ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_CURRENCY . ' 
                WHERE  ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_IS_DELETE . ' = "0"
                ORDER BY  ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_ID . ' DESC
                LIMIT ' . $startPage . ',' . $perPage . '
               ';
        //echo $sql;
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    public function getPlotDetails($id) {
        $sql = 'SELECT ' . dbConfig::TABLE_PLOT . '.*,' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME . ',' . dbConfig::TABLE_PLOT_BLOCK . '.' . dbConfig::TABLE_PLOT_BLOCK_ATT_BLOCK_NAME . ',' . dbConfig::TABLE_PLOT_FACING . '.' . dbConfig::TABLE_PLOT_FACING_ATT_FACE_NAME . ',' . dbConfig::TABLE_CURRENCY . '.' . dbConfig::TABLE_CURRENCY_ATT_CURRENCY_CODE . ',' . dbConfig::TABLE_PLOT_STATUS . '.' . dbConfig::TABLE_PLOT_STATUS_ATT_STATUS_NAME . ',' . dbConfig::TABLE_PLOT_CONDITION . '.' . dbConfig::TABLE_PLOT_CONDITION_ATT_CONDITION_NAME . '
                FROM ' . dbConfig::TABLE_PLOT . ' 
                LEFT JOIN ' . dbConfig::TABLE_PROJECT . ' ON ' . dbConfig::TABLE_PROJECT . '.' . dbConfig::TABLE_PROJECT_ATT_ID . ' = ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_PROJECT_ID . ' 
                LEFT JOIN ' . dbConfig::TABLE_PLOT_BLOCK . ' ON ' . dbConfig::TABLE_PLOT_BLOCK . '.' . dbConfig::TABLE_PLOT_BLOCK_ATT_BLOCK_ID . ' = ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_BLOCK . ' 
                LEFT JOIN ' . dbConfig::TABLE_PLOT_FACING . ' ON ' . dbConfig::TABLE_PLOT_FACING . '.' . dbConfig::TABLE_PLOT_FACING_ATT_FACE_ID . ' = ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_FACING . ' 
                LEFT JOIN ' . dbConfig::TABLE_PLOT_CONDITION . ' ON ' . dbConfig::TABLE_PLOT_CONDITION . '.' . dbConfig::TABLE_PLOT_CONDITION_ATT_CONDITION_ID . ' = ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_CONDITION . ' 
                LEFT JOIN ' . dbConfig::TABLE_PLOT_STATUS . ' ON ' . dbConfig::TABLE_PLOT_STATUS . '.' . dbConfig::TABLE_PLOT_STATUS_ATT_STATUS_ID . ' = ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_STATUS . ' 
                LEFT JOIN ' . dbConfig::TABLE_CURRENCY . ' ON ' . dbConfig::TABLE_CURRENCY . '.' . dbConfig::TABLE_CURRENCY_ATT_CURRENCY_ID . ' = ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_CURRENCY . ' 
                WHERE  ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_IS_DELETE . ' = "0"
                AND  ' . dbConfig::TABLE_PLOT . '.' . dbConfig::TABLE_PLOT_ATT_PLOT_ID . ' = "' . $id . '"
               ';
        //echo $sql;
        $result = $this->db->query($sql)->row_array();
        $result['seller'] = $this->getPlotSeller($id);

        return $result;
    }

    public function getPlotSeller($plotId) {
        $this->db->where(dbConfig::TABLE_PLOT_ATT_PLOT_ID, $plotId);
        $r = $this->db->get(dbConfig::TABLE_PLOT)->row_array();

        if (!empty($r)) {

            if ($r[dbConfig::TABLE_PLOT_ATT_PLOT_MARK_AS_COMPANY] == '1') {
                $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $r[dbConfig::TABLE_PLOT_ATT_PLOT_SELLER_ID]);
                $r2 = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

                return $r2[dbConfig::TABLE_COMPANY_ATT_NAME];
            }
            elseif ($r[dbConfig::TABLE_PLOT_ATT_PLOT_MARK_AS_COMPANY] == '0') {
                $this->db->where(dbConfig::TABLE_CLIENT_ATT_ID, $r[dbConfig::TABLE_PLOT_ATT_PLOT_SELLER_ID]);
                $r2 = $this->db->get(dbConfig::TABLE_CLIENT)->row_array();

                return $r2[dbConfig::TABLE_CLIENT_ATT_FIRST_NAME].' '.$r2[dbConfig::TABLE_CLIENT_ATT_LAST_NAME];
            }
        }
    }

    public function deletePlot($plotId, $userId) {

        $this->db->where(dbConfig::TABLE_PLOT_ATT_PLOT_ID, $plotId);
        $r = $this->db->get(dbConfig::TABLE_PLOT)->row_array();

        if ($r[dbConfig::TABLE_PLOT_ATT_PLOT_BUYER_ID] == '0') {

            $data[dbConfig::TABLE_PLOT_ATT_PLOT_IS_DELETE] = '1';
            $this->db->set($data);
            $this->db->where(dbConfig::TABLE_PLOT_ATT_PLOT_ID, $plotId);
            $d = $this->db->update(dbConfig::TABLE_PLOT);

            if ($d) {

                $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> deleted a plot <b>' . $r[dbConfig::TABLE_PLOT_ATT_PLOT_NAME] . '</b>';
                $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
                $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
                $this->db->insert(dbConfig::TABLE_LOG, $data1);

                return '1';
            }
        } else {
            return '0';
        }
    }

    public function updatePlot($plotId, $userId, $seller) {
        $sellerId = 0;
        $markAsCompanay = 0;
        if (isset($_POST['markAsCompany'])) {
            $sellerId = $seller;
            $markAsCompanay = 1;
        } else {
            $sellerId = $this->input->post('plot-seller');
        }

        $data[dbConfig::TABLE_PLOT_ATT_PLOT_NAME] = $this->input->post('plot-name');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_ADDESS] = $this->input->post('plot-address');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_BLOCK] = $this->input->post('plot-block');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_FACING] = $this->input->post('plot-facing');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_PROJECT_ID] = $this->input->post('plot-project');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_SELLER_ID] = $sellerId;
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_ASKING_PRICE] = $this->input->post('plot-asking-price');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_ASKING_MIN_PRICE] = $this->input->post('plot-asking-min-price');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_CURRENCY] = $this->input->post('plot-currency');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_CONDITION] = $this->input->post('plot-condition');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_STATUS] = $this->input->post('plot-status');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_COMMENT] = $this->input->post('plot-comment');
        $data[dbConfig::TABLE_PLOT_ATT_PLOT_MARK_AS_COMPANY] = $markAsCompanay;

        $this->db->set($data);
        $this->db->where(dbConfig::TABLE_PLOT_ATT_PLOT_ID, $plotId);
        $i = $this->db->update(dbConfig::TABLE_PLOT);

        if ($i) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> edited a plot <a href="' . base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_VIEW_PLOT . encode($plotId) . '">' . $this->input->post('plot-name') . '</a> ';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            return '1';
        }
    }

    public function getProjectByPlot($plotId) {
        $this->db->where(dbConfig::TABLE_PLOT_ATT_PLOT_ID, $plotId);
        $r = $this->db->get(dbConfig::TABLE_PLOT)->row_array();

        $this->db->where(dbConfig::TABLE_PROJECT_ATT_ID, $r[dbConfig::TABLE_PLOT_ATT_PLOT_PROJECT_ID]);
        $r2 = $this->db->get(dbConfig::TABLE_PROJECT)->row_array();

        if (!empty($r2)) {

            $this->db->where(dbConfig::TABLE_PROJECT_ATT_COMPANY_ID, $r2[dbConfig::TABLE_PROJECT_ATT_COMPANY_ID]);
            $r3 = $this->db->get(dbConfig::TABLE_PROJECT)->result_array();

            return $r3;
        }
    }

    public function sentMailToPlot($userId) {
        $this->db->where(dbConfig::TABLE_PLOT_ATT_PLOT_ID, decode($_POST['id']));
        $r = $this->db->get(dbConfig::TABLE_PLOT)->row_array();

        $this->db->where(dbConfig::TABLE_PROJECT_ATT_ID, $r[dbConfig::TABLE_PLOT_ATT_PLOT_PROJECT_ID]);
        $r2 = $this->db->get(dbConfig::TABLE_PROJECT)->row_array();

        $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $r2[dbConfig::TABLE_PROJECT_ATT_COMPANY_ID]);
        $r3 = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

        if (!empty($r3)) {

            $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> send mail to <a href="' . base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_VIEW_COMPANY . $r3[dbConfig::TABLE_COMPANY_ATT_ID] . '">' . $r3[dbConfig::TABLE_COMPANY_ATT_NAME] . '</a> about the plot <a href="' . base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_VIEW_PLOT . encode($r[dbConfig::TABLE_PLOT_ATT_PLOT_ID]) . '">' . $r[dbConfig::TABLE_PLOT_ATT_PLOT_NAME] . '</a>';
            $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
            $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
            $this->db->insert(dbConfig::TABLE_LOG, $data1);

            $this->email->from('admin@dhakahome.com', 'Dhaka Home Administration');
            $this->email->to($r3[dbConfig::TABLE_COMPANY_ATT_EMAIL]);
            $this->email->subject($this->input->post('subject'));
            $this->email->message($this->input->post('body'));

            $this->email->send();

            return '1';
        }
    }

    public function sentMailToMultiplePlot($userId) {

        foreach ($_POST['id'] as $id) {

            $this->db->where(dbConfig::TABLE_PLOT_ATT_PLOT_ID, decode($id));
            $r = $this->db->get(dbConfig::TABLE_PLOT)->row_array();

            $this->db->where(dbConfig::TABLE_PROJECT_ATT_ID, $r[dbConfig::TABLE_PLOT_ATT_PLOT_PROJECT_ID]);
            $r2 = $this->db->get(dbConfig::TABLE_PROJECT)->row_array();

            $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $r2[dbConfig::TABLE_PROJECT_ATT_COMPANY_ID]);
            $r3 = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

            if (!empty($r3)) {

                $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> send mail to <a href="' . base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_VIEW_COMPANY . $r3[dbConfig::TABLE_COMPANY_ATT_ID] . '">' . $r3[dbConfig::TABLE_COMPANY_ATT_NAME] . '</a> about the plot <a href="' . base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_VIEW_PLOT . encode($r[dbConfig::TABLE_PLOT_ATT_PLOT_ID]) . '">' . $r[dbConfig::TABLE_PLOT_ATT_PLOT_NAME] . '</a>';
                $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
                $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
                $this->db->insert(dbConfig::TABLE_LOG, $data1);

                $this->email->from('admin@dhakahome.com', 'Dhaka Home Administration');
                $this->email->to($r3[dbConfig::TABLE_COMPANY_ATT_EMAIL]);
                $this->email->subject($this->input->post('subject'));
                $this->email->message($this->input->post('body'));
                $this->email->send();
            }
        }

        return '1';
    }

    public function plotNameCheck($name) {
        $this->db->where(DBConfig::TABLE_PLOT_ATT_PLOT_NAME, $name);
        $query = $this->db->get(DBConfig::TABLE_PLOT);

        if ($query->num_rows() == 1) {
            return '1';
        } else {
            return '0';
        }
    }

    public function getCompanyProjectNclient() {
        $data = array();
        $data['project'] = array();
        $data['client'] = array();

        $this->db->select(dbConfig::TABLE_PROJECT_ATT_ID);
        $this->db->select(dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME);
        $this->db->where(dbConfig::TABLE_PROJECT_ATT_IS_DELETE, '0');
        $this->db->where(dbConfig::TABLE_PROJECT_ATT_COMPANY_ID, $this->input->post('id'));

        $r = $this->db->get(dbConfig::TABLE_PROJECT)->result_array();

        foreach ($r as $row) {
            array_push($data['project'], $row);
        }

        $this->db->select(dbConfig::TABLE_CLIENT_ATT_ID);
        $this->db->select(dbConfig::TABLE_CLIENT_ATT_FIRST_NAME);
        $this->db->where(dbConfig::TABLE_CLIENT_ATT_IS_DELETE, '0');
        $this->db->where(dbConfig::TABLE_CLIENT_ATT_COMPANY, $this->input->post('id'));

        $r1 = $this->db->get(dbConfig::TABLE_CLIENT)->result_array();

        foreach ($r1 as $row) {
            array_push($data['client'], $row);
        }

        return json_encode($data);
    }

    public function sellPlot($id, $userId) {

        $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $this->input->post('company'));
        $r = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

        $this->db->where(dbConfig::TABLE_PLOT_ATT_PLOT_ID, $id);
        $this->db->where(dbConfig::TABLE_PLOT_ATT_PLOT_IS_DELETE, '0');
        $r2 = $this->db->get(dbConfig::TABLE_PLOT)->row_array();

        if (!empty($r2)) {

            //$data1[dbConfig::TABLE_PLOT_ATT_PLOT_BUYER_ID]= $this->input->post('company');
            $data2[dbConfig::TABLE_PLOT_ATT_PLOT_SELLER_ID] = $this->input->post('company');
            $data2[dbConfig::TABLE_PLOT_ATT_PLOT_PROJECT_ID] = $this->input->post('project');
            $data2[dbConfig::TABLE_PLOT_ATT_PLOT_STATUS] = '1';
            $this->db->set($data2);
            $this->db->where(dbConfig::TABLE_PLOT_ATT_PLOT_ID, $id);
            $this->db->update(dbConfig::TABLE_PLOT);

            $data[dbConfig::TABLE_SOLD_PLOT_ATT_PLOT_ID] = $id;
            $data[dbConfig::TABLE_SOLD_PLOT_ATT_COMPANY_ID] = $this->input->post('company');
            $data[dbConfig::TABLE_SOLD_PLOT_ATT_CLIENT_ID] = $this->input->post('client');
            $data[dbConfig::TABLE_SOLD_PLOT_ATT_PROJECT_ID] = $this->input->post('project');
            $data[dbConfig::TABLE_SOLD_PLOT_ATT_COMMENT] = $this->input->post('comment');
            $data[dbConfig::TABLE_SOLD_PLOT_ATT_SELLER_ID] = $r2[dbConfig::TABLE_PLOT_ATT_PLOT_SELLER_ID];
            $data[dbConfig::TABLE_SOLD_PLOT_ATT_OLD_PROJECT_ID] = $r2[dbConfig::TABLE_PLOT_ATT_PLOT_PROJECT_ID];
            $data[dbConfig::TABLE_SOLD_PLOT_ATT_TIME] = time();

            if (isset($_POST['markAsInstallmentSales'])) {
                $data[dbConfig::TABLE_SOLD_PLOT_ATT_SUBTOTAL] = $this->input->post('sub-total');
                $data[dbConfig::TABLE_SOLD_PLOT_ATT_DOWN_PAYMENT] = $this->input->post('down-payment');
                $data[dbConfig::TABLE_SOLD_PLOT_ATT_INSTALLMENT_PERIOD] = $this->input->post('installment-period');
                $data[dbConfig::TABLE_SOLD_PLOT_ATT_MONTH_PAYMENT] = $this->input->post('monthly-payment');
                $data[dbConfig::TABLE_SOLD_PLOT_ATT_IS_INSTALLMENT_SALE] = '1';
            }

            $i = $this->db->insert(dbConfig::TABLE_SOLD_PLOT, $data);

            if ($i) {
                $logTxt = '<a href="' . base_url() . siteConfig::CONTROLLER_USER . siteConfig::METHOD_VIEW_PROFILE . $userId . '">' . getUserNameById($userId) . '</a> sold a plot <a href="' . base_url() . siteConfig::CONTROLLER_PLOT . siteConfig::METHOD_PLOT_VIEW_PLOT . encode($r2[dbConfig::TABLE_PLOT_ATT_PLOT_ID]) . '">' . $r2[dbConfig::TABLE_PLOT_ATT_PLOT_NAME] . '</a>(' . getProjectName($r2[dbConfig::TABLE_PLOT_ATT_PLOT_PROJECT_ID]) . ',' . getCompanyName($r2[dbConfig::TABLE_PLOT_ATT_PLOT_SELLER_ID]) . ') to <a href="' . base_url() . siteConfig::CONTROLLER_COMPANY . siteConfig::METHOD_VIEW_COMPANY . $r[dbConfig::TABLE_COMPANY_ATT_ID] . '">' . $r[dbConfig::TABLE_COMPANY_ATT_NAME] . '</a> ';
                $data1[dbConfig::TABLE_LOG_ATT_LOG_TXT] = $logTxt;
                $data1[dbConfig::TABLE_LOG_ATT_TIME] = time();
                $this->db->insert(dbConfig::TABLE_LOG, $data1);
                return '1';
            }
        }
    }

    public function getSellHistory($id) {
        $this->db->where(dbConfig::TABLE_SOLD_PLOT_ATT_PLOT_ID, $id);
        $r = $this->db->get(dbConfig::TABLE_SOLD_PLOT)->result_array();

        $data = array();

        foreach ($r as $row) {
            $row['buyer'] = getBuyerName($row[dbConfig::TABLE_SOLD_PLOT_ATT_COMPANY_ID]);
            $row['seller'] = getSellerName($row[dbConfig::TABLE_SOLD_PLOT_ATT_SELLER_ID]);
            $row['project'] = getProjectName($row[dbConfig::TABLE_SOLD_PLOT_ATT_OLD_PROJECT_ID]);
            array_push($data, $row);
        }

        return $data;
    }

    public function getCompanyName($id) {
        $this->db->where(dbConfig::TABLE_COMPANY_ATT_ID, $id);
        $r = $this->db->get(dbConfig::TABLE_COMPANY)->row_array();

        return $r[dbConfig::TABLE_COMPANY_ATT_NAME];
    }
    public function getClientNameById($id) {
        $this->db->where(dbConfig::TABLE_CLIENT_ATT_ID, $id);
        $r = $this->db->get(dbConfig::TABLE_CLIENT)->row_array();

        return $r[dbConfig::TABLE_CLIENT_ATT_FIRST_NAME];;
    }

    public function getProjectName($id) {
        $this->db->where(dbConfig::TABLE_PROJECT_ATT_ID, $id);
        $r = $this->db->get(dbConfig::TABLE_PROJECT)->row_array();

        return $r[dbConfig::TABLE_PROJECT_ATT_PROJECT_NAME];
    }

    public function getPlotName($id) {
        $this->db->where(dbConfig::TABLE_PLOT_ATT_PLOT_ID, $id);
        $r = $this->db->get(dbConfig::TABLE_PLOT)->row_array();

        return $r[dbConfig::TABLE_PLOT_ATT_PLOT_NAME];
    }


}
