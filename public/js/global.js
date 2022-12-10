var global = (function () {

    var help_ktable = function (id, urll, column, search, child) {
        var options = {
            // datasource definition
            data: {
                type: "remote",
                source: {
                    read: {
                        url: urll,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    }
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true
            },

            // layout definition
            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and
                footer: false, // display/hide footer
                spinner: {
                    type: 'loader'
                }
            },

            // column sorting
            sortable: true,
            pagination: true,
            columns: column
        };

        if (child != undefined) {
            options.detail = {
                title: child.title,
                content: subTableInit
            };

            function subTableInit(e) {
                if (child.html == true) {
                    $("<div/>")
                        .attr("id", "child_data_ajax_" + e.data.RecordID)
                        .appendTo(e.detailCell);

                    $.ajax({
                        type: "POST",
                        url: child.route,
                        data: {
                            id: e.data.RecordID
                        },
                        // dataType: 'POST',
                        success: function (res) {
                            $("#child_data_ajax_" + e.data.RecordID).html(res);
                        }
                    });
                }
            }
        }

        // enable extension
        options.extensions = {
            // boolean or object (extension options)
            checkbox: true
        };

        var datatable = $(id).KTDatatable(options);
        var btn_search = '#btn-search';

        $(btn_search).on('click', function () {
            $(document).bind("ajaxStart.mine", function() {
                KTApp.block($(id), {
                    overlayColor: "#000000",
                    state: "danger",
                    message: "Please wait..."
                });
            });
            var items = {};
            $.each(search, function (index, value) { 
                var val_key = $(value).val();          
                items[index] = val_key;
            });
            Object.keys(search).forEach(function (key) {
            });
            datatable.search(
                items
            );

            $(document).bind("ajaxStop.mine", function() {
                setTimeout(function () {
                    KTApp.unblock($(id));
                }, 1000);
                $(document).unbind(".mine");
            });
        });

        datatable.on("datatable-on-click-checkbox", function (e) {
            // datatable.checkbox() access to extension methods
            var ids = datatable.checkbox().getSelectedId();
            var count = ids.length;

            $("#kt_datatable_selected_records_2").html(count);

            if (count > 0) {
                $("#kt_datatable_group_action_form_2").collapse("show");
            } else {
                $("#kt_datatable_group_action_form_2").collapse("hide");
            }

            // start poses untuk update status pakai fitur checkbox
            $(".updateStatus").on("click", function (e) {
                e.preventDefault();

                var option = {
                    route: $(this).attr("href"),
                    data: {
                        status: $(this).data("value"),
                        ids: ids
                    },
                    blkUi: "#body-content",
                    type: "swal",
                    attr: {
                        title: "Anda yakin ?",
                        text: "akan mengupdate data ini",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Iya",
                        cancelButtonText: "Tidak",
                        reverseButtons: true
                    }
                };

                ajaxProses("post", option, null, null, datatable);
            });
            // start poses untuk update status pakai fitur checkbox

            // start proses delete all pakai fitur checkbox
            $(".kt_datatable_delete_all").on("click", function (e) {
                e.preventDefault();

                var option = {
                    route: $(this).attr("href"),
                    data: {
                        ids: ids
                    },
                    blkUi: "#body-content",
                    type: "swal",
                    attr: {
                        title: "Anda yakin ?",
                        text: "akan menghapus data ini",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Iya",
                        cancelButtonText: "Tidak",
                        reverseButtons: true
                    }
                };
                ajaxProses("post", option, null, null, datatable);
            });
            // end proses delete all pakai fitur checkbox
        });

        $("#kt_datatable_fetch_modal_2")
            .on("show.bs.modal", function (e) {
                var ids = datatable.checkbox().getSelectedId();
                var c = document.createDocumentFragment();
                for (var i = 0; i < ids.length; i++) {
                    var li = document.createElement("li");
                    li.setAttribute("data-id", ids[i]);
                    li.innerHTML = "Selected record ID: " + ids[i];
                    c.appendChild(li);
                }
                $("#kt_datatable_fetch_display_2").append(c);
            })
            .on("hide.bs.modal", function (e) {
                $("#kt_datatable_fetch_display_2").empty();
            });

        $(document).on('click', `${id} .btn-delete`, function(e){
            e.preventDefault();
            var option = {
                route: $(this).attr("href"),
                blkUi: "#body-content",
                type: "swal",
                attr: {
                    title: "Anda yakin ?",
                    text: 'akan menghapus data ini',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Iya",
                    cancelButtonText: "Tidak",
                    reverseButtons: true
                }
            };
        
            ajaxProses("post", option, null, null, datatable);
            // const url = $(this).attr('href');
           
            // swal.fire({
            //     title: "Anda yakin ?",
            //     text: "akan menghapus data ini.",
            //     icon: "warning",
            //     showCancelButton: true,
            //     confirmButtonText: "Iya",
            //     cancelButtonText: "Tidak",
            //     reverseButtons: true
            // }).then(result => {
            //     if (result.value) {
            //         KTApp.block('#body-content', {
            //             overlayColor: "#000000",
            //             type: "v2",
            //             state: "success",
            //             message: "Please wait..."
            //         });
                    
            //         $.ajax({
            //             url: url,
            //             type: 'DELETE',
            //             dataType: 'JSON',
            //             success: function(response){
            //                 swal.fire(
            //                     response.status == 1 ?
            //                     "Berhasil" :
            //                     "Gagal",
            //                     response.message,
            //                     response.status == 1 ?
            //                     "success" :
            //                     "error"
            //                 );

            //                 if (response.status == 1) {
            //                     setTimeout(function () {
            //                         KTApp.unblock('#body-content');
            //                     }, 1000);

            //                     datatable.reload();
            //                     $(".scrolltop").trigger("click");
            //                 } else {
            //                     $(".scrolltop").trigger("click");

            //                     setTimeout(function () {
            //                         KTApp.unblock('#body-content');
            //                     }, 1000);
            //                 }
            //             }
            //         })
            //     }
            // })
        });
    };

    var hlp_formVldtn = function (form, fields) {
        if (form === null) {
            return false; 
        }
        var validation;
        var confirm = form.getAttribute("data-cofirm");
        var urll    = form.getAttribute("action");
        var submit  = $(form).find(':submit');

        validation = FormValidation.formValidation(form, {
            fields: fields,

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        });

        $(submit).on("click", function (e) {
            e.preventDefault();

            // var content = form;
            var content = document.getElementById('kt_body');

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            validation.validate().then(function (status) {
                if (status == "Valid") {
                    if (confirm == 1) {
                        Swal.fire({
                            title: "Apakah kamu yakin ?",
                            text: "akan mengubah data ini. ",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Iya",
                            cancelButtonText: "Tidak",
                            reverseButtons: true
                        }).then(function (result) {
                            if (result.value) {
                                KTApp.block(content, {
                                    overlayColor: "#000000",
                                    state: "danger",
                                    message: "Please wait..."
                                });

                                $.ajax({
                                    url: urll,
                                    data: new FormData(form),
                                    type: "POST",
                                    dataType: "json",
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    success: function (response) {
                                        setTimeout(function () {
                                            KTApp.unblock(content);
                                        }, 2000);

                                        if (response.status == 0) {
                                            var tipe = "error";
                                            var title = "Error !!!";
                                        } else if (response.status == 1) {
                                            var tipe = "success";
                                            var title = "Berhasil";
                                        } else {
                                            var tipe = "warning";
                                            var title = "Perhatian ...";
                                        }

                                        toastr.options = {
                                            closeButton: true,
                                            debug: false,
                                            newestOnTop: true,
                                            progressBar: true,
                                            positionClass: "toast-top-right",
                                            preventDuplicates: false,
                                            onclick: null,
                                            showDuration: 300,
                                            hideDuration: 1000,
                                            timeOut: 5000,
                                            extendedTimeOut: 1000,
                                            showEasing: "swing",
                                            hideEasing: "linear",
                                            showMethod: "fadeIn",
                                            hideMethod: "fadeOut"
                                        };

                                        var $toast = toastr[tipe](response.message, title);
                                        $(".scrolltop").trigger("click");

                                        if (response.status == 1) {
                                            if (
                                                typeof response.reload !==
                                                "undefined"
                                            ) {
                                                location.href =
                                                    response.cus_url;
                                            } else if (
                                                response.cus_url == undefined
                                            ) {
                                                $(".reload").trigger("click");
                                            } else {
                                                $(".reload").attr(
                                                    "href",
                                                    response.cus_url
                                                );
                                                $(".reload").trigger("click");
                                            }
                                        }

                                        $(".modal").modal("hide");
                                        $(".modal-backdrop").remove();
                                    },
                                    error: function (request) {
                                        if (request.responseJSON != undefined) {
                                            swal.fire({
                                                text: request.responseJSON.message,
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, got it!",
                                                customClass: {
                                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                                }
                                            }).then(function () {
                                                // KTUtil.scrollTop();
                                                $(".scrolltop").trigger("click");
                                            });
                                        } else {
                                            $(".scrolltop").trigger("click");
                                        }
                                    }
                                });
                            } else {
                                KTApp.unblock(content);
                            }
                        });
                    } else {
                        KTApp.block(content, {
                            overlayColor: "#000000",
                            state: "danger",
                            message: "Please wait..."
                        });

                        $.ajax({
                            url: urll,
                            data: new FormData(form),
                            type: "POST",
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                setTimeout(function () {
                                    KTApp.unblock(content);
                                }, 2000);

                                if (response.status == 0) {
                                    var tipe = "error";
                                    var title = "Error !!!";
                                } else if (response.status == 1) {
                                    var tipe = "success";
                                    var title = "Berhasil";
                                } else {
                                    var tipe = "warning";
                                    var title = "Perhatian ...";
                                }

                                toastr.options = {
                                    closeButton: true,
                                    debug: false,
                                    newestOnTop: true,
                                    progressBar: true,
                                    positionClass: "toast-top-right",
                                    preventDuplicates: false,
                                    onclick: null,
                                    showDuration: 300,
                                    hideDuration: 1000,
                                    timeOut: 5000,
                                    extendedTimeOut: 1000,
                                    showEasing: "swing",
                                    hideEasing: "linear",
                                    showMethod: "fadeIn",
                                    hideMethod: "fadeOut"
                                };

                                var $toast = toastr[tipe](response.message, title);
                                $(".scrolltop").trigger("click");

                                if (response.status == 1) {
                                    if (response.cus_url == undefined) {
                                        $(".reload").trigger("click");
                                    } else {
                                        $(".reload").attr(
                                            "href",
                                            response.cus_url
                                        );
                                        $(".reload").trigger("click");
                                    }
                                }

                                $(".modal").modal("hide");
                                $(".modal-backdrop").remove();
                            },
                            error: function (request) {
                                if (request.responseJSON != undefined) {
                                    swal.fire({
                                        text: request.responseJSON.message,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn font-weight-bold btn-light-primary"
                                        }
                                    }).then(function () {
                                        // KTUtil.scrollTop();
                                        $(".scrolltop").trigger("click");
                                    });
                                } else {
                                    $(".scrolltop").trigger("click");
                                }
                            }
                        });
                    }
                }
            });
        });
    };

    var hlp_select2 = function (clas, option) {
        if (option.route_to == undefined) {
            $(clas).select2({
                placeholder: option.placeholder == undefined ?
                    "Select Option" : option.placeholder,
                allowClear: option.allowClear == undefined ? false : option.allowClear
            });
        } else {
            $(clas).select2({
                placeholder: option.placeholder == undefined ?
                    "Select Option" : option.placeholder,
                allowClear: option.allowClear == undefined ? false : option.allowClear,
                ajax: {
                    url: option.route_to,
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: params.page * 30 < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                tags: option.tag == undefined || option.tag == false ?
                    false : option.tag,
                tokeSparator: [","],
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: option.MininputLength == undefined ?
                    false : option.MininputLength,
                templateResult: formatResult, // omitted for brevity, see the source of this page
                templateSelection: formatResult // omitted for brevity, see the source of this page
            });

            function formatResult(result) {
                return result.text;
            }
        }
    };

    var hlp_wizard = function (idWizard, idForm, temp) {
        // Base elements
        var _wizardEl;
        var _formEl;
        var _wizard;
        var _validations = [];

        // Private functions
        var initWizard = function () {
            // Initialize form wizard
            _wizard = new KTWizard(_wizardEl, {
                startStep: 1, // initial active step number
                clickableSteps: true // allow step clicking
            });

            // Validation before going to next page
            _wizard.on("beforeNext", function (wizard) {
                _validations[wizard.getStep() - 1]
                    .validate()
                    .then(function (status) {
                        if (status == "Valid") {
                            _wizard.goNext();
                            KTUtil.scrollTop();
                        } else {
                            Swal.fire({
                                text: "Sorry, looks like there are some input blank, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light"
                                }
                            }).then(function () {
                                KTUtil.scrollTop();
                            });
                        }
                    });

                _wizard.stop(); // Don't go to the next step
            });

            // Change event
            _wizard.on("change", function (wizard) {
                KTUtil.scrollTop();
            });
        };

        var initValidation = function (temp) {
            temp.forEach(function (field) {
                _validations.push(
                    FormValidation.formValidation(_formEl, {
                        fields: field,
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap()
                        }
                    })
                );
            });
        };

        // public functions
        _wizardEl = KTUtil.getById(idWizard);
        _formEl = KTUtil.getById(idForm);

        initWizard();
        initValidation(temp);
    };

    var hlp_dtrp = function (tipe, clas, prm) {
        // 1 = datepicker, 2 = datettimepicker, 3 = timepicker, 4 = rangepicker

        if (tipe == "1") {
            $(clas).datepicker(prm);
        } else if (tipe == "2") {
            $(clas).datetimepicker(prm);
        } else if (tipe == "3") {
            $(clas).timepicker(prm);
        } else {
            $(clas).daterangepicker(prm, function (start, end, label) {
                $(clas + " .form-control").val(
                    start.format(prm.format) + " - " + end.format(prm.format)
                );
            });
        }
    };

    var hlp_frmrpt = function (clas) {
        $(clas).repeater({
            initEmpty: false,

            defaultValues: {
                "text-input": "foo"
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                const inp_primary = $(this).find('.input-primary').val();

                if (inp_primary == '') {
                    $(this).slideUp(deleteElement);
                } else {
                    Swal.fire({
                        title: "Apa anda yakin?",
                        text: 'Anda akan menghapus inputan ini?',
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes!"
                    }).then(function (result) {
                        if (result.value) {
                            $(this).slideUp(deleteElement);
                        }
                    });
                }
            }
        });
    };

    const hlp_autonumeric = function(selector, options) {
        const isDomExists = $(selector).length;
        if(!isDomExists) return;

        return new AutoNumeric.multiple(selector, {
            unformatOnSubmit: true,
            modifyValueOnWheel: false,
            onInvalidPaste: 'truncate',
            ...options
        })
    }

    return {
        init_ktable: function (id, urll, column, search, child) {
            help_ktable(id, urll, column, search, child);
        },
        init_select2: function (clas, option) {
            hlp_select2(clas, option);
        },
        init_wizard: function (idWizard, idForm, temp) {
            hlp_wizard(idWizard, idForm, temp);
        },
        init_dtrp: function (tipe, clas, prm) {
            hlp_dtrp(tipe, clas, prm);
        },
        init_formVldtn: function (form, fields) {
            hlp_formVldtn(form, fields);
        },
        init_frmrpt: function (clas) {
            hlp_frmrpt(clas);
        },
        init_autonumeric: (selector, options = []) => hlp_autonumeric(selector, options),
    };
})();
