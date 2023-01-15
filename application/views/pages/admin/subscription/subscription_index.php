<div id="kt_content_container" class="container-fluid">
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Subscriptions" />
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    <a href="<?= base_url($route . '/create') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add Data</a>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="py-3">
                <?php $this->load->view('partials/admin/admin_alert'); ?>
            </div>

            <table class="table align-middle table-row-dashed fs-6 gy-5" id="<?= $table_id ?>">

            </table>
        </div>
    </div>
</div>

<script defer>
    "use strict";

    // Class definition
    const KTHandleList = function() {
        // Define shared variables
        let table;
        let datatable;

        const initDataList = function() {
            table = document.getElementById('<?= $table_id ?>');

            datatable = $(table).DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '<?= base_url($route . '/paginate') ?>',
                    type: 'POST'
                },
                columns: [{
                        data: 'name',
                        title: 'Name',
                        render: function(data, type, row) {
                            return `
                                <div>
                                    <div class="mb-3"><strong>${row.name}</strong></div>

                                    <div class="d-flex flex-column w-100 me-2">
                                        <div class="d-flex flex-stack mb-2">
                                            <div class="text-muted small">Client subscripted</div>
                                            <span class="text-muted me-2 fs-7 fw-bold">${row.active_user_percentage}%</span>
                                        </div>
                                        <div class="progress h-6px w-100">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: ${row.active_user_percentage}%" aria-valuenow="${row.active_user_percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'description',
                        title: 'Description'
                    },
                    {
                        data: 'total_price',
                        title: 'Price',
                        render: function(data, type, row) {
                            return helpers.numberFormat(row.total_price);
                        }
                    },
                    {
                        data: 'id',
                        title: 'Actions',
                        orderable: false,
                        render: function(data, type, row) {
                            return `
								<a href="<?= base_url($route . '/edit/') ?>${row.id}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
								</a>
								<a href="<?= base_url($route . '/delete/') ?>${row.id}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
								</a>
						`;
                        }
                    }
                ]
            });

            const filterSearch = document.querySelector('[data-kt-customer-table-filter="search"]');
            filterSearch.addEventListener('keyup', function(e) {
                datatable.search(e.target.value).draw();
            });

            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure to delete this data?',
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
        };

        return {
            init: function() {
                initDataList();
            }
        }
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        KTHandleList.init();
    })
</script>