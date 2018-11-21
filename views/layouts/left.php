<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= \yii\helpers\Url::to(['/images/avatars/common-avatar.jpg']) ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Administrator</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <!--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Главное меню', 'options' => ['class' => 'header']],
                    ['label' => 'Клиенты', 'icon' => 'users', 'url' => ['/admin/client']],
                    ['label' => 'Категории', 'icon' => ' fa-folder-open', 'url' => ['/admin/category']],
                    ['label' => 'Товары', 'icon' => ' fa-folder-open', 'url' => ['/admin/product']],
                    ['label' => 'Заказы', 'icon' => ' fa-folder-open', 'url' => ['/admin/order']],
                    ['label' => 'Гарантии', 'icon' => ' fa-folder-open', 'url' => ['/admin/warranty']],
                    ['label' => 'Акции', 'icon' => ' fa-folder-open', 'url' => ['/admin/discount']],
                ],
            ]
        ) ?>

    </section>

</aside>
