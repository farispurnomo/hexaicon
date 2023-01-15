<div id="kt_content_container" class="container-fluid">
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img draggable="false" src="<?= $client->url_image ?>" alt="image">
                        <!-- <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div> -->
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1"><?= $client->name ?></a>
                                <span href="#" class="badge bg-success fw-bolder ms-2 fs-8 py-1 px-3"><?= $client->subscription_name ?></span>
                            </div>
                            <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="currentColor"></path>
                                            <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                    <?= $client->position ?: '-' ?>
                                </span>
                                <a href="mailto:<?= $client->email ?>" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor"></path>
                                            <path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                    <?= $client->email ?>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex my-4">
                            <a id="delete-user" href="<?= base_url($route . '/delete/' . $id) ?>" class="btn btn-sm btn-danger me-2">
                                <i class="fa fa-trash-alt"></i>
                                <span class="indicator-label">Delete</span>
                            </a>
                        </div>
                    </div>
                    <div>
                        <div>Joined from</div>
                        <div class="small text-muted"><?= date('Y-m-d', strtotime($client->created_at)) ?></div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 <?php if (current_url() === base_url($route . '/profile/' . $id)) echo 'active' ?>" href="<?= base_url($route . '/profile/' . $id) ?>">Profile</a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 <?php if (current_url() === base_url($route . '/subscription/' . $id)) echo 'active' ?>" href="<?= base_url($route . '/subscription/' . $id) ?>">Subscription</a>
                </li>
            </ul>
        </div>
    </div>

    <?= $view ?>
</div>

<script defer>
    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        $(document).on('click', '#delete-user', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure to delete this client?',
                icon: "question",
                buttonsStyling: false,
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: "Cancel",
                customClass: {
                    confirmButton: "btn btn-primary",
                    denyButton: "btn btn-danger"
                },
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = $(e.currentTarget).attr('href');
                }
            });

            return false;
        });
    })
</script>