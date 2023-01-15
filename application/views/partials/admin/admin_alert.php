<?php if ($message = $this->session->flashdata('success')) : ?>
    <div class="alert alert-success">
        <i class="fa fa-check me-2 text-success"></i> <strong><?= $message ?></strong>
    </div>
<?php endif ?>

<?php if ($message = $this->session->flashdata('error')) : ?>
    <div class="alert alert-danger">
        <i class="fa fa-exclamation-triangle me-2 text-danger"></i> <strong><?= $message ?></strong>
    </div>
<?php endif ?>

<?php if ($message = $this->session->flashdata('info')) : ?>
    <div class="alert alert-info">
        <i class="fa fa-exclamation-triangle me-2 text-info"></i> <strong><?= $message ?></strong>
    </div>
<?php endif ?>

<?php if ($message = $this->session->flashdata('warning')) : ?>
    <div class="alert alert-warning">
        <i class="fa fa-exclamation-triangle me-2 text-warning"></i> <strong><?= $message ?></strong>
    </div>
<?php endif ?>