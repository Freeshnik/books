<?php

namespace App\Assets\Packages;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class ChosenAsset extends AssetBundle
{
    public $sourcePath = '@bower/chosen';

    public $css = [
        'chosen.css',
        '/css/bootstrap-chosen/bootstrap-chosen.css',
    ];

    public $js = [
        'chosen.jquery.js',
    ];

    public $depends = [JqueryAsset::class];
}
