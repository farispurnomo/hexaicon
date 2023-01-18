import helper from './helper.js';

const menuIconDiscover = function () {
    const initInputSearch = function () {

        let is_backdrop = false;
        const openBackdrop = function () {
            if (is_backdrop) return;

            const html = `<div class="modal-backdrop search-backdrop show"></div>`;
            $('body').append(html);
            is_backdrop = true;
        };

        const removeBackdrop = function () {
            $('body').find('.search-backdrop').remove();
            is_backdrop = false;
        };

        const searchQuery = function (keyword) {
            const makeBold = function (input, word) {
                return input.replace(new RegExp(word, 'ig'), '<b>' + word + '</b>');
            }

            $('.search-section').addClass('open');

            $.ajax({
                url: helper.getBaseUrl() + '/icon_discover/search?q=' + keyword,
                method: 'GET',
                dataType: 'JSON',
                success: function (response) {
                    if (response.status == 200) {
                        if (response.data.length) {
                            let html = '';
                            response.data.forEach((icon) => {
                                html += `
                                    <li>
                                        <div data-keyword="${icon.name}" role="button">
                                            <img draggable="false" width="32" loading="lazy" class="img-fluid" src="${icon.url_image}" alt="">
                                            <span>${makeBold(icon.name, keyword)}</span>
                                        </div>
                                    </li>
                                `;
                            })
                            $('.search-section .search-dataset').html(html);
                        } else {
                            $('.search-section').removeClass('open');
                        }
                    }
                },
            })
        };

        let debounce;
        $('#input-search').on({
            input: function () {
                const value = this.value;
                if (value) {
                    $(this).siblings('.icon-clear').css('display', 'flex');

                    clearTimeout(debounce);
                    debounce = setTimeout(function () {
                        searchQuery(value);
                    }, 200);

                } else {
                    $(this).siblings('.icon-clear').css('display', 'none');
                    $('.search-section').removeClass('open');
                }
            },
            blur: function () {
                setTimeout(function () {
                    $('.search-section').removeClass('open').css('z-index', 'unset');
                    removeBackdrop();
                }, 200)
            },
            focus: function () {
                $('.search-section').css('z-index', '1051');
                openBackdrop();
            }
        });

        $('.search-section .icon-clear').on('click', function () {
            $('#input-search').val('').trigger('input');
        })

        $(document).on('click', '.search-section [data-keyword]', function () {
            const keyword = $(this).data('keyword');
            if (!keyword) return;

            window.location.href = helper.getBaseUrl() + 'icon_search?q=' + keyword;
        });
    };

    const initializeDefaultData = function () {
        $.ajax({
            url: helper.getBaseUrl() + '/icon_discover/get_data',
            method: 'GET',
            dataType: 'JSON',
            beforeSend: function () {

            },
            success: function (response) {
                if (response.status == 200) {
                    renderCategories(response.data.categories);

                    renderIconStyle(response.data.icon_styles);
                    renderIconset(response.data.icon_sets);

                    renderFilterData(response.data.icon_popular);
                }
            },
            error: function () {

            }
        })
    };

    const renderIconStyle = function (styles) {
        const renderIcons = function (icons) {
            let html = '';
            icons.forEach((icon) => {
                html += `
                <div class="col-4 text-center p-3">
                    <img draggable="false" class="img-fluid" width="96" loading="lazy" src="${icon.url_image}" />
                </div>`;
            });
            return html;
        };

        let html = `
            <div class="text-center">
                <div>
                    <lottie-player class="m-auto" src="${helper.getBaseUrl() + 'public/images/25943-nodata.json'}"  background="transparent"  speed="1"  style="width: 300px; height: 300px;" loop autoplay/>
                </div>
                <div>No Data Available</div>
            </div>
        `;
        if (styles.length) {
            html = '';
            styles.forEach((style) => {
                html += `
                <div class="col-md-3 p-3">
                    <a href="" class="text-black text-decoration-none">
                        <div class="bg-white rounded">
                            <div class="row">
                                ${renderIcons(style.icons)}
                            </div>
                        </div>
                        <div class="text-center fw-bold py-3">
                            <div>Icon ${style.name}</div>
                        </div>
                    </a>
                </div>
            `;
            });
        }
        $('#icon-styles').html(html)
    };

    const renderCategories = function (categories = []) {
        let html = '<div class="row row-cols-1 row-cols-md-3 row-cols-lg-5">';
        if (categories.length) {
            categories.forEach((category) => {
                html += `
                        <div class="col-6 col p-3">
                            <a href="" class="text-decoration-none">
                                <div class="icon-category">
                                    <div class="row align-items-center">
                                        <div class="col-xl-4 text-center">
                                            <img draggable="false" class="img-fluid" loading="lazy" src="${category.url_image}" />
                                        </div>
                                        <div class="col-xl-8 text-center text-xl-start fw-bold">
                                            ${category.name}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `;
            });

            html += `
                    <div class="col p-3">
                        <a href="javascript:void(0)" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#categoriesModal">
                            <div class="icon-category bg-hi-primary justify-content-center">
                                <div class="row align-items-center">
                                    <div class="col-12 fw-bold text-center h4">
                                        All <br/> Categories
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
        }
        html += '</div>';
        $('#discover-icon-categories').html(html);
    }

    const renderIconset = function (sets) {
        let html = `<div class="text-center">
            <div>
                <lottie-player class="m-auto" src="${helper.getBaseUrl() + 'public/images/25943-nodata.json'}"  background="transparent"  speed="1"  style="width: 300px; height: 300px;" loop autoplay/>
            </div>
            <div>No Data Available</div>
        </div>`;
        if (sets.length) {
            const set_1 = function () {

                const renderIcons = function (icons) {
                    let result = '';
                    // for (let i = 0, n = icons.length; i < n; i++) {
                    for (let i = 0, n = 20; i < n; i++) {
                        const element = icons[i];

                        if (element) {
                            const url = helper.getBaseUrl() + 'icon_style/index/' + element.id;
                            result += `
                                <div class="text-center p-3 d-flex align-items-center justify-content-center">
                                    <a href="${url}">
                                        <img loading="lazy" width="96" src="${element.url_image}" draggable="false" class="rounded img-fluid"/>
                                    </a>
                                </div>
                            `;
                        }
                    }
                    return result;
                };

                let result = '';
                if (sets[0]) {
                    result = `
                        <div class="bg-white icon-set-content position-relative">
                            <div class="row row-cols-4 row-cols-md-5 h-100">
                                ${renderIcons(sets[0].icons)}
                            </div>
                            <a href="" class="text-center footer btn btn-hi-primary">
                                <div class="d-flex justify-content-center align-items-center h4">
                                    ${sets[0].name}
                                </div>
                            </a>
                        </div>
                `;
                }
                return result;
            };

            const set_2 = function () {

                const renderIcons = function (icons) {
                    let result = '';
                    // for (let i = 0, n = icons.length; i < n; i++) {
                    for (let i = 0, n = 20; i < n; i++) {
                        const element = icons[i];
                        if (element) {
                            const url = helper.getBaseUrl() + 'icon_style/index/' + element.id;
                            result += `
                                <div class="text-center p-3">
                                    <a href="${url}">
                                        <img loading="lazy" width="96" src="${element.url_image}" draggable="false" class="rounded img-fluid"/>
                                    </a>
                                </div>
                            `;
                        }
                    }
                    return result;
                };

                let result = '';
                if (sets[1]) {
                    result = `
                    <div class="col-12 p-3">
                        <div class="bg-white icon-set-content">
                            <div class="row row-cols-4 row-cols-md-5">
                                ${renderIcons(sets[1].icons)}
                            </div>
                            <a href="" class="text-center footer btn btn-hi-primary">
                                <div class="d-flex justify-content-center align-items-center h4">
                                    ${sets[1].name}
                                </div>
                            </a>
                        </div>
                    </div>
                `;
                }
                return result;
            };

            const set_3 = function () {

                const renderIcons = function (icons) {
                    let result = '';
                    for (let i = 0; i < 9; i++) {
                        const element = icons[i];

                        if (element) {
                            const url = helper.getBaseUrl() + 'icon_style/index/' + element.id;
                            result += `
                                <div class="col-4 text-center p-3">
                                    <a href="${url}">
                                        <img loading="lazy" width="96" src="${element.url_image}" draggable="false" class="rounded img-fluid"/>
                                    </a>
                                </div>
                            `;
                        }
                    }
                    return result;
                };

                let result = '';
                if (sets[2]) {
                    result = `
                    <div class="col-md-6 p-3">
                        <div class="bg-white icon-set-content">
                            <div class="row">
                                ${renderIcons(sets[2].icons)}
                            </div>
                            <a href="" class="text-center footer btn btn-secondary">
                                <div class="d-flex justify-content-center align-items-center h4">
                                    ${sets[2].name}
                                </div>
                            </a>
                        </div>
                    </div>
                `;
                }
                return result;
            };

            const set_4 = function () {
                const renderIcons = function (icons) {
                    let result = '';
                    for (let i = 0; i < 9; i++) {
                        const element = icons[i];

                        if (element) {
                            const url = helper.getBaseUrl() + 'icon_style/index/' + element.id;
                            result += `
                                <div class="col-4 text-center p-3">
                                    <a href="${url}">
                                        <img loading="lazy" width="96" src="${element.url_image}" draggable="false" class="rounded img-fluid"/>
                                    </a>
                                </div>
                            `;
                        }
                    }
                    return result;
                };

                let result = '';
                if (sets[3]) {
                    result = `
                    <div class="col-md-6 p-3">
                        <div class="bg-white icon-set-content">
                            <div class="row">
                                ${renderIcons(sets[3].icons)}
                            </div>
                            <a href="" class="text-center footer btn btn-secondary">
                                <div class="d-flex justify-content-center align-items-center h4">
                                    ${sets[3].name}
                                </div>
                            </a>
                        </div>
                    </div>
                `;
                }
                return result;
            };

            html = `
                <div class="col-md-6 p-3">
                    ${set_1()}
                </div>
                
                <div class="col-md-6">
                    <div class="row">
                        ${set_2()}
                    </div>
                    <div class="row">
                        ${set_3()}
                        ${set_4()}
                    </div>
                </div>
            `;
        }

        $('#discover-icon-sets').html(html);
    }

    const renderFilterData = function (icons) {
        if (!icons.length) {
            let html = `
                <div class="text-center">
                    <div>
                        <lottie-player class="m-auto" src="${helper.getBaseUrl() + 'public/images/25943-nodata.json'}"  background="transparent"  speed="1"  style="width: 300px; height: 300px;" loop autoplay/>
                    </div>
                    <div>No Data Available</div>
                </div>
                `;
            $('#icon-filter-data').html(html);
            return;
        }

        let html = '<div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xxl-6">';
        icons.forEach(icon => {
            const url = helper.getBaseUrl() + 'icon_style/index/' + icon.id;

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

        html += '</div>';

        $('#icon-filter-data').html(html);
    };

    const initFilterData = function () {
        const renderLoading = function () {
            let html = '<div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 row-cols-xxl-6">';
            for (let i = 0; i <= 20; i++) {
                html += `
                    <div class="col placeholder-glow placeholder-trending">
                        <div class="m-1 m-md-3">
                            <div class="placeholder w-100"></div>
                        </div>
                    </div>`;
            }
            html += '</div>';
            $('#icon-filter-data').html(html);
        };


        $(document).on('click', '#icon-filter input[name="icon_categories"]', function () {
            const type = $(this).val();

            // $('#icon-filter div[data-type]').removeClass('bg-hi-primary text-white').addClass('border-hi-primary');
            // $(this).removeClass('border-hi-primary').addClass('bg-hi-primary text-white');

            $.ajax({
                url: helper.getBaseUrl() + '/icon_discover/get_icons',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    type: type
                },
                beforeSend: renderLoading,
                success: function (response) {
                    if (response.status == 200) {
                        renderFilterData(response.data);
                    }
                },
                error: function () {

                }
            });
        });
    };

    const initRestrictionModal = function () {
        $('#restrictionModal').on('show.bs.modal', function (e) {
            const button = e.relatedTarget;
            const icon_id = $(button).data('bs-icon');

            const body = $(this).find('.modal-body');

            $.ajax({
                url: helper.getBaseUrl() + 'icon_discover/get_detail_icon/' + icon_id,
                method: 'GET',
                dataType: 'JSON',
                beforeSend: function () {
                    body.html('<div class="text-center p-5"><i class="fa fa-spin fa-spinner fa-2x"></i></div>')
                },
                success: function (response) {
                    if (response.status == 200) {

                        if (!response.is_login) { // jika belum login
                            // if (response.data.guest_access) { // jika access gratis diberikan
                            // suruh login

                            body.html(`
                                    <div class="text-center">
                                        <div class="my-4">
                                            <img loading="lazy" class="img-fluid" width="48" src="${helper.getBaseUrl() + 'public/images/min-logo-color.png'}"/>
                                        </div>
                                        <div class="mb-3 h4">You must login first</div>
                                        <a class="btn btn-hi-primary px-4" href="${helper.getBaseUrl() + 'client/auth/login'}">Login</a>
                                    </div>
                                `);

                            // }
                        } else { // sudah login
                            if (!response.data.is_unlock) {// jika subscription tidak sesuai
                                // suruh bayar

                                if (response.data.minimum_subscription) {
                                    body.html(`
                                        <div class="text-center">
                                            <div class="my-4">
                                                <img loading="lazy" class="img-fluid" width="48" src="${helper.getBaseUrl() + 'public/images/min-logo-color.png'}"/>
                                            </div>
                                            <div class="mb-3 h4">Unlock with ${response.data.minimum_subscription.name}</div>
                                            <a class="btn btn-hi-primary px-4" href="${helper.getBaseUrl() + 'subscription/index?id=' + response.data.minimum_subscription.id}">Only ${response.data.minimum_subscription.total_price} <i class="fa fa-arrow-right ms-2"></i></a>
                                        </div>
                                    `);
                                } else {
                                    body.html(`
                                        <div class="text-center">
                                            <div class="my-4">
                                                <img loading="lazy" class="img-fluid" width="48" src="${helper.getBaseUrl() + 'public/images/min-logo-color.png'}"/>
                                            </div>
                                            <div class="mb-3 h4">Icon not supported anymore</div>
                                            <div>Please <a href="${helper.getBaseUrl() + 'contact_us'}">contact us</a> if you're think this is a mistake</div>
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

    const initCategoriesModal = function () {
        let current_page = 1;
        let body;

        const load_more = function () {
            $.ajax({
                url: helper.getBaseUrl() + 'icon_discover/get_categories?page=' + current_page,
                method: 'GET',
                dataType: 'JSON',
                beforeSend: function () {
                    let html = '';
                    for (let i = 0; i < 6; i++) {
                        html += `
                            <div class="col-6 col p-3 placeholder-glow">
                                <div class="p-5 col-12 placeholder rounded"></div>
                            </div>
                        `;
                    }
                    body.find('#modal-category-list').append(html);
                },
                success: function (response) {
                    current_page++;

                    let html = '';
                    body.find('#modal-category-list').find('.placeholder-glow').remove();

                    response.data.categories.forEach(category => {
                        html += `
                            <div class="col-6 col p-3">
                                <a href="" class="text-decoration-none">
                                    <div class="icon-category-2">
                                        <div class="row gx-0 align-items-center">
                                            <div class="col-xl-4 text-center" style="background-color: #eeeeee">
                                                <img draggable="false" class="img-fluid" loading="lazy" src="${category.url_image}" />
                                            </div>
                                            <div class="col-xl-8 fw-bold">
                                                <div class="px-3">${category.name}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        `;
                    });

                    body.find('#modal-category-list').append(html);

                    if (response.data.is_done) {
                        $('#load-more-wrapper').addClass('d-none');
                    }
                }
            })
        };

        $('#categoriesModal').on('show.bs.modal', function () {
            current_page = 1;
            body = $(this).find('.modal-body');
            body.find('#modal-category-list').empty()
            $('#load-more-wrapper').removeClass('d-none');

            load_more();
        });

        $(document).on('click', '#load-more-wrapper', function () {
            load_more();
        })
    };

    const init = function () {
        initInputSearch();
        initializeDefaultData();
        initFilterData();
        initRestrictionModal();
        initCategoriesModal();
    };

    return {
        init: () => init()
    }
}();

export default menuIconDiscover;