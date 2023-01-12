<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
    <title>Hexaicons</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />

    <link rel="shortcut icon" href="<?= base_url('public/images/min-logo-color.png') ?>" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <link href="<?= base_url('public/src/') ?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('public/src/') ?>css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('public/vendor/') ?>animate/animate.min.css" rel="stylesheet" type="text/css" />

    <base href="<?= base_url() ?>">
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="bg-body">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(<?= base_url('public/src/') ?>media/illustrations/sketchy-1/14.png">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20 animate__animated animate__fadeInDown">
                <!--begin::Logo-->
                <a href="" class="mb-12">
                    <img alt="Logo" src="<?= base_url('public/images/') ?>logo-color2.png" class="h-40px" />
                </a>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <?= $content ?>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = '<?= base_url('public/src/') ?>';
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="<?= base_url('public/src/') ?>plugins/global/plugins.bundle.js"></script>
    <script src="<?= base_url('public/src/') ?>js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="<?= base_url('public/src/') ?>js/custom/authentication/sign-in/general.js"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>