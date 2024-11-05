<?php

use yii\web\View;
use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;

$datasets = null;
foreach ($models as $model) {
    $datasets[] = [
        'label' => $model->region,
        'borderColor' => $model->color,
        'pointBackgroundColor' => $model->color,
        'pointBorderColor' => "#fff",
        'pointHoverBackgroundColor' => "#fff",
        'pointHoverBorderColor' => "rgba(179,181,198,1)",
        'data' => $model->prodcount
    ];
}
?>


<div class="container-fluid">
    <div class="row">

        <div class="col-12">
            <div class="card card-primary card-outline">

                <div class="card-body">
                    <?= ChartJs::widget([
                        'type' => 'bar',
                        'options' => [

                            //'height' => 40000,
                            //'width' => 400
                        ],
                        'clientOptions' => [
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
                            'labels' => ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "Decemeber"],
                            'datasets' => $datasets
                        ]
                    ]);
                    ?>
                </div>

            </div>
        </div>

    </div>

</div>