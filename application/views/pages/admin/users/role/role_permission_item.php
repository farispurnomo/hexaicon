<?php $deep++ ?>

<?php foreach ($menus as $menu) : ?>
    <tr>
        <td>
            <div style="padding-left: <?= $deep * 30 ?>px;">
                <?= $menu->title ?>
            </div>
        </td>
        <td>
            <?php foreach ($menu->abilities as $ability) : ?>
                <div class="py-3">
                    <label class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" value="<?= $ability->id ?>" name="privileges[]" <?= $ability->is_granted ? 'checked' : '' ?>>
                        <span class="form-check-label fw-bold text-muted"><?= $ability->name ?></span>
                    </label>
                </div>
            <?php endforeach ?>
        </td>
    </tr>

    <?php
    if (!empty($menu->child)) {
        $this->load->view('pages/admin/users/role/role_permission_item', ['menus' => $menu->child, 'deep' => $deep]);
    }
    ?>
<?php endforeach ?>