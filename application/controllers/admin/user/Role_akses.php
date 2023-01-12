<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role_akses extends HEXAICONS_Controller
{
    protected $namespace    = 'pages/admin/master/role_akses/role_akses_';
    protected $route        = 'admin/role_akses';
    protected $tabel        = 'core_roles';
    protected $pagetitle    = 'Access Role';
    protected $extend_view  = 'layouts/admin';

    public function index()
    {
        $data['extend_view']    = $this->extend_view;
        $data['title']          = $this->pagetitle;
        $data['subheaders']     = ['Index' => base_url($this->route . '.index')];
        $data['pagetitle']      = $this->pagetitle;

        $data['table_role']      = $this->get_role();
        $this->db->select('a.id,b.title');
        $this->db->join('core_menus b', 'a.menu_id=b.id', 'INNER');
        $data['menu']      = $this->db->get('core_menu_abilities a')->result();
        $this->db->select('b.id,b.name', false);
        $this->db->group_by('b.id,b.name');
        $this->db->join('core_roles b', 'a.role_id=b.id', 'INNER');
        $data['table']      = $this->db->get('core_privileges a')->result();


        $this->template->load($this->namespace . 'index', $data);
    }

    public function create()
    {
    }
    public function get_role()
    {
        $data =  $this->db->query("SELECT * FROM core_roles WHERE id not in (SELECT role_id FROM core_privileges group by role_id)")->result();
        $role = "<option >Select Role</option>";
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $role .= "<option value='$value->id'>$value->name</option>";
            }
        }
        return $role;
    }

    public function store()
    {
        $menu = $this->input->post('menu');
        $parent_id = $this->input->post('parent_id');
        if ($parent_id != '' && count($menu) >= 1) {
            $success = 0;
            foreach ($menu as $key => $value) {
                $this->db->set('role_id', $parent_id);
                $this->db->set('ability_id', $value);

                if ($this->db->insert('core_privileges')) {
                    $success++;
                }
            }
            if ($success == count($menu)) {
                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Added Access Role</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to add Access Role</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Role Required, Menu seleced min 1</b>'];
        }
        echo json_encode($feedback);
    }

    public function edit()
    {
        $id = $this->input->post('id');
        if ($id != '') {
            $data_tabel = $this->db->get($this->tabel);
            $this->db->where('role_id', $id);
            if ($tabel = $this->db->get('core_privileges')) {
                $this->db->select('a.id,a.menu_id,b.title');
                $this->db->join('core_menus b', 'a.menu_id=b.id', 'INNER');
                $menu      = $this->db->get('core_menu_abilities a')->result();
                $role = "";

                foreach ($menu as $key => $value) {
                    $role .=  '<div class="col-md-3">
                                        <label class="form-check form-check-solid">';
                    $checked = "";
                    foreach ($tabel->result() as $key_core => $value_core) {
                        if ($value->id == $value_core->ability_id) {
                            $checked = 'checked';
                        }
                    }
                    $role .= '           <input class="form-check-input" name="menu[]" type="checkbox" value="' . $value->id . '"  '.$checked.' />
                                            <span class="form-check-label fw-bold text-muted">' . $value->title . '</span>
                                        </label>
                                        <br>
                                    </div>';
                }
                $feedback = ['status' => 200, 'data' => $tabel->row(), 'role' => $role, 'msg' => '<b>Successfully Delete Access Role</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to Delete Access Role</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Access Role Not Found</b>'];
        }
        echo json_encode($feedback);
    }

    public function update()
    {
        // $id = $this->input->post('id');
        // $nama = $this->input->post('nama');
        // $url = $this->input->post('url');
        // $icon = $this->input->post('icon');
        // $parent_id = $this->input->post('parent_id');
        // if ($nama != '' && $url != '' && $parent_id != '' && $id != '') {
        //     $this->db->where('id', $id);
        //     $this->db->set('url', $url);
        //     $this->db->set('icon', $icon);
        //     $this->db->set('title', $nama);
        //     $this->db->set('parent_id', $parent_id);
        //     if ($this->db->update($this->tabel)) {
        //         $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Update Menu</b>'];
        //     } else {
        //         $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to Update Menu</b>'];
        //     }
        // } else {
        //     $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Name Required, Url Required, Menu Parent</b>'];
        // }
        // echo json_encode($feedback);
        $menu = $this->input->post('menu');
        $parent_id = $this->input->post('parent_id');
        if ($parent_id != '' && count($menu) >= 1) {
            $success = 0;
            $this->db->where('role_id', $parent_id);
            $this->db->delete('core_privileges');
            foreach ($menu as $key => $value) {
                $this->db->set('role_id', $parent_id);
                $this->db->set('ability_id', $value);

                if ($this->db->insert('core_privileges')) {
                    $success++;
                }
            }
            if ($success == count($menu)) {
                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Added Access Role</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to add Access Role</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Role Required, Menu seleced min 1</b>'];
        }
        echo json_encode($feedback);
    }

    public function destroy()
    {
        $id = $this->input->post('id');
        if ($id != '') {
            $this->db->where('role_id', $id);
            if ($this->db->delete('core_privileges')) {
                $feedback = ['status' => 200, 'data' => [], 'msg' => '<b>Successfully Delete Access Role</b>'];
            } else {
                $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Failed to Delete Access Role</b>'];
            }
        } else {
            $feedback = ['status' => 201, 'data' => [], 'msg' => '<b>Access Role Not Found</b>'];
        }
        echo json_encode($feedback);
    }
}
