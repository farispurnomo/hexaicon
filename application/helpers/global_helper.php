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

if (!function_exists('getClientLogin')) {
    function getClientLogin()
    {
        $ci         = &get_instance();
        $is_client  = $ci->session->userdata('is_client');
        if (!$is_client) return;

        $id         = $ci->session->userdata('client_id');

        $client     = $ci->db
            ->select('mst_clients.*, mst_subscription_plans.name AS subscription_name')
            ->from('mst_clients')
            ->join('mst_subscription_plans', 'mst_subscription_plans.id=mst_clients.subscription_plan_id')
            ->where('mst_clients.id', $id)
            ->get()
            ->row();

        if ($client) {
            $path               = ($client->image ? $client->image : '/public/images/no_image.png');
            $client->url_image  = base_url($path);
        }


        return $client;
    }
}

if (!function_exists('getUserLogin')) {
    function getUserLogin()
    {
        $ci         = &get_instance();
        $is_client  = $ci->session->userdata('is_admin');

        if (!$is_client) return;

        $id         = $ci->session->userdata('user_id');
        $user       = $ci->db
            ->select('core_users.*, core_roles.name AS role_name')
            ->from('core_users')
            ->join('core_roles', 'core_roles.id=core_users.role_id')
            ->where('core_users.id', $id)
            ->get()
            ->row();

        if ($user) {
            $path               = ($user->avatar ? $user->avatar : '/public/src/media/avatars/blank.png');
            $user->url_avatar  = base_url($path);
        }

        return $user;
    }
}

if (!function_exists('getGeneralSetting')) {
    function getGeneralSetting($name)
    {
        $ci             = &get_instance();
        $setting        = $ci->db
            ->from('app_settings')
            ->where('name', $name)
            ->get()
            ->row();

        if ($setting) {
            return $setting->value;
        }
    }
}
