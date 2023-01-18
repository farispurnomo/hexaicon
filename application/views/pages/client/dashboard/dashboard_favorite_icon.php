<main class="min-vh-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-start my-5">
                    <h1 class="fw-bold">Your Favorite Icons</h1>
                    <!-- <h5>Take your desired plan to get access to our icon easily</h5> -->
                </div>
            </div>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xxl-6" id="icon-list">

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
                url: '<?= base_url($route . '/favorite_icon_paginate?page=') ?>' + current_page,
                method: 'GET',
                dataType: 'JSON',
                beforeSend: function() {

                },
                success: function(response) {
                    current_page++;

                    let html = '';
                    response.data.icons.forEach(icon => {
                        const url = '<?= base_url('icon_style/index/') ?>' + icon.id;

                        if (icon.guest_access) {
                            html += `
                                    <div class="col p-1 p-md-3">
                                        <a href="${url}" class="text-decoration-none text-black icon-item">
                                            <div class="text-center p-2">
                                                <!-- <img draggable="false" class="img-fluid" src="${icon.url_image}"/> -->
                                                <img draggable="false" class="img-fluid" width="96" loading="lazy" src="${icon.url_image}"/>
                                                <div>${icon.name}</div>
                                            </div>
                                        </a>
                                    </div>
                                `;
                        } else {
                            if (!icon.is_unlock) {
                                html += `
                                        <div class="col p-1 p-md-3">
                                            <a href="javascript:void(0)" class="text-decoration-none text-black icon-item locked" data-bs-toggle="modal" data-bs-icon="${icon.id}" data-bs-target="#restrictionModal">
                                                <div class="text-center p-2">
                                                    <!-- <img draggable="false" class="img-fluid" src="${icon.url_image}"/> -->
                                                    <img draggable="false" class="img-fluid" width="96" loading="lazy" src="${icon.url_image}"/>
                                                    <div>${icon.name}</div>
                                                </div>
                                            </a>
                                        </div>
                                    `;
                            } else {
                                html += `
                                        <div class="col p-1 p-md-3">
                                            <a href="${url}" class="text-decoration-none text-black icon-item">
                                                <div class="text-center p-2">
                                                    <!-- <img draggable="false" class="img-fluid" src="${icon.url_image}"/> -->
                                                    <img draggable="false" class="img-fluid" width="96" loading="lazy" src="${icon.url_image}"/>
                                                    <div>${icon.name}</div>
                                                </div>
                                            </a>
                                        </div>
                                    `;
                            }
                        }
                    });

                    $('#icon-list').append(html);

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