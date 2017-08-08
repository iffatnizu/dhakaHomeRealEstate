<?php

function getCommercialFloor() {
    $CI = &get_instance();
    $CI->load->model('model_commercial');
    return $CI->model_commercial->getCommercialFloor();
}

function getCommercialSize() {
    $CI = &get_instance();
    $CI->load->model('model_commercial');
    return $CI->model_commercial->getCommercialSize();
}

function getCondition() {
    $CI = &get_instance();
    $CI->load->model('model_commercial');
    return $CI->model_commercial->getCondition();
}

function getCommercialStatus() {
    $CI = &get_instance();
    $CI->load->model('model_commercial');
    return $CI->model_commercial->getCommercialStatus();
}
