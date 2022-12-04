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
                    <a class="nav-link nav-text px-3" href="">Pricing</a>
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
                    <a class="nav-link btn btn-login" href="<?= base_url('login') ?>">Login</a>
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
                <a href="<?= base_url('pricing') ?>" class="text-decoration-none">
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

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Login / Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Login</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Register" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Register</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="login">
                        <div class="card-body p-4 p-sm-5">
                            <!-- <h5 class="card-title text-center mb-5 fw-light fs-5">Login</h5> -->
                            <form id="form_login">
                                <div class="form-floating mb-3" id="alert">
                                    <!-- <div class="alert alert-danger" role="alert">
                                        A simple success alert—check it out!
                                    </div> -->
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="email" use>
                                    <label for="floatingInput">Email address</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                                    <label for="floatingPassword">Password</label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="" id="rememberPasswordCheck">
                                    <label class="form-check-label" for="rememberPasswordCheck">
                                        Remember password
                                    </label>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-login text-uppercase fw-bold" type="button" id="btn_login">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="Register">
                        <form id="form_register">
                            <div class="form-floating mb-3" id="alert_register">
                                <!-- <div class="alert alert-danger" role="alert">
                                        A simple success alert—check it out!
                                    </div> -->
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" placeholder="email">
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="kon_password" class="form-control" placeholder="Confirmation Password">
                                <label for="floatingPassword">Confirmation Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Name">
                                <label for="floatingInput">Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="telpon" class="form-control" placeholder="Phone">
                                <label for="floatingPassword">Phone</label>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="button" id="btn_register">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
        </div>
    </div>
</div>