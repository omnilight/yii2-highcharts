<?php

namespace omnilight\assets;

use yii\helpers\ArrayHelper;
use yii\web\AssetBundle;
use yii\web\View;


/**
 * Class HighchartsAsset
 */
class HighchartsAsset extends AssetBundle
{
    public $sourcePath = '@bower/highcharts';

    public $js = [
        'highcharts.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    /**
     * Registers bundle with several options. Options available are:
     *  - modules - array of modules ('module.js')
     *  - theme - name of the theme
     * @param View $view
     * @param array $options
     * @return HighchartsAsset
     */
    public static function registerWithOptions($view, $options = [])
    {
        $bundle = self::register($view);
        foreach ((array)ArrayHelper::getValue($options, 'modules', []) as $module) {
            $bundle->js[] = "modules/{$module}";
        }
        if ($theme = ArrayHelper::getValue($options, 'theme', null)) {
            $bundle->js[] = "themes/{$theme}.js";
        }

        return $bundle;
    }
} 