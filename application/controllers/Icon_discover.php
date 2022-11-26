<?php defined('BASEPATH') or exit('No direct script access allowed');

class Icon_discover extends CI_Controller
{
    protected $namespace    = 'pages/client/icon_discover/icon_discover_';
    protected $extend_view  = 'layouts/client';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_icon_discover');
    }

    public function index()
    {
        $data['extend_view']    = $this->extend_view;

        $this->template->load($this->namespace . 'index', $data);
    }

    public function get_data()
    {
        try {
            $categories         = $this->M_icon_discover->doGetCategories();
            $icon_styles        = $this->M_icon_discover->doGetIconStyles();
            $icon_trends        = $this->M_icon_discover->doGetTrandingIcons();;

            $datarow['status']  = 200;
            $datarow['msg']     = 'sukses';
            $datarow['data']    = array(
                'categories'    => $categories,
                'icon_styles'   => $icon_styles,
                'icon_sets'     => [],
                'icon_trends'   => $icon_trends
            );
        } catch (Exception $e) {
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
        $post = $this->input->post();
        try {
            if (!isset($post['type'])) throw new Exception('Invalid Request', 405);

            switch ($post['type']) {
                case 'LATEST':
                    $icons = $this->M_icon_discover->doGetLatestIcons();
                    break;

                case 'POPULAR':
                    $icons = $this->M_icon_discover->doGetPopularIcons();
                    break;

                default:
                    $icons = $this->M_icon_discover->doGetTrandingIcons();
                    break;
            }

            $datarow['status']  = 200;
            $datarow['msg']     = 'sukses';
            $datarow['data']    = $icons;
        } catch (Exception $e) {
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
            $datarow['last_query'] = $this->db->last_query();
        } catch (Exception $e) {
            $datarow['status']  = $e->getCode();
            $datarow['msg']     = $e->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datarow));
        }
    }
}
