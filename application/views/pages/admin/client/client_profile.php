<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">Profile Details</h3>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url($route . '/edit/' . $id) ?>" class="btn btn-sm btn-flex btn-light-primary">
                <i class="fa fa-edit"></i>
                Edit
            </a>
        </div>
    </div>
    <div class="card-body p-9">
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">Email</label>
            <div class="col-lg-8 d-flex align-items-center">
                <span class="fw-bolder fs-6 text-gray-800 me-2"><?= $client->email ?: '-' ?></span>
                <span class="badge badge-success"><?= $client->account_type ?></span>
            </div>
        </div>
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">Name</label>
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800"><?= $client->name ?: '-' ?></span>
            </div>
        </div>
        <div class="row mb-7">
            <label class="col-lg-4 fw-bold text-muted">Job</label>
            <div class="col-lg-8">
                <span class="fw-bolder text-gray-800 fs-6"><?= $client->position ?: '-' ?></span>
            </div>
        </div>
    </div>
</div>