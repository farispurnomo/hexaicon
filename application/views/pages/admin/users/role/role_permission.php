<div id="kt_content_container" class="container-fluid">
    <form method="POST" action="<?= base_url($route . '/permission_store/' . $record->id) ?>" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">

        <div class="d-flex flex-column flex-row-fluid gap-12">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2><?= $pagetitle ?></h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table table-row-bordered table-flush align-middle gy-6">
                        <thead class="border-bottom border-gray-200 fs-6 fw-bolder bg-lighten">
                            <tr>
                                <th class="min-w-125px ps-9">Menu</th>
                                <th class="min-w-125px px-0">Ability</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $this->load->view('pages/admin/users/role/role_permission_item', ['menus' => $menus, 'deep' => 0]); ?>
                        </tbody>
                    </table>
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