<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_Payment extends CI_Model {

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
    
    public function getPlotDue()
    {
       $r = $this->db->get(dbConfig::TABLE_SOLD_PLOT)->result_array();
       
       $data = array();
       
       
       foreach($r as $row)
       {
           $row['buyer'] = getBuyerName($row[dbConfig::TABLE_SOLD_PLOT_ATT_COMPANY_ID]);
           $row['seller'] = getSellerName($row[dbConfig::TABLE_SOLD_PLOT_ATT_SELLER_ID]);
           $row['plotName'] = getPlotName($row[dbConfig::TABLE_SOLD_PLOT_ATT_ID]);
           array_push($data, $row);
       }
       
       return $data;
    }
    
    public function getApartmentDue()
    {
       $r = $this->db->get(dbConfig::TABLE_SOLD_APARTMENT)->result_array();
       
       $data = array();
       
       
       foreach($r as $row)
       {
           $row['buyer'] = getBuyerName($row[dbConfig::TABLE_SOLD_APARTMENT_ATT_COMPANY_ID]);
           $row['seller'] = getSellerName($row[dbConfig::TABLE_SOLD_APARTMENT_ATT_SELLER_ID]);
           $row['apartmentName'] = getApartmentName($row[dbConfig::TABLE_SOLD_APARTMENT_ATT_APARTMENT_ID]);
           array_push($data, $row);
       }
       
       return $data;
    }
    
    public function getCommercialDue()
    {
       $r = $this->db->get(dbConfig::TABLE_SOLD_COMMERCIAL)->result_array();
       
       $data = array();
       
       
       foreach($r as $row)
       {
           $row['buyer'] = getBuyerName($row[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_COMPANY_ID]);
           $row['seller'] = getSellerName($row[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_SELLER_ID]);
           $row['commercialName'] = getCommercialName($row[dbConfig::TABLE_SOLD_COMMERCIAL_ATT_COMMERCIAL_ID]);
           array_push($data, $row);
       }
       
       return $data;
    }
}
