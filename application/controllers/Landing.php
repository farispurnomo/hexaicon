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

    // public function dummy_icon_subscription()
    // {
    //     $generate_rand_subscriptions = function ($min = 1, $max = 3) {
    //         if ($min === 1) {
    //             $weights = array(1 => 0.2, 2 => 0.3, 3 => 0.5);
    //         } else if ($min === 2) {
    //             $weights = array(2 => 0.5, 3 => 0.5);
    //         } else {
    //             $weights = array(3 => 1);
    //         }

    //         $rand = (float)rand() / (float)getrandmax();
    //         foreach ($weights as $value => $weight) {
    //             if ($rand < $weight) {
    //                 $result = $value;
    //                 break;
    //             }
    //             $rand -= $weight;
    //         }

    //         for ($i = $result; $i <= 3; $i++) {
    //             $subscription_ids[] = $i;
    //         }
    //         return $subscription_ids;
    //     };

    //     // echo '<pre>';
    //     // print_r($generate_rand_subscriptions(1, 3));
    //     // exit;

    //     // $generate_rand_subscriptions = function ($min = 1, $max = 3) {
    //     //     $subscription_ids       = [];
    //     //     $random                 = rand($min, $max);

    //     //     for ($i = 1; $i <= $random; $i++) {
    //     //         $subscription_ids[] = $i;
    //     //     }
    //     //     return $subscription_ids;
    //     // };

    //     $insert_icon_format = function ($icon_id, $format_name, $min_plan_id) use ($generate_rand_subscriptions) {
    //         $guest_access = '0';
    //         if ($min_plan_id === 1) {
    //             $guest_access = '1';
    //         }

    //         $icon_formats               = array(
    //             'icon_id'                   => $icon_id,
    //             'name'                      => $format_name,
    //             'guest_access'              => $guest_access,
    //             'created_at'                => date('Y-m-d H:i:s')
    //         );

    //         $this->db->insert('mst_icon_formats', $icon_formats);
    //         $insert_id                  = $this->db->insert_id();

    //         $subscription_ids           = $generate_rand_subscriptions($min_plan_id, 3);
    //         $format_subscriptions       = [];
    //         foreach ($subscription_ids as  $subscription_id) {
    //             $format_subscriptions[] = array(
    //                 'icon_format_id'        => $insert_id,
    //                 'subscription_plan_id'  => $subscription_id
    //             );
    //         }

    //         if (!empty($format_subscriptions)) {
    //             $this->db->insert_batch('mst_icon_format_subscriptions', $format_subscriptions);
    //         }
    //     };

    //     // $this->db->delete('mst_icon_subscriptions');
    //     // $this->db->delete('mst_icon_format_subscriptions');
    //     // $this->db->delete('mst_icon_formats');

    //     $icons = $this->db->get('mst_icons')->result();

    //     $this->db->trans_start();
    //     foreach ($icons as $icon) {
    //         $subscription_ids           = $generate_rand_subscriptions(1, 3);
    //         $icon_subscriptions         = [];
    //         foreach ($subscription_ids as $subscription_id) {
    //             $icon_subscriptions[]   = array(
    //                 'icon_id'               => $icon->id,
    //                 'subscription_plan_id'  => $subscription_id,
    //                 'created_at'            => date('Y-m-d H:i:s')
    //             );
    //         }

    //         if (!empty($icon_subscriptions)) {
    //             $this->db->insert_batch('mst_icon_subscriptions', $icon_subscriptions);
    //         }

    //         $min_plan_id                = min($subscription_ids);
    //         $insert_icon_format($icon->id, 'svg', $min_plan_id);
    //         $insert_icon_format($icon->id, 'png', $min_plan_id);

    //         $guest_access = '0';
    //         if ($min_plan_id === 1) {
    //             $guest_access = '1';
    //         }

    //         $this->db
    //             ->where('id', $icon->id)
    //             ->update('mst_icons', ['guest_access' => $guest_access]);
    //     }

    //     $this->db->trans_complete();
    // }
}
