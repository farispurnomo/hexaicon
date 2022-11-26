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
                                            <img width="32" class="img-fluid" src="${icon.url_image}" alt="">
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
                    $('.search-section').removeClass('open');
                    removeBackdrop();
                }, 500)
            },
            focus: function () {
                openBackdrop()
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
                    renderFilterData(response.data.icon_trends);
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
                    <img class="img-fluid" src="${icon.url_image}" />
                </div>`;
            });
            return html;
        };

        let html = '';
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
        $('#icon-styles').html(html)
    };

    const renderCategories = function (categories) {
        let html = '<div class="row row-cols-1 row-cols-md-3 row-cols-lg-5">';
        categories.forEach((category) => {
            html += `
                <div class="col p-3">
                    <a href="" class="text-decoration-none">
                        <div class="icon-category">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <img class="img-fluid" src="${category.url_image}" />
                                </div>
                                <div class="col-8 fw-bold">
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
        html += '</div>';
        $('#icon-categories').html(html);
    }

    const renderFilterData = function (icons) {
        if (!icons.length) {
            let html = `<div class="text-center">No data available</div>`
            $('#icon-filter-data').html(html);
            return;
        }

        let html = '<div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 row-cols-xxl-6">';
        icons.forEach(icon => {
            const url = helper.getBaseUrl() + 'icon_style/index/' + icon.id;
            html += `
                <div class="col">
                    <a href="${url}" class="text-decoration-none">
                        <div class="m-1 m-md-3 icon-item">
                            <div class="text-center">
                                <img class="img-fluid" src="${icon.url_image}"/>
                                <div>${icon.name}</div>
                            </div>
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


        $(document).on('click', '#icon-filter [data-type]', function () {
            const type = $(this).data('type');

            $('#icon-filter div[data-type]').removeClass('bg-hi-primary text-white').addClass('border-hi-primary');
            $(this).removeClass('border-hi-primary').addClass('bg-hi-primary text-white');

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