<div class="container">
    <div class="row">
        <div class="col-xl-4 m-auto">
            <div class="text-center">
                <div class="mb-5 text-center">
                    <h2 class="fw-bold">Reset Your Password</h2>
                    <hr class="mt-2" />
                </div>
                <div class="mb-5">
                    <div>Create new password.</div>
                    <div>Please input your new password for <span class="text-danger fw-bold"><?= $token_data->email ?></span></div>
                </div>
            </div>

            <form action="<?= base_url('client/auth/reset_password_act') ?>" method="post" autocomplete="off">
                <input type="hidden" name="_token" value="<?= $token_data->token ?>">
                <input type="hidden" name="_email" value="<?= $token_data->email ?>">

                <?php if ($message = $this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle"></i> <?= $message ?>
                    </div>
                <?php endif ?>

                <div class="form__group form__group_icon mb-3">
                    <input type="password" name="password" minlength="6" id="password" class="form__field" placeholder="Password" required>
                    <label for="password" class="form__label">Password</label>
                    <span class="form__icon_append toggle-password"><i class="fa fa-eye"></i></span>
                </div>

                <div class="form__group form__group_icon mb-3">
                    <input type="password" name="confirm_password" id="confirm_password" class="form__field" placeholder="Confirm Password" required>
                    <label for="confirm_password" class="form__label">Confirm Password</label>
                    <span class="form__icon_append toggle-password"><i class="fa fa-eye"></i></span>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn py-2 btn-hi-primary">Reset Password</button>
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
        width: 5rem;
        margin: auto;
    }
</style>

<script>
    let is_show_password = true;
    $(function() {
        $(document).on('click', '.toggle-password', function() {
            if (is_show_password) {
                $(this).parent().find('input').attr('type', 'text');

                $(this)
                    .parent()
                    .find('i')
                    .addClass('fa-eye-slash')
                    .removeClass('fa-eye');
            } else {
                $(this).parent().find('input').attr('type', 'password');

                $(this)
                    .parent()
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