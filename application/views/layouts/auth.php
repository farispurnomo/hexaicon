<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="<?= base_url('public/vendor/bootstrap-5.2.0/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('public/vendor/fontawesome-free-6.1.1-web/css/all.min.css') ?>" />

    <link rel="shortcut icon" href="<?= base_url('public/images/mini-logo.png') ?>" />
</head>

<body>
    <!-- <div class="position-relative"> -->
    
    <!-- </div> -->
    <?php $this->load->view('partials/auth/auth_header'); ?>

    <?php $this->load->view($content); ?>

    

    <footer class="bg-black">
        <!-- <?php $this->load->view('partials/client/client_footer'); ?> -->
    </footer>
    <script>
        const base_url = "<?= base_url() ?>";
    </script>
    <script src="<?= base_url('public/vendor/bootstrap-5.2.0/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('public/vendor/jquery-3.6.1/jquery-3.6.1.min.js') ?>"></script>
</body>

</html>