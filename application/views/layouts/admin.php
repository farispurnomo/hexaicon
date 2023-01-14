<!DOCTYPE html>
<html lang="en">

<head>
    <title>Hexaicons <?php if (isset($pagetitle)) echo '| ' . $pagetitle ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />

    <link rel="shortcut icon" href="<?= base_url('public/images/min-logo-color.png') ?>" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	
	<link href="<?= base_url() ?>public/src/plugins/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>public/src/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>public/src/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="<?= base_url('public/vendor/animate/animate.min.css') ?>" />

    <base href="<?= base_url() ?>">
	
	<script src="<?= base_url() ?>public/src/plugins/global/plugins.bundle.js"></script>
    <script src="<?= base_url() ?>public/src/js/scripts.bundle.js"></script>

	<script src="<?= base_url() ?>public/src/plugins/datatables/datatables.bundle.js"></script>
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">

            <?php $this->load->view('partials/admin/admin_sidebar'); ?>

            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php $this->load->view('partials/admin/admin_header'); ?>

                <div class="content d-flex flex-column flex-column-fluid p-0" id="kt_content">

                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <?= $content ?>
                    </div>

                    <?php $this->load->view('partials/admin/admin_footer'); ?>
                </div>
            </div>
        </div>
    </div>
	

    <!--<script src="<?= base_url() ?>public/src/js/custom/widgets.js"></script>
    <script src="<?= base_url() ?>public/src/js/custom/apps/chat/chat.js"></script>
    <script src="<?= base_url() ?>public/src/js/custom/modals/create-app.js"></script>
    <script src="<?= base_url() ?>public/src/js/custom/modals/upgrade-plan.js"></script>-->
</body>

</html>