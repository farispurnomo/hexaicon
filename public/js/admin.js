// $(document).on("click", ".ajaxify", function (e) {
//     e.preventDefault();
//     var ajaxify = [null, null, null];
//     var url = $(this).attr("href");
//     var content = $("#body-content");
//     var mnActve = "menu-item-active";
//     var mnCls = $(this).attr("class");
//     var clsOpen = "menu-item-open";

//     if (mnCls.includes("menu-link")) {
//         $("li").removeClass(clsOpen);
//         $("li").removeClass(mnActve);

//         $(this)
//             .parents("li")
//             .addClass(clsOpen);
//         $(this)
//             .parents("li")
//             .addClass(mnActve);
//     }

//     history.pushState(null, null, url);
//     if (url != ajaxify[2]) {
//         ajaxify.push(url);
//     }

//     ajaxify = ajaxify.slice(-3, 5);

//     $.ajaxSetup({
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
//         }
//     });

//     KTApp.block(content, {
//         overlayColor: "#000000",
//         state: "danger",
//         message: "Please wait..."
//     });

//     var posting = $.get(url, {
//         status_link: "ajax"
//     });

//     posting.done(function (data) {
//         content.html(data);
        
//         // untuk mengubah nama title sesuai halaman yang dimuat
//         var pagetitle = $( ".card-label" ).first().text();
//         var pagename = pagetitle != '' ? pagetitle : $('.breadcrumb-item').first().find('a').text();
//         $('title').text(app_name + ' | ' + $.trim(pagename));

//         // set ubBlockui
//         setTimeout(function () {
//             KTApp.unblock(content);
//         }, 2000);

//         // set otomastis scroll top
//         $(".scrolltop").trigger("click");
//     }).fail(function() {
//         window.location = window.location;
//     });;

// });

function ajaxProses(method, option, ele = null, eve = null, datatable = null) {
    if (method == "post") {
        if (option.type == "swal") {
            swal.fire(option.attr).then(function (result) {
                if (result.value) {
                    if (
                        option.attrChild != undefined ||
                        option.attrChild != null
                    ) {
                        Swal.fire(option.attrChild).then(result => {
                            if (result.value) {
                                KTApp.block(option.blkUi, {
                                    overlayColor: "#000000",
                                    type: "v2",
                                    state: "success",
                                    message: "Please wait..."
                                });

                                $.ajaxSetup({
                                    headers: {
                                        "X-CSRF-TOKEN": $(
                                            'meta[name="csrf-token"]'
                                        ).attr("content")
                                    }
                                });

                                $.post(
                                    option.route, {
                                        note: result.value
                                    },
                                    function (res) {
                                        swal.fire(
                                            res.status == 1 ?
                                            "Berhasil" :
                                            "Gagal",
                                            res.message,
                                            res.status == 1 ?
                                            "success" :
                                            "error"
                                        );
                                        if (res.status == 1) {
                                            setTimeout(function () {
                                                KTApp.unblock(option.blkUi);
                                            }, 1000);

                                            // $(".reload").trigger("click");
                                            $('#kt_datatable_group_action_form_2').collapse('hide');
                                            if(datatable) datatable.reload();
                                            $(".scrolltop").trigger("click");
                                        } else {
                                            $(".scrolltop").trigger("click");

                                            setTimeout(function () {
                                                KTApp.unblock(option.blkUi);
                                            }, 1000);
                                        }
                                    },
                                    "json"
                                );
                            }
                        });
                    } else {
                        var param = {
                            route: option.route,
                            data: option.data,
                            blkUi: option.blkUi,
                            type: option.type,
                            datatable: datatable
                        };

                        ajaxx(param);
                    }
                }
            });
        } else if (option.type == "ajax") {
            var param = {
                route: option.route,
                data: option.data,
                blkUi: option.blkUi,
                file: option.file,
                type: option.type,
                extn: option.extn,
                html: option.html,
                rnder: option.rnder
            };

            ajaxx(param);
        }
    } else if (method == "get") {}
}

function ajaxx(param) {
    // if(param.html == undefined){
    KTApp.block(param.blkUi, {
        overlayColor: "#000000",
        type: "v2",
        state: "success",
        message: "Please wait..."
    });
    // }

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.post(
        param.route,
        param.data,
        function (res) {
            if (param.html == true) {
                $(param.rnder).html(res);

                setTimeout(function () {
                    KTApp.unblock(param.blkUi);
                }, 1000);
            } else {
                if (param.type == "swal") {
                    swal.fire(
                        res.status == 1 ? "Berhasil" : "Gagal",
                        res.message,
                        res.status == 1 ? "success" : "error"
                    );
                }

                setTimeout(function () {
                    KTApp.unblock(param.blkUi);
                }, 1000);

                if (res.status == 1) {
                    if (param.file != undefined) {
                        if (param.extn == "pdf") {
                            var anchor = document.createElement("a");
                            anchor.href = param.file;
                            anchor.target = "_blank";
                            anchor.download = "users.pdf";
                            anchor.click();
                        } else {
                            window.location.href = param.file;
                        }
                    } else {
                        if (res.cus_url == undefined) {
                            // $(".reload").trigger("click");
                            $('#kt_datatable_group_action_form_2').collapse('hide');
                            if(param.datatable) param.datatable.reload();
                        } else {
                            $(".reload").attr("href", res.cus_url);
                            // $(".reload").trigger("click");
                            $('#kt_datatable_group_action_form_2').collapse('hide');
                            if(param.datatable) param.datatable.reload();
                        }
                    }
                }
            }

            $(".scrolltop").trigger("click");
        },
        param.html == undefined ? "json" : "html"
    );
}

//fungsi ajax untuk load view
function ajaxview(param) {
    // param.blkUi -> definisi class atau id yang ada di blok (rekomendasi id body modal)
    // param.route -> definisi route untuk menampilkan view
    // param.data  -> definisikan data dalam json
    // opsional
    // param.txtModalHeader -> definisikan text untuk mengubah title modal setelah load selesai
    // param.idModalHeader  -> definisikan class atau id titel modal
    var content = $(param.blkUi);
    KTApp.block(param.blkUi, {
        overlayColor: "#000000",
        type: "v2",
        state: "success",
        message: "Please wait...",
    });
    // }

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var posting = $.post(param.route, param.data);

    posting.done(function (data) {
        typeof param.idModalHeader !== "undefined"
            ? $(param.idModalHeader).text(param.txtModalHeader)
            : "";
        content.html(data);
        setTimeout(function () {
            KTApp.unblock(content);
        }, 1000);
    });
}

function f_action(ele, eve, flag) {
    eve.preventDefault();

    var option = {
        route: $(ele).attr("href"),
        blkUi: "#body-content",
        type: "swal",
        attr: {
            title: "Anda yakin ?",
            text: flag == undefined ?
                "akan menghapus data ini." : flag == 1 ?
                "akan mengembalikan kembali data ini." : flag == 0 ?
                "akan me non aktifkan data ini. " : "akan menghapus sementara data ini",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Iya",
            cancelButtonText: "Tidak",
            reverseButtons: true
        }
    };

    ajaxProses("post", option);
}

$(document).on("click", "#reset", function (e) {
    e.preventDefault();
    const form = $(this)
        .closest("form")
        .attr("id");

    $("form#" + form + " :input").each(function () {
        const input = $(this); // This is the jquery object of the input, do what you will
        input.val("");
    });
});

// start function untuk checkbox list permission di role
function uncheckall(a) {
    var ischecked = $(a).is(":checked") ? true : false;
    var checkall = $(a)
        .closest(".card-body")
        .find(".checkbox-all");
    var checklist = $(a).closest(".checkbox-list");
    var isAllChecked =
        $(checklist).find(" input[type=checkbox]:checked").length ==
        $(checklist).find(" input[type=checkbox]").length ?
        true :
        false;

    if (ischecked == false || isAllChecked == false) {
        $(checkall).prop("checked", false);
    } else if (isAllChecked == true) {
        $(checkall).prop("checked", true);
    }
}
// end function untuk checkbox list permission di role

// start check dan uncheck pilih semua
$(document).on("click", ".checkbox-all", function () {
    var ischecked = $(this).is(":checked") ? true : false;
    var permin = $(this)
        .closest(".card-body")
        .find(".list-permission");
    $(permin)
        .find("input[type=checkbox]")
        .each(function () {
            if (ischecked == false) {
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }
        });
});
// end check dan uncheck pilih semua

// start function mendapatkan menu yang dipilih dalam jstree
function getselectedjstree() {
    var result = $("#js_tree").jstree("get_selected", true);
    var resultIds = [];
    $.each(result, function () {
        resultIds.push({
            id: this.id,
            parent: this.parent == "#" ? this.id : this.parent
        });
    });
    $("#val_jstree").val(
        JSON.stringify(resultIds) == "[]" ? "" : JSON.stringify(resultIds)
    );
}
// end function mendapatkan menu yang dipilih dalam jstree

function numberFormat(angka, absolute = true){
    try {
        angka = angka.toString();

        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join(',');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        // return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        if (!absolute) {
            if (angka < 0) {
                rupiah = angka.charAt(0) + rupiah;
            }
        }
        return rupiah;
    } catch (error) {
        return '-';
    }
}
