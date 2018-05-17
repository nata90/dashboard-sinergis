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
                        'text'=> 'JUMLAH KUNJUNGAN RAWAT JALAN'
                    ],
                    'subtitle'=> [
                        'text'=> date('d F Y')
                    ],
                    'plotOptions'=> [
                        'pie'=> [
                            'innerSize'=> 100,
                            'depth'=> 45
                        ]
                    ],
                    'series'=> [[
                        'name'=> 'Total Pasien',
                        'data'=> $arDataPoli
                    ]]
               ]
            ]);
            ?>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-6" style="padding-bottom:20px;">

               <?php 
                echo Highcharts::widget([
                   'options' => [
                      'title' => ['text' => 'Trend Kunjungan Rawat Jalan '.date('F')],
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
            <div class="col-lg-6" style="padding-bottom:20px;">

                <?php 
                echo Highcharts::widget([
                   'options' => [
                        'chart'=> [
                            'type'=> 'column'
                        ],
                        'title' => ['text' => 'Trend Kunjungan Rawat Inap '.date('F')],
                        //'subtitle' => ['text' => 'Source: WorldClimate.com'],
                        'xAxis' => [
                            'categories' => $arrX,
                            'crosshair' => true,
                        ],
                        'yAxis'=> [
                            'min'=> 0,
                            'title'=> [
                                'text'=> 'Total pasien'
                            ]
                        ],
                        'tooltip'=> [
                            'headerFormat'=> '<span style="font-size:10px">{point.key}</span><table>',
                            'pointFormat'=>'<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} pasien</b></td></tr>',
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
                        'series'=> $returnRi
                   ]
                ]);
                ?>
            </div>

           <div class="jumbotron">

                <?php 
                echo Highcharts::widget([
                   'options' => [
                        
                        'title'=> [
                            'text'=> 'Pendapatan Tunai '.date('F')
                        ],                        
                        'xAxis'=> [
                            'categories'=> $arrX,
                            'title' => ['text' => 'Tanggal']
                        ],
                        'yAxis' => [
                             'title' => ['text' => 'Rupiah']
                          ],
                        'tooltip'=> [
                            'pointFormat'=>'{point.y:.0f} rupiah',
                            'shared'=> true,
                            'useHTML'=> true,
                            
                        ],
                        'series'=> [[
                            'type'=> 'column',
                            'colorByPoint'=> 'true',
                            'data'=> $arrDataTunai,
                            'showInLegend'=> false
                        ]]
                   ]
                ]);
                ?>
            </div>

                <?php 
                /*echo Highcharts::widget([
                   'options' => [
                        'chart'=> [
                            'type'=> 'column'
                        ],
                        'title' => ['text' => 'Pendapapatan Per Tanggungan '.date('F')],
                        //'subtitle' => ['text' => 'Source: WorldClimate.com'],
                        'xAxis' => [
                            'categories' => $arrX,
                            'crosshair' => true,
                        ],
                        'yAxis'=> [
                            'min'=> 0,
                            'title'=> [
                                'text'=> 'Total pasien'
                            ]
                        ],
                        'tooltip'=> [
                            'headerFormat'=> '<span style="font-size:10px">{point.key}</span><table>',
                            'pointFormat'=>'<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} pasien</b></td></tr>',
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
                        'series'=> $returnRi
                   ]
                ]);*/
                ?>
        </div>



    </div>
    
</div>
