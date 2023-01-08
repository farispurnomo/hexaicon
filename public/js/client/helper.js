const helper = function () {
    const getBaseUrl = function () {
        const base_url = $(document).find('base').attr('href');
        return base_url;
    };

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

    const toast = function () {
        const element = $('#toast');
        const toast_obj = new bootstrap.Toast(element);

        let temp_class = '';
        const type = {
            PRIMARY: 'text-bg-hi-primary',
            DANGER: 'text-bg-danger'
        };

        const show = function (type, title, msg) {
            $('#toast').removeClass(temp_class).addClass(type);

            $('#toast').find('#toast-title').text(title);
            $('#toast').find('#toast-msg').html(msg);

            toast_obj.show();

            temp_class = type
        };

        return {
            init: () => init(),
            show: (type = '', title = '', msg = '') => show(type, title, msg),
            type: type
        }
    };

    return {
        getBaseUrl: () => getBaseUrl(),
        numberFormat: (angka, absolute = true) => numberFormat(angka, absolute),
        toast: () => toast()
    }
}();
export default helper;