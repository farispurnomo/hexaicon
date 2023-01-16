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
                    <div class="mb-10 fv-row">
                        <label class="form-label">Image</label>
                        <div>
                            <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url(<?= $record->url_image ?>)">
                                <div class="image-input-wrapper w-150px h-150px"></div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="file" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                </label>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                            </div>
                            <div class="text-muted fs-7">Set the category thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted</div>
                            <?= form_error('file', '<div class="text-danger">', '</div>') ?>
                        </div>
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