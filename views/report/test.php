<?php

use app\assets\ChartAsset;
use yii\web\View;
use dosamigos\chartjs\ChartJs;

// ChartAsset::register($this);

?>
<div>
    <!-- <canvas id="myChart" width="400" height="400"></canvas> -->
    
    <?= ChartJs::widget([
        'type' => 'bar',
        'options' => [
            'scales' => [
                'xAxes' => [
                    'stacked' => true
                ],
                'yAxes' => [
                    'stacked' => true
                ]
            ]
        ],
        'data' => [
            'labels' => ["January", "February", "March", "April", "May", "June", "July"],
            'datasets' => [
                [
                    'label' => "My First dataset",
                    'backgroundColor' => "red",
                    'borderColor' => "rgba(179,181,198,1)",
                    'pointBackgroundColor' => "rgba(179,181,198,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(179,181,198,1)",
                    'data' => [65, 59, 90, 81, 56, 55, 40]
                ],
                [
                    'label' => "My Second dataset",
                    'backgroundColor' => "yellow",
                    'borderColor' => "rgba(255,99,132,1)",
                    'pointBackgroundColor' => "rgba(255,99,132,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(255,99,132,1)",
                    'data' => [28, 48, 40, 19, 96, 27, 100]
                ]
            ]
        ]
    ]);
    ?>
</div>