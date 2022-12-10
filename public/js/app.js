$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const global = {
    base_url: $('base').attr('href'),
};

const urlHandle = function () {
    const init = function () {
        let url = window.location.href;
        url = url.replace(global.base_url, '');
        if (url.charAt(0) == '/') {
            url = url.substring(1, url.length);
        }
        const urls = url.split('/');
        $(document).find(`#${urls[0]}-nav`).addClass('active');
    };

    return {
        init: () => init()
    }
}();

const common = function () {
    const numberFormat = function (angka, absolute = true) {
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
    };

    return {
        numberFormat: (angka, absolute = true) => numberFormat(angka, absolute),
    }
}();

const header = function () {
    const init = function () {
        $(document).on('click', '#offcanvasSidebar .mega-parent', function () {
            const text = $(this).text();
            const mega_menu = $(this).siblings('.mega-menu');
            mega_menu.addClass('active');
            mega_menu.prepend(`
                <div class="px-4 text-center position-absolute mega-topbar">
                    <div>
                        ${text}
                    </div>
                </div>
            `);
        });

        $(document).on('click', '#offcanvasSidebar .mega-topbar > div', function(){
            $('.mega-menu.active').removeClass('active');
        });
    }

    return {
        init: () => init()
    }
}();

$(function () {
    urlHandle.init();
    header.init();
});