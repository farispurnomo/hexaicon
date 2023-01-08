<div class="container">
    <div class="row">
        <div class="col-xl-4 m-auto">
            <div class="text-center">
                <div class="mb-5 text-center">
                    <h2 class="fw-bold">Register</h2>
                    <hr class="mt-2" />
                </div>
                <div class="mb-5">
                    <div>Create an new account.</div>
                    <div>Already a member, <a href="<?= base_url('client/auth/login') ?>" class="fw-bold text-hi-primary text-decoration-none">Login?</a></div>
                </div>
            </div>

            <form action="<?= base_url('client/auth/register_act') ?>" method="post" autocomplete="off">

                <?php if ($message = $this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle"></i> <?= $message ?>
                    </div>
                <?php endif ?>

                <div class="form__group mb-3">
                    <input type="email" name="email" id="email" class="form__field" placeholder="Your Email" required autofocus value="<?= set_value('email') ?>">
                    <label for="email" class="form__label">Your Email</label>
                </div>

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
                    <button type="submit" class="btn py-2 btn-hi-primary">Register</button>
                </div>

                <div class="login-choice"><span>or</span></div>

                <div class="signup-buttons">
                    <a href="javascript:void(0)" class="google-signup" id="sign-with-google">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" aria-hidden="true">
                            <title>Google</title>
                            <g fill="none" fill-rule="evenodd">
                                <path fill="#4285F4" d="M17.64 9.2045c0-.6381-.0573-1.2518-.1636-1.8409H9v3.4814h4.8436c-.2086 1.125-.8427 2.0782-1.7959 2.7164v2.2581h2.9087c1.7018-1.5668 2.6836-3.874 2.6836-6.615z"></path>
                                <path fill="#34A853" d="M9 18c2.43 0 4.4673-.806 5.9564-2.1805l-2.9087-2.2581c-.8059.54-1.8368.859-3.0477.859-2.344 0-4.3282-1.5831-5.036-3.7104H.9574v2.3318C2.4382 15.9832 5.4818 18 9 18z"></path>
                                <path fill="#FBBC05" d="M3.964 10.71c-.18-.54-.2822-1.1168-.2822-1.71s.1023-1.17.2823-1.71V4.9582H.9573A8.9965 8.9965 0 0 0 0 9c0 1.4523.3477 2.8268.9573 4.0418L3.964 10.71z"></path>
                                <path fill="#EA4335" d="M9 3.5795c1.3214 0 2.5077.4541 3.4405 1.346l2.5813-2.5814C13.4632.8918 11.426 0 9 0 5.4818 0 2.4382 2.0168.9573 4.9582L3.964 7.29C4.6718 5.1627 6.6559 3.5795 9 3.5795z"></path>
                            </g>
                        </svg>
                        Sign Up With Google
                    </a>
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

    .login-choice span {
        margin-top: 15px;
        margin-bottom: 15px;
        color: #5b6987;
        display: -ms-grid;
        display: grid;
        font-size: 16px;
        width: 100%;
        line-height: 40px;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        text-align: center;
        -ms-grid-columns: minmax(20px, 1fr) auto minmax(20px, 1fr);
        grid-template-columns: minmax(20px, 1fr) auto minmax(20px, 1fr);
        grid-gap: 19px;
    }

    .login-choice span:after,
    .login-choice span:before {
        content: "";
        border-top: 1px solid #e5e8ed;
    }

    .signup-buttons {
        /* margin-top: 15px; */
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        position: relative;
    }

    .facebook-signup,
    .google-signup {
        color: #031b4e;
        background: #f2f8ff;
        border: 1px solid rgba(0, 105, 255, 0.2);
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        border-radius: 3px;
        display: inline-block;
        margin-top: 0;
        /* width: 47.5%; */
        width: 100%;
        padding: 15px;
        text-align: center;
        position: inherit;
    }

    .signup-buttons a {
        vertical-align: middle;
        text-decoration: none;
    }

    .signup-buttons svg {
        left: 16px;
        position: absolute;
        top: 50%;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }
</style>

<script>
    let client;

    function initClient() {
        client = google.accounts.oauth2.initTokenClient({
            client_id: '426424058919-r3q994duuggmnn254p8cnmehl4gphb6a.apps.googleusercontent.com',
            scope: 'https://www.googleapis.com/auth/userinfo.profile \
                    https://www.googleapis.com/auth/userinfo.email',
            ux_mode: 'popup',
            callback: async (tokenResponse) => {
                if (tokenResponse && tokenResponse.access_token) {
                    $.ajax({
                        url: 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' + tokenResponse.access_token,
                        success: function(response) {

                            $.ajax({
                                url: '<?= base_url('client/auth/register_email_act') ?>',
                                method: 'POST',
                                dataType: 'JSON',
                                data: {
                                    email: response.email,
                                    type: 'GOOGLE',
                                },
                                success: function(response) {
                                    if (response.status === 200) {
                                        window.location.href = '<?= base_url('client/auth/login') ?>';
                                    } else {
                                        window.location.reload();
                                    }
                                }
                            })
                        }
                    })
                }
            },
        });
    }
</script>

<script src="https://apis.google.com/js/api.js" async defer></script>
<script onload="initClient()" src="https://accounts.google.com/gsi/client" async defer></script>

<script>
    let is_show_password = true;

    const toast_el = $('#toast');
    const toast = new bootstrap.Toast(toast_el)

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

        $(document).on('click', '#sign-with-google', function() {
            try {
                client.requestAccessToken();
            } catch (error) {
                toast_el.addClass('bg-danger');
                toast_el.find('#toast-title')
                    .addClass('text-black')
                    .html('Failed')

                toast_el.find('#toast-msg')
                    .addClass('text-white')
                    .html('Sorry, we couldn\'t complete your request')

                toast.show();
            }
        });
    })
</script>