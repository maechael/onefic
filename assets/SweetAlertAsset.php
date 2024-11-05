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
class SweetAlertAsset extends AssetBundle
{
    /**
     * @var string the directory that contains the source asset files.
     */
    public $sourcePath = '@bower/sweetalert';

    /**
     * @var array list of JavaScript files.
     */
    public $js = [
        'dist/sweetalert.min.js',
    ];

    /**
     * @var array list of CSS files.
     */
    public $css = [
        'dist/sweetalert.css'
    ];

    /**
     * Adds a Sweet Alert theme CSS file
     *
     * @param string $theme the theme name
     *
     * @return object instance
     */
    public function addTheme($theme)
    {
        $this->css[] = "themes/{$theme}/{$theme}.css";
        return $this;
    }
}
