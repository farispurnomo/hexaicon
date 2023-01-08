<?php defined('BASEPATH') or exit('No direct script access allowed');

class Errors extends CI_Controller
{
    protected $namespace    = 'pages/client/error/error_';
    protected $extend_view  = 'layouts/client';

    public function error_404()
    {
        $this->output->set_status_header('404');

        $data['extend_view']    = $this->extend_view;
        $this->template->load($this->namespace . '404', $data);
    }
}
