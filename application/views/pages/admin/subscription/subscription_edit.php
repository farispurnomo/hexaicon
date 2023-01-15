<div id="kt_content_container" class="container-fluid">
    <form method="POST" action="<?= base_url($route . '/store') ?>" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">

        <div class="d-flex flex-column flex-row-fluid gap-12">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2><?= $pagetitle ?></h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-10 fv-row">
                        <label class="required form-label">Name</label>
                        <input type="text" name="name" class="form-control mb-2" required value="<?= $record->name ?>" />
                        <?= form_error('name', '<div class="text-danger">', '</div>') ?>
                    </div>
                    <div class="mb-10 fv-row">
                        <label class="required form-label">Description</label>
                        <input type="text" name="description" class="form-control mb-2" required value="<?= $record->description ?>" />
                        <?= form_error('description', '<div class="text-danger">', '</div>') ?>
                    </div>
                    <div class="mb-10 fv-row">
                        <label class="required form-label">Price</label>
                        <input type="text" name="price" class="form-control mb-2 autonumeric" required value="<?= $record->total_price ?>" />
                        <?= form_error('price', '<div class="text-danger">', '</div>') ?>
                    </div>
                    <div class="mb-10 fv-row">
                        <label class="form-label">Item</label>
                        <div id="draggable-zone">
                            <?php foreach ($record->items as $item) : ?>
                                <div class="row mb-3 draggable" data-id="<?= $item->order ?>">
                                    <div class="col-1">
                                        <div class="d-flex align-items-center justify-content-center h-100 w-100 text-hover-dark draggable-handle" role="button">
                                            <i class="fa fa-bars"></i>
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" value="<?= $item->name ?>" class="form-control mb-2" required />
                                    </div>
                                    <div class="col-1">
                                        <div class="d-flex align-items-center justify-content-center h-100 w-100 text-hover-danger delete-item" role="button">
                                            <i class="fa fa-trash"></i>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div>
                            <button type="button" id="add-item" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="<?= base_url($route . '/index') ?>" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                    <span class="indicator-label">Save</span>
                </button>
            </div>
        </div>

    </form>
</div>

<script src="<?= base_url('public/vendor/sortable/sortable.min.js') ?>"></script>
<script src="<?= base_url('public/vendor/autonumeric/autoNumeric.min.js') ?>"></script>

<script defer>
    const KTHandleForm = function() {
        const init = function() {
            let counter = <?= count($record->items) + 1 ?>;

            $(document).on('click', '#add-item', function() {
                $('#draggable-zone').append(`
                    <div class="row mb-3 draggable" data-id="${counter}">
                        <div class="col-1">
                            <div class="d-flex align-items-center justify-content-center h-100 w-100 text-hover-dark draggable-handle" role="button">
                                <i class="fa fa-bars"></i>
                            </div>
                        </div>
                        <div class="col-10">
                            <input type="text" class="form-control mb-2" required />
                        </div>
                        <div class="col-1">
                            <div class="d-flex align-items-center justify-content-center h-100 w-100 text-hover-danger delete-item" role="button">
                                <i class="fa fa-trash"></i>
                            </div>
                        </div>
                    </div>
                `);

                counter++;
            });

            $(document).on('click', '.delete-item', function() {
                console.log($(this).parentsUntil('#draggable-zone'));
                $(this).parentsUntil('#draggable-zone').remove();
            });

            new AutoNumeric.multiple('.autonumeric', {
                unformatOnSubmit: true,
                modifyValueOnWheel: false,
                onInvalidPaste: 'truncate',
                decimalPlaces: 0,
            });

            const containers = document.getElementById('draggable-zone');
            const sortable = new Sortable(containers, {
                sort: true,
                draggable: '.draggable',
                handle: '.draggable .draggable-handle',
                animation: 150,
                dataIdAttr: 'data-id'
            });

            $(document).on('submit', 'form', function(e) {
                e.preventDefault();

                const items = sortable.toArray({
                    attribute: 'data-id'
                });

                const formdata = new FormData();
                formdata.append('name', $(this).find('input[name="name"]').val());
                formdata.append('description', $(this).find('input[name="description"]').val());
                formdata.append('price', $(this).find('input[name="price"]').val());

                items.forEach((item, key) => {
                    formdata.append(`items[${key}][name]`, $('#draggable-zone').find(`div[data-id="${item}"] input`).val());
                    formdata.append(`items[${key}][order]`, key);
                });

                $.ajax({
                    url: '<?= base_url($route . '/update/' . $id) ?>',
                    dataType: 'JSON',
                    data: formdata,
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire({
                                html: 'Data Successfully Saved',
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                },
                            }).then(function(result) {
                                window.location.href = "<?= base_url($route) ?>"
                            });
                        } else {
                            Swal.fire({
                                html: response.msg,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again later.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                })

                return false
            })
        };

        return {
            init: () => init()
        }
    }();

    KTUtil.onDOMContentLoaded(function() {
        KTHandleForm.init();
    })
</script>