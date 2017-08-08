<?php

function getApartmentSize() {
    $CI = &get_instance();
    $CI->load->model('model_apartment');
    return $CI->model_apartment->getApartmentSize();
}

function getApartmentFloor() {
    $CI = &get_instance();
    $CI->load->model('model_apartment');
    return $CI->model_apartment->getApartmentFloor();
}

function getApartmentFacing() {
    $CI = &get_instance();
    $CI->load->model('model_apartment');
    return $CI->model_apartment->getApartmentFacing();
}

function getApartmentCondition() {
    $CI = &get_instance();
    $CI->load->model('model_apartment');
    return $CI->model_apartment->getApartmentCondition();
}

function getApartmentBed() {
    $CI = &get_instance();
    $CI->load->model('model_apartment');
    return $CI->model_apartment->getApartmentBed();
}

function getApartmentBath() {
    $CI = &get_instance();
    $CI->load->model('model_apartment');
    return $CI->model_apartment->getApartmentBath();
}

function getApartmentStatus() {
    $CI = &get_instance();
    $CI->load->model('model_apartment');
    return $CI->model_apartment->getApartmentStatus();
}

function getApartmentName($id) {
    $CI = &get_instance();
    $CI->load->model('model_apartment');
    return $CI->model_apartment->getApartmentName($id);
}


