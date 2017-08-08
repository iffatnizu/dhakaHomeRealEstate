<?php

function debugPrint($object, $title = "", $isMarkup = false) {
    echo '<font color="red">Debug <<< START';
    if (!empty($title)) {
        echo "$title: ";
    }
    if ($isMarkup == false) {
        echo "<pre>";
        print_r($object);
        echo "</pre>";
    } else {
        echo htmlspecialchars($object);
    }
    echo 'END >>></font>';
}

function getAllCountry() {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getAllCountry();
}

function getAllCompany() {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getAllCompany();
}

function getProjectType() {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getProjectType();
}

function getAllPriviledge() {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getAllPriviledge();
}

function shortUserFeed($a, $b) {
    return $b['time'] - $a['time'];
}

function cmp($a, $b) {
    global $array;
    return strcmp($array[$a]['date'], $array[$b]['date']);
}

function array_sort_by_column(&$array, $column, $direction = SORT_DESC) {
    $reference_array = array();

    foreach ($array as $key => $row) {
        $reference_array[$key] = $row[$column];
    }

    array_multisort($reference_array, $direction, $array);
}

function getUserNameById($userId) {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getUserNameById($userId);
}

function getAllClients() {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getAllClients();
}

function getAllProject() {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getAllProject();
}

function getCompanyIdByName($name) {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getCompanyIdByName($name);
}

function getClientIdByName($email) {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getClientIdByName($email);
}
function getClientName($email) {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getClientName($email);
}

function getProjectIdByName($name) {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getProjectIdByName($name);
}

function getClientByCompany($companyId) {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getClientByCompany($companyId);
}

function getProjectByCompany($companyId) {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getProjectByCompany($companyId);
}

function getCurrency() {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getCurrency();
}

function encode($str = '') {

    $str1 = base64_encode($str);
    $str2 = base64_encode($str1);
    $str3 = base64_encode($str2);
    $str4 = base64_encode($str3);
    $str5 = strrev($str4);
    $encrypt = bin2hex($str5);

    return $encrypt;
}

function decode($encrypt = '') {
    //$encrypt = strrev($encrypt);
    $str = '';
    for ($i = 0; $i < strlen($encrypt) - 1; $i+=2) {
        $str .= chr(hexdec($encrypt[$i] . $encrypt[$i + 1]));
    }
    $str5 = strrev($str);
    $str4 = base64_decode($str5);
    $str3 = base64_decode($str4);
    $str2 = base64_decode($str3);
    $decode = base64_decode($str2);

    return $decode;
}

function makeSeoFriendlyUrl($data) {
    $filter1 = strtolower(str_replace(" ", "-", $data));
    $filter2 = str_replace("&", "", $filter1);
    $filter3 = str_replace("--", "-", $filter2);
    $filter4 = str_replace("'", "", $filter3);
    $filter5 = str_replace(".", "", $filter4);
    $filter6 = str_replace("%", "-", $filter5);

    return $filter6;
}

function getCommercialName($id) {
    $CI = &get_instance();
    $CI->load->model('model_commercial');
    return $CI->model_commercial->getCommercialName($id);
}

function getProjectName($id) {
    $CI = &get_instance();
    $CI->load->model('model_plot');
    return $CI->model_plot->getProjectName($id);
}

function getCompanyName($id) {
    $CI = &get_instance();
    $CI->load->model('model_plot');
    return $CI->model_plot->getCompanyName($id);
}


function getBuyerName($id)
{
    $CI = &get_instance();
    $CI->load->model('model_plot');
    return $CI->model_plot->getCompanyName($id);
}
function getClientNameById($id)
{
    $CI = &get_instance();
    $CI->load->model('model_plot');
    return $CI->model_plot->getClientNameById($id);
}


function getSellerName($id)
{
    $CI = &get_instance();
    $CI->load->model('model_plot');
    return $CI->model_plot->getCompanyName($id);
}
