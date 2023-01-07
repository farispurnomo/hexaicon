<main class="min-vh-100">
    <div class="container wow animate__fadeIn">
        <div class="row">
            <div class="col-12">
                <div class="text-center my-5">
                    <h1 class="fw-bold">Choose Your Plan</h1>
                    <h5>Take your desired plan to get access to our icon easily</h5>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php
            foreach ($subscriptions as $key => $subscription) :
                $is_last = $key + 1 == count($subscriptions);
            ?>
                <div class="col-md-3 p-3 d-flex align-items-stretch">
                    <div class="card-pricing <?= ($is_last ? '' : 'card-pricing-light') ?>">
                        <div class="card-pricing-content">
                            <div class="card-pricing-body">
                                <div class="mb-3 subtitle fw-bold"><?= $subscription->name ?></div>
                                <div class="mb-3"><span class="title fw-bold"><?= thousandCurrencyFormat($subscription->total_price) ?></span> / year</div>
                                <div class="mb-3"><?= $subscription->description ?></div>
                                <div class="mb-5 px-3">
                                    <?php foreach ($subscription->items as $item) : ?>
                                        <div class="mb-3">
                                            <?php if ($is_last) : ?>
                                                <img draggable="false" src="<?= base_url('public/images/check-circle-yellow.png') ?>" alt="">
                                            <?php else : ?>
                                                <img draggable="false" src="<?= base_url('public/images/check-circle.png') ?>" alt="">
                                            <?php endif ?>

                                            <span><?= $item->name ?></span>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <div class="card-pricing-footer">
                                <div class="small mb-1"><?= $subscription->note ?></div>
                                <a href="<?= base_url('subscription/purchase/' . $subscription->id) ?>" class="btn subtitle px-md-5 rounded-pill <?= ($is_last ? 'btn-hi-white' : 'btn-hi-primary') ?>">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</main>

<?php 
/*<html>

<body>
    <!-- <button id="pay-button">Pay!</button>
    <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre> -->

    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <!-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-d0ZIHeiVBEjyBEcJ"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('<?= $snap_token ?>', {
                // Optional
                onSuccess: function(result) {
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onPending: function(result) {
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script> -->
</body>

</html>*/
