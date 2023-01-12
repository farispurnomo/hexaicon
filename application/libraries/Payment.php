<?php defined('BASEPATH') or exit('No direct script access allowed');

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class Payment
{
    private $ci;

    public function __construct()
    {
        $this->ci = &get_instance();

        Config::$serverKey      = $this->ci->config->item('midrans_server_key');
        Config::$isProduction   = $this->ci->config->item('midrans_is_production');
        Config::$isSanitized    = $this->ci->config->item('midrans_is_sanitized');
        Config::$is3ds          = $this->ci->config->item('midrans_is_3ds');
    }

    public function getSnapToken($params)
    {
        return Snap::getSnapToken($params);
    }

    public function createTransaction($params)
    {
        return Snap::createTransaction($params);
    }

    public function getTransactionStatus($order_id)
    {
        return Transaction::status($order_id);
    }

    public function approveTransaction($order_id)
    {
        return Transaction::approve($order_id);
    }

    public function refund($order_id, $params)
    {
        return Transaction::refund($order_id, $params);
    }

    public function refundDirect($order_id, $params)
    {
        return Transaction::refundDirect($order_id, $params);
    }
}
