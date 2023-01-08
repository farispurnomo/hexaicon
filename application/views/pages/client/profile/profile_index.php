<main class="py-3">

    <section class="container-fluid p-0">
        <form method="POST" action="<?= base_url($route . '/update') ?>" enctype="multipart/form-data">
            <div class="row g-0">
                <div class="col-md-3 text-center" id="profile-card">
                    <div class="py-2 py-md-5">

                        <div class="px-5 mb-3">
                            <div class="profilepic rounded-circle m-auto" role="button">
                                <img id="image" class="profilepic__image w-100 h-100" src="<?= $client->url_image ?>" />
                                <label class="profilepic__content" for="file" role="button">
                                    <span class="profilepic__icon"><i class="fas fa-camera fa-2xl"></i></span>
                                    <span class="profilepic__text">Edit Profile</span>
                                </label>
                                <input class="d-none" type="file" name="file" id="file" accept=".gif,.jpg,.png,.jpeg" onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])">
                            </div>

                        </div>

                        <div class="mb-3">
                            <div class="fw-bold">Joined at</div>
                            <div><?= $client->created_at ?: '-' ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="fw-bold">Subscription level</div>
                            <div class="badge rounded-pill bg-hi-primary px-4 py-2"><?= $client->subscription_name ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="fw-bold">Subscription expired in</div>
                            <div><?= $client->subscription_ends_at ?: '-' ?></div>
                        </div>

                    </div>
                </div>

                <div class="col-md-9 d-flex align-self-center">
                    <div class="w-100 p-2 pt-5 p-md-5">
                        <?php if ($message = $this->session->flashdata('msg')) : ?>
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle"></i> <?= $message ?>
                            </div>
                        <?php endif ?>

                        <?php if ($message = $this->session->flashdata('success')) : ?>
                            <div class="alert alert-hi-primary">
                                <i class="fa fa-check-circle"></i> <?= $message ?>
                            </div>
                        <?php endif ?>

                        <div class="mb-3">
                            <div class="h5 fw-bold">Edit Profile</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?= $client->name ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="job">Job</label>
                            <input type="text" id="job" name="position" class="form-control" value="<?= $client->position ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" id="email" class="form-control-plaintext" value="<?= $client->email ?>">
                        </div>

                        <?php if ($client->account_type === ACCOUNT_TYPE_EMAIL) : ?>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input type="text" id="password" name="password" class="form-control">
                                <small class="text-muted">* leave blank if you don't want to change it</small>
                            </div>
                        <?php endif ?>

                        <div class="mb-3 d-flex">
                            <div class="pe-3">
                                <button class="btn btn-hi-primary px-4">Save</button>
                            </div>
                            <div>
                                <a href="<?= base_url('client/dashboard') ?>" class="btn btn-hi-outline-primary px-3">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

</main>