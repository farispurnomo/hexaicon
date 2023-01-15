<?php defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends CI_Controller
{
    protected $namespace    = 'pages/client/landing/landing_';
    protected $extend_view  = 'layouts/client';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_landing');
    }

    public function index()
    {
        $data['extend_view']    = $this->extend_view;
        $data['subscriptions']  = $this->M_landing->getSubscriptions();

        $this->template->load($this->namespace . 'index', $data);
    }

    // public function import(){
    //     // style -> category -> icon

    //     $basepath   = FCPATH . 'public\\uploads\\hexaicons_assets\\';
    //     $targetpath = FCPATH . 'public\\uploads\\icons\\';

    //     $recursive = function ($paths, $filepath) use ($targetpath, &$recursive) {
    //         foreach ($paths as $key => $path) {
    //             if (is_array($path)) {
    //                 $recursive($path, $filepath . $key);
    //             } else {
    //                 $ext = pathinfo($filepath . $path, PATHINFO_EXTENSION);
    //                 if ($ext === 'svg') {
    //                     $filename   = $filepath . $path;
    //                     $filename   = explode('\\', $filename);
    //                     // echo '<pre>';
    //                     // print_R($filename);
    //                     // exit;

    //                     $category   = $filename[count($filename) - 2];

    //                     $style      = $filename[count($filename) - 3];
    //                     $style      = ucfirst(strtolower($style));

    //                     $name       = str_replace('-svgrepo-com', '', $path);
    //                     $name       = str_replace('-', ' ', $name);
    //                     $name       = str_replace('.svg', ' ', $name);

    //                     $category_record   = $this->db->get_where('mst_icon_categories', [
    //                         'name'  => $category
    //                     ])->row();

    //                     if ($category_record) {
    //                         $category_id    = $category_record->id;
    //                     } else {
    //                         $this->db->insert('mst_icon_categories', [
    //                             'name'  => $category
    //                         ]);
    //                         $category_id    = $this->db->insert_id();
    //                     }

    //                     $style_record   = $this->db->get_where('mst_icon_styles', [
    //                         'name'  => $style
    //                     ])->row();

    //                     if ($style_record) {
    //                         $style_id    = $style_record->id;
    //                     } else {
    //                         $this->db->insert('mst_icon_styles', [
    //                             'name'  => $style
    //                         ]);
    //                         $style_id    = $this->db->insert_id();
    //                     }

    //                     $this->db->insert('mst_icons', [
    //                         'style_id'      => $style_id,
    //                         'category_id'   => $category_id,
    //                         'name'          => $name,
    //                         'image'         => '/public/uploads/icons/' . $path
    //                     ]);

    //                     copy($filepath . $path, $targetpath . $path);
    //                 }
    //             }
    //         }
    //     };

    //     $this->load->helper('directory');
    //     $dir = directory_map($basepath);

    //     $this->db->trans_start();
    //     $recursive($dir, $basepath);
    //     $this->db->trans_complete();
    // }
}
