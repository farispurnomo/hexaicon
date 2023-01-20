<?php defined('BASEPATH') or exit('No direct script access allowed');

class Icon_style extends CI_Controller
{
    private $namespace    = 'pages/client/icon_style/icon_style_';
    private $extend_view  = 'layouts/client';
    private $route        = 'icon_style';

    private $client;

    public function __construct()
    {
        parent::__construct();

        $this->client       = getClientLogin();
        $this->load->model('M_icon_style');
    }

    public function index($id = null)
    {
        try {
            $subscription_id   = $this->client ? $this->client->subscription_plan_id : null;
            if (!$id) throw new Exception();

            $data['extend_view']    = $this->extend_view;
            $data['route']          = $this->route;
            $data['icon_id']        = $id;
            $data['is_favorite']    = false;
            $data['client']         = $this->client;
            $data['namespace']      = $this->namespace;
            $data['icon']           = $this->M_icon_style->doGetIconById($id, $subscription_id);

            if ($this->client) {
                $data['is_favorite']    = $this->M_icon_style->doCheckIsFavorite($id, $this->client->id);
            }

            $this->template->load($this->namespace . 'index', $data);
        } catch (Throwable $e) {
            show_404();
        }
    }

    public function get_suggestion($id)
    {
        try {
            if (!$id) throw new Exception('Ikon tidak ditemukan', 201);

            $subscription_id   = $this->client ? $this->client->subscription_plan_id : null;
            $icon              = $this->M_icon_style->doGetDetaiIcon($id, $subscription_id);
            if (!$icon) throw new Exception('Ikon tidak ditemukan', 201);

            $suggestions        = $this->M_icon_style->doGetIconLikeId($id, $subscription_id);

            $datarow['status'] = 200;
            $datarow['msg']    = 'sukses';
            $datarow['data']   = $suggestions;
        } catch (Throwable $e) {
            $datarow['status'] = $e->getCode();
            $datarow['msg']    = $e->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datarow));
        }
    }

    public function get_more_icons()
    {
        try {
            $page = $this->input->get('page', true);

            $subscription_id   = $this->client ? $this->client->subscription_plan_id : null;

            $datarow['status'] = 200;
            $datarow['msg']    = 'sukses';
            $datarow['data']   = $this->M_icon_style->doGetMoreCategoryWithIcons($subscription_id, $page);
        } catch (Throwable $e) {
            $datarow['status'] = $e->getCode();
            $datarow['msg']    = $e->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datarow));
        }
    }

    public function download($format_id = null)
    {
        try {
            if (!$format_id) throw new Exception();

            $format_icon = $this->M_icon_style->doGetFormatIconById($format_id);
            if (!$format_icon || !$format_icon->image) throw new Exception();
            $this->M_icon_style->updateDownloadIcon($format_icon->icon_id);

            // force_download(FCPATH . '/' . $format_icon->image, NULL);
        } catch (Throwable $e) {
            show_404();
        }
    }

    public function add_to_favorite($icon_id)
    {
        if (!$this->client) {
            redirect('login');
        } else {
            $this->M_icon_style->doToggleFavorite($icon_id, $this->client->id);
            redirect('icon_style/index/' . $icon_id);
        }
    }
}
