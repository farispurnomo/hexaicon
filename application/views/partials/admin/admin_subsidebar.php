<ul class="menu-subnav">
    <?php foreach ($childs as $menu) : ?>
        <?php if (empty($menu['childs'])) : ?>
            <li class="menu-item submenu <?= (strpos(current_url(), $menu['url']) !== FALSE ? 'menu-item-active' : '') ?>" aria-haspopup="true">
                <a href="<?= base_url($menu['url'] ?? '') ?>" class="menu-link submenu">
                    <span class="menu-icon">
                        <i class="<?= $menu['icon'] ?? 'flaticon2-architecture-and-city' ?>"></i>
                    </span>
                    <span class="menu-text"><?= $menu['title'] ?></span>
                </a>
            </li>
        <?php else : ?>
            <div class="menu-submenu">
                <span class="menu-arrow"></span>
                <?php $this->load->view('partials/admin/admin_subsidebar', ['childs' => $menu['childs']]); ?>
            </div>
        <?php endif ?>
    <?php endforeach ?>
</ul>