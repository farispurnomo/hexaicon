<div id="kt_content_container" class="container-fluid">
    <form method="POST" action="<?= base_url($route . '/update/' . $record->id) ?>" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">

        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Image</h2>
                    </div>
                </div>
                <div class="card-body text-center pt-0">
                    <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url(<?= $record->url_image ?>)">
                        <div class="image-input-wrapper w-150px h-150px"></div>
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                            <i class="bi bi-pencil-fill fs-7"></i>
                            <input type="file" name="file" accept=".svg" />
                            <input type="hidden" name="avatar_remove" />
                        </label>
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                    </div>
                    <div class="text-muted fs-7">Set the icon thumbnail image. Only *.svg image files is accepted</div>
                    <?= form_error('file', '<div class="text-danger">', '</div>') ?>
                </div>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Icon Subscription</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <?php foreach ($subscriptions as $subscription) : ?>
                        <div class="mb-3">
                            <label class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="<?= $subscription->id ?>" name="subscriptions[]" <?= in_array($subscription->id, $record->subscriptions) ? 'checked' : '' ?>>
                                <span class="form-check-label text-gray-600"><?= $subscription->name ?></span>
                            </label>
                        </div>
                    <?php endforeach ?>
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

                    <div class="mb-10 fv-row">
                        <label class="required form-label">Name</label>
                        <input type="text" name="name" class="form-control mb-2" required value="<?= $record->name ?>" />
                        <?= form_error('name', '<div class="text-danger">', '</div>') ?>
                    </div>

                    <div class="mb-10 fv-row">
                        <label class="form-label">Set</label>
                        <select name="set_id" class="form-select kt-select2 mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option">
                            <option value="">Select</option>
                            <?php foreach ($sets as $set) : ?>
                                <option <?= $set->id == $record->set_id ? 'selected' : '' ?> value="<?= $set->id ?>"><?= $set->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <?= form_error('set_id', '<div class="text-danger">', '</div>') ?>
                    </div>
                    <div class="mb-10 fv-row">
                        <label class="form-label">Style</label>
                        <select name="style_id" class="form-select kt-select2 mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option">
                            <option value="">Select</option>
                            <?php foreach ($styles as $style) : ?>
                                <option <?= $style->id == $record->style_id ? 'selected' : '' ?> value="<?= $style->id ?>"><?= $style->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <?= form_error('style_id', '<div class="text-danger">', '</div>') ?>
                    </div>
                    <div class="mb-10 fv-row">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select kt-select2 mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option">
                            <option value="">Select</option>
                            <?php foreach ($categories as $category) : ?>
                                <option <?= $category->id == $record->category_id ? 'selected' : '' ?> value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <?= form_error('category_id', '<div class="text-danger">', '</div>') ?>
                    </div>

                    <div class="mb-10 fv-row">
                        <label class="form-label">Extension Subscription</label>
                        <ul class="nav nav-pills me-6 mb-3">
                            <?php foreach ($record->formats as $key => $format) : ?>
                                <li class="nav-item m-0">
                                    <a class="btn px-5 btn-sm btn-light btn-color-muted btn-active-primary <?= $key === 0 ? ' active ' : '' ?> me-3" data-bs-toggle="tab" href="#kt_<?= $format->id ?>_pane">
                                        <?= strtoupper($format->name) ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>

                        <div class="tab-content" id="nav-tabContent">

                            <?php foreach ($record->formats as $key => $format) : ?>
                                <div class="tab-pane fade <?= $key === 0 ? 'show active' : '' ?>" id="kt_<?= $format->id ?>_pane" role="tabpanel" tabindex="0">
                                    <?php foreach ($subscriptions as $subscription) : ?>
                                        <div class="mb-3">
                                            <label class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="<?= $subscription->id ?>" name="<?= $format->name ?>[]" <?= in_array($subscription->id, $format->subscriptions) ? 'checked' : '' ?>>
                                                <span class="form-check-label text-gray-600"><?= $subscription->name ?></span>
                                            </label>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            <?php endforeach ?>

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

<script defer>
    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        $('.kt-select2').select2()
    })
</script>