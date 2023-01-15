const global = {
    base_url: $('base').attr('href'),
};

const helpers = function () {
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