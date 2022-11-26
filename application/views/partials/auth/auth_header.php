<div class="position-absolute top-0 end-0" style="z-index: -1;">
    <img class="img-fluid" src="<?= base_url() . 'public/images/auth/Vector19.png' ?>" />
</div>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img class="img-fluid" src="<?= base_url() . 'public/images/auth/logo.png' ?>" />
        </div>
        <div class="col-md-6" style="z-index: 1;">
            <ul class="nav nav-pills justify-content-end ">
                <li class="nav-item" style="--bs-nav-pills-link-active-bg: transparent;--bs-nav-pills-link-active-color: white;--bs-nav-link-color: white;">
                    <a class="nav-link" href="#">Discover</a>
                </li>
                <li class="nav-item" style="--bs-nav-pills-link-active-bg: transparent;--bs-nav-pills-link-active-color: white;--bs-nav-link-color: white;">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <?php
                if ($link == 'login') { ?>
                    <li class="nav-item" style="--bs-nav-pills-link-active-bg: transparent;--bs-nav-pills-link-active-color: white;--bs-nav-link-color: white;">
                        <a class="nav-link" href="<?= base_url('admin/auth/auth/index_register') ?>">Register</a>
                    </li>
                <?php  } else { ?>
                    <li class="nav-item" style="--bs-nav-pills-link-active-bg: transparent;--bs-nav-pills-link-active-color: white;--bs-nav-link-color: white;">
                        <a class="nav-link" href="<?= base_url('admin/auth/auth/login') ?>">Login</a>
                    </li>
                <?php } ?>

            </ul>
        </div>
    </div>
</div>