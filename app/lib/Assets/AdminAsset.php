<?php

namespace App\Assets;

use App\App;
use App\Assets\Packages\AwesomeAsset;
use App\Assets\Packages\BootstrapDatepickerAssets;
use App\Assets\Packages\ChosenAsset;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/admin.css',
        'css/skins/skin-purple.min.css',
    ];
    public $js = [
        'js/app.min.js',
    ];

    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        AwesomeAsset::class,
        BootstrapPluginAsset::class,
        ChosenAsset::class,
        BootstrapDatepickerAssets::class,
    ];

    public function __construct()
    {
        parent::__construct();
        $this->css[] = 'css/skins/skin-' . App::i()->getCurrentModule()->params['layout_color'] . '.min.css';
    }
}
