<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Icon extends HEXAICONS_Controller
{
    protected $table        = 'master_iconsTable';
    protected $namespace    = 'pages/admin/master/icon/icon_';
    protected $route        = 'admin/icon';
    protected $pagetitle    = 'Icon';
    protected $extend_view  = 'layouts/admin';

    public function index()
    {
        $data['extend_view']    = $this->extend_view;
        $data['title']          = $this->pagetitle;
        $data['subheaders']     = ['Index' => base_url($this->route . '.index')];
        $data['table']          = $this->table;
        $data['pagetitle']      = $this->pagetitle;

        $this->template->load($this->namespace . 'index', $data);
    }

    public function create()
    {
    }

    public function store()
    {
        $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
    }

    public function edit($id)
    {
    }

    public function update($id)
    {
        $this->session->set_flashdata('success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
    }
}
