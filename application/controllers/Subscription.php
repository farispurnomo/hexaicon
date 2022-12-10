<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subscription extends CI_Controller
{
    protected $namespace    = 'pages/client/subscription/subscription_';
    protected $route        = 'subscription';
    protected $pagetitle    = 'Dashboard';
    protected $extend_view  = 'layouts/client';

    public function __construct()
    {
        parent::__construct();

        $this->load->library('payment');
    }

    public function index()
    {
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'callback'  => array(
                'finish'    => base_url('subscription/pending')
            )
        );

        $data['extend_view']    = $this->extend_view;
        $data['title']          = $this->pagetitle;
        $data['subheaders']     = ['Index' => base_url($this->route . '.index')];

        $data['snap_token']     = $this->payment->getSnapToken($params);

        $this->template->load($this->namespace . 'index', $data);
    }
}
