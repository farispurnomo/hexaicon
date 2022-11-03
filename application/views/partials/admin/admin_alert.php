<?php if ($message = $this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-check text-white"></i> <strong><?= $message ?></strong>
    </div>
<?php endif ?>

<?php if ($message = $this->session->flashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-exclamation-triangle text-white"></i> <strong><?= $message ?></strong>
    </div>
<?php endif ?>

<?php if ($message = $this->session->flashdata('info')) : ?>
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-exclamation-triangle text-white"></i> <strong><?= $message ?></strong>
    </div>
<?php endif ?>

<?php if ($message = $this->session->flashdata('warning')) : ?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-exclamation-triangle text-white"></i> <strong><?= $message ?></strong>
    </div>
<?php endif ?>