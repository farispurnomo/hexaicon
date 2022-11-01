
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
})