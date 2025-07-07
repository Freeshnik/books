<?php

namespace App\Assets\Packages;

use yii\web\AssetBundle;

class AwesomeAsset extends AssetBundle
{
    public $sourcePath = '@bower/fontawesome';
    public $css = [
        'css/font-awesome.min.css',
    ];
}
