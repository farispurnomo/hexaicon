<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    private $namespace    = 'pages/admin/dashboard/dashboard_';
    private $route        = 'admin/dashboard';
    private $pagetitle    = 'Dashboard';
    private $extend_view  = 'layouts/admin';

    public function __construct()
    {
        parent::__construct();

        if (!getUserLogin()) redirect('admin/auth/login');

        $this->load->model('M_admin_dashboard');
    }

    public function index()
    {
        $data['extend_view']            = $this->extend_view;
        $data['pagetitle']              = $this->pagetitle;
        $data['subheaders']             = ['Dashboard' => base_url($this->route . '.index')];

        $downloaded                     = $this->M_admin_dashboard->doGetIconDownloadedData();

        $categories                     = $downloaded->categories;
        $categories[0]                  = '';
        $categories[count($categories)] = '';

        $chart_icon_downloaded          = array(
            'categories'                    => $categories,
            'series'                            => array([
                'name'                              => "Downloaded",
                'data'                              => $downloaded->series
            ])
        );

        $today                          = date('Y-m-d');

        $data['chart_downloaded']       = json_encode($chart_icon_downloaded);
        $data['total_icons']            = $this->M_admin_dashboard->doCountTotalIcons();
        $data['total_clients']          = $this->M_admin_dashboard->doCountTotalClients();
        $data['total_downloads']        = $this->M_admin_dashboard->doCountTotalDownloads($today);

        $categories                     = $this->M_admin_dashboard->doGetMostDownloadedCategories();
        $data['most_downloaded']        = array(
            // 'average'                       => $this->M_admin_dashboard->doGetAverageDownloads(),
            'categories'                    => $categories
        );

        $transactions                   = $this->M_admin_dashboard->doGetLatestTransaction();
        $transactions                   = array_map(function ($transaction) {
            switch ($transaction->status_id) {
                case TRANSACTION_STATUS_PENDING:
                    $transaction->status_html   = '<span class="badge py-3 px-4 fs-7 badge-light-warning">Pending</span>';
                    break;

                case TRANSACTION_STATUS_SUCCESS:
                    $transaction->status_html   = '<span class="badge py-3 px-4 fs-7 badge-light-success">Success</span>';
                    break;

                case TRANSACTION_STATUS_FAILED:
                    $transaction->status_html   = '<span class="badge py-3 px-4 fs-7 badge-light-danger">Failed</span>';
                    break;

                default:
                    $transaction->status_html   = '';
                    break;
            }

            $transaction->created               = timespan(strtotime($transaction->created_at),  now(), 1) . ' ago';

            return $transaction;
        }, $transactions);

        $data['latest_transactions']    = array(
            'average'                       => $this->M_admin_dashboard->doGetAverageTransactions(),
            'transactions'                  => $transactions
        );

        $this->template->load($this->namespace . 'index', $data);
    }
}
