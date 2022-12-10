<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template
{
    public function __construct()
    {
        $this->CI = &get_instance();
    }

    private function get_tree_menu_by_child(array $ids)
    {
        // 1. cari tree per menu
        // 2. tambahkan ke $menus 1 per 1
        // 3. reindex + reorder array $menus :)

        $menus = [];
        // untuk mencari parent teratas hanya dengan parent_id pertama
        $find_parent = function ($parent_id, $child) use (&$find_parent) {
            $menu = $this->CI->db->get_where('core_menus', ['id' => $parent_id])->row_array();
            $menu['childs'][$child['id']] = $child;
            if ($menu['parent_id']) {
                $menu = $find_parent($menu['parent_id'], $menu);
            }
            return $menu;
        };

        // untuk menambahkan child ke array menus
        $append_menus = function ($parent, &$menus) use (&$append_menus) {
            foreach ($parent['childs'] as $key => $value) {
                if (isset($menus['childs'][$key])) {
                    if (isset($menus['childs'][$key])) {
                        $menus['childs'][$key] = $append_menus($value, $menus['childs'][$key]);
                    } else {
                        $menus['childs'][$key] = $value;
                    }
                } else {
                    $menus['childs'][$key] = $value;
                }
            }
            return $menus;
        };

        foreach ($ids as $id) {
            $menu    = $this->CI->db->get_where('core_menus', ['id' => $id])->row_array();
            $menu['childs'] = [];
            if ($menu['parent_id']) {
                $parent = $find_parent($menu['parent_id'], $menu);
                if (isset($menus[$parent['id']])) {
                    $menus[$parent['id']] = $append_menus($parent, $menus[$parent['id']]);
                } else {
                    $menus[$parent['id']] = $parent;
                }
            } else
                $menus[$menu['id']] = $menu;
        }

        // untuk re-index + reorder key $menus
        $reIndexMenus = function ($menus) use (&$reIndexMenus) {
            $count = 0;
            $result = array();
            foreach ($menus as $menu) {
                $result[$count] = $menu;
                $result[$count]['childs'] = $reIndexMenus($menu['childs']);
                ++$count;
            }
            usort($result, function ($a, $b) {
                return $a['order'] > $b['order'];
            });
            return $result;
        };

        return $reIndexMenus($menus);
    }

    private function get_tree_menu($role_id)
    {
        $this->CI->db->select('core_menu_abilities.name, core_menu_abilities.menu_id');
        $this->CI->db->from('core_privileges');
        $this->CI->db->join('core_menu_abilities', 'core_menu_abilities.id=core_privileges.ability_id');
        $this->CI->db->where('core_privileges.role_id', $role_id);
        $abilities = $this->CI->db->get()->result();
        $menu_ids = [];
        foreach ($abilities as $ability) {
            if (strpos($ability->name, ':read') !== FALSE) {
                $menu_ids[] = $ability->menu_id;
            }
        }

        $menu_ids = array_unique($menu_ids);

        return $this->get_tree_menu_by_child($menu_ids);
    }

    private function render_navigation_sidebar($menus)
    {
        $html = '';
        $render_child = function ($childs) use (&$render_child) {
            $child_html = '';
            foreach ($childs as $menu) {
                if (!empty($menu->child)) {
                    $child_html .= '  <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                            <span class="kt-menu__link-text">' . $menu->judul . '</span>
                                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                            <ul class="kt-menu__subnav">';
                    $child_html .=                $render_child($menu->child);
                    $child_html .= '        </ul>
                                        </div>
                                    </li>';
                } else {
                    $child_html .= '<li class="kt-menu__item " aria-haspopup="true">
                                        <a href="' . base_url($menu->url) . '" class="kt-menu__link ">
                                            <i class="kt-menu__link-icon ' . $menu->icon . '"></i>
                                            <span class="kt-menu__link-text">
                                            ' . $menu->judul . '
                                            </span>
                                        </a>
                                    </li>';
                }
            }
            return $child_html;
        };

        foreach ($menus as $key => $value) {
            if (!empty($value->child)) {
                $html .= '  <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="click">
                                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                    <i class="kt-menu__link-icon ' . $value->icon . '"></i>
                                    <span class="kt-menu__link-text">' . $value->judul . '</span>
                                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                </a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">';
                $html .=                $render_child($value->child);
                $html .= '          </ul>
                                </div>
                            </li>';
            } else {
                $html .= '  <li title="' . $value->judul . '" class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="click">
                                <a href="' . base_url($value->url) . '" class="kt-menu__link">
                                    <i class="kt-menu__link-icon ' . $value->icon . '"></i>
                                    <span class="kt-menu__link-text">' . $value->judul . '</span>
                                </a>
                            </li>';
            }
        }
        return $html;
    }

    public function load($view, $data = array(), $return = false)
    {
        // $role_id = $this->CI->session->userdata('role_id');
        $role_id = 1;
        $template_data['menus']     = $this->get_tree_menu($role_id);
        // $template_data = [
        //     'sidebar_menu' => $this->render_navigation_sidebar($menus)
        // ];

        $extend                     = $data['extend_view'] ?: 'layouts/app';
        $template_data['content']   = $this->CI->load->view($view, $data, true);
        $this->CI->load->view($extend, $template_data, $return);
    }

    public function load_auth($view, $data = array(), $return = false)
    {
        $template_data = [];

        $template_data['content'] = $this->CI->load->view($view, $data, true);
        $this->CI->load->view('layouts/auth', $template_data, $return);
    }
}
