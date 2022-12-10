<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends HEXAICONS_Controller
{
    protected $namespace    = 'pages/admin/master/role/role_';
    protected $route        = 'admin/role';
    protected $tabel        = 'core_roles';
    protected $pagetitle    = 'Role';
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
        if ($nama != '') {
            $this->db->set('name',$nama);
            if ($this->db->insert($this->tabel)) {
                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Added Role</b>'];
            }else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to add Role</b>'];
            }
            
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Name Required</b>'];
        }
        echo json_encode($feedback);
    }

    public function edit($id)
    {
    }

    public function update($id)
    {
        $this->session->set_flashdata('success', 'Data Berhasil Diupdate');
    }

    public function destroy()
    {
        $id = $this->input->post('id');
        if ($id != '') {
            $this->db->where('id',$id);
            if ($this->db->delete($this->tabel)) {
                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Delete Role</b>'];
            }else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to Delete Role</b>'];
            }
            
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Role Not Found</b>'];
        }
        echo json_encode($feedback);
    }
}
