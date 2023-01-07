<main class="min-vh-100">

    <section class="container">
        <div class="row">
            <div class="col-12 py-3">
                <div class="card card-hi-primary">
                    <div class="card-header bg-hi-primary text-center h5 text-white">
                        Subscription Plan Order
                    </div>
                    <div class="card-body">
                        <div class="fw-bold h5">Order Summary</div>
                        <div class="row">
                            <div class="col-6"><?= $subscription->name ?></div>
                            <div class="col-6 text-end"><?= number_format($subscription->total_price) ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6"><span class="h6 fw-bold">Total Amount</span></div>
                            <div class="col-6 text-end"><span class="h6 fw-bold"><?= number_format($subscription->total_price) ?></span></div>
                        </div>

                        <?php if ($is_can_purchase) : ?>
                            <div class="text-center">
                                <button class="btn btn-hi-primary" id="btn-purchase">Purchase to Checkout</button>
                            </div>
                        <?php else : ?>
                            <div class="alert text-center alert-danger" role="alert">
                                <i class="fa fa-exclamation-triangle"></i> <?= $error_note ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $this->config->item('midrans_client_key'); ?>"></script>
<script type="module">
    import menuSubscription from "<?= base_url('public/js/client/subscription.js') ?>";

    $(function() {
        menuSubscription.init('<?= $subscription->id ?>');
    });
</script>