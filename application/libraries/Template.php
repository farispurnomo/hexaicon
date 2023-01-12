<?php defined('BASEPATH') or exit('No direct script access allowed');

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
                if (!empty($menu['childs'])) {
                    $child_html   .= '
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="' . $menu['icon'] . '"></i>
                                </span>
                                <span class="menu-title">' . $menu['title'] . '</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion menu-active-bg">';
                    $child_html   .=                $render_child($menu['childs']);
                    $child_html   .= '
                            </div>
                        </div>';
                } else {
                    $child_html .= '<div class="menu-item">
                                        <a class="menu-link" href="' . base_url($menu['url']) . '">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">' . $menu['title'] . '</span>
                                        </a>
                                    </div>';
                }
            }
            return $child_html;
        };

        foreach ($menus as $key => $value) {
            if (!empty($value['childs'])) {
                $html   .= '
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="' . $value['icon'] . '"></i>
                                </span>
                                <span class="menu-title">' . $value['title'] . '</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion menu-active-bg">';
                $html   .=                $render_child($value['childs']);
                $html   .= '
                            </div>
                        </div>';
            } else {
                $html   .= '
                        <div class="menu-item">
                            <a class="menu-link py-3" href="' . base_url($value['url']) . '" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                <span class="menu-icon">
                                    <i class="' . $value['icon'] . '"></i>
                                </span>
                                <span class="menu-title">' . $value['title'] . '</span>
                            </a>
                        </div>';
            }
        }
        return $html;
    }

    public function load($view, $data = array(), $return = false)
    {
        $template_data['user']              = getUserLogin();
        if ($template_data['user']) {
            $role_id                        = $template_data['user']->role_id ?? null;
            $menus                          = $this->get_tree_menu($role_id);
            $template_data['sidebar_menu']  = $this->render_navigation_sidebar($menus);
        }

        $extend                         = $data['extend_view'] ?: 'layouts/app';
        $template_data['content']       = $this->CI->load->view($view, $data, true);
        $this->CI->load->view($extend, $template_data, $return);
    }
}
