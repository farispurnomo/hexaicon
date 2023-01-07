<div class="container">
    <div class="row">
        <div class="col-xl-4 m-auto">
            <div class="text-center">
                <div class="mb-5 d-flex justify-content-center">
                    <div>
                        <h2 class="fw-bold">Login</h2>
                        <hr class="mt-2"/>
                    </div>
                </div>
                <div class="mb-5">
                    <div>Login to access the your panel dashboard.</div>
                    <div>Did you <a href="<?= base_url('client/auth/forget') ?>" class="fw-bold text-hi-primary text-decoration-none">forget yout password?</a></div>
                </div>
            </div>

            <form action="<?= base_url('client/auth/login_act') ?>" method="post" autocomplete="off">

                <?php if ($message = $this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle"></i> <?= $message ?>
                    </div>
                <?php endif ?>

                <div class="form__group mb-3">
                    <input type="email" name="email" id="email" class="form__field" placeholder="Your Email" required autofocus>
                    <label for="email" class="form__label">Your Email</label>
                </div>

                <div class="form__group form__group_icon mb-3">
                    <input type="password" name="password" id="password" class="form__field" placeholder="Password" required>
                    <label for="password" class="form__label">Password</label>
                    <span class="form__icon_append" id="toggle-password"><i class="fa fa-eye"></i></span>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn py-2 btn-hi-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .row {
        min-height: 90vh;
    }

    hr {
        border: 2px solid black;
        opacity: 1;
        border-radius: 10px;
    }
</style>

<script>
    let is_show_password = true;
    $(function() {
        $(document).on('click', '#toggle-password', function() {
            if (is_show_password) {
                $('#password').attr('type', 'text');

                $(this)
                    .find('i')
                    .addClass('fa-eye-slash')
                    .removeClass('fa-eye');
            } else {
                $('#password').attr('type', 'password');

                $(this)
                    .find('i')
                    .addClass('fa-eye')
                    .removeClass('fa-eye-slash');
            }

            is_show_password = !is_show_password;
        });

        $(document).on('submit', 'form', function() {
            const html = '<i class="fa fa-spin fa-spinner"></i> Please wait ....'

            $(this)
                .find('button[type="submit"]')
                .prop('disabled', true)
                .html(html);
        });
    })
</script>