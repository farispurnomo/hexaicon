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

    <section>
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8 order-2 order-md-1">
                    <div class="fw-bold" id="icon-name">

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
                            <a href="<?= base_url('icon_style/add_to_favorite/' . $icon_id) ?>" class="btn rounded-pill <?= ($is_favorite ? 'btn-hi-primary' : 'btn-hi-outline-primary') ?>">
                                <svg width="24" height="24" viewBox="0 0 53 53" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect width="53" height="53" fill="url(#pattern0)" />
                                    <defs>
                                        <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                            <use xlink:href="#image0_340_29" transform="scale(0.00390625)" />
                                        </pattern>
                                        <image id="image0_340_29" width="256" height="256" xlink:href="data:image/png;base64,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" />
                                    </defs>
                                </svg>
                                <?= ($is_favorite ? 'Remove From Favorite' : 'Add To Favorite') ?>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid" id="suggestion-icons">

        </div>
    </section>
</main>

<script type="module" defer>
    import menuIconStyle from "<?= base_url('public/js/client/icon-style.js') ?>";

    $(function() {
        menuIconStyle.init('<?= $icon_id ?>');
    })
</script>