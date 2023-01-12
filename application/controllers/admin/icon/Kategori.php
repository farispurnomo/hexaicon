<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends HEXAICONS_Controller
{
    protected $namespace    = 'pages/admin/master/kategori/kategori_';
    protected $route        = 'admin/kategori';
    protected $tabel        = 'mst_icon_categories';
    protected $pagetitle    = 'Categori';
    protected $extend_view  = 'layouts/admin';

    public function index()
    {
        $data['extend_view']    = $this->extend_view;
        $data['title']          = $this->pagetitle;
        $data['subheaders']     = ['Index' => base_url($this->route . '.index')];
        $data['pagetitle']      = $this->pagetitle;
        $data['table']      = $this->db->get($this->tabel)->result();

        $this->template->load($this->namespace . 'index', $data);
    }

    public function create()
    {
    }

    public function store()
    {
        $nama = $this->input->post('nama');
        $description = $this->input->post('description');
        if ($nama != '') {
            $this->db->set('name', $nama);
            $this->db->set('description', $description);
            if ($this->db->insert($this->tabel)) {
                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Added Categori</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to add Categori</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Name Required</b>'];
        }
        echo json_encode($feedback);
    }

    public function edit()
    {
        $id = $this->input->post('id');
        if ($id != '') {
            $data_tabel = $this->db->get($this->tabel);
            $this->db->where('id', $id);
            if ($tabel = $this->db->get($this->tabel)) {
                $feedback = ['status' => 200, 'data' => $tabel->row(), 'msg' => '<b>Successfully Delete Categori</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to Delete Categori</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Categori Not Found</b>'];
        }
        echo json_encode($feedback);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $description = $this->input->post('description');
        $parent_id = $this->input->post('parent_id');
        if ($nama != '' ) {
            $this->db->where('id', $id);
            $this->db->set('name', $nama);
            $this->db->set('description', $description);
            if ($this->db->update($this->tabel)) {
                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Update Categori</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to Update Categori</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Name Required</b>'];
        }
        echo json_encode($feedback);
    }

    public function destroy()
    {
        $id = $this->input->post('id');
        if ($id != '') {
            $this->db->where('id', $id);
            if ($this->db->delete($this->tabel)) {
                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Delete Categori</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to Delete Categori</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Categori Not Found</b>'];
        }
        echo json_encode($feedback);
    }
}
