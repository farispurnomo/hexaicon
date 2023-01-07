<main class="bg-hi-primary mt-3">

    <section class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="text-center px-5 py-3 p-lg-5">
                    <div class="p-lg-3">
                        <img class="img-fluid img-thumbnail rounded-circle" draggable="false" src="<?= $client->url_image ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="col-md-8 d-md-flex align-items-center">
                <div class="text-center text-md-start p-3 p-lg-0 pb-3 w-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="fw-bold text-white h5 mb-3">
                                <?= $client->name ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-white h6 mb-4">
                                <?= $client->position ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-10 col-lg-5 d-flex align-items-center">
                                    <div class="rounded-pill bg-white py-2 px-3 d-flex align-items-center justify-content-between w-100" style="box-shadow: 3px 3px 3px #a23247;">
                                        <span class="fw-bold">Subscription Plan</span>
                                        <span class="badge rounded-pill bg-hi-primary px-4 py-2"><?= $client->subscription_name ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-2 d-flex align-items-center justify-content-center">
                                    <div class="py-2 py-lg-0">
                                        <a href="<?= base_url('client/profile') ?>">
                                            <img class="img-fluid" width="42" draggable="false" src="<?= base_url('public/images/edit-icon.png') ?>" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="py-3">
                                <a href="<?= base_url('client/auth/logout') ?>" class="btn btn-hi-warning"><i class="fa fa-sign-in-alt"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-12">
                <div class="bg-white h-100 big-radius">
                    <div class="mb-5">
                        <div class="d-md-flex justify-content-between">
                            <div class="fw-bold h3">Favorite Icon Set</div>
                            <div>
                                <a href="" class="text-decoration-none text-black">See all >></a>
                            </div>
                        </div>
                        <div class="row py-3">
                            <?php if (!empty($favorite_icon_sets)) : ?>
                                <?php foreach ($favorite_icon_sets as $icon_set) : ?>
                                    <div class="col-sm-6 col-lg-3 d-flex align-item-stretch">
                                        <a href="" class="text-decoration-none w-100 p-2">
                                            <div class="favorite-icon-set-card">
                                                <div class="favorite-icon-set-card-body">
                                                    <div class="row g-0 h-100">
                                                        <?php foreach ($icon_set->icons as $icon) : ?>
                                                            <div class="col-4 d-flex align-items-center justify-content-center">
                                                                <img class="img-fluid" draggable="false" src="<?= $icon->url_image ?>" alt="">
                                                            </div>
                                                        <?php endforeach ?>
                                                    </div>
                                                </div>
                                                <div class="favorite-icon-set-card-footer text-center">
                                                    <div class="h4 mb-0">
                                                        <?= $icon_set->name ?> set icon
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach ?>
                            <?php else : ?>
                                <div class="col-12 text-center">
                                    Data not available
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <div>
                        <div class="d-md-flex justify-content-between">
                            <div class="fw-bold h3">Favorite icon</div>
                            <div>
                                <a href="" class="text-decoration-none text-black">See all >></a>
                            </div>
                        </div>
                        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-6 py-3">
                            <?php if (!empty($favorite_icons)) : ?>
                                <?php foreach ($favorite_icons as $icon) : ?>
                                    <div class="col">
                                        <a href="<?= base_url('icon_style/index/' . $icon->id) ?>" class="text-decoration-none">
                                            <div class="m-1 m-md-3 icon-item">
                                                <div class="text-center">
                                                    <img draggable="false" class="img-fluid" src="<?= $icon->url_image ?>" />
                                                    <div><?= $icon->name ?></div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach ?>
                            <?php else : ?>
                                <div class="text-center m-auto">
                                    Data not available
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>