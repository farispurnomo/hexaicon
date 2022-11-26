<?php defined('BASEPATH') or exit('No direct script access allowed');

class Icon_style extends CI_Controller
{
    protected $namespace    = 'pages/client/icon_style/icon_style_';
    protected $extend_view  = 'layouts/client';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_icon_style');
    }

    public function index($id = null)
    {
        try {
            if (!$id) throw new Exception();

            $client_id  = $this->session->userdata('id');

            $data['extend_view']    = $this->extend_view;
            $data['icon_id']        = $id;
            $data['is_favorite']    = $this->M_icon_style->doCheckIsFavorite($id, $client_id);

            $this->template->load($this->namespace . 'index', $data);
        } catch (Exception $e) {
            show_404();
        }
    }

    public function get_icon($id = null)
    {
        try {
            if (!$id) throw new Exception('Ikon tidak ditemukan', 201);

            $subscription_id   = getUserSubscription()->id;
            $icon              = $this->M_icon_style->doGetDetaiIcon($id, $subscription_id);
            if (!$icon) throw new Exception('Ikon tidak ditemukan', 201);

            $suggestions        = $this->M_icon_style->doGetIconLikeId($id);

            $datarow['status'] = 200;
            $datarow['msg']    = 'sukses';
            $datarow['data']   = array(
                'icon'          => $icon,
                'suggestions'   => $suggestions
            );
        } catch (Exception $e) {
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

            $datarow['status'] = 200;
            $datarow['msg']    = 'sukses';
            $datarow['data']   = $this->M_icon_style->doGetMoreCategoryWithIcons($page);
        } catch (Exception $e) {
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

            force_download(FCPATH . '/' . $format_icon->image, NULL);
        } catch (Exception $e) {
            show_404();
        }
    }

    public function add_to_favorite($icon_id)
    {
        $is_login = $this->session->userdata('is_client');
        $client_id  = $this->session->userdata('id');

        if (!$is_login) {
            redirect('login');
        } else {
            $this->M_icon_style->doToggleFavorite($icon_id, $client_id);
            redirect(base_url('icon_style/index/' . $icon_id));
        }
    }
}
