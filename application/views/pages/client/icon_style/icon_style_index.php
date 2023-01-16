<main>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 py-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center pt-5 pb-4">
                                <div class="h1 fw-bold">Icon Styling</div>
                                <div>Choose the size of the icon and download it</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-3">
        <?php $this->load->view($namespace . 'edit'); ?>

        <div class="container">
            <div class="row">
                <div class="col-6 text-center">
                    <a href="<?= base_url('client/auth/login') ?>" class="btn rounded-pill <?= ($is_favorite ? 'btn-hi-primary' : 'btn-hi-outline-primary') ?>">
                        Download
                    </a>
                </div>
                <div class="col-md-6 text-center">
                    <?php if ($client) : ?>
                        <a href="<?= base_url($route . '/add_to_favorite/' . $icon_id) ?>" class="btn rounded-pill <?= ($is_favorite ? 'btn-hi-primary' : 'btn-hi-outline-primary') ?>">
                            <img draggable="false" src="<?= base_url('public/images/icons8-heart-plus-100.png') ?>" width="24" alt="" class="img-fluid">
                            <?= ($is_favorite ? 'Remove From Favorite' : 'Add To Favorite') ?>
                        </a>
                    <?php else : ?>
                        <a href="<?= base_url('client/auth/login') ?>" class="btn rounded-pill <?= ($is_favorite ? 'btn-hi-primary' : 'btn-hi-outline-primary') ?>">
                            <img draggable="false" src="<?= base_url('public/images/icons8-heart-plus-100.png') ?>" width="24" alt="" class="img-fluid">
                            Add To Favorite
                        </a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>

    <!-- <section id="image-detail-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8 order-2 order-md-1">
                    <div class="fw-bold h4" id="icon-name">

                        <div class="placeholder-glow">
                            <div class="placeholder py-2 rounded col-4">&nbsp;</div>
                        </div>

                    </div>
                    <div>
                        <span class="fw-bold">Select Size</span>
                        <div class="row" id="icon-sizes">

                            <?php for ($i = 1; $i <= 6; $i++) : ?>
                                <div class="col-6 col-sm-3 placeholder-glow p-2 text-center">
                                    <span class="rounded-pill placeholder py-2 col-9">&nbsp;</span>
                                </div>
                            <?php endfor ?>

                        </div>
                    </div>
                    <div>
                        <span class="fw-bold">Format Download</span>
                        <div class="row" id="icon-formats">

                            <?php for ($i = 1; $i <= 2; $i++) : ?>
                                <div class="col-6 placeholder-glow p-2 text-center">
                                    <span class="rounded-pill placeholder py-2 col-8">&nbsp;</span>
                                </div>
                            <?php endfor ?>

                        </div>
                    </div>
                </div>
                <div class="col-md-4 order-1 order-md-2 text-center d-flex align-items-center justify-content-center">

                    <div>
                        <div id="icon-preview">
                            <div class="placeholder-glow">
                                <div class="placeholder w-50" style="aspect-ratio: 1/1;">&nbsp;</div>
                            </div>
                        </div>

                        <div class="p-3">
                            <?php if ($client) : ?>
                                <a href="<?= base_url($route . '/add_to_favorite/' . $icon_id) ?>" class="btn rounded-pill <?= ($is_favorite ? 'btn-hi-primary' : 'btn-hi-outline-primary') ?>">
                                    <img draggable="false" src="<?= base_url('public/images/icons8-heart-plus-100.png') ?>" width="24" alt="" class="img-fluid">
                                    <?= ($is_favorite ? 'Remove From Favorite' : 'Add To Favorite') ?>
                                </a>
                            <?php else : ?>
                                <a href="<?= base_url('client/auth/login') ?>" class="btn rounded-pill <?= ($is_favorite ? 'btn-hi-primary' : 'btn-hi-outline-primary') ?>">
                                    <img draggable="false" src="<?= base_url('public/images/icons8-heart-plus-100.png') ?>" width="24" alt="" class="img-fluid">
                                    Add To Favorite
                                </a>
                            <?php endif ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section> -->

    <section>
        <div class="container-fluid" id="suggestion-icons">

        </div>
    </section>

</main>

<style>
    .fw-bold.text-capitalize.h5 {
        display: flex;
        align-items: center;
    }

    .fw-bold.text-capitalize.h5::after {
        content: "";
        bottom: 0;
        width: 100%;
        height: 1px;
        margin-left: 24px;
        background: rgba(0, 0, 0, 1);
    }

    #wrapper {
        position: relative;
        overflow: hidden;
    }

    #wrapper::before,
    #wrapper::after {
        position: absolute;
        top: 51%;
        overflow: hidden;
        width: 48%;
        height: 1px;
        content: '\a0';
        background-color: #000;
        margin-left: 2%;
    }

    #wrapper::before {
        margin-left: -50%;
        text-align: right;
    }
</style>

<script type="module" defer>
    import menuIconStyle from "<?= base_url('public/js/client/icon-style.js') ?>";

    $(function() {
        menuIconStyle.init('<?= $icon_id ?>');
    });
</script>