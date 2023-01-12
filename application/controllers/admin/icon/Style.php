<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Style extends HEXAICONS_Controller
{
    protected $namespace    = 'pages/admin/master/style/style_';
    protected $route        = 'admin/style';
    protected $tabel        = 'mst_icon_styles';
    protected $pagetitle    = 'Style';
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
                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Added Style</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to add Style</b>'];
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
                $feedback = ['status' => 200, 'data' => $tabel->row(), 'msg' => '<b>Successfully Delete Style</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to Delete Style</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Style Not Found</b>'];
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
                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Update Style</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to Update Style</b>'];
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
                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Delete Style</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to Delete Style</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Style Not Found</b>'];
        }
        echo json_encode($feedback);
    }
}
