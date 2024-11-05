<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="oneFIC Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= Yii::$app->name ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $assetDir ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> -->

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [

                    ['label' => 'FIC', 'url' => ['/demo/fic/index'], 'icon' => 'warehouse'],
                    ['label' => 'Equipment', 'url' => ['/demo/equipment/index'], 'iconStyle' => 'fas', 'icon' => 'toolbox'],
                    ['label' => 'Services', 'url' => ['/demo/service/index'], 'icon' => 'hand-holding-water'],
                    ['label' => 'Personnels', 'url' => ['/demo/personnel/index'], 'icon' => 'users'],
                    ['label' => 'Facilities', 'url' => ['/demo/facility/index'], 'icon' => 'laptop-house'],
                    ['label' => 'Products', 'url' => ['/demo/product/index'], 'icon' => 'hand-holding-usd'],

                    ['label' => 'Logs', 'header' => true],
                    ['label' => 'Maintenance Log', 'url' => ['/demo/maintenance-log/index'], 'icon' => 'tools'],
                    ['label' => 'Repair Log', 'url' => ['/demo/repair-log/index'], 'icon' => 'hammer'],
                    ['label' => 'Usage Log', 'url' => ['/demo/usage-log/index'], 'icon' => 'people-carry'],

                    ['label' => 'Reports', 'header' => true],
                    ['label' => 'Reports', 'url' => ['/demo/#'], 'icon' => 'book-open'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>