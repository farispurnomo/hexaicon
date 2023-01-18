<main class="min-vh-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-start my-5">
                    <h1 class="fw-bold">Your Favorite Icon Sets</h1>
                    <!-- <h5>Take your desired plan to get access to our icon easily</h5> -->
                </div>
            </div>
        </div>
        <div class="row" id="icon-set-list">

        </div>
        <div class="row d-none" id="load-more-wrapper">
            <div class="col-12 text-center py-3 px-md-4">
                <div id="wrapper">
                    <button type="button" id="btn-load-more" class="btn rounded-pill px-4 btn-hi-primary">Load More</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script defer>
    const handleList = function() {
        let current_page = 1;

        const load_more = function() {
            const render_icon = function(icons) {
                let html = '';
                icons.forEach(icon => {
                    html += `
                        <div class="col-4 d-flex align-items-center justify-content-center">
                            <img class="img-fluid" loading="lazy" width="96" draggable="false" src="${icon.url_image}" alt="">
                        </div>
                    `;
                });
                return html;
            };

            $.ajax({
                url: '<?= base_url($route . '/favorite_icon_set_paginate?page=') ?>' + current_page,
                method: 'GET',
                dataType: 'JSON',
                beforeSend: function() {

                },
                success: function(response) {
                    current_page++;

                    let html = '';
                    response.data.sets.forEach(set => {
                        html += `
                            <div class="col-sm-6 col-lg-3 d-flex align-item-stretch">
                                <a href="" class="text-decoration-none w-100 p-2">
                                    <div class="favorite-icon-set-card">
                                        <div class="favorite-icon-set-card-body">
                                            <div class="row g-0 h-100">
                                                ${render_icon(set.icons)}
                                            </div>
                                        </div>
                                        <div class="favorite-icon-set-card-footer text-center">
                                            <div class="h4 mb-0">
                                                ${set.name} set icon
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        `;
                    });
                    $('#icon-set-list').append(html);

                    if (response.data.total_data == 0) {
                        $('#icon-set-list').html(`
                            <div class="col-12 text-center">
                                <div>
                                    <lottie-player class="m-auto" src="<?= base_url('public/images/25943-nodata.json') ?>" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay />
                                </div>
                                <div>No Data Available</div>

                                <!--<div>
                                    Find your first favorite icon sets. <a href=""></a>
                                </div>-->
                            </div>
                        `);
                    }

                    if (response.data.is_done) {
                        $('#load-more-wrapper').addClass('d-none');
                    }
                }
            })
        };

        const init = function() {
            load_more();

            $(document).on('click', '#btn-load-more', function() {
                load_more();
            })
        };

        return {
            init: () => init()
        }
    }();

    $(function() {
        handleList.init();
    })
</script>