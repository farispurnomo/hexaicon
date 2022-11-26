import helper from './helper.js';

const menuIconStyle = function () {
    let data_icon = null,
        size_id = null,
        current_page = 1;

    const handleEvents = function () {
        $(document).on('change', '#icon-sizes input[name="icon_size_id"]', function () {
            size_id = this.value;

            const resolution = data_icon.resolutions.find((x) => x.id == size_id);
            if (!resolution) return;

            const html = `<img width="${resolution.size}" src="${helper.getBaseUrl() + resolution.image}"/>`;
            $('#icon-preview').html(html);

            renderFormats();
        });

        $(document).on('click', '#btn-load-more', function () {
            $(this).remove();
            // $(this).prop('disabled', true);
            // $(this).html('<i class="fa fa-spin fa-spinner"></i> Please Wait ...');

            current_page++;
            requestCategories();
        });
    };

    const renderSizes = function () {
        let html = '';

        if (data_icon.resolutions.length) {
            data_icon.resolutions.forEach(resolution => {
                html += `
                    <div class="col-6 col-sm-3 p-2 text-center">
                        <div class="custom-hi-radio-primary">
                            <input id="size-${resolution.id}" type="radio" name="icon_size_id" value="${resolution.id}">
                            <label for="size-${resolution.id}" class="rounded-pill w-100 py-2">${resolution.name}</label>
                        </div>
                    </div>
                `;
            });
            $('#icon-sizes').html(html);
            $('#icon-sizes input:first').click();
            return;
        }

        html = '<div class="text-center">No data Available</div>';
        $('#icon-sizes').html(html);
        renderFormats();
        $('#icon-preview').html('');
    };

    const renderFormats = function () {
        let html = '<div class="text-center">No data Available</div>';

        const formats = data_icon.resolutions.find((x) => x.id === size_id)?.formats || [];
        if (formats.length) {
            html = '';
            formats.forEach((format) => {
                html += `
                    <div class="col-6 col-sm-3 p-2 text-center">
                        <a href="${helper.getBaseUrl() + 'icon_style/download/' + format.id}" class="btn rounded-pill px-4 btn-hi-outline-primary w-100">${format.name}</a>
                    </div>
                `;
            });
        }
        $('#icon-formats').html(html);
    };

    const renderCategoryWithIcons = function (category) {
        const renderIcons = function (icons) {
            let html = '';
            icons.forEach(icon => {
                const url = helper.getBaseUrl() + 'icon_style/index/' + icon.id;
                html += `
                    <div class="col-auto">
                        <div class="discover-item-card h-100 p-3">
                            <a href="${url}" class="text-decoration-none text-black">
                                <div class="text-center">
                                    <img class="img-fluid" src="${icon.url_image}"/>
                                    <div>${icon.name}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                `;
            })
            return html;
        };

        const html = `
            <div class="row mb-5">
                <div class="col-12">
                    <div class="fw-bold text-capitalize">${category.name.toLowerCase()}</div>
                    <div class="row">
                        ${renderIcons(category.icons)}
                    </row>
                </div>
            </div>
        `;
        $('#suggestion-icons').append(html);
    };

    const requestDataIcon = function (icon_id) {
        $.ajax({
            url: helper.getBaseUrl() + 'icon_style/get_icon/' + icon_id,
            method: 'GET',
            dataType: 'JSON',
            success: function (response) {
                if (response.status == 200) {
                    data_icon = response.data.icon;
                    $('#icon-name').html(response.data.icon.name);
                    renderSizes();
                    const category = {
                        name: 'suggestions',
                        icons: response.data.suggestions
                    };
                    renderCategoryWithIcons(category);

                    requestCategories();
                }

            }
        })
    };

    const requestCategories = function () {
        const renderLoading = function () {
            const renderIcons = function (total) {
                let html = ''
                for (let i = 0; i < total; i++) {
                    html += `
                        <div class="col-auto">
                            <div class="text-center p-3" style="width: 128px">
                                <div style="aspect-ratio: 1/1" class="img-fluid p-5 placeholder rounded"></div>
                                <div class="placeholder placeholder-lg col-8"></div>
                            </div>
                        </div>
                    `;
                }
                return html
            };
            const renderCategories = function (total) {
                let html = '';
                for (let i = 0; i < total; i++) {
                    html += `
                        <div class="col-12">
                            <div class="placeholder placeholder-lg rounded col-md-4"></div>
                            <div class="row">
                                ${renderIcons(13)}
                            </div>
                        </div>
                    `;
                }
                return html;
            }
            let html = `
                <div class="row placeholder-glow">
                    ${renderCategories(2)}
                </div>
            `;
            $('#suggestion-icons').append(html);
        };

        $.ajax({
            url: helper.getBaseUrl() + 'icon_style/get_more_icons?page=' + current_page,
            method: 'GET',
            dataType: 'JSON',
            beforeSend: renderLoading,
            success: function (response) {
                $('#suggestion-icons').find('.placeholder-glow').remove()

                if (response.status == 200) {
                    response.data.categories.forEach((category) => {
                        renderCategoryWithIcons(category);
                    });

                    $('#suggestion-icons').find('#load-more-wrapper').remove();
                    if (!response.data.is_done) {
                        $('#suggestion-icons').append(`
                            <div class="row" id="load-more-wrapper">
                                <div class="col-12 text-center py-3">
                                    <button type="button" id="btn-load-more" class="btn rounded-pill px-4 btn-hi-primary">Load More</button>
                                </div>
                            </div> 
                        `);
                    }
                }

            }
        })
    }

    const init = function (icon_id) {
        handleEvents();
        requestDataIcon(icon_id);
    };

    return {
        init: (icon_id) => init(icon_id)
    };
}();
export default menuIconStyle;