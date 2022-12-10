<?php $this->load->view('partials/admin/admin_alert') ?>

<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                <?= $pagetitle ?>
            </h3>
        </div>
        <div class="card-toolbar">
            <a id="add_modal" class="btn btn-success btn-sm mr-3 ajaxify" data-bs-toggle="modal" data-bs-target="#modal_add">
                <i class="flaticon-file-1"></i> Tambah Data
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="datatable datatable-bordered datatable-head-custom">
            <table class="table">
                <thead>
                    <tr>
                        <td>
                            No
                        </td>
                        <td>
                            Style
                        </td>
                        <td>
                            Action
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($table as $key => $value) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $value->name ?></td>
                            <td>
                                <a class="btn btn-primary btn-sm mr-3 ajaxify" onclick="edit('<?= $value->id ?>')" data-bs-toggle="modal" data-bs-target="#modal_edit">
                                    <i class="flaticon-file-1"></i> Edit Data
                                </a>
                                <a class="btn btn-danger btn-sm mr-3 ajaxify" onclick="ajax_delete('<?= $value->id ?>','<?= $value->name ?>')">
                                    <i class="flaticon-file-1"></i> Delete Data
                                </a>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_add" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content rounded">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
                            </g>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <form id="form_add" class="form" action="#">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Add <?= $pagetitle ?></h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Name <?= $pagetitle ?></span>
                            <!-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference"></i> -->
                        </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Enter Name" id="nama_tambah" name="nama" />
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">description</span>
                            <!-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference"></i> -->
                        </label>
                        <textarea class="form-control form-control-solid mb-5" rows="3" name="description" data-kt-element="input" placeholder="Input Description"></textarea>
                    </div>

                    <div class="text-center">
                        <button type="reset" id="modal_cancel_add" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="modal_submit_add" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content rounded">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
                            </g>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <form id="form_edit" class="form" action="#">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Edit <?= $pagetitle ?></h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Name <?= $pagetitle ?></span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference"></i>
                        </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Enter Name" id="nama_edit" name="nama" />
                        <input type="hidden" class="form-control form-control-solid" placeholder="Enter Target Title" id="id_edit" name="id" />
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">description</span>
                        </label>
                        <textarea class="form-control form-control-solid mb-5" rows="3" name="description" id="text_area_edit" data-kt-element="input" placeholder="Input Description"></textarea>
                    </div>
                    <div class="text-center">
                        <button type="reset" id="modal_cancel_edit" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="modal_submit_edit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#modal_submit_add').click(function() {
        ajax_add()
    })
    $('#modal_submit_edit').click(function() {
        ajax_edit()
    })

    function ajax_add() {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>" + "admin/master/style/store",
            data: $("#form_add").serializeArray(),
            dataType: "json",
            success: function(data) {
                if (data.status == "200") {
                    Swal.fire({
                        html: data.msg,
                        icon: "success",
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        },
                        timer: 2000,
                        timerProgressBar: true,
                    }).then((result) => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        html: data.msg,
                        icon: "error",
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        },
                    });
                }
            },
            failure: function(errMsg) {
                alert(errMsg);
            },
        });
    }

    function edit(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>" + "admin/master/style/edit",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(data) {
                if (data.status == "200") {
                    $("#nama_edit").val(data.data.name);
                    $("#id_edit").val(data.data.id);
                    $("#text_area_edit").val(data.data.description);               
                    
                    // $("#parent_id").html(data.menu)
                    // $("#parent_id").html(data.menu)
                    // $("#parent_id").html(data.menu)
                    // $("#parent_id").html(data.menu)
                    // $("#id_role").val(data.nm_role.ID);
                } else {
                    Swal.fire({
                        html: data.msg,
                        icon: "error",
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        },
                    });
                }
            },
            failure: function(errMsg) {
                alert(errMsg);
            },
        });
    }

    function ajax_edit() {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>" + "admin/master/style/update",
            data: $("#form_edit").serializeArray(),
            dataType: "json",
            success: function(data) {
                if (data.status == "200") {
                    Swal.fire({
                        html: data.msg,
                        icon: "success",
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        },
                        timer: 2000,
                        timerProgressBar: true,
                    }).then((result) => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        html: data.msg,
                        icon: "error",
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        },
                    });
                }
            },
            failure: function(errMsg) {
                alert(errMsg);
            },
        });
    }

    function ajax_delete(id, name) {
        Swal.fire({
            text: "Are you sure you want to Remove Style name " + name + "?",
            icon: "error",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes, Delete !",
            cancelButtonText: "No, Back",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light",
            },
        }).then(function(t) {
            // console.log(t);
            if (t.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>" + "admin/master/style/destroy",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status == "200") {
                            Swal.fire({
                                html: data.msg,
                                icon: "success",
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: "btn btn-succcess"
                                },
                                timer: 2000,
                                timerProgressBar: true,
                            }).then((result) => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                html: data.msg,
                                icon: "error",
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                },
                            });
                        }
                    },
                });
            } else {}
        });
        // $.ajax({
        //     type: "POST",
        //     url: "<?= base_url() ?>" + "admin/master/role/destroy",
        //     data: {
        //         ID: ID,
        //     },
        //     dataType: "json",
        //     success: function(data) {
        //         if (data.status == "200") {
        //             Swal.fire({
        //                 text: "Apakah Anda yakin ingin Menghapus Akses Role " + data.nm_role.NM_ROLE + "?",
        //                 icon: "error",
        //                 showCancelButton: !0,
        //                 buttonsStyling: !1,
        //                 confirmButtonText: "Ya, Hapus !",
        //                 cancelButtonText: "Tidak, kembali",
        //                 customClass: {
        //                     confirmButton: "btn btn-danger",
        //                     cancelButton: "btn btn-active-light",
        //                 },
        //             }).then(function(t) {
        //                 // console.log(t);
        //                 if (t.isConfirmed) {
        //                     $.ajax({
        //                         type: "POST",
        //                         url: base_url + "master/akses/delete",
        //                         data: {
        //                             id: ID,
        //                         },
        //                         dataType: "json",
        //                         success: function(data) {
        //                             if (data.status == "200") {
        //                                 Swal.fire({
        //                                     html: data.msg,
        //                                     icon: "success",
        //                                     confirmButtonText: "OK",
        //                                     customClass: {
        //                                         confirmButton: "btn btn-succcess"
        //                                     },
        //                                     timer: 2000,
        //                                     timerProgressBar: true,
        //                                 }).then((result) => {
        //                                     window.location.reload();
        //                                 });
        //                             } else {
        //                                 Swal.fire({
        //                                     html: data.msg,
        //                                     icon: "error",
        //                                     confirmButtonText: "OK",
        //                                     customClass: {
        //                                         confirmButton: "btn btn-primary"
        //                                     },
        //                                 });
        //                             }
        //                         },
        //                     });
        //                 } else {}
        //             });
        //         } else {
        //             Swal.fire({
        //                 html: data.msg,
        //                 icon: "error",
        //                 confirmButtonText: "OK",
        //                 customClass: {
        //                     confirmButton: "btn btn-primary"
        //                 },
        //             });
        //         }
        //     },
        //     failure: function(errMsg) {
        //         alert(errMsg);
        //     },
        // });
    }

    function redirect() {
        window.location.replace(base_url + "master/style/");
    }
</script>