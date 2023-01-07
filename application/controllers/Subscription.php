<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subscription extends CI_Controller
{
    protected $namespace    = 'pages/client/subscription/subscription_';
    protected $route        = 'subscription';
    protected $pagetitle    = 'Dashboard';
    protected $extend_view  = 'layouts/client';

    protected $client_id;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('payment');
        $this->load->model('M_client_subscription');

        $this->client_id = $this->session->userdata('id');
    }

    public function index()
    {
        $data['extend_view']    = $this->extend_view;
        $data['subscriptions']  = $this->M_client_subscription->getSubscriptions();
        $this->template->load($this->namespace . 'index', $data);
    }

    public function purchase($id)
    {
        $data['user']               = $this->M_client_subscription->doGetClientById($this->client_id);
        if (!$data['user']) show_404();

        $data['subscription']       = $this->M_client_subscription->doGetDetailSubscription(intval($id));
        if (!$data['subscription']) show_404();

        $data['extend_view']        = $this->extend_view;
        $data['title']              = $this->pagetitle;

        $data['is_can_purchase']    = true;
        $data['error_note']         = 'Subscription has been purchased';

        $this->template->load($this->namespace . 'purchase', $data);
    }

    public function request_token()
    {
        try {
            $user               = $this->M_client_subscription->doGetClientById($this->client_id);
            if (!$user) throw new Exception('Unauthorized', 401);

            $plan_id            = $this->input->post('plan_id', true);
            $subscription       = $this->M_client_subscription->doGetDetailSubscription($plan_id);
            if (!$subscription) throw new Exception('Subscription plan not found', 201);

            $params             = array(
                'transaction_details'   => array(
                    'order_id'              => rand(),
                    'gross_amount'          => $subscription->total_price,
                ),
                'callback'              => array(
                    'finish'                => base_url('subscription/pending')
                )
            );
            $token              = $this->payment->getSnapToken($params);

            $datarow['status']  = 200;
            $datarow['msg']     = 'success';
            $datarow['token']   = $token;
        } catch (Throwable $th) {
            $datarow['status']  = $th->getCode();
            $datarow['msg']     = $th->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datarow));
        }
    }

    public function upgrade()
    {
        try {
            $user               = $this->M_client_subscription->doGetClientById($this->client_id);
            if (!$user) throw new Exception('Unauthenticated', 401);

            $subscription           = $this->M_client_subscription->doGetDetailSubscription($this->input->post('plan_id', true));
            if (!$subscription) throw new Exception('Subscription plan not found', 201);

            $response               = $this->input->post('response');
            $response               = json_decode($response);
            if ($response) {
                if ($response->transaction_status == 'settlement') {
                    $subscribed_at          = date('Y-m-d H:i:s');
                    $subscription_ends_at   = date('Y-m-d H:i:s', strtotime('+1 years'));

                    $update                 = array(
                        'subscription_plan_id'      => $subscription->id,
                        'subscribed_at'             => $subscribed_at,
                        'subscription_ends_at'      => $subscription_ends_at,
                    );
                    $this->M_client_subscription->doUpdateSubscriptionClient($this->client_id, $update);
                }
            }

            $log                    = array(
                'client_id'                 => $this->client_id,
                'client_email'              => $user->email,
                'subscription_plan_id'      => $subscription->id,
                'subscription_plan_name'    => $subscription->name,
                'subscribed_at'             => $subscribed_at,
                'subscription_ends_at'      => $subscription_ends_at,
                'response'                  => $this->input->post('response')
            );
            $this->M_client_subscription->doInsertLogSubscription($log);

            $datarow['status']  = 200;
            $datarow['msg']     = 'success';
        } catch (Throwable $th) {
            $datarow['status']  = $th->getCode();
            $datarow['msg']     = $th->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datarow));
        }
    }
}
