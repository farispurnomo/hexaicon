const helper = function () {
    const getBaseUrl = function () {
        const base_url = $(document).find('base').attr('href');
        return base_url;
    };

    return {
        getBaseUrl: () => getBaseUrl()
    }
}();
export default helper;