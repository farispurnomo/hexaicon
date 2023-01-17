<?php defined('BASEPATH') or exit('No direct script access allowed');

class Icon_discover extends CI_Controller
{
    private $namespace    = 'pages/client/icon_discover/icon_discover_';
    private $extend_view  = 'layouts/client';

    private $client;

    public function __construct()
    {
        parent::__construct();

        $this->client = getClientLogin();

        $this->load->model('M_icon_discover');
    }

    public function index()
    {
        $data['extend_view']    = $this->extend_view;

        $this->template->load($this->namespace . 'index', $data);
    }

    public function get_data()
    {
        $subscription_id        = @$this->client->subscription_plan_id;
        try {
            $categories         = $this->M_icon_discover->doGetCategories();
            $icon_styles        = $this->M_icon_discover->doGetIconStyles();
            $icon_popular       = $this->M_icon_discover->doGetPopularIcons($subscription_id);
            $icon_sets          = $this->M_icon_discover->doGetIconSets();

            $datarow['status']  = 200;
            $datarow['msg']     = 'sukses';
            $datarow['data']    = array(
                'categories'    => $categories,
                'icon_styles'   => $icon_styles,
                'icon_sets'     => $icon_sets,
                'icon_popular'  => $icon_popular
            );
        } catch (Throwable $e) {
            $datarow['status']  = $e->getCode();
            $datarow['msg']     = $e->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datarow));
        }
    }

    public function get_icons()
    {
        $post                   = $this->input->post();
        $subscription_id        = @$this->client->subscription_plan_id;

        try {
            if (!isset($post['type'])) throw new Exception('Invalid Request', 405);

            switch ($post['type']) {
                case 'LATEST':
                    $icons = $this->M_icon_discover->doGetLatestIcons($subscription_id);
                    break;

                case 'POPULAR':
                    $icons = $this->M_icon_discover->doGetPopularIcons($subscription_id);
                    break;

                default:
                    $icons = $this->M_icon_discover->doGetFreeIcons($subscription_id);
                    break;
            }

            $datarow['status']  = 200;
            $datarow['msg']     = 'sukses';
            $datarow['data']    = $icons;
        } catch (Throwable $e) {
            $datarow['status']  = $e->getCode();
            $datarow['msg']     = $e->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datarow));
        }
    }

    public function search()
    {
        $keyword = $this->input->get('q', true);
        try {
            $icons = $this->M_icon_discover->doGetIconByKeyword($keyword);

            $datarow['status']  = 200;
            $datarow['msg']     = 'sukses';
            $datarow['data']    = $icons;
        } catch (Throwable $e) {
            $datarow['status']  = $e->getCode();
            $datarow['msg']     = $e->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datarow));
        }
    }

    public function get_detail_icon($icon_id = null)
    {
        if (!$icon_id) show_404();
        $subscription_id        = @$this->client->subscription_plan_id;

        try {
            $icon               = $this->M_icon_discover->doGetDetailIcon($icon_id, $subscription_id);

            $datarow['status']      = 200;
            $datarow['msg']         = 'sukses';
            $datarow['is_login']    = $this->client ? true : false;
            $datarow['data']        = $icon;
        } catch (Throwable $th) {
            $datarow['status']      = $th->getCode();
            $datarow['msg']         = $th->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datarow));
        }
    }

    public function get_categories()
    {
        try {
            $page = $this->input->get('page', true);

            $datarow['status'] = 200;
            $datarow['msg']    = 'sukses';
            $datarow['data']   = $this->M_icon_discover->doGetMoreCategories($page);
        } catch (Throwable $e) {
            $datarow['status'] = $e->getCode();
            $datarow['msg']    = $e->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datarow));
        }
    }
}
