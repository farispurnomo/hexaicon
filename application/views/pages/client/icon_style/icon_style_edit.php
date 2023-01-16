<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <h4><strong><?= $icon->name ?></strong></h4>
            </div>
            <div class="mb-3">
                <label class="form-label">Icon size</label>
                <input class="form-range" type="range" name="size" min="64" max="256">
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
                <input class="form-range" type="range" name="rotate" min="0" max="360" value="0">
            </div>
        </div>
        <div class="col-md-6">
            <div id="vector">
                <?= $icon->vector ?>
            </div>
        </div>
    </div>
</div>

<script defer>
    $(function() {
        $(document).on('input', 'input[name="size"]', function() {
            const size = $(this).val();
            $('#vector svg').attr('width', size + 'px')
                .attr('height', size + 'px');
        });

        $('input[name="size"]').val('64').trigger('input');

        $(document).on('input', 'input[name="rotate"]', function() {
            let degree = $(this).val();
            degree = parseInt(degree);

            let transform = $('#vector svg').attr('transform') || '';
            if (transform) {
                transform = transform.replace(/rotate\(\s*([^)].+?)\s*\)/g, '');
            }

            $('#vector svg').attr('transform', transform + `rotate(${degree})`);
        });

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
</style>