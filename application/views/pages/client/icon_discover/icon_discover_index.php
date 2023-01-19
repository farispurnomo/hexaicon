<main>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 py-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center pt-5 pb-4">
                                <div class="h1 fw-bold">Icon discover</div>
                                <div>Find the perfect icons to complete any project</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 justify-content-center">
                        <div class="col-md-10">
                            <div class="search-section">
                                <div class="search-input">
                                    <input type="text" placeholder="Search Icon and Style" id="input-search">
                                    <div class="icon-clear">
                                        <svg focusable="false" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                        </svg>
                                    </div>
                                    <div class="divider">
                                        <span></span>
                                    </div>
                                    <div class="icon-search">
                                        <svg width="24" height="24" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.3333 31.6667C25.6971 31.6667 31.6667 25.6971 31.6667 18.3333C31.6667 10.9695 25.6971 5 18.3333 5C10.9695 5 5 10.9695 5 18.3333C5 25.6971 10.9695 31.6667 18.3333 31.6667Z" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M35 35L27.75 27.75" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="search-result">
                                    <div class="divider"></div>
                                    <ul class="search-dataset">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="discover-icon-categories">
                            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <div class="col placeholder-glow">
                                        <div class="placeholder p-5 w-100 rounded-pill">&nbsp;</div>
                                    </div>
                                <?php endfor ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid bg-hi-grey big-radius">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="fw-bold h3">Icon Style</div>
                        </div>
                    </div>
                    <div class="row" id="icon-styles">
                        <?php for ($i = 1; $i <= 4; $i++) : ?>
                            <div class="col-md-3 p-3">
                                <div class="bg-white rounded">
                                    <div class="row">
                                        <?php for ($j = 1; $j <= 9; $j++) : ?>
                                            <div class="col-4 text-center placeholder-glow p-3">
                                                <div class="placeholder rounded col-9 p-3">&nbsp;</div>
                                            </div>
                                        <?php endfor ?>
                                    </div>
                                </div>
                                <div class="text-center fw-bold py-3 placeholder-glow">
                                    <div class="placeholder rounded col-7">&nbsp;</div>
                                </div>
                            </div>
                        <?php endfor ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="fw-bold h3">Icon Set</div>
                        </div>
                    </div>
                    <div class="row" id="discover-icon-sets">
                        <div class="col-md-6 p-3">
                            <div class="bg-white icon-set-content">
                                <div class="row row-cols-4 row-cols-md-5 h-100">
                                    <?php for ($i = 1; $i <= 20; $i++) : ?>
                                        <div class="text-center placeholder-glow p-3 d-flex align-items-center justify-content-center">
                                            <div class="placeholder rounded col-9 img-fluid">&nbsp;</div>
                                        </div>
                                    <?php endfor ?>
                                </div>
                                <div class="text-center footer">
                                    <div class="placeholder-glow">
                                        <div class="placeholder col-12 h-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12 p-3">
                                    <div class="bg-white icon-set-content">
                                        <div class="row row-cols-4 row-cols-md-5">
                                            <?php for ($i = 1; $i <= 20; $i++) : ?>
                                                <div class="text-center placeholder-glow p-3">
                                                    <div class="placeholder rounded col-9 p-3">&nbsp;</div>
                                                </div>
                                            <?php endfor ?>
                                        </div>
                                        <div class="text-center footer">
                                            <div class="placeholder-glow">
                                                <div class="placeholder col-12 h-100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 p-3">
                                    <div class="bg-white icon-set-content">
                                        <div class="row">
                                            <?php for ($i = 1; $i <= 9; $i++) : ?>
                                                <div class="col-4 text-center placeholder-glow p-3">
                                                    <div class="placeholder rounded col-9 p-3">&nbsp;</div>
                                                </div>
                                            <?php endfor ?>
                                        </div>
                                        <div class="text-center footer">
                                            <div class="placeholder-glow">
                                                <div class="placeholder col-12 h-100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 p-3">
                                    <div class="bg-white icon-set-content">
                                        <div class="row">
                                            <?php for ($i = 1; $i <= 9; $i++) : ?>
                                                <div class="col-4 text-center placeholder-glow p-3">
                                                    <div class="placeholder rounded col-9 p-3">&nbsp;</div>
                                                </div>
                                            <?php endfor ?>
                                        </div>
                                        <div class="text-center footer">
                                            <div class="placeholder-glow">
                                                <div class="placeholder col-12 h-100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row mb-5">
                <div class="col-12 pt-5">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row" id="icon-filter">
                                <div class="col-md-3 col-lg-2 text-center p-2">
                                    <div class="custom-hi-radio-primary">
                                        <input id="category-popular" type="radio" name="icon_categories" value="POPULAR" checked>
                                        <label for="category-popular" class="rounded-pill w-100 py-2">Popular</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-2 text-center p-2">
                                    <div class="custom-hi-radio-primary">
                                        <input id="category-latest" type="radio" name="icon_categories" value="LATEST">
                                        <label for="category-latest" class="rounded-pill w-100 py-2">Latest</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-2 text-center p-2">
                                    <div class="custom-hi-radio-primary">
                                        <input id="category-free" type="radio" name="icon_categories" value="FREE">
                                        <label for="category-free" class="rounded-pill w-100 py-2">Free</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-end px-5">
                                <div>See more >>></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md-12 px-md-5" id="icon-filter-data">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 row-cols-xxl-6">
                        <?php for ($i = 1; $i <= 20; $i++) : ?>
                            <div class="col placeholder-glow placeholder-trending">
                                <div class="m-1 m-md-3">
                                    <div class="placeholder w-100"></div>
                                </div>
                            </div>
                        <?php endfor ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<div class="modal fade" id="restrictionModal" tabindex="-1" aria-labelledby="restrictionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="categoriesModal" tabindex="-1" aria-labelledby="categoriesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row row-cols-1 row-cols-md-3" id="modal-category-list">

                </div>
                <div class="row" id="load-more-wrapper">
                    <div class="col-12 text-center py-3 px-md-4">
                        <div id="wrapper">
                            <button type="button" id="btn-load-more" class="btn rounded-pill px-4 btn-hi-primary w-100">Load More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module" defer>
    import menuIconDiscover from "<?= base_url('public/js/client/icon-discover.js') ?>";

    $(function() {
        menuIconDiscover.init();
    })
</script>

<style>
    .icon-style-item {
        border-radius: 10px;
        transition: all .1s ease-in-out
    }

    .icon-style-item:hover {
        box-shadow: 5px 5px 20px #bdbdbd;
    }
</style>