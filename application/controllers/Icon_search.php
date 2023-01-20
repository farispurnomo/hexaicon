<?php defined('BASEPATH') or exit('No direct script access allowed');

class Icon_search extends CI_Controller
{
    private $namespace    = 'pages/client/icon_search/icon_search_';
    private $extend_view  = 'layouts/client';
    private $route        = 'icon_search';

    private $client;

    public function __construct()
    {
        parent::__construct();

        $this->client       = getClientLogin();
        $this->load->model('M_icon_search');
    }

    public function index()
    {
        $data['extend_view']        = $this->extend_view;
        $data['styles']             = $this->M_icon_search->doGetStyles();
        $data['sets']               = $this->M_icon_search->doGetSets();
        $data['categories']         = $this->M_icon_search->doGetCategories();
        $data['subscriptions']      = $this->M_icon_search->doGetSubscriptions();

        $this->template->load($this->namespace . 'index', $data);
    }

    public function paginate()
    {
        try {
            $post                       = $this->input->raw_input_stream;
            $post                       = (array) json_decode($post);

            $post['params']->subscription_id    = @$this->client->subscription_plan_id;
            $items                      = $this->M_icon_search->doGetIconPaginate($post['params'], $post['page']);

            $datarow['status']          = 200;
            $datarow['msg']             = 'sukses';
            $datarow['data']            = $items;
        } catch (Throwable $e) {
            $datarow['status']          = $e->getCode();
            $datarow['msg']             = $e->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datarow));
        }
    }
}
