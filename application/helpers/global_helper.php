<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('thousandCurrencyFormat')) {
    function thousandCurrencyFormat($num)
    {
        if ($num > 1000) {
            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];
            return $x_display;
        }
        return $num;
    }
}

if (!function_exists('getUserSubscription')) {
    function getUserSubscription()
    {
        $ci = &get_instance();
        $id = $ci->session->userdata('subscription_plan_id');

        $ci->db->from('mst_subscription_plans');
        if ($id) $ci->db->where('id', $id);
        return $ci->db->get()->row();
    }
}
