<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <h4><strong><?= $icon->name ?></strong></h4>
            </div>
            <div class="mb-3">
                <label class="form-label">Icon size</label>
                <div class="row">
                    <div class="col-10">
                        <input class="form-range" type="range" name="size" min="64" max="256">
                    </div>
                    <div class="col-2">
                        <span id="size-info"></span>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Flip / Mirror</label>
                <div>
                    <div class="btn-group" role="group" id="button-flip">
                        <button type="button" class="btn btn-light" id="flip_original">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="#555" width="16" height="16" transform="matrix(1, 0, 0, 1, 0, 0)">
                                <path d="M 8 1 L 8 13 L 14 13 L 8 1 z M 7 1.0058594 L 1.0078125 13 L 7 13 L 7 1.0058594 z M 6 5.2441406 L 6 12 L 2.6230469 12 L 6 5.2441406 z"></path>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-light" id="flip_horizonal">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="#555" width="16" height="16" transform="matrix(-1, 0, 0, 1, 0, 0)">
                                <path d="M 8 1 L 8 13 L 14 13 L 8 1 z M 7 1.0058594 L 1.0078125 13 L 7 13 L 7 1.0058594 z M 6 5.2441406 L 6 12 L 2.6230469 12 L 6 5.2441406 z"></path>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-light" id="flip_vertical">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="#555" width="16" height="16" transform="matrix(1, 0, 0, -1, 0, 0)">
                                <path d="M 8 1 L 8 13 L 14 13 L 8 1 z M 7 1.0058594 L 1.0078125 13 L 7 13 L 7 1.0058594 z M 6 5.2441406 L 6 12 L 2.6230469 12 L 6 5.2441406 z"></path>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-light" id="flip_horizontal_vertical">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="#555" width="16" height="16" transform="matrix(-1, 0, 0, -1, 0, 0)">
                                <path d="M 8 1 L 8 13 L 14 13 L 8 1 z M 7 1.0058594 L 1.0078125 13 L 7 13 L 7 1.0058594 z M 6 5.2441406 L 6 12 L 2.6230469 12 L 6 5.2441406 z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label>Rotation</label>
                <div class="row">
                    <div class="col-md-10">
                        <input class="form-range" type="range" name="rotate" min="0" max="360" value="0">
                    </div>
                    <div class="col-md-2">
                        <span id="rotate-info"></span>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label>Oultine</label>
                <input class="form-range" id="thickness" type="range" min="0" max="10" value="0" />
            </div>

            <div class="mb-3">
                <label>Outine Color</label>
                <input class="form-control" id="linecolor" type="color" value="#000000" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3" id="vector">
                <?= $icon->vector ?>
            </div>

            <div class="row" id="colors">

            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6 text-center">
            <div class="my-3">
                <div class="dropdown">
                    <button class="btn btn-hi-primary rounded-pill px-5 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-download"></i> Download
                    </button>
                    <ul class="dropdown-menu">
                        <?php foreach ($icon->formats as $format) : ?>
                            <li>
                                <?php if ($format->guest_access) : ?>
                                    <a class="dropdown-item download" data-mode="<?= strtoupper($format->name) ?>" href="#"><?= strtoupper($format->name) ?></a>
                                <?php else : ?>
                                    <?php if ($format->is_unlock) : ?>
                                        <a class="dropdown-item download" data-mode="<?= strtoupper($format->name) ?>" href="#"><?= strtoupper($format->name) ?></a>
                                    <?php else : ?>
                                        <a class="dropdown-item disabled" href="#"><?= strtoupper($format->name) ?></a>
                                    <?php endif ?>
                                <?php endif ?>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-center">
            <div class="my-3">
                <?php if ($client) : ?>
                    <a href="<?= base_url($route . '/add_to_favorite/' . $icon_id) ?>" class="btn rounded-pill <?= ($is_favorite ? 'btn-hi-primary' : 'btn-hi-outline-primary') ?>">
                        <img draggable="false" src="<?= base_url('public/images/icons8-heart-plus-100.png') ?>" width="24" alt="" class="img-fluid">
                        <?= ($is_favorite ? 'Remove From Favorite' : 'Add To Favorite') ?>
                    </a>
                <?php else : ?>
                    <a href="<?= base_url('client/auth/login') ?>" class="btn rounded-pill <?= ($is_favorite ? 'btn-hi-primary' : 'btn-hi-outline-primary') ?>">
                        <img draggable="false" src="<?= base_url('public/images/icons8-heart-plus-100.png') ?>" width="24" alt="" class="img-fluid">
                        Add To Favorite
                    </a>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<canvas class="d-none" id="canvas"></canvas>

<script defer>
    const svgHandle = function() {
        const initSizeControl = function() {
            $(document).on('input', 'input[name="size"]', function() {
                const size = $(this).val();
                $('#vector svg').attr('width', size + 'px')
                    .attr('height', size + 'px');

                $('#size-info').html(size + 'px');
            });
        };

        const initRotationControl = function() {
            $(document).on('input', 'input[name="rotate"]', function() {
                let degree = $(this).val();
                degree = parseInt(degree);

                let transform = $('#vector svg').attr('transform') || '';
                if (transform) {
                    transform = transform.replace(/rotate\(\s*([^)].+?)\s*\)/g, '');
                }

                $('#vector svg').attr('transform', transform + `rotate(${degree})`);

                $('#rotate-info').html(degree + '°');
            });
        };

        const initMirrorControl = function() {
            $(document).on('click', '#flip_original', function() {
                let transform = $('#vector svg').attr('transform') || '';
                if (transform) {
                    transform = transform.replace(/matrix\(\s*([^)].+?)\s*\)/g, '');
                }

                $('#vector svg').attr('transform', transform + 'matrix(1, 0, 0, 1, 0, 0)');

                $('#button-flip button')
                    .removeClass('btn-secondary')
                    .addClass('btn-light')
                    .prop('disabled', false);

                $(this)
                    .removeClass('btn-light')
                    .addClass('btn-secondary')
                    .prop('disabled', true);
            });

            $(document).on('click', '#flip_horizonal', function() {
                let transform = $('#vector svg').attr('transform') || '';
                if (transform) {
                    transform = transform.replace(/matrix\(\s*([^)].+?)\s*\)/g, '');
                }
                $('#vector svg').attr('transform', transform + 'matrix(-1, 0, 0, 1, 0, 0)');

                $('#button-flip button')
                    .removeClass('btn-secondary')
                    .addClass('btn-light')
                    .prop('disabled', false);

                $(this)
                    .removeClass('btn-light')
                    .addClass('btn-secondary')
                    .prop('disabled', true);
            });

            $(document).on('click', '#flip_vertical', function() {
                let transform = $('#vector svg').attr('transform') || '';
                if (transform) {
                    transform = transform.replace(/matrix\(\s*([^)].+?)\s*\)/g, '');
                }
                $('#vector svg').attr('transform', transform + 'matrix(1, 0, 0, -1, 0, 0)');

                $('#button-flip button')
                    .removeClass('btn-secondary')
                    .addClass('btn-light')
                    .prop('disabled', false);

                $(this)
                    .removeClass('btn-light')
                    .addClass('btn-secondary')
                    .prop('disabled', true);
            });

            $(document).on('click', '#flip_horizontal_vertical', function() {
                let transform = $('#vector svg').attr('transform') || '';
                if (transform) {
                    transform = transform.replace(/matrix\(\s*([^)].+?)\s*\)/g, '');
                }
                $('#vector svg').attr('transform', transform + 'matrix(-1, 0, 0, -1, 0, 0)');

                $('#button-flip button')
                    .removeClass('btn-secondary')
                    .addClass('btn-light')
                    .prop('disabled', false);

                $(this)
                    .removeClass('btn-light')
                    .addClass('btn-secondary')
                    .prop('disabled', true);
            });
        };

        const initOutlineControl = function() {
            $(document).on('input', '#thickness, #linecolor', function() {
                const color = $('#linecolor').val();
                const stroke = $('#thickness').val();
                $('#vector svg').attr('stroke-width', stroke).attr('stroke', color);
            });
        };

        const initColorControl = function() {
            const type = {
                ATTRIBUTE: 'ATTRIBUTE',
                INLINE_STYLE: 'INLINE_STYLE',
                INTERNAL_STYLE: 'INTERNAL_STYLE'
            };

            const convertToHexacolor = function(color) {
                // hexacolor
                if (/^#[0-9A-F]{6}$/i.test(color)) {
                    return color;
                }

                if (color.substring(0, 4) === 'rgb(') {
                    color = color.substring(4, color.length - 1);
                };

                color = color.replaceAll(' ', '');
                const [r, g, b] = color.split(',');
                return "#" + (1 << 24 | r << 16 | g << 8 | b).toString(16).slice(1);
            }

            let fill_colors = [];
            let fill_color;
            let color;

            const style_sheets = document.styleSheets;
            const is_have_tag_style = $('svg style').length > 0;
            $('#vector svg').find('*').each(function(i, obj) {
                let index;

                if ($(obj).prop('style')) {
                    color = $(obj).prop('style')['fill'];
                    if (color != '') {
                        color = convertToHexacolor(color);

                        fill_color = fill_colors.find((x) => x.color === color.toUpperCase());
                        if (fill_color) {
                            fill_color.elements.push({
                                type: type.INLINE_STYLE,
                                obj: $(obj)
                            });
                        } else {
                            fill_colors.push({
                                color: color.toUpperCase(),
                                elements: [{
                                    type: type.INLINE_STYLE,
                                    obj: $(obj)
                                }]
                            })
                        }
                    }
                }

                color = $(obj).attr('fill');
                if (color && color != 'none') {
                    color = convertToHexacolor(color);
                    fill_color = fill_colors.find((x) => x.color === color.toUpperCase());
                    if (fill_color) {
                        fill_color.elements.push({
                            type: type.ATTRIBUTE,
                            obj: $(obj)
                        });
                    } else {
                        fill_colors.push({
                            color: color.toUpperCase(),
                            elements: [{
                                type: type.ATTRIBUTE,
                                obj: $(obj)
                            }]
                        })
                    }
                }

                if (is_have_tag_style) {
                    const cssObj = window.getComputedStyle($(obj)[0], null);
                    for (i = 0; i < cssObj.length; i++) {
                        const prop = cssObj.item(i);
                        const value = cssObj.getPropertyValue(prop)

                        if (prop === 'fill' && value !== 'none' && value !== 'rgb(0, 0, 0)') {
                            color = convertToHexacolor(value);

                            fill_color = fill_colors.find((x) => x.color === color.toUpperCase());
                            if (fill_color) {
                                fill_color.elements.push({
                                    type: type.INTERNAL_STYLE,
                                    obj: $(obj)
                                });
                            } else {
                                fill_colors.push({
                                    color: color.toUpperCase(),
                                    elements: [{
                                        type: type.INTERNAL_STYLE,
                                        obj: $(obj)
                                    }]
                                })
                            }
                        }
                    }
                }
            });

            fill_colors.forEach(function(value, index) {
                const html = `
                    <div class="col-md-6 m-auto">
                        <div class="p-2">
                            <input class="form-control" type="color" name="color" data-index="${index}" value="${value.color}"/>
                        </div>
                    </div>
                `;
                $('#colors').append(html);
            });

            $('#colors').on('input', 'input[name="color"]', function() {
                const index = $(this).data('index');
                const color = $(this).val();
                const el = fill_colors[index];

                el.elements.forEach(function(v, index) {
                    if (v.type === type.INLINE_STYLE || v.type === type.INTERNAL_STYLE) {
                        $(v.obj).prop('style')['fill'] = color;
                    }

                    if (v.type === type.ATTRIBUTE) {
                        $(v.obj).attr('fill', color);
                    }
                });
            });
        };

        const initDownloadControl = function() {
            const insertLogDownload = function() {
                $.ajax({
                    url: '<?= base_url('icon_style/download/' . $icon->id) ?>',
                    method: 'GET'
                })
            };

            const saveAsSSVG = function() {
                let triggerDownload = (imgURI) => {
                    let a = document.createElement('a');

                    a.setAttribute('download', '<?= $icon->name ?>-hexaicons');
                    a.setAttribute('href', imgURI);
                    a.setAttribute('target', '_blank');

                    a.click();
                };

                const svg = $('#vector svg')[0];
                const data = (new XMLSerializer()).serializeToString(svg);
                const svgBlob = new Blob([data], {
                    type: 'image/svg+xml;charset=utf-8'
                });

                const url = URL.createObjectURL(svgBlob);

                triggerDownload(url);
            };

            const saveAsPNG = function() {
                const triggerDownload = function(imgURI) {
                    const evt = new MouseEvent('click', {
                        view: window,
                        bubbles: false,
                        cancelable: true
                    });

                    const a = document.createElement('a');
                    a.setAttribute('download', '<?= $icon->name ?>-hexaicons.png');
                    a.setAttribute('href', imgURI);
                    a.setAttribute('target', '_blank');

                    a.dispatchEvent(evt);
                };

                const svg = $('#vector svg')[0];
                const rect = svg.getBoundingClientRect();

                const canvas = $('canvas')[0];
                canvas.height = rect.height;
                canvas.width = rect.width;

                const ctx = canvas.getContext('2d');
                const data = (new XMLSerializer()).serializeToString(svg);
                const DOMURL = window.URL || window.webkitURL || window;

                const img = new Image();
                const svgBlob = new Blob([data], {
                    type: 'image/svg+xml;charset=utf-8'
                });
                const url = DOMURL.createObjectURL(svgBlob);

                img.onload = function() {
                    ctx.drawImage(img, 0, 0);
                    DOMURL.revokeObjectURL(url);

                    const imgURI = canvas
                        .toDataURL('image/png')
                        .replace('image/png', 'image/octet-stream');

                    triggerDownload(imgURI);
                };

                img.src = url;
            };

            $(document).on('click', '.download', function(e) {
                e.preventDefault();

                const type = {
                    PNG: 'png',
                    SVG: 'svg'
                };

                let s_type = $(this).data('mode');
                s_type = type[s_type];
                if (!s_type) return;

                switch (s_type) {
                    case type.PNG:
                        saveAsPNG();

                        insertLogDownload();
                        break;
                    case type.SVG:
                        saveAsSSVG();

                        insertLogDownload();
                        break;

                    default:
                        alert('Request not supported');
                        break;
                }
            })
        };

        return {
            init: () => {
                initSizeControl();
                initMirrorControl();
                initRotationControl();
                initOutlineControl();
                initColorControl();
                initDownloadControl();
            }
        }
    }();

    $(function() {
        svgHandle.init();

        $('input[name="size"]').val('64').trigger('input');
        $('input[name="rotate"]').val('0').trigger('input');
    });
</script>

<style>
    #vector {
        margin: auto;
        /* height: 300px;
        width: 300px; */
        /* height: 100%; */
        height: 300px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-image: url('<?= base_url('public/images/dot.svg') ?>');
    }

    .btn-group {
        box-shadow: 2px 2px 8px #d1d1d1;
    }
</style>