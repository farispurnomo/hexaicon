<div class="container animate__animated animate__fadeIn">
    <div class="row">
        <div class="col-xl-4 m-auto">
            <div class="text-center">
                <div class="mb-5 text-center">
                    <h2 class="fw-bold">Forget Password</h2>
                    <hr class="mt-2" />
                </div>
                <div class="mb-5">
                    <div>Please enter your email below to receive yout password reset instruction.</div>
                </div>
            </div>

            <form action="<?= base_url('client/auth/send_reset_password_token') ?>" method="post" autocomplete="off">

                <?php if ($message = $this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle"></i> <?= $message ?>
                    </div>
                <?php endif ?>

                <?php if ($message = $this->session->flashdata('success')) : ?>
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle"></i> <?= $message ?>
                    </div>
                <?php endif ?>

                <div class="form__group mb-3">
                    <input type="email" name="email" id="email" class="form__field" placeholder="Your Email" required autofocus>
                    <label for="email" class="form__label">Your Email</label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn py-2 btn-hi-primary">Send Verification Code</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        $(document).on('submit', 'form', function() {
            const html = '<i class="fa fa-spin fa-spinner"></i> Please wait ....'

            $(this)
                .find('button[type="submit"]')
                .prop('disabled', true)
                .html(html);
        });
    });
</script>

<style>
    .row {
        min-height: 90vh;
    }

    hr {
        border: 2px solid black;
        opacity: 1;
        border-radius: 10px;
        width: 6rem;
        margin: auto;
    }
</style>