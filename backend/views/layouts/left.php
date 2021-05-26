<aside class="main-sidebar">

    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Пользователи', 'icon' => 'users', 'url' => ['/user/index']],
                    ['label' => 'Категории', 'icon' => 'sitemap', 'url' => ['/category/index']],
                    ['label' => 'Новости', 'icon' => 'newspaper-o', 'url' => ['/news/index']],
                ],
            ]
        ) ?>
    </section>

</aside>
