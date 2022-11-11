
const headerHandle = function () {
    const init = function () {
        const window_height = $(window).height();

        $(window).scroll(function () {
            const scroll_top = $(this).scrollTop();
            // $('nav').toggleClass('sticky-top bg-hi-primary', scroll_top > window_height);
            $('nav').toggleClass('navbar-down', scroll_top > window_height);
        });
    };

    return {
        init: () => init()
    }
}();

$(function () {
    headerHandle.init();
    // console.log('oke');
    $('#btn_login').click(function () {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: base_url + "admin/auth/auth/login",
            data: $('#form_login').serializeArray()
        })
            .done(function (res) {
                console.log(res);
                if (res.status == 200) {
                    $('#alert').html(`<div class="alert alert-success" role="alert">
                    `+ res.msg + `
                </div> `)
                    setTimeout(function () {
                        window.location.replace(base_url+'admin/dashboard');
                        // window.location.reload(base_url+'admin/dashboard');
                    }, 1500);
                } else {
                    $('#alert').html(`<div class="alert alert-danger" role="alert">
                            `+ res.msg + `
                        </div> `)
                }
            });
        // console.log('oke');
        // console.log($('#form_login').serializeArray());
    })
    $('#btn_register').click(function () {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: base_url + "admin/auth/auth/register",
            data: $('#form_register').serializeArray()
        })
            .done(function (res) {
                if (res.status == 200) {
                    $('#alert_register').html(`<div class="alert alert-success" role="alert">
                            `+ res.msg + `
                        </div> `)
                } else {
                    $('#alert_register').html(`<div class="alert alert-danger" role="alert">
                            `+ res.msg + `
                        </div> `)
                }
            });
        // console.log('oke');
        // console.log($('#form_login').serializeArray());
    })
})