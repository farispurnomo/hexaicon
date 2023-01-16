<div id="kt_content_container" class="container-fluid">
    <form method="POST" action="<?= base_url($route . '/store') ?>" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">

        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Image</h2>
                    </div>
                </div>
                <div class="card-body text-center pt-0">
                    <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url(<?= base_url('public/src/media/svg/files/blank-image.svg') ?>)">
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
                    <div class="text-muted fs-7">Set the icon thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted</div>
                </div>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Detail Icon</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-10 fv-row">
                        <label class="required form-label">Set</label>
                        <select name="subscription_plan_id" class="form-select kt-select2 mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" required>
                            <option value="">Select</option>
                            <?php foreach ($sets as $set) : ?>
                                <option value="<?= $set->id ?>"><?= $set->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <?= form_error('subscription_plan_id', '<div class="text-danger">', '</div>') ?>
                    </div>
                    <div class="mb-10 fv-row">
                        <label class="required form-label">Style</label>
                        <select name="subscription_plan_id" class="form-select kt-select2 mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" required>
                            <option value="">Select</option>
                            <?php foreach ($styles as $style) : ?>
                                <option value="<?= $style->id ?>"><?= $style->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <?= form_error('subscription_plan_id', '<div class="text-danger">', '</div>') ?>
                    </div>
                    <div class="mb-10 fv-row">
                        <label class="required form-label">Category</label>
                        <select name="subscription_plan_id" class="form-select kt-select2 mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" required>
                            <option value="">Select</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <?= form_error('subscription_plan_id', '<div class="text-danger">', '</div>') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Setting Icon</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="py-3">
                        <?php $this->load->view('partials/admin/admin_alert'); ?>
                    </div>

                    <div>
                        <div>-> Resolusi (tab sheet vertical)</div>
                        <div>-> Resolusi -> Format (list vertical like form)</div>
                        <div>-> Resolusi -> Format -> Subscription (collapse list per format)</div>
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

<script defer>
    const value = "<?php echo set_value('subscription_id'); ?>";
    if (value) {
        document.querySelector('form select[name="subscription_id"]').value = value;
    }

    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        $('.kt-select2').select2()
    })
</script>