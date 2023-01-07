<?php $is_landing = $this->uri->segment(1) == ''; ?>
<nav class="navbar navbar-expand-lg sticky-top px-md-5 <?php if ($is_landing) echo 'bg-hi-primary' ?>" id="main-navbar">
    <div class="container-fluid">
        <a href="<?= base_url('/') ?>" class="navbar-brand">
            <?php if ($is_landing) : ?>
                <img draggable="false" width="130" class="img-fluid" src="<?= base_url('public/images/main-logo.png') ?>" alt="">
            <?php else : ?>
                <img draggable="false" width="130" class="img-fluid" src="<?= base_url('public/images/logo-color2.png') ?>" alt="">
            <?php endif ?>
        </a>

        <button id="button-menu-toggle" class="d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="collapse navbar-collapse" id="main-navbar-menu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;" id="navbar-menu">
                <li class="nav-item">
                    <a class="nav-link nav-text px-3" href="<?= base_url('icon_discover') ?>">Discover</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-text px-3" href="">Icon Styles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-text px-3" href="<?= base_url('subscription') ?>">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-0 px-3" href="">
                        <div class="search">
                            <svg width="24" height="24" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.3333 31.6667C25.6971 31.6667 31.6667 25.6971 31.6667 18.3333C31.6667 10.9695 25.6971 5 18.3333 5C10.9695 5 5 10.9695 5 18.3333C5 25.6971 10.9695 31.6667 18.3333 31.6667Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M35 35L27.75 27.75" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-login" href="<?= base_url('admin/auth/auth/login') ?>">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
