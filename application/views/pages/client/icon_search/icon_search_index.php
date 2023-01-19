<main class="mb-5">
    <section class="mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center pt-5 pb-4">
                        <div class="h1 fw-bold">Icon Search</div>
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
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 search-page">
                    <div class="px-3 py-2 py-md-5">
                        <div class="mb-3">
                            <div><strong>Style</strong></div>
                            <div class="search-checkbox" id="search-style">

                            </div>
                        </div>
                        <div class="mb-3">
                            <div><strong>Sets</strong></div>
                            <div class="search-checkbox" id="search-set">

                            </div>
                        </div>
                        <div class="mb-3">
                            <div><strong>Categories</strong></div>
                            <div class="search-checkbox" id="search-category">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 p-md-5">
                    <div class="my-3" id="search-params">

                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="fw-bold h5">
                            <span id="total-icon"></span> Icons
                        </div>
                    </div>

                    <div id="icon-results">

                    </div>

                    <div id="pagination">
                        <div id="prev-page">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                <path d="M15 18l-6-6 6-6"></path>
                            </svg>
                        </div>

                        <span id="page"></span>

                        <div id="next-page">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                <path d="M9 18l6-6-6-6"></path>
                            </svg>
                        </div>
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

<script>
    const genUuidv4 = function() {
        return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
            (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
        );
    };

    const numberFormat = function(angka, absolute = true) {
        try {
            angka = angka.toString();

            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join(',');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            // return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            if (!absolute) {
                if (angka < 0) {
                    rupiah = angka.charAt(0) + rupiah;
                }
            }
            return rupiah;
        } catch (error) {
            return '-';
        }
    };

    const searchHandle = function() {
        const type = {
            QUERY: 'QUERY',
            STYLE: 'STYLE',
            SET: 'SET',
            CATEGORY: 'CATEGORY'
        };

        let styles = JSON.parse(`<?= json_encode($styles) ?>`);
        styles.map(e => ({
            checked: false,
            ...e
        }));

        let sets = JSON.parse('<?= json_encode($sets) ?>');
        sets.map(e => ({
            checked: false,
            ...e
        }))

        let categories = JSON.parse('<?= json_encode($categories) ?>');
        categories.map(e => ({
            checked: false,
            ...e
        }))

        let current_page = 1,
            last_page = 1;

        const params_queries = []

        const toggleParams = function(s_type, id) {
            let index;

            switch (s_type) {
                case type.QUERY:
                    const query = params_queries.find(x => x.text === id);
                    if (query) return;

                    const query_id = genUuidv4();

                    params_queries.push({
                        id: query_id,
                        text: id
                    });

                    $('#search-params').append(`
                            <div role="button" class="badge px-4 py-2 mb-3 rounded-pill search-item" id="search-query_${query_id}" data-type="${s_type}" data-value="${query_id}">
                                <span class="me-4">${id}</span> <i class="fa fa-times"></i>
                            </div>
                        `).children(':last')
                        .hide()
                        .fadeIn(500);

                    break;
                case type.STYLE:
                    const style = styles.find(x => x.id == id);

                    if (!style) return;
                    style.checked = !style.checked;

                    const el_style = $('#search-params').find(`div#search-style_${style.id}`);
                    $('#search-style').find(`#style_${style.id}`).prop('checked', style.checked);

                    if (el_style.length) {
                        el_style.fadeOut(200, function() {
                            $(this).remove();
                        });
                    } else {
                        $('#search-params').append(`
                            <div role="button" class="badge px-4 py-2 mb-3 rounded-pill search-item" id="search-style_${style.id}" data-type="${s_type}" data-value="${style.id}">
                                <span class="me-4">${style.name}</span> <i class="fa fa-times"></i>
                            </div>
                        `).children(':last')
                            .hide()
                            .fadeIn(500);
                    }
                    break;
                case type.SET:
                    const set = sets.find(x => x.id == id);

                    if (!set) return;
                    set.checked = !set.checked;

                    const el_set = $('#search-params').find(`div#search-set_${set.id}`);
                    $('#search-set').find(`#set_${set.id}`).prop('checked', set.checked);

                    if (el_set.length) {
                        el_set.fadeOut(200, function() {
                            $(this).remove();
                        });
                    } else {
                        $('#search-params').append(`
                            <div role="button" class="badge px-4 py-2 mb-3 rounded-pill search-item" id="search-set_${set.id}" data-type="${s_type}" data-value="${set.id}">
                                <span class="me-4">${set.name}</span> <i class="fa fa-times"></i>
                            </div>
                        `).children(':last')
                            .hide()
                            .fadeIn(500);
                    }

                    break;
                case type.CATEGORY:
                    const category = categories.find(x => x.id == id);

                    if (!category) return;
                    category.checked = !category.checked;

                    const el_category = $('#search-params').find(`div#search-category_${category.id}`);
                    $('#search-category').find(`#category_${category.id}`).prop('checked', category.checked);

                    if (el_category.length) {
                        el_category.fadeOut(200, function() {
                            $(this).remove();
                        });
                    } else {
                        $('#search-params').append(`
                            <div role="button" class="badge px-4 py-2 mb-3 rounded-pill search-item" id="search-category_${category.id}" data-type="${s_type}" data-value="${category.id}">
                                <span class="me-4">${category.name}</span> <i class="fa fa-times"></i>
                            </div>
                        `).children(':last')
                            .hide()
                            .fadeIn(500);
                    }
                    break;

                default:
                    break;
            }

            current_page = 1;
            loadMore();
        };

        const loadMore = function() {
            const params = {
                page: current_page,
                params: {
                    style_ids: styles.filter(x => x.checked === true).map(x => x.id),
                    set_ids: sets.filter(x => x.checked === true).map(x => x.id),
                    category_ids: categories.filter(x => x.checked === true).map(x => x.id),
                    queries: params_queries.map(x => x.text)
                }
            };

            $.ajax({
                url: '<?= base_url('icon_search/paginate') ?>',
                method: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: 'application/json',
                data: JSON.stringify(params),
                beforeSend: function() {
                    $('#prev-page').addClass('disabled');
                    $('#next-page').addClass('disabled');

                    let html = '<div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 mb-4">';
                    for (let i = 1; i <= 20; i++) {
                        html += `
                            <div class="col placeholder-glow placeholder-trending">
                                <div class="m-1 m-md-3">
                                    <div class="placeholder w-100"></div>
                                </div>
                            </div>
                        `;
                    }
                    html += '</div>';

                    $('#page').html('Please wait ...');
                    $('#icon-results').html(html);
                },
                success: function(response) {
                    $('#prev-page').removeClass('disabled');
                    $('#next-page').removeClass('disabled');

                    let html = '';
                    if (response.data.items.length) {
                        html = '<div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 mb-4">';
                        response.data.items.forEach(icon => {
                            if (icon.guest_access) {
                                html += `
                                    <div class="col p-2 p-md-3">
                                        <a href="" class="text-decoration-none text-black icon-item">
                                            <div class="text-center p-2">
                                                <img draggable="false" class="img-fluid" loading="lazy" src="${icon.url_image}"/>
                                                <div>${icon.name}</div>
                                            </div>
                                        </a>
                                    </div>
                                `;
                            } else {
                                if (!icon.is_unlock) {
                                    html += `
                                        <div class="col p-2 p-md-3">
                                            <a href="javascript:void(0)" class="text-decoration-none text-black icon-item locked" data-bs-toggle="modal" data-bs-icon="${icon.id}" data-bs-target="#restrictionModal">
                                                <div class="text-center p-2">
                                                    <img draggable="false" class="img-fluid" loading="lazy" src="${icon.url_image}"/>
                                                    <div>${icon.name}</div>
                                                </div>
                                            </a>
                                        </div>
                                    `;
                                } else {
                                    html += `
                                        <div class="col p-2 p-md-3">
                                            <a href="" class="text-decoration-none text-black icon-item">
                                                <div class="text-center p-2">
                                                    <img draggable="false" class="img-fluid" loading="lazy" src="${icon.url_image}"/>
                                                    <div>${icon.name}</div>
                                                </div>
                                            </a>
                                        </div>
                                    `;
                                }
                            }
                        });
                        html += '</div>';

                        $('#pagination').fadeIn();
                    } else {
                        html = `
                            <div class="text-center">
                                <div>
                                    <lottie-player class="m-auto" src="<?= base_url('public/images/25943-nodata.json') ?>"  background="transparent"  speed="1"  style="width: 300px; height: 300px;" loop autoplay/>
                                </div>
                                <div>No Data Available</div>
                            </div>
                        `;
                        $('#pagination').fadeOut();
                    }

                    last_page = response.data.last_page;

                    $('#icon-results').html(html);

                    $('#total-icon').html(numberFormat(response.data.total_data));
                    $('#page').html(`Page ${response.data.current_page} of ${response.data.last_page}`);

                    if (response.data.current_page === 1) {
                        $('#prev-page').addClass('disabled');
                    }

                    if (response.data.current_page === response.data.last_page) {
                        $('#next-page').addClass('disabled');
                    }
                }
            });
        };

        const initEvents = function() {
            $(document).on('change', 'input[name="style_id"], input[name="set_id"], input[name="category_id"]', function(e) {
                // const checked = $(this).is(':checked');
                const type = $(this).data('type');
                const value = this.value;

                toggleParams(type, value);
            });

            $(document).on('click', '.search-item', function() {
                const s_type = $(this).data('type');
                const value = $(this).data('value');

                if (s_type === type.QUERY) {
                    const index = params_queries.findIndex(x => x.id === value);
                    if (index !== -1) {
                        params_queries.splice(index, 1);
                    }

                    const el_query = $('#search-params').find(`div#search-query_${value}`);
                    if (el_query.length) {
                        el_query.fadeOut(200, function() {
                            $(this).remove();
                        });
                    }

                    current_page = 1;
                    loadMore();
                } else {
                    toggleParams(s_type, value);
                }
            });

            $(document).on('keypress', '#input-search', function(e) {
                if (e.which === 13) {
                    if (this.value != '') {
                        toggleParams(type.QUERY, this.value)
                        this.value = '';
                    }
                }
            });

            $(document).on('click', '#prev-page', function() {
                if (current_page <= 1) return;
                current_page--;

                loadMore();
            });

            $(document).on('click', '#next-page', function() {
                if (current_page >= last_page) return;
                current_page++;

                loadMore();
            });
        };

        const initializeDataSearch = function() {
            let html = '';

            styles.forEach(style => {
                html += `
                    <div>
                        <input type="checkbox" id="style_${style.id}" name="style_id" value="${style.id}" data-type="${type.STYLE}">
                        <label for="style_${style.id}">
                            <span class="pe-3">${style.name}</span><span>${style.total_icons || ''}</span>
                        </label>
                    </div>
                `;
            });
            $('#search-style').html(html)

            html = '';
            sets.forEach(set => {
                html += `
                    <div>
                        <input type="checkbox" id="set_${set.id}" name="set_id" value="${set.id}" data-type="${type.SET}">
                        <label for="set_${set.id}">
                            <span class="pe-3">${set.name}</span><span>${set.total_icons || ''}</span>
                        </label>
                    </div>
                `;
            });
            $('#search-set').html(html)

            html = '';
            categories.forEach(category => {
                html += `
                    <div>
                        <input type="checkbox" id="category_${category.id}" name="category_id" value="${category.id}" data-type="${type.CATEGORY}">
                        <label for="category_${category.id}">
                            <span class="pe-3">${category.name}</span><span>${category.total_icons || ''}</span>
                        </label>
                    </div>
                `;
            });
            $('#search-category').html(html)
        };

        const initRestrictionModal = function() {
            $('#restrictionModal').on('show.bs.modal', function(e) {
                const button = e.relatedTarget;
                const icon_id = $(button).data('bs-icon');

                const body = $(this).find('.modal-body');

                $.ajax({
                    url: '<?= base_url('icon_discover/get_detail_icon/') ?>' + icon_id,
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
                                        <a class="btn btn-hi-primary px-4" href="<?= base_url('client/auth/login') ?>">Login</a>
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
                                                <a class="btn btn-hi-primary px-4" href="${'<?= base_url('subscription/index?id=') ?>' + response.data.minimum_subscription.id}">Only ${response.data.minimum_subscription.total_price} <i class="fa fa-arrow-right ms-2"></i></a>
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
        };

        const init = function() {
            initEvents();
            initRestrictionModal();

            initializeDataSearch();

            let searchParams = new URLSearchParams(window.location.search)
            if (searchParams.has('style_id')) {
                toggleParams(type.STYLE, searchParams.get('style_id'));
            }

            if (searchParams.has('category_id')) {
                toggleParams(type.STYLE, searchParams.get('category_id'));
            }

            loadMore();
        };

        return {
            init: () => init()
        }
    }();

    $(function() {
        searchHandle.init();
    });
</script>

<style>
    .search-page {
        border-radius: 25px;
        background-color: #efefef;
        border-radius: 0 30px 30px 0;
    }

    @media (min-width: 768px) {
        .search-page {
            border-radius: 0 100px 100px 0;
        }
    }

    .search-item {
        background-color: #efefef;
        color: black;
        font-size: inherit;
    }

    .search-checkbox {
        padding-left: 20px;
        padding-right: 20px;
    }

    .search-checkbox>div {
        padding-bottom: 5px;
    }

    .search-checkbox label {
        padding: 5px 20px;
        border-radius: var(--bs-border-radius-pill) !important;
        width: 100%;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
    }

    .search-checkbox input[type="checkbox"] {
        display: none;
    }

    .search-checkbox input[type="checkbox"]:checked+label {
        background: linear-gradient(to right, #DF5933, #ce3a64);
        color: white;
    }

    #pagination {
        box-shadow: 0 0.1rem 0.2rem 0 rgb(0 0 0 / 5%);
        border-radius: 23px;
        border: 1px solid #f5f5f5;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        height: 46px;
        width: 300px;
        overflow: hidden;
        margin: auto;
    }

    #pagination span {
        color: #374957;
        font-size: 18px;
        font-weight: 700;
    }

    #pagination div:first-child {
        border-right: 1px solid #f5f5f5;
    }

    #pagination div:nth-child(3) {
        border-left: 1px solid #f5f5f5;
    }

    #pagination>div {
        width: 73px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    #prev-page.disabled>svg,
    #next-page.disabled>svg {
        stroke: #ccc;
    }

    #prev-page:not(.disabled),
    #next-page:not(.disabled) {
        cursor: pointer;
    }

    #prev-page:not(.disabled):hover,
    #next-page:not(.disabled):hover {
        background-color: #e7e7e7;
    }

    #prev-page.disabled,
    #next-page.disabled {
        cursor: not-allowed;
    }
</style>