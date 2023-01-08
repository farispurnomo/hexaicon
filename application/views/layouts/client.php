<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hexaicons</title>

    <link rel="stylesheet" href="<?= base_url('public/vendor/bootstrap-5.2.0/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('public/vendor/fontawesome-free-6.1.1-web/css/all.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('public/vendor/animate/animate.min.css') ?>" />

    <link rel="stylesheet" href="<?= base_url('public/css/client.css') ?>?v<?= $this->config->item('app_version_summary') ?>">

    <link rel="shortcut icon" href="<?= base_url('public/images/min-logo-color.png') ?>" />
    <base href="<?= site_url() ?>">
</head>

<body>
    <?php $this->load->view('partials/client/client_header'); ?>

    <?= $content ?>

    <!-- Toastr -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img width="24" src="<?= base_url('public/images/min-logo-color.png') ?>" class="rounded me-2" alt="...">
                <strong class="me-auto" id="toast-title">Success</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toast-msg">
                Data Successfuly Saved
            </div>
        </div>
    </div>
    <!-- Toastr -->

    <footer class="bg-black">
        <?php $this->load->view('partials/client/client_footer'); ?>
    </footer>
    <script>
        const base_url = "<?=base_url()?>";
    </script>
    <script src="<?= base_url('public/vendor/bootstrap-5.2.0/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('public/vendor/jquery-3.6.1/jquery-3.6.1.min.js') ?>"></script>
    <script src="<?= base_url('public/vendor/wow/wow.min.js') ?>"></script>
    <script type="module" src="<?= base_url('public/js/client.js') ?>?v<?= $this->config->item('app_version_summary') ?>"></script>
</body>

</html>