<?php

/* @var $this yii\web\View */
use miloschuman\highcharts\Highcharts;

$this->title = 'DASHBOARD SINERGIS';
?>
<div class="site-index">


    <div class="body-content">

        <div class="row">
             <div class="jumbotron">
                <?php 
                echo Highcharts::widget([
                    'options' => [
                        'chart'=> [
                            'type'=> 'bar',
                        ],
                        'title'=> [
                            'text'=> 'INDIKATOR KINERJA TERPILIH (BULAN INI)'
                        ],
                        /*'subtitle'=> [
                            'text'=> 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>',
                        ],*/
                        'xAxis'=> [
                            'categories'=> $arrData,
                            'title'=> [
                                'text'=> null
                            ]
                        ],
                        'yAxis'=> [
                            'min'=> 0,
                            'title'=> [
                                'text'=> 'Persen',
                                'align'=> 'high'
                            ],
                            'labels'=> [
                                'overflow'=> 'justify'
                            ]
                        ],
                        'tooltip'=> [
                            'valueSuffix'=> ' persen'
                        ],
                        'plotOptions'=> [
                            'bar'=> [
                                'dataLabels'=> [
                                    'enabled'=> true
                                ]
                            ]
                        ],
                        'credits'=> [
                            'enabled'=> false
                        ],
                        'series'=> [[
                            'name'=> 'Persen',
                            'data'=> $arrData2
                        ]]
                   ]
                ]);
                 ?>
            </div>
            <div class="jumbotron">
                <?php 
                echo Highcharts::widget([
                    'options' => [
                        'chart'=> [
                            'type'=> 'column',
                        ],
                        'title'=> [
                            'text'=> 'PENYERAPAN ANGGARAN (BULANAN)'
                        ],
                        'subtitle'=> [
                            'text'=> 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>',
                        ],
                        'xAxis'=> [
                            'categories'=> [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
                            'title'=> [
                                'text'=> null
                            ]
                        ],
                        'yAxis'=> [
                            'min'=> 0,
                            'title'=> [
                                'text'=> 'Population (millions)',
                                'align'=> 'high'
                            ],
                            'labels'=> [
                                'overflow'=> 'justify'
                            ]
                        ],
                        'tooltip'=> [
                            'valueSuffix'=> ' millions'
                        ],
                        'plotOptions'=> [
                            'bar'=> [
                                'dataLabels'=> [
                                    'enabled'=> true
                                ]
                            ]
                        ],
                        'credits'=> [
                            'enabled'=> false
                        ],
                        'series'=> [
                            [
                                'name'=>'Bulan ini',
                                'data'=> [10,11,50,25,12,67,55,32,56,34,56,77,99,55,44,33,54,63,64,64,64,54,76,67,78,33,45,68,88,55,55]
                            ],
                            [
                                'name'=>'Bulan lalu',
                                'data'=> [89,5,45,76,89,33,66,37,45,88,64,67,89,90,12,45,23,46,76,34,68,21,68,35,76,15,47,87,88,23,55]
                            ],
                        ]
                   ]
                ]);
                 ?>
            </div>
        </div>



    </div>
    
</div>
