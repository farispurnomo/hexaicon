import helper from './helper.js';

const canvasHandle = function () {
    let canvas, ctx, image;

    const mimes_support = {
        png: 'png',
        jpg: 'jpg',
        svg: 'svg'
    };

    const init = function () {
        canvas = document.createElement('canvas');
        canvas.style.width = '100%';
        canvas.style.height = '100%';
        ctx = canvas.getContext('2d');

        const element = document.getElementById('icon-preview')
        element.textContent = '';
        element.appendChild(canvas);
    };

    const draw = function (size) {
        const wrh = image.width / image.height;
        let newwidth = size
        let newheight = size

        if (newheight > canvas.height) {
            newheight = canvas.height;
            newwidth = newheight * wrh;
        }

        const xoffset = newwidth < canvas.width ? ((canvas.width - newwidth) / 2) : 0;
        const yoffset = newheight < canvas.height ? ((canvas.height - newheight) / 2) : 0;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        ctx.drawImage(image, xoffset, yoffset, newwidth, newheight);
    }

    const download = function (format, size) {
        const canvas = document.createElement('canvas')
        const ctx = canvas.getContext('2d');

        canvas.width = size;
        canvas.height = size;

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
        const link = document.createElement('a');

        switch (format.toLowerCase()) {
            case mimes_support.png:
                link.download = 'filename.png';
                link.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream")
                link.click();
                break;

            case mimes_support.jpg:
                link.download = 'filename.jpg';
                link.href = canvas.toDataURL('image/jpg');
                link.click();
                break;

            case mimes_support.svg:
                link.download = 'filename.svg';
                let svg = '<?xml version="1.0"?>';
                svg = `<svg width="${size}" height="${size}" viewBox="0 0 ${size} ${size}" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">`;
                svg += `<image width="${size}" height="${size}" xlink:href="${canvas.toDataURL()}"/>`;
                svg += '</svg>';
                link.href = 'data:image/svg+xml;utf8,' + svg;
                // document.body.appendChild(link);
                link.click();
                // document.body.removeChild(link);
                break;

            default:
                alert('unsupported format');
                break;
        }
    }

    return {
        init: () => init(),
        setIcon: (icon) => image = icon,
        draw: (size = 64) => draw(size),
        download: (format, size) => download(format, size)
    }
}();

const menuIconStyle = function () {
    let data_icon = null,
        size_id = null,
        current_page = 1;

    const handleEvents = function () {
        $(document).on('change', '#icon-sizes input[name="icon_size_id"]', function () {
            size_id = this.value;

            const resolution = data_icon.resolutions.find((x) => x.id == size_id);
            if (!resolution) return;

            canvasHandle.draw(resolution.size);

            renderFormats();
        });

        $(document).on('click', '#btn-load-more', function () {
            $(this).remove();
            // $(this).prop('disabled', true);
            // $(this).html('<i class="fa fa-spin fa-spinner"></i> Please Wait ...');

            current_page++;
            requestCategories();
        });

        $(document).on('click', '[data-format]', function () {
            const format_id = $(this).data('format');

            let resolution;
            let format;
            for (let i = 0, n = data_icon.resolutions.length; i < n; i++) {
                const element = data_icon.resolutions[i];

                const temp_format = element.formats.find((x) => x.id == format_id)
                if (temp_format) {
                    resolution = element;
                    format = temp_format;
                    break;
                }
            }
            if (!resolution || !format) return;

            $.ajax({
                url: helper.getBaseUrl() + 'icon_style/download/' + format_id,
                method: 'GET',
            })
            canvasHandle.download(format.name, resolution.size);
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
    };

    const renderFormats = function () {
        let html = '<div class="text-center">No data Available</div>';

        const formats = data_icon.resolutions.find((x) => x.id === size_id)?.formats || [];
        if (formats.length) {
            html = '';
            formats.forEach((format) => {
                html += `
                    <div class="col-6 col-sm-3 p-2 text-center">
                        <!--<a href="${helper.getBaseUrl() + 'icon_style/download/' + format.id}" class="btn rounded-pill px-4 btn-hi-outline-primary w-100"><i class="fa fa-download"></i> ${format.name}</a>-->
                        <button data-format="${format.id}" class="btn rounded-pill px-4 btn-hi-outline-primary w-100"><i class="fa fa-download"></i> ${format.name}</button>
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
                        <div class="style-item-card h-100 p-3">
                            <a href="${url}" class="text-decoration-none text-black">
                                <div class="text-center">
                                    <img loading="lazy" width="96" draggable="false" class="img-fluid" src="${icon.url_image}"/>
                                    <!--<img draggable="false" class="img-fluid" src="http://localhost/ap2/public/images/icons8-heart-plus-100.png"/>-->
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
                <div class="col-12 px-md-4">
                    <div class="fw-bold text-capitalize h5 text-nowrap">${category.name.toLowerCase()}</div>
                    <div class="row">
                        ${renderIcons(category.icons)}
                    </row>
                </div>
            </div>
        `;
        $('#suggestion-icons').append(html);
    };

    const image_processor = function (src) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = () => resolve(img);
            img.onerror = reject;
            img.src = src;
            // img.src = 'http://localhost/ap2/public/images/icons8-heart-plus-100.png';
        });
    };

    const requestDataIcon = function (icon_id) {
        $.ajax({
            url: helper.getBaseUrl() + 'icon_style/get_icon/' + icon_id,
            method: 'GET',
            dataType: 'JSON',
            success: async function (response) {
                if (response.status == 200) {
                    data_icon = response.data.icon;
                    $('#icon-name').html(response.data.icon.name);

                    try {
                        const image = await image_processor(data_icon.url_image);
                        canvasHandle.setIcon(image);
                        canvasHandle.draw();
                    } catch (error) {
                        alert('Image temporary not available, please try again later');
                        $('#image-detail-section').remove();
                    }


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
                                <div class="col-12 text-center py-3 px-md-4">
                                    <div id="wrapper">
                                        <button type="button" id="btn-load-more" class="btn rounded-pill px-4 btn-hi-primary">Load More</button>
                                    </div>
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

        canvasHandle.init();
    };

    return {
        init: (icon_id) => init(icon_id)
    };
}();
export default menuIconStyle;