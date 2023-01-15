<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">Subscription History</h3>
        </div>
    </div>
    <div class="card-body p-9">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_user_subscription_plan_table">

        </table>
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

            table = document.getElementById('kt_user_subscription_plan_table');

            datatable = $(table).DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '<?= base_url($route . '/subscription_paginate/' . $id) ?>',
                    type: 'POST'
                },
                columns: [{
                        data: 'order_id',
                        title: 'Order ID',
                        render: function(data, type, row) {
                            let response;
                            try {
                                response = JSON.parse(row.response);
                            } catch (error) {
                                response = null;
                            }

                            const render_modal_content = function(content) {
                                let html = '<div class="text-center">No Data Available</div>'

                                if (content) {
                                    html = `
                                        <div class="mb-7 h5 fw-bolder">Response Detail</div>

                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">status code</label>
                                            <div class="col-lg-8">
                                                <span class="fw-bolder fs-6 text-gray-800">${content.status_code}</span>
                                            </div>
                                        </div>
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">status message</label>
                                            <div class="col-lg-8">
                                                <span class="fw-bolder fs-6 text-gray-800">${content.status_message}</span>
                                            </div>
                                        </div>
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">transaction id</label>
                                            <div class="col-lg-8">
                                                <span class="fw-bolder fs-6 text-gray-800">${content.transaction_id}</span>
                                            </div>
                                        </div>
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">order id</label>
                                            <div class="col-lg-8">
                                                <span class="fw-bolder fs-6 text-gray-800">${content.order_id}</span>
                                            </div>
                                        </div>
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">gross amount</label>
                                            <div class="col-lg-8">
                                                <span class="fw-bolder fs-6 text-gray-800">${content.gross_amount}</span>
                                            </div>
                                        </div>
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">payment type</label>
                                            <div class="col-lg-8">
                                                <span class="fw-bolder fs-6 text-gray-800">${content.payment_type}</span>
                                            </div>
                                        </div>
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">transaction time</label>
                                            <div class="col-lg-8">
                                                <span class="fw-bolder fs-6 text-gray-800">${content.transaction_time}</span>
                                            </div>
                                        </div>
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">transaction status</label>
                                            <div class="col-lg-8">
                                                <span class="fw-bolder fs-6 text-gray-800">${content.transaction_status}</span>
                                            </div>
                                        </div>
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">fraud status</label>
                                            <div class="col-lg-8">
                                                <span class="fw-bolder fs-6 text-gray-800">${content.fraud_status}</span>
                                            </div>
                                        </div>
                                    `;
                                }

                                return html;
                            };

                            return `
                                <div class="modal fade" id="detail-${row.id}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header pb-0 border-0 justify-content-end">
                                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                    <span class="svg-icon svg-icon-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                                                ${render_modal_content(response)}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="button" data-bs-toggle="modal" data-bs-target="#detail-${row.id}">
                                    <strong class="text-hover-primary">${data}</strong>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'created_at',
                        title: 'Created'
                    },
                    {
                        data: 'status_id',
                        title: 'Status',
                        render: function(data) {
                            let html = '';
                            switch (data) {
                                case '<?= TRANSACTION_STATUS_PENDING ?>':
                                    html = '<span class="badge bg-warning">Pending</span>'
                                    break;

                                case '<?= TRANSACTION_STATUS_SUCCESS ?>':
                                    html = '<span class="badge bg-success">Success</span>'
                                    break;

                                case '<?= TRANSACTION_STATUS_FAILED ?>':
                                    html = '<span class="badge bg-danger">Failed</span>'
                                    break;

                                default:
                                    break;
                            }

                            return html;
                        }
                    },
                    {
                        data: 'subscription_total',
                        title: 'Price',
                        render: function(data) {
                            return helpers.numberFormat(data);
                        }
                    }
                ]
            });

        }

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