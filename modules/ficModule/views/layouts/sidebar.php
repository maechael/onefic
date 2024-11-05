<?php

use hail812\adminlte\widgets\Menu;
use mdm\admin\components\MenuHelper;

// $callback = function ($menu) {
//     $data = eval($menu['data']);
//     return [
//         'label' => $menu['name'],
//         'url' => [$menu['route']],
//         // 'options' => $data,
//         'items' => $menu['children'],
//         'icon' => 'fas fa-book'
//     ];
// }
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="oneFIC Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= Yii::$app->name ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?= Menu::widget([
                'items' => [
                    ['label' => 'FIC', 'url' => ['/fic-module/fic/index'], 'icon' => 'warehouse'],
                    ['label' => 'Equipment', 'url' => ['/fic-module/fic-equipment/index'], 'icon' => 'toolbox'],
                    ['label' => 'Personnels', 'url' => ['/fic-module/fic-personnel/index'], 'icon' => 'users'],
                    ['label' => 'Products', 'url' => ['/fic-module/fic-personnel/index'], 'icon' => 'box-open'],
                    ['label' => 'Suppliers', 'url' => ['/fic-module/supplier/index'], 'icon' => 'truck'],
                    ['label' => 'Fabricators', 'url' => ['/fic-module/fic-personnel/index'], 'icon' => 'truck-loading'],
                    [
                        'label' => 'Job Order Request',
                        'icon' => 'clipboard-list',
                        'items' => [
                            ['label' => 'My Request', 'url' => ['/fic-module/job-order-request/index'], 'iconStyle' => 'fas', 'icon' => 'caret-right'],
                            ['label' => 'For Approval', 'url' => ['/fic-module/job-order-request/for-approval'], 'iconStyle' => 'fas', 'icon' => 'caret-right'],
                            ['label' => 'Request History', 'url' => [''], 'iconStyle' => 'fas', 'icon' => 'caret-right'],
                        ]
                    ]
                ],
                // 'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback)
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>