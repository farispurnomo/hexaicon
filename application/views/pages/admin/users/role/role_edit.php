<div id="kt_content_container" class="container-fluid">
    <form method="POST" action="<?= base_url($route . '/update/' . $record->id) ?>" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">

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
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control mb-2" value="<?= $record->description ?>" />
                        <?= form_error('description', '<div class="text-danger">', '</div>') ?>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="<?= base_url($route . '/index') ?>" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                    <span class="indicator-label">Update</span>
                </button>
            </div>
        </div>

    </form>
</div>