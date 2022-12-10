<main class="d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-md-8 py-5 m-auto">
                <div class="card card-hi-primary">
                    <div class="card-header bg-hi-primary h5 text-white">
                        Submit a Request
                    </div>
                    <form action="<?= base_url($route . '/store') ?>" method="post">
                        <div class="card-body">
                            <?php if ($message = $this->session->flashdata('success')) : ?>
                                <div class="alert alert-success d-flex align-items-center" role="alert">
                                    <i class="fa fa-circle-check me-2"></i>
                                    <div>
                                        <?= $message ?>
                                    </div>
                                </div>
                            <?php endif ?>
                            <div class="mb-3">
                                <label class="form-label">Your Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Subject</label>
                                <input type="text" class="form-control" name="subject" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Details</label>
                                <textarea class="form-control" name="content" rows="10" placeholder="Please write your question or a description of the problem you're trying to solve here." required></textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-hi-primary"><i class="fa fa-paper-plane"></i> Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>