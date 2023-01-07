<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hexaicons <?= isset($pagetitle) ? "| $pagetitle" : '' ?></title>

    <link rel="stylesheet" href="<?= base_url('public/vendor/bootstrap-5.2.0/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('public/vendor/fontawesome-free-6.1.1-web/css/all.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('public/vendor/animate/animate.min.css') ?>" />

    <link rel="stylesheet" href="<?= base_url('public/css/client_auth.css') ?>?v<?= $this->config->item('app_version_summary') ?>">

    <link rel="shortcut icon" href="<?= base_url('public/images/min-logo-color.png') ?>" />
    <base href="<?= site_url() ?>">
</head>

<body>
    <script src="<?= base_url('public/vendor/bootstrap-5.2.0/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('public/vendor/jquery-3.6.1/jquery-3.6.1.min.js') ?>"></script>

    <?php $this->load->view('partials/client/auth/auth_header'); ?>

    <main id="main-content">
        <?= $content ?>
    </main>

</body>

</html>