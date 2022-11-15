<main>
    <section class="container-fluid">
        <div class="row min-vh-100 align-items-center" id="home-section">
            <div class="col-md-4 order-2 order-md-1 text-white">
                <div class="p-md-5">
                    <h2>BOOST</h2>
                    <h3>Your Design and Creativity</h3>
                    <h5 class="mb-5">Make your project look elegant and professional and save time on your design</h5>
                    <a href="">
                        <div>
                            <span>Explore</span> <img class="img-fluid" draggable="false" src="<?= base_url('public/images/arrow-right-circle.png') ?>" alt="">
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-8 order-1 order-md-2">
                <img draggable="false" src="<?= base_url('public/images/Market launch-pana 1.png') ?>" alt="" class="img-fluid">
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row min-vh-100" id="feature-section">
            <article class="col-12 text-center py-5">
                <h2 class="fw-bold mb-3">The smartest for <span class="text-danger">creatives like you</span></h2>
                <h5>Whether you're looking for icons, you'll find the perfect <br /> assets on Hexaicons</h5>
            </article>
            <article class="col-12">
                <div class="row mb-5">
                    <div class="col-md-3 text-center">
                        <div class="box-card mx-xxl-3">
                            <div class="box-icon">
                                <div class="box-icon-image">
                                    <img draggable="false" src="<?= base_url('public/images/Design.png') ?>" alt="" class="img-fluid">
                                </div>
                            </div>
                            <div class="box-content">
                                <div class="fw-bold h3">Awesome design</div>
                                <div class="small">Our icon created by professional designer who have qualified skills in their field</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="box-card mx-xxl-3">
                            <div class="box-icon">
                                <div class="box-icon-image">
                                    <img draggable="false" src="<?= base_url('public/images/Easy.png') ?>" alt="" class="img-fluid">
                                </div>
                            </div>
                            <div class="box-content">
                                <div class="fw-bold h3">Easy to Use</div>
                                <div class="small">Just download it and use it without attribute or you can just use our plugins, cheers</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="box-card mx-xxl-3">
                            <div class="box-icon">
                                <div class="box-icon-image">
                                    <img draggable="false" src="<?= base_url('public/images/Illustrator.png') ?>" alt="" class="img-fluid">
                                </div>
                            </div>
                            <div class="box-content">
                                <div class="fw-bold h3">Ready to Use Assets</div>
                                <div class="small">Access thousand of icons ready-to-publish and save time on your design</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="box-card mx-xxl-3">
                            <div class="box-icon">
                                <div class="box-icon-image">
                                    <img draggable="false" src="<?= base_url('public/images/Windows 10 Personalization.png') ?>" alt="" class="img-fluid">
                                </div>
                            </div>
                            <div class="box-content">
                                <div class="fw-bold h3">Flexible Integration</div>
                                <div class="small">We has integrations plugins with popular design and developer tools</div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-12">
                <div class="mt-5 text-center">
                    <h5 class="mb-3">Trusted by thousand users from 175+ companies in the worlds</h5>

                    <div class="row">
                        <div class="col-md-3 align-self-center">
                            <img draggable="false" src="<?= base_url('public/images/image 5.png') ?>" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-3 align-self-center">
                            <img draggable="false" src="<?= base_url('public/images/Group.png') ?>" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-3 align-self-center">
                            <img draggable="false" src="<?= base_url('public/images/logodetik-01 1.png') ?>" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-3 align-self-center">
                            <img draggable="false" src="<?= base_url('public/images/logo-liputan6 1.png') ?>" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-4 align-self-center">
                            <img draggable="false" src="<?= base_url('public/images/logo-cnnindo 1.png') ?>" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-4 align-self-center">
                            <img draggable="false" src="<?= base_url('public/images/image 8.png') ?>" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-4 align-self-center">
                            <img draggable="false" src="<?= base_url('public/images/logo-forbes 1.png') ?>" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h4>Icon Styles</h4>
                <div>
                    Hexaicons contains more than 5.000 icons with includes currently 3 styles: regular, thin and regular, with more coming soon. You're will sure to find the perfect icon for your project.
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row mb-5">
            <div class="col-12">
                <div class="text-center">
                    <h2 class="fw-bold">Pricing & Plans</h2>
                    <h5>Choose your subscription plan</h5>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php
            foreach ($subscriptions as $key => $subscription) :
                $is_last = $key + 1 == count($subscriptions);
            ?>
                <div class="col-md-3 d-flex align-items-stretch">
                    <div class="card-pricing <?= ($is_last ? '' : 'card-pricing-light') ?>">
                        <div class="card-pricing-content">
                            <div class="card-pricing-body">
                                <div class="mb-3 h5 fw-bold"><?= $subscription->name ?></div>
                                <div class="mb-3 h2 fw-bold"><?= number_format($subscription->total_price) ?></div>
                                <div class="mb-3"><?= $subscription->description ?></div>
                                <div class="mb-5 px-3">
                                    <?php foreach ($subscription->items as $item) : ?>
                                        <div class="mb-3">
                                            <?php if ($is_last) : ?>
                                                <img src="<?= base_url('public/images/check-circle-yellow.png') ?>" alt="">
                                            <?php else : ?>
                                                <img src="<?= base_url('public/images/check-circle.png') ?>" alt="">
                                            <?php endif ?>

                                            <span><?= $item->name ?></span>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <div class="card-pricing-footer">
                                <div class="small mb-1"><?= $subscription->note ?></div>
                                <button class="btn">Get Started</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2>Icon Trends</h2>
                <div>
                    The most downloaded trends and icons
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-12">

            </div>
        </div>
    </section>

    <section class="container-fluid" id="integrated-section">
        <div class="row min-vh-100">
            <div class="col-md-6 align-self-center">
                <h2 class="fw-bold">Integrates seamlessly with <br />your <span class="text-danger">Favorite Tools</span></h2>
                <h5>
                    We has plugins and integrations for several <br /> popular design and developer tools.
                </h5>
            </div>
            <div class="col-md-6 align-self-center">
                <div class="row">
                    <div class="col-4 d-flex align-item-stretch p-3 p-xxl-5">
                        <div class="bg-card-icon">
                            <img src="<?= base_url('public/images/after-effect-icon.png') ?>" alt="">
                        </div>
                    </div>
                    <div class="col-4 d-flex align-item-stretch p-3 p-xxl-5">
                        <div class="bg-card-icon">
                            <img src="<?= base_url('public/images/xd-icon.png') ?>" alt="">
                        </div>
                    </div>
                    <div class="col-4 d-flex align-item-stretch p-3 p-xxl-5">
                        <div class="bg-card-icon">
                            <img src="<?= base_url('public/images/wordpress-icon.png') ?>" alt="">
                        </div>
                    </div>
                    <div class="col-4 d-flex align-item-stretch p-3 p-xxl-5">
                        <div class="bg-card-icon">
                            <img src="<?= base_url('public/images/figma-icon.png') ?>" alt="">
                        </div>
                    </div>
                    <div class="col-4 d-flex align-item-stretch p-3 p-xxl-5">
                        <div class="bg-card-icon">
                            <img src="<?= base_url('public/images/ai-icon.png') ?>" alt="">
                        </div>
                    </div>
                    <div class="col-4 d-flex align-item-stretch p-3 p-xxl-5">
                        <div class="bg-card-icon">
                            <img src="<?= base_url('public/images/npm-icon.png') ?>" alt="">
                        </div>
                    </div>
                    <div class="col-4 d-flex align-item-stretch p-3 p-xxl-5">
                        <div class="bg-card-icon">
                            <img src="<?= base_url('public/images/penpot-icon.png') ?>" alt="">
                        </div>
                    </div>
                    <div class="col-4 d-flex align-item-stretch p-3 p-xxl-5">
                        <div class="bg-card-icon">
                            <img src="<?= base_url('public/images/canva-icon.png') ?>" alt="">
                        </div>
                    </div>
                    <div class="col-4 d-flex align-item-stretch p-3 p-xxl-5">
                        <div class="bg-card-icon">
                            <img src="<?= base_url('public/images/image 20.png') ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid" id="upgrade-to-pro-section">
        <div class="row position-relative">
            <div class="col-12 p-0">
                <img draggable="false" class="img-fluid" src="<?= base_url('public/images/Frame 31.png') ?>" alt="">
            </div>
            <div class="col-12 position-absolute h-100 w-100">
                <div class="row h-100 w-100 align-content-center">
                    <div class="col-md-10 text-white">
                        <h3 class="fw-bold">UPGRADE TO PRO</h3>
                        <div>Empower your teams with our additional features</div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-light rounded-0">Get Pro</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>