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
                Register
            </h1>
            <div class="text-center mt-5">
                <form action="<?= base_url('admin/auth/auth/register') ?>" method="post">
                

                    <span>
                    Create an new account.
                    </span><br>
                    <span>
                    Already a member,  <a href="<?= base_url('admin/auth/auth/') ?>"><b class="text-danger"> Login? </b></a>
                    </span>
                    <?php if ($this->session->flashdata('register')) { ?>
                        <div class="row justify-content-md-center mt-5 px-1">
                            <div class="col-md-2">
                                <div class="alert alert-danger" role="alert">
                                    <?=$this->session->flashdata('register')?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row justify-content-md-center mt-2 px-1 pt-5 pb-2">

                        <div class="text-center col-md-2">
                            <input type="text" placeholder="Email"required name="email" class="">
                        </div>

                    </div>
                    <div class="row justify-content-md-center pt-2 px-1 pb-2">
                        <div class="text-center col-md-2">
                            <input type="password" placeholder="Password" name="password" required class="">
                        </div>
                    </div>
                    <div class="row justify-content-md-center pt-2 px-1 pb-2">
                        <div class="text-center col-md-2">
                            <input type="password" placeholder="Confirm Password" name="ulpassword" required class="">
                        </div>
                    </div>

                    <div class="row justify-content-md-center pt-5 px-1">
                        <div class="col-md-2">
                            <button type="submit" class="form-control text-light" style="background-image: url(<?= base_url('public/images/auth/btn.png') ?>);">
                                Register
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