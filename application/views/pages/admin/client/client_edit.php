<div id="kt_content_container" class="container-fluid">
    <form method="POST" action="<?= base_url($route . '/update/' . $record->id) ?>" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">

        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Avatar</h2>
                    </div>
                </div>
                <div class="card-body text-center pt-0">
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
                    <div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted</div>
                </div>
            </div>
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2 class="required">Subscription</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select name="subscription_plan_id" class="form-select kt-select2 mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" required>
                        <?php foreach ($subscriptions as $subscription) : ?>
                            <option value="<?= $subscription->id ?>" <?= $subscription->id == $record->subscription_plan_id ? 'selected' : '' ?>><?= $subscription->name ?></option>
                        <?php endforeach ?>
                    </select>
                    <?= form_error('subscription_plan_id', '<div class="text-danger">', '</div>') ?>
                    <div class="d-none mt-10">
                        <label for="kt_ecommerce_add_product_status_datepicker" class="form-label">Select publishing date and time</label>
                        <input class="form-control" id="kt_ecommerce_add_product_status_datepicker" placeholder="Pick date &amp; time" />
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2><?= $pagetitle ?></h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="py-3">
                        <?php $this->load->view('partials/admin/admin_alert'); ?>
                    </div>

                    <div class="mb-10 fv-row">
                        <label class="required form-label">Email</label>
                        <input type="email" name="email" class="form-control mb-2" value="<?= $record->email ?>" disabled />
                        <?= form_error('email', '<div class="text-danger">', '</div>') ?>
                    </div>
                    <div class="mb-10 fv-row">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control mb-2" />
                        <div class="form-text">Leave blank if doesn't change the password.</div>
                        <?= form_error('password', '<div class="text-danger">', '</div>') ?>
                    </div>
                    <div class="mb-10 fv-row">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control mb-2" value="<?= $record->name ?>" />
                    </div>
                    <div class="mb-10 fv-row">
                        <label class="form-label">Job</label>
                        <input type="text" name="position" class="form-control mb-2" value="<?= $record->position ?>" />
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

<script>
    const value = "<?php echo set_value('subscription_id'); ?>";
    if (value) {
        document.querySelector('form select[name="subscription_id"]').value = value;
    }

    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        $('.kt-select2').select2()
    })
</script>