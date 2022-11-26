<style>
    input {
        border: 0;
        outline: 0;
        border-bottom: 2px solid;
        font-size: 1.4rem;
    }
</style>
<div class="row mt-5 pt-5">
    <div class="col-md-12 text-center">

        <div>
            <h1 class="fw-bold">
                Login
            </h1>
            <div class="text-center mt-5">
                <form action="<?= base_url('admin/auth/auth/login') ?>" method="post">
                    <span>
                        Login to access the your panel dashboard.
                    </span><br>
                    <span>
                        Did you <a href="<?= base_url('admin/auth/auth/index_forget') ?>"><b class="text-danger"> forgot your password ?</b></a>
                    </span>
                    <?php if ($this->session->flashdata('login')) { ?>
                        <div class="row justify-content-md-center mt-5 px-1">
                            <div class="col-md-2">
                                <div class="alert alert-danger" role="alert">
                                    <?=$this->session->flashdata('login')?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('success')) { ?>
                        <div class="row justify-content-md-center mt-5 px-1">
                            <div class="col-md-2">
                                <div class="alert alert-success" role="alert">
                                    <?=$this->session->flashdata('success')?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row justify-content-md-center mt-2 px-1 p-5">

                        <div class="text-center col-md-2">
                            <input type="text" placeholder="Email" id="inputPassword5" required name="email" class="">
                        </div>

                    </div>
                    <div class="row justify-content-md-center pt-2 px-1">
                        <div class="text-center col-md-2">
                            <input type="password" placeholder="Password" name="password" required class="">
                        </div>
                    </div>

                    <div class="row justify-content-md-center pt-5 px-1">
                        <div class="col-md-2">
                            <button type="submit" class="form-control text-light" style="background-image: url(<?= base_url('public/images/auth/btn.png') ?>);">
                                Login
                            </button>
                        </div>
                    </div>


                </form>

            </div>
        </div>



    </div>
    <!-- <div class="col-md">
        cc
    </div> -->
</div>