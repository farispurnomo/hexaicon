import helper from './helper.js';

const menuSubscription = function () {
    const toast = helper.toast();
    let plan_id;

    const successPayment = function (result) {
        $.ajax({
            url: helper.getBaseUrl() + '/subscription/upgrade',
            method: 'POST',
            dataType: 'JSON',
            data: {
                plan_id: plan_id,
                response: JSON.stringify(result)
            },
            beforeSend: function () {

            },
            success: function (response) {
                if (response.status == 200) {
                    if (result.transaction_status === 'settlement') {
                        toast.show(toast.type.PRIMARY, 'Success', 'Payment successfull');
                    } else {
                        toast.show(toast.type.PRIMARY, 'Success', 'Transaction pending, please wait');
                    }

                    setTimeout(function () {
                        window.location.href = helper.getBaseUrl() + '/client/dashboard';
                    }, 5000);
                }
            }
        })
    };

    const pay = function (token) {
        snap.pay(token, {
            onSuccess: successPayment,
            onPending: function (result) {

            },
            onError: function (result) {
                toast.show(toast.type.DANGER, 'Failed!', 'Service unavailable, Please try again later');
            },
        });
    };

    const request_token = function () {
        $.ajax({
            url: helper.getBaseUrl() + '/subscription/request_token',
            method: 'POST',
            dataType: 'JSON',
            data: {
                plan_id: plan_id
            },
            beforeSend: function () {

            },
            success: function (response) {
                if (response.status == 200) {
                    pay(response.token);
                } else {
                    toast.show(toast.type.DANGER, 'Failed!', response.msg);
                }
            }
        })
    };

    const init = function (id) {
        plan_id = id;
        $(document).on('click', '#btn-purchase', function () {
            if (confirm('Your subscription before will be lost, Are you sure to continue?')) {
                request_token();
            }
        });
    };

    return {
        init: (plan_id) => init(plan_id)
    };
}();

export default menuSubscription;