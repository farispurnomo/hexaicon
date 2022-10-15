<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="<?= base_url('public/vendor/bootstrap-5.2.0/css/bootstrap.min.css') ?>"/>
    <link rel="stylesheet" href="<?= base_url('public/vendor/fontawesome-free-6.1.1-web/css/all.min.css') ?>"/>

    <link rel="shortcut icon" href="<?= base_url('public/images/mini-logo.png') ?>" />
</head>

<body>
    <header>
        <img src="<?=base_url('public/images/main-logo.png')?>" alt="">
        <ul>
            <li>Discover</li>
            <li>Icon Styles</li>
            <li>Pricing</li>
            <li>search</li>
            <li>
                <button class="btn btn-white">
                    Login
                </button>
            </li>
        </ul>
    </header>

    <?= $content ?>

    <footer class="bg-black">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="pt-4 pb-2">
                        <img class="img-fluid" width="150" src="<?= base_url('public/images/main-logo.png')?>" alt="">
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-white">
                            Hexaicons internet's icon library. We've got 5,000+ in more than 9 categories accross 3 styles. Get icons into your projects fast with Hexaicons.
                        </div>
                        <div class="col-md-4">
                            <div class="text-white">Icon Set</div>
                            <ul>
                                <li class="text-white">
                                    <a href="" class="text-decoration-none text-white">Solid</a>
                                </li>
                                <li class="text-white">
                                    <a href="" class="text-decoration-none text-white">Thin</a>
                                </li>
                                <li class="text-white">
                                    <a href="" class="text-decoration-none text-white">Regular</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="text-white">Service</div>
                            <ul>
                                <li class="text-white">
                                    <a href="" class="text-decoration-none text-white">FAQ</a>
                                </li>
                                <li class="text-white">
                                    <a href="" class="text-decoration-none text-white">About Us</a>
                                </li>
                                <li class="text-white">
                                    <a href="" class="text-decoration-none text-white">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr style="border: 5px solid #CB356B">
            <div class="row">
                <div class="col-md-6 text-white">
                    &copy; 2022 Hexaicons Teams
                </div>
                <div class="col-md-6 text-end">
                    <a href="" class="text-white text-decoration-none">
                        Privacy Policy
                    </a>
                    <a href="" class="text-white text-decoration-none">
                        Terms of Service
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="<?= base_url('public/vendor/bootstrap-5.2.0/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('public/vendor/jquery-3.6.1/jquery-3.6.1.min.js') ?>"></script>
    <script src="<?= base_url('public/js/app.js') ?>"></script>
</body>

</html>