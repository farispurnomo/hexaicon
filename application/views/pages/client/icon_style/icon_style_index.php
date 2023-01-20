<main>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 py-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center pt-5 pb-4">
                                <div class="h1 fw-bold">Icon Styling</div>
                                <div>Styling your icon and download it</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-3">
        <?php $this->load->view($namespace . 'edit'); ?>
    </section>

    <section>
        <div class="container-fluid" id="suggestion-icons">

        </div>
    </section>

</main>

<div class="modal fade" id="restrictionModal" tabindex="-1" aria-labelledby="restrictionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<style>
    .fw-bold.text-capitalize.h5 {
        display: flex;
        align-items: center;
    }

    .fw-bold.text-capitalize.h5::after {
        content: "";
        bottom: 0;
        width: 100%;
        height: 1px;
        margin-left: 24px;
        background: rgba(0, 0, 0, 1);
    }

    #wrapper {
        position: relative;
        overflow: hidden;
    }

    #wrapper::before,
    #wrapper::after {
        position: absolute;
        top: 51%;
        overflow: hidden;
        width: 48%;
        height: 1px;
        content: '\a0';
        background-color: #000;
        margin-left: 2%;
    }

    #wrapper::before {
        margin-left: -50%;
        text-align: right;
    }
</style>

<script type="module" defer>
    import menuIconStyle from "<?= base_url('public/js/client/icon-style.js') ?>";

    $(function() {
        menuIconStyle.init('<?= $icon_id ?>');
    });
</script>