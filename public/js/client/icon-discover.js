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

        let html = '<div class="text-center">Data not available</div>';
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
                        <a href="" class="text-decoration-none">
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
        let html = '<div class="text-center">Data not available</div>';
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
            let html = `<div class="text-center">No data available</div>`
            $('#icon-filter-data').html(html);
            return;
        }

        let html = '<div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xxl-6">';
        icons.forEach(icon => {
            const url = helper.getBaseUrl() + 'icon_style/index/' + icon.id;
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

    const init = function () {
        initInputSearch();
        initializeDefaultData();
        initFilterData();
    };

    return {
        init: () => init()
    }
}();

export default menuIconDiscover;