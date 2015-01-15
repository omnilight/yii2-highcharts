<?php

namespace omnilight\widgets;
use omnilight\assets\HighchartsAsset;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * Class Highcharts
 */
class Highcharts extends Widget
{
    /**
     * @var array
     */
    public $options = ['tag' => 'div'];
    /**
     * @var array
     */
    public $clientOptions = [];
    /**
     * @var array
     */
    public $modules = [];
    /**
     * @var string
     */
    public $theme = null;

    public function run()
    {
        parent::run();
        if ($this->options !== null) {
            $tag = ArrayHelper::remove($this->options, 'tag', 'div');
            $options = ArrayHelper::merge([
                'id' => $this->id,
            ],$this->options);
            echo Html::tag($tag, '', $options);
            $this->clientOptions['chart']['renderTo'] = '#'.$this->id;
        }
        $this->registerClientScripts();
    }

    public function registerClientScripts()
    {
        HighchartsAsset::registerWithOptions($this->view, [
            'modules' => $this->modules,
            'theme' => $this->theme,
        ]);
        $options = $this->clientOptions;
        $this->view->registerJs("var {$this->id} = new Highcharts.Chart({$options});");
    }
}