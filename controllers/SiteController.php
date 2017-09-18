<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use linslin\yii2\curl;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //Init curl
        $curl = new curl\Curl();
        $dateNow = date('Y-m-d');

        $sevenDaysAgo = date('Y-m-d', strtotime('-7 days', strtotime($dateNow)));

        $arrTanggal =[];
        $arrX = [];
 
        //ambil data 7 hari terakhir
        for($i=1;$i<=7;$i++){
            $arrTanggal[] = date('Y-m-d', strtotime('+'.$i.' days', strtotime($sevenDaysAgo)));
            $arrX[] = date('d', strtotime('+'.$i.' days', strtotime($sevenDaysAgo)));
        }

        //get data kunjungan rawat jalan
        $arrJkn = [];
        $arrNonJkn = [];

        $returnData = [];
        foreach($arrTanggal as $val){
            $response = $curl->get('http://192.168.0.90/rsstnet/index.php?r=integrasi/index&pelayanan=irj&tanggal='.$val);
            $arData = json_decode($response);
            $totalJkn = 0;
            $totalNonJkn = 0;
            
            foreach($arData as $row){ 
                $toArray = (array)$row; 


                //$tes = $row->toArray();
                $totalJkn += $toArray['JKN'];
                $totalNonJkn += $toArray['NON JKN'];

            }

            array_push($arrJkn, $totalJkn);
            array_push($arrNonJkn, $totalNonJkn);
        }
        
        $returnData = [
            ['name'=>'JKN', 'data'=>$arrJkn],
            ['name'=>'NON JKN', 'data'=>$arrNonJkn]
        ];

        //get data kunjungan rawat inap
        $returnDataRi = [];
        foreach($arrTanggal as $row){
             $responseRi = $curl->get('http://192.168.0.90/rsstnet/index.php?r=integrasi/index&pelayanan=irj&tanggal='.$row);
             $arDataRi = json_decode($responseRi);


        }


        /*[[
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

                        ]]*/
       
        return $this->render('index',[
            'returnData'=>$returnData,
            'arrTanggal'=>$arrTanggal,
            'arrX'=>$arrX
        ]);
    }

    public function actionTes()
    {
        $curl = new curl\Curl();
        

        $arrTanggal =[];
        $returnDataRi = [];

        $sevenDaysAgo = date('Y-m-d', strtotime('-7 days', strtotime($dateNow)));

        for($i=1;$i<=7;$i++){
            $arrTanggal[] = date('Y-m-d', strtotime('+'.$i.' days', strtotime($sevenDaysAgo)));
        }

        foreach($arrTanggal as $val){
            $responseRi = $curl->get('http://192.168.0.90/rsstnet/index.php?r=integrasi/index&pelayanan=iri&tanggal='.$val);
            $arDataRi = json_decode($responseRi);

            foreach($arDataRi as $row){
                $toArray = (array)$row;
                //$returnDataRi[] = ['name'=>$toArray['CONTENT'], 'data'=> [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6]];
                $returnDataRi = $row;
            }

            
        }

        echo '<pre>';
        print_r($returnDataRi);
        echo '</pre>';
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
