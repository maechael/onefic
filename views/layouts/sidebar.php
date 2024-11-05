<?php

use hail812\adminlte\widgets\Menu;
use mdm\admin\components\MenuHelper;
use yii\helpers\ArrayHelper;

$callback = function ($menu) {
    $data = eval($menu['data']);
    $iconClass = $data && ArrayHelper::keyExists('iconClass', $data, true) ? $data['iconClass'] : 'nav-icon fas fa-caret-right';
    $header = $data && ArrayHelper::keyExists('header', $data, true) ? $data['header'] : false;
    return [
        'label' => $menu['name'],
        // 'header' => $header,
        'url' => [$menu['route']],
        // 'options' => $data,
        'items' => $menu['children'],
        'iconClass' => $iconClass
    ];
}
?>
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
            <?= Menu::widget([
                'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback, true),
                // 'items' => [
                //     // [
                //     //     'label' => 'List Administration',
                //     //     'icon' => 'list-alt',
                //     //     'items' => [
                //     //         ['label' => 'FIC', 'url' => ['fic/index'], 'icon' => 'warehouse'],
                //     //         ['label' => 'Equipment', 'url' => ['equipment/index'], 'icon' => 'toolbox'],
                //     //     ]
                //     // ],
                //     ['label' => 'List Management', 'header' => true],
                //     ['label' => 'FIC', 'url' => ['/fic/index'], 'icon' => 'warehouse'],
                //     [
                //         'label' => 'Equipment',
                //         'icon' => 'toolbox',
                //         'items' => [
                //             ['label' => 'Equipment', 'url' => ['/equipment/index'], 'iconStyle' => 'fas', 'icon' => 'caret-right'],
                //             ['label' => 'Specs', 'url' => ['/equipment-spec/index'], 'iconStyle' => 'fas', 'icon' => 'caret-right'],
                //             ['label' => 'Component', 'url' => ['/component/index'], 'iconStyle' => 'fas', 'icon' => 'caret-right'],
                //             ['label' => 'Part', 'url' => ['/part/index'], 'iconStyle' => 'fas', 'icon' => 'caret-right'],
                //             ['label' => 'Processing Capability', 'url' => ['/processing-capability/index'], 'iconStyle' => 'fas', 'icon' => 'caret-right'],
                //         ],
                //     ],
                //     [
                //         'label' => 'Supplier',
                //         'icon' => 'boxes',
                //         'items' => [
                //             ['label' => 'Supplier', 'url' => ['/supplier-module/supplier/index'], 'iconStyle' => 'fas', 'icon' => 'caret-right'],
                //             // ['label' => 'Supplier Approval', 'url' => ['/supplier-module/supplier/approval'], 'iconStyle' => 'fas', 'icon' => 'caret-right']
                //         ]
                //     ],
                //     ['label' => 'Facility', 'url' => ['/facility/index'], 'icon' => 'laptop-house'],
                //     ['label' => 'Service', 'url' => ['/service/index'], 'icon' => 'hand-holding-water'],
                //     ['label' => 'Designation', 'url' => ['/designation/index'], 'iconStyle' => 'fas', 'icon' => 'user-circle'],

                //     ['label' => 'User Administration', 'header' => true],
                //     ['label' => 'Users', 'url' => ['/user-profile/index'], 'icon' => 'users'],

                //     ['label' => 'Security', 'header' => true],
                //     ['label' => 'Assignments', 'url' => ['/admin/assignment/'], 'icon' => 'address-book'],
                //     ['label' => 'Roles', 'url' => ['/admin/role/'], 'icon' => 'user-tag'],
                //     ['label' => 'Permissions', 'url' => ['/admin/permission/'], 'icon' => 'user-edit'],
                //     ['label' => 'Menu', 'url' => ['/admin/menu/'], 'icon' => 'bars'],
                //     ['label' => 'Routes', 'url' => ['/admin/route/'], 'icon' => 'route'],
                //     ['label' => 'Rules', 'url' => ['/admin/rule/'], 'icon' => 'scroll'],

                //     ['label' => 'Reports', 'header' => true],
                //     ['label' => 'Reports', 'url' => ['/report/index'], 'icon' => 'book-open'],

                //     ['label' => 'Demo', 'header' => true],
                //     ['label' => 'Demo', 'url' => ['/demo/default/index'], 'icon' => 'laptop-code'],
                // ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>