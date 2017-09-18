<?php

/* @var $this yii\web\View */
use miloschuman\highcharts\Highcharts;

$this->title = 'DASHBOARD SINERGIS';
?>
<div class="site-index">

    <div class="jumbotron">
        <?php 
            echo Highcharts::widget([
               'options' => [
                    'chart'=> [
                        'type'=> 'pie',
                        'options3d'=> [
                            'enabled'=> true,
                            'alpha'=> 45
                        ]
                    ],
                    'title'=> [
                        'text'=> 'Contents of Highsoft\'s weekly fruit delivery'
                    ],
                    'subtitle'=> [
                        'text'=> '3D donut in Highcharts'
                    ],
                    'plotOptions'=> [
                        'pie'=> [
                            'innerSize'=> 100,
                            'depth'=> 45
                        ]
                    ],
                    'series'=> [[
                        'name'=> 'Delivered amount',
                        'data'=> [
                            ['Bananas', 8],
                            ['Kiwi', 3],
                            ['Mixed nuts', 1],
                            ['Oranges', 6],
                            ['Apples', 8],
                            ['Pears', 4],
                            ['Clementines', 4],
                            ['Reddish (bag)', 1],
                            ['Grapes (bunch)', 1]
                        ]
                    ]]
               ]
            ]);
            ?>
    </div>

    <div class="body-content">

        <div class="row">
            


            <div class="col-lg-6">
                <h2>Trend Kunjungan Rawat Jalan</h2>

               <?php 
                echo Highcharts::widget([
                   'options' => [
                      'title' => ['text' => date('F')],
                      'xAxis' => [
                         'categories' => $arrX
                      ],
                      'yAxis' => [
                         'title' => ['text' => 'Total Pengunjung']
                      ],
                      'series' => $returnData
                   ]
                ]);
                ?>
            </div>
            
            <div class="col-lg-6">
                <h2>Trend Kunjungan Rawat Inap</h2>

                <?php 
                echo Highcharts::widget([
                   'options' => [
                        'chart'=> [
                            'type'=> 'column'
                        ],
                        'title' => ['text' => date('F')],
                        //'subtitle' => ['text' => 'Source: WorldClimate.com'],
                        'xAxis' => [
                            'categories' => $arrX,
                            'crosshair' => true,
                        ],
                        'yAxis'=> [
                            'min'=> 0,
                            'title'=> [
                                'text'=> 'Rainfall (mm)'
                            ]
                        ],
                        'tooltip'=> [
                            'headerFormat'=> '<span style="font-size:10px">{point.key}</span><table>',
                            'pointFormat'=>'<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                            'footerFormat'=> '</table>',
                            'shared'=> true,
                            'useHTML'=> true
                        ],
                        'plotOptions'=> [
                            'column'=> [
                                'pointPadding'=> 0.2,
                                'borderWidth'=> 0
                            ]
                        ],
                        'series'=> [[
                            'name'=> 'Tokyo',
                            'data'=> [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6]

                        ], [
                            'name'=> 'New York',
                            'data'=> [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0]

                        ], [
                            'name'=> 'London',
                            'data'=> [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0]

                        ], [
                            'name'=> 'Berlin',
                            'data'=> [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4]

                        ]]
                   ]
                ]);
                ?>
            </div>

            
        </div>

    </div>
</div>
