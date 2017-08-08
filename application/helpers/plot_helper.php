<?php

function getPlotBlock() {
    $CI = &get_instance();
    $CI->load->model('model_plot');
    return $CI->model_plot->getPlotBlock();
}

function getPlotFacing() {
    $CI = &get_instance();
    $CI->load->model('model_plot');
    return $CI->model_plot->getPlotFacing();
}

function getCondition() {
    $CI = &get_instance();
    $CI->load->model('model_plot');
    return $CI->model_plot->getCondition();
}

function getPlotStatus() {
    $CI = &get_instance();
    $CI->load->model('model_plot');
    return $CI->model_plot->getPlotStatus();
}


function getPlotName($id)
{
    $CI = &get_instance();
    $CI->load->model('model_plot');
    return $CI->model_plot->getPlotName($id);
}

