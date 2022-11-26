<main>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 py-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center pt-5 pb-4">
                                <div class="h1 fw-bold">Icon search</div>
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
                        <div class="col-12" id="icon-categories">
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
</main>