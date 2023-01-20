<main class="bg-hi-primary mt-3">

    <section class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="text-center py-3">
                    <div class="p-lg-3">
                        <img class="img-fluid img-thumbnail rounded-circle" draggable="false" src="<?= $client->url_image ?>" alt="" style="height: 250px; width: 250px">
                    </div>
                </div>
            </div>
            <div class="col-md-8 d-md-flex align-items-center">
                <div class="text-center text-md-start p-3 p-lg-0 pb-3 w-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="fw-bold text-white h5 mb-3">
                                <?= $client->email ?: '-' ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="fw-bold text-white h5 mb-3">
                                <?= $client->name ?: '-' ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-white h6 mb-4">
                                <?= $client->position ?: '-' ?>
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
                                <a href="<?= base_url($route . '/favorite_icon_set') ?>" class="text-decoration-none text-black">See all >></a>
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
                                                                <img class="img-fluid" loading="lazy" width="96" draggable="false" src="<?= $icon->url_image ?>" alt="">
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
                                    <div>
                                        <lottie-player class="m-auto" src="<?= base_url('public/images/25943-nodata.json') ?>" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay />
                                    </div>
                                    <div>No Data Available</div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <div>
                        <div class="d-md-flex justify-content-between">
                            <div class="fw-bold h3">Favorite icon</div>
                            <div>
                                <a href="<?= base_url($route . '/favorite_icon') ?>" class="text-decoration-none text-black">See all >></a>
                            </div>
                        </div>
                        <div>
                            <?php if (!empty($favorite_icons)) : ?>
                                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-6 py-3">
                                    <?php foreach ($favorite_icons as $icon) : ?>
                                        <div class="col p-1 p-md-3">
                                            <?php if ($icon->is_unlock) : ?>
                                                <a href="<?= base_url('icon_style/index/' . $icon->id) ?>" class="text-decoration-none text-black icon-item">
                                                    <div class="text-center">
                                                        <img draggable="false" loading="lazy" width="96" class="img-fluid" src="<?= $icon->url_image ?>" />
                                                        <div><?= $icon->name ?></div>
                                                    </div>
                                                </a>
                                            <?php else : ?>
                                                <a href="javascript:void(0)" class="text-decoration-none text-black icon-item locked" data-bs-toggle="modal" data-bs-icon="<?= $icon->id ?>" data-bs-target="#restrictionModal">
                                                    <div class="text-center">
                                                        <img draggable="false" loading="lazy" width="96" class="img-fluid" src="<?= $icon->url_image ?>" />
                                                        <div><?= $icon->name ?></div>
                                                    </div>
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            <?php else : ?>
                                <div class="text-center">
                                    <div>
                                        <lottie-player class="m-auto" src="<?= base_url('public/images/25943-nodata.json') ?>" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay />
                                    </div>
                                    <div>No Data Available</div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal -->
<div class="modal fade" id="restrictionModal" tabindex="-1" aria-labelledby="restrictionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<script defer>
    $(function() {
        const base_url = $(document).find('base').attr('href');

        $('#restrictionModal').on('show.bs.modal', function(e) {
            const button = e.relatedTarget;
            const icon_id = $(button).data('bs-icon');

            const body = $(this).find('.modal-body');

            $.ajax({
                url: base_url + 'icon_discover/get_detail_icon/' + icon_id,
                method: 'GET',
                dataType: 'JSON',
                beforeSend: function() {
                    body.html('<div class="text-center p-5"><i class="fa fa-spin fa-spinner fa-2x"></i></div>')
                },
                success: function(response) {
                    if (response.status == 200) {

                        if (!response.is_login) { // jika belum login
                            // if (response.data.guest_access) { // jika access gratis diberikan
                            // suruh login

                            body.html(`
                                    <div class="text-center">
                                        <div class="my-4">
                                                <img loading="lazy" class="img-fluid" width="48" src="<?= base_url('public/images/min-logo-color.png') ?>"/>
                                            </div>
                                        <div class="mb-3 h4">You must login first</div>
                                        <a class="btn btn-hi-primary px-4" href="${base_url + 'client/auth/login'}">Login</a>
                                    </div>
                                `);

                            // }
                        } else { // sudah login
                            if (!response.data.is_unlock) { // jika subscription tidak sesuai
                                // suruh bayar

                                if (response.data.minimum_subscription) {
                                    body.html(`
                                        <div class="text-center">
                                            <div class="my-4">
                                                <img loading="lazy" class="img-fluid" width="48" src="<?= base_url('public/images/min-logo-color.png') ?>"/>
                                            </div>
                                            <div class="mb-3 h4">Unlock with ${response.data.minimum_subscription.name}</div>
                                            <a class="btn btn-hi-primary px-4" href="${base_url + 'subscription/index?id=' + response.data.minimum_subscription.id}">Only ${response.data.minimum_subscription.total_price} <i class="fa fa-arrow-right ms-2"></i></a>
                                        </div>
                                    `);
                                } else {
                                    body.html(`
                                        <div class="text-center">
                                            <div class="my-4">
                                                <img loading="lazy" class="img-fluid" width="48" src="<?= base_url('public/images/min-logo-color.png') ?>"/>
                                            </div>
                                            <div class="mb-3 h4">Icon not supported anymore</div>
                                            <div>Please <a href="<?= base_url('contact_us') ?>">contact us</a> if you're think this is a mistake</div>
                                        </div>
                                    `);
                                }

                            }
                        }

                    } else {
                        body.html(`<div class="text-center">${response.msg}</div>`)
                    }
                }
            })
        });
    });
</script>