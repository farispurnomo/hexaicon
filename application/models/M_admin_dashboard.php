<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_admin_dashboard extends CI_Model
{
    private $table_log_downloads        = 'log_downloads';
    private $table_log_subscriptions    = 'log_subscriptions';

    private $table_categories           = 'mst_icon_categories';
    private $table_icons                = 'mst_icons';
    private $table_clients              = 'mst_clients';
    private $table_status_transactions  = 'mst_status_transactions';

    public function doCountTotalDownloads($date)
    {
        $download =  $this->db
            ->from($this->table_log_downloads)
            ->where('DATE(date)', $date)
            ->get()
            ->row();

        $total = 0;
        if ($download) {
            $total = $download->total;
        }
        return $total;
    }

    public function doCountTotalIcons()
    {
        return $this->db
            ->from($this->table_icons)
            ->count_all_results();
    }

    public function doCountTotalClients()
    {
        return $this->db
            ->from($this->table_clients)
            ->count_all_results();
    }

    public function doGetIconDownloadedData()
    {
        $categories         = array();
        $series             = array();

        $i = 22;
        while ($i >= 0) {
            $download       = $this->db
                ->from($this->table_log_downloads)
                ->where('DATE(date)', date('Y-m-d', strtotime("-$i days")))
                ->get()
                ->row();

            $total          = 0;
            if ($download) {
                $total      = $download->total;
            }

            $categories[]   = date('M d', strtotime("-$i days"));
            $series[]       = $total;
            $i--;
        }

        return (object) array(
            'categories'    => $categories,
            'series'        => $series
        );
    }

    public function doGetMostDownloadedCategories()
    {
        $categories                 = $this->db
            ->select("
                $this->table_categories.*,
                (SELECT COUNT(*) FROM $this->table_icons WHERE $this->table_categories.id = $this->table_icons.category_id) AS total_icons,
                (SELECT SUM(number_of_downloads) FROM $this->table_icons WHERE $this->table_categories.id = $this->table_icons.category_id) AS number_of_downloads
            ")
            ->from($this->table_categories)
            ->order_by('number_of_downloads', 'DESC')
            ->limit(7)
            ->get()
            ->result();

        $sum_number_of_downloads    = array_sum(array_column($categories, 'number_of_downloads'));

        foreach ($categories as &$category) {
            $average                = $category->number_of_downloads / $sum_number_of_downloads * 100;
            $category->average      = round($average);

            $path                   = ($category->image ? $category->image : '/public/images/no_image.png');
            $category->url_image    = base_url($path);
        }

        return $categories;
    }

    public function doGetLatestTransaction()
    {
        return $this->db
            ->select("
                $this->table_log_subscriptions.*,
                $this->table_status_transactions.name AS status_name
            ")
            ->from($this->table_log_subscriptions)
            ->join($this->table_status_transactions, "$this->table_status_transactions.id=$this->table_log_subscriptions.status_id")
            ->order_by('created_at', 'DESC')
            ->limit(7)
            ->get()
            ->result();
    }

    public function doGetAverageTransactions()
    {
        $subscriptions  = $this->db
            ->select("
                DATE_FORMAT(created_at, '%Y-%m') AS bulan, 
                COUNT(*) AS total
            ")
            ->from($this->table_log_subscriptions)
            ->group_by('bulan')
            ->get()
            ->result();

        $averages = array_column($subscriptions, 'total');

        $average  = 0;
        if ($total_data = count($averages)) {
            $average  = array_sum($averages) / $total_data;
        }

        return $average;
    }
}
