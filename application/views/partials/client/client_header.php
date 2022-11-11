<nav class="navbar navbar-expand-sm">
    <div class="container-fluid">
        <a href="" class="navbar-brand">
            <img draggable="false" width="130" class="img-fluid" src="<?= base_url('public/images/main-logo.png') ?>" alt="">
        </a>

        <button id="button-menu-toggle" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="collapse navbar-collapse" id="main-navbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;" id="navbar-menu">
                <li class="nav-item">
                    <a class="nav-link text-white" href="">Discover</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="">Icon Styles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="">Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
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
                                    <input type="email" name="email" class="form-control" placeholder="email"use>
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
                                    <input type="password" name="kon_password" class="form-control"placeholder="Confirmation Password">
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