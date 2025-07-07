<?php

namespace App\Assets\Packages;

use yii\web\AssetBundle;

class InputMaskAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery.inputmask/dist';
    public $js = [
        'jquery.inputmask.bundle.js',
    ];
}
