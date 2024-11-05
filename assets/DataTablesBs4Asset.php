<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DataTablesBs4Asset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-bs4/';

    public $css = [
        'css/dataTables.bootstrap4.css'
    ];

    public $js = [
        'js/dataTables.bootstrap4.js',
    ];

    public $depends = [
        // 'yii\web\JqueryAsset',
        // 'yii\bootstrap4\BootstrapAsset',
        'app\assets\DataTablesAsset',
    ];
}
