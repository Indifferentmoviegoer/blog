<aside class="main-sidebar">

    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Пользователи', 'icon' => 'users', 'url' => ['/user/index']],
                    ['label' => 'Категории', 'icon' => 'sitemap', 'url' => ['/category/index']],
                    ['label' => 'Новости', 'icon' => 'newspaper-o', 'url' => ['/news/index']],
                    ['label' => 'Категории изображений', 'icon' => 'file-image-o', 'url' => ['/gallery-category/index']],
                    ['label' => 'Галерея', 'icon' => 'file-image-o', 'url' => ['/gallery/index']],
                    ['label' => 'Комментарии', 'icon' => 'comments', 'url' => ['/comment/index']],
                    ['label' => 'Настройки', 'icon' => 'comments', 'url' => ['/setting/index']],
                ],
            ]
        ) ?>
    </section>

</aside>
