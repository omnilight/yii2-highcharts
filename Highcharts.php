<?php

namespace omnilight\widgets;
use omnilight\assets\HighchartsAsset;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;


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
    /**
     * @var string
     */
    public $jsonUrl = null;
    /**
     * @var string
     */
    public $jsonSeriesUrl = null;

    public function run()
    {
        parent::run();
        if ($this->options !== null) {
            $tag = ArrayHelper::remove($this->options, 'tag', 'div');
            $options = ArrayHelper::merge([
                'id' => $this->id,
            ],$this->options);
            echo Html::tag($tag, '', $options);
            $this->clientOptions['chart']['renderTo'] = $this->id;
        }
        $this->registerClientScripts();
    }

    public function registerClientScripts()
    {
        HighchartsAsset::registerWithOptions($this->view, [
            'modules' => $this->modules,
            'theme' => $this->theme,
        ]);
        $options = Json::encode($this->clientOptions);
        if ($this->jsonUrl) {
            $url = Url::to($this->jsonUrl);
            $js = <<<JS
var {$this->id};
$.getJSON('{$url}', function(data) {
    var options = {$options};
    options.series = [{data: data}];
    {$this->id} = new Highcharts.Chart(options);
});
JS;
        } elseif ($this->jsonSeriesUrl) {
            $url = Url::to($this->jsonSeriesUrl);
            $js = <<<JS
var {$this->id};
$.getJSON('{$url}', function(data) {
    var options = {$options};
    options.series = data;
    {$this->id} = new Highcharts.Chart(options);
});
JS;
        } else {
            $js =<<<JS
var {$this->id} = new Highcharts.Chart({$options});
JS;

        }
        $this->view->registerJs($js);
    }
}