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
                    <?php if (getClientLogin()) : ?>
                        <a class="nav-link btn btn-login" href="<?= base_url('client/dashboard') ?>">Dashboard</a>
                    <?php else : ?>
                        <a class="nav-link btn btn-login" href="<?= base_url('client/auth/login') ?>">Login</a>
                    <?php endif ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="offcanvas bg-hi-primary offcanvas-start w-100" tabindex="-1" id="offcanvasSidebar">
    <div class="offcanvas-header">
        <button type="button" class="btn-close btn-close-white pe-4 pt-5" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <h5 class="offcanvas-title">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 52 52" fill="white">
                    <path d="M10.333,58A4.157,4.157,0,0,1,7.3,56.7,4.157,4.157,0,0,1,6,53.667V10.333A4.157,4.157,0,0,1,7.3,7.3,4.157,4.157,0,0,1,10.333,6H31.35v4.333H10.333V53.667H31.35V58Zm35.1-13.361-3.106-3.106,7.367-7.367H24.417V29.833H49.55l-7.367-7.367,3.106-3.106L58,32.072Z" transform="translate(-6 -6)" />
                </svg>
            </div>
        </h5>
    </div>
    <div class="offcanvas-body p-0 position-relative">
        <ul class="px-4">
            <li>
                <a href="<?= base_url('icon_discover') ?>" class="text-decoration-none">
                    Discover
                </a>
            </li>
            <li>
                <a href="<?= base_url('icon_styles') ?>" class="text-decoration-none">
                    Icon Styles
                </a>
            </li>
            <li>
                <a href="<?= base_url('subscription') ?>" class="text-decoration-none">
                    Pricing
                </a>
            </li>
            <li>
                <a href="<?= base_url('search') ?>" class="text-decoration-none">
                    Search
                </a>
            </li>
        </ul>
    </div>
</div>