<?php

namespace app\widgets;

use app\assets\ChartAsset;
use app\assets\ChartJsAsset;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

class Chart extends Widget
{
    const TYPE_LINE = 'line';
    const TYPE_BAR = 'bar';
    const TYPE_PIE = 'pie';
    const TYPE_DOUGHNUT = 'doughnut';

    public $options = [];
    public $clientOptions = [];
    public $data = [];
    public $type;
    public $plugins = [];

    public function init()
    {
        parent::init();
        if ($this->type === null) {
            throw new InvalidConfigException("The 'type' option is required");
        }
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        echo Html::tag('canvas', '', $this->options);
        $this->registerClientScript();
    }

    protected function registerClientScript()
    {
        $id = $this->options['id'];
        $view = $this->getView();
        ChartJsAsset::register($view);

        $config = Json::encode(
            [
                'type' => $this->type,
                'data' => $this->data ?: new JsExpression('{}'),
                'options' => $this->clientOptions ?: new JsExpression('{}'),
                'plugins' => $this->plugins
            ]
        );

        $js = ";var chartJS_{$id} = new Chart($('#{$id}'),{$config});";
        $view->registerJs($js);
    }
}
