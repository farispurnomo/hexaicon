<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends HEXAICONS_Controller
{
    protected $namespace    = 'pages/admin/master/menu/menu_';
    protected $route        = 'admin/menu';
    protected $tabel        = 'core_menus';
    protected $pagetitle    = 'Menu';
    protected $extend_view  = 'layouts/admin';

    public function index()
    {
        $data['extend_view']    = $this->extend_view;
        $data['title']          = $this->pagetitle;
        $data['subheaders']     = ['Index' => base_url($this->route . '.index')];
        $data['pagetitle']      = $this->pagetitle;
        $data['table']      = $this->db->get($this->tabel)->result();
        $data_menu = $this->db->get($this->tabel);
        $menu = "<option value='0'>Root</option>";
        foreach ($data_menu->result() as $key => $value) {
            $menu .= "<option value='$value->id'>$value->title</option>";
        }
        $data['menu']      = $menu;

        $this->template->load($this->namespace . 'index', $data);
    }

    public function create()
    {
    }

    public function store()
    {
        $nama = $this->input->post('nama');
        $url = $this->input->post('url');
        $icon = $this->input->post('icon');
        $parent_id = $this->input->post('parent_id');
        if ($nama != '' && $url != '' && $parent_id != '') {
            $this->db->where('parent_id', $parent_id);
            $no = $this->db->count_all_results($this->tabel)+1;
            $this->db->set('url', $url);
            $this->db->set('icon', $icon);
            $this->db->set('title', $nama);
            $this->db->set('parent_id', $parent_id);
            $this->db->set('order', $no);
            if ($this->db->insert($this->tabel)) {
                $id_menu = $this->db->insert_id();

                $this->db->set('name', $url.':read');
                $this->db->set('menu_id', $id_menu);
                $this->db->insert("core_menu_abilities");

                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Added Menu</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to add Menu</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Name Required, Url Required, Menu Parent</b>'];
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
                $menu = "<option value='0'>Root</option>";
                foreach ($data_tabel->result() as $key => $value) {
                    $selected = $value->id == $tabel->row()->parent_id ? 'selected' : '';
                    $menu .= "<option value='$value->id'  $selected >$value->title</option>";
                }
                $feedback = ['status' => 200, 'data' => $tabel->row(), 'menu' => $menu, 'msg' => '<b>Successfully Delete Menu</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to Delete Menu</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Menu Not Found</b>'];
        }
        echo json_encode($feedback);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $url = $this->input->post('url');
        $icon = $this->input->post('icon');
        $parent_id = $this->input->post('parent_id');
        if ($nama != '' && $url != '' && $parent_id != '' && $id != '') {
            $this->db->where('id', $id);
            $this->db->set('url', $url);
            $this->db->set('icon', $icon);
            $this->db->set('title', $nama);
            $this->db->set('parent_id', $parent_id);
            if ($this->db->update($this->tabel)) {
                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Update Menu</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to Update Menu</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Name Required, Url Required, Menu Parent</b>'];
        }
        echo json_encode($feedback);
    }

    public function destroy()
    {
        $id = $this->input->post('id');
        if ($id != '') {
            $this->db->where('id', $id);
            if ($this->db->delete($this->tabel)) {
                $this->db->where('menu_id', $id);
                $this->db->delete("core_menu_abilities");
                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Delete Menu</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to Delete Menu</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Menu Not Found</b>'];
        }
        echo json_encode($feedback);
    }
}
