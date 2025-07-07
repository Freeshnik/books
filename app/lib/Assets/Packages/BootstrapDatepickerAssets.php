<?php

namespace App\Assets\Packages;

use rmrevin\yii\fontawesome\cdn\AssetBundle;
use yii\bootstrap\BootstrapPluginAsset;

class BootstrapDatepickerAssets extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';

    public $css = [
        'datepicker/datepicker3.css',
    ];
    public $js = [
        'datepicker/bootstrap-datepicker.js',
        'datepicker/locales/bootstrap-datepicker.ru.js',
    ];

    public $depends = [BootstrapPluginAsset::class];
}
