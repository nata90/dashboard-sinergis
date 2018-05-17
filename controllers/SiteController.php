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
            $arrX[] = date('d F', strtotime('+'.$i.' days', strtotime($sevenDaysAgo)));
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

        $arrDataKelas1 = array();
        $arrDataKelas2 = array();
        $arrDataKelas3 = array();
        $arrDataVip = array();

        $returnDataRi = [];
        foreach($arrTanggal as $row){
            $responseRi = $curl->get('http://192.168.0.90/rsstnet/index.php?r=integrasi/index&pelayanan=iri&tanggal='.$row);
            $arDataRi = json_decode($responseRi);

           foreach($arDataRi as $values){
                $toArray = (array)$values;

                if(strtoupper(trim($toArray['CONTENT'])) == 'KELAS I'){
                    array_push($arrDataKelas1, (int)$toArray['JLH']);
                    $returnDataRi[strtoupper(trim($toArray['CONTENT']))] = ['name'=>$toArray['CONTENT'], 'data'=> $arrDataKelas1];
                }elseif(strtoupper(trim($toArray['CONTENT'])) == 'KELAS II'){
                    array_push($arrDataKelas2, (int)$toArray['JLH']);
                    $returnDataRi[strtoupper(trim($toArray['CONTENT']))] = ['name'=>$toArray['CONTENT'], 'data'=> $arrDataKelas2];
                }elseif(strtoupper(trim($toArray['CONTENT'])) == 'KELAS III'){
                    array_push($arrDataKelas3, (int)$toArray['JLH']);
                    $returnDataRi[strtoupper(trim($toArray['CONTENT']))] = ['name'=>$toArray['CONTENT'], 'data'=> $arrDataKelas3];
                }elseif(strtoupper(trim($toArray['CONTENT'])) == 'VIP A'){
                    array_push($arrDataVip, (int)$toArray['JLH']);
                    $returnDataRi[strtoupper(trim($toArray['CONTENT']))] = ['name'=>$toArray['CONTENT'], 'data'=> $arrDataVip];
                }
           }
        }

        $returnRi = array_values($returnDataRi);

        /*echo '<pre>';
        print_r($returnRi);
        echo '</pre>';
        exit();*/

        //get data pendaftaran poli
        $responsePoli = $curl->get('http://192.168.0.90/rsstnet/index.php?r=integrasi/getdatapoli');
        $arDataPoli = json_decode($responsePoli);

        //get data pendapatan tunai
        $arrDataTunai = array();
        foreach($arrTanggal as $value){

            $responseTunai = $curl->get('http://192.168.0.90/rsstnet/index.php?r=integrasi/getpendapatantunai&tanggal='.$value);
            $arTunai = json_decode($responseTunai);

            $toArray = (array)$arTunai;

            $arrDataTunai[] = $toArray['total'];
        }
       
        return $this->render('index',[
            'returnData'=>$returnData,
            'arrTanggal'=>$arrTanggal,
            'arrX'=>$arrX,
            'returnRi'=>$returnRi,
            'arDataPoli'=>$arDataPoli,
            'arrDataTunai'=>$arrDataTunai
        ]);
    }

    public function actionTes()
    {
        $curl = new curl\Curl();
        

        $arrTanggal =[];
        $returnDataRi = [];
        $dateNow = date('Y-m-d');

        $arrDataKelas1 = array();
        $arrDataKelas2 = array();
        $arrDataKelas3 = array();
        $arrDataVip = array();

        $sevenDaysAgo = date('Y-m-d', strtotime('-7 days', strtotime($dateNow)));

        for($i=1;$i<=7;$i++){
            $arrTanggal[] = date('Y-m-d', strtotime('+'.$i.' days', strtotime($sevenDaysAgo)));
        }

        foreach($arrTanggal as $val){
            $responseRi = $curl->get('http://192.168.0.90/rsstnet/index.php?r=integrasi/index&pelayanan=iri&tanggal='.$val);
            $arDataRi = json_decode($responseRi);

           foreach($arDataRi as $row){
                $toArray = (array)$row;

                if(strtoupper(trim($toArray['CONTENT'])) == 'KELAS I'){
                    array_push($arrDataKelas1, $toArray['JLH']);
                    $returnDataRi[strtoupper(trim($toArray['CONTENT']))] = ['name'=>$toArray['CONTENT'], 'data'=> $arrDataKelas1];
                }elseif(strtoupper(trim($toArray['CONTENT'])) == 'KELAS II'){
                    array_push($arrDataKelas2, $toArray['JLH']);
                    $returnDataRi[strtoupper(trim($toArray['CONTENT']))] = ['name'=>$toArray['CONTENT'], 'data'=> $arrDataKelas2];
                }elseif(strtoupper(trim($toArray['CONTENT'])) == 'KELAS III'){
                    array_push($arrDataKelas3, $toArray['JLH']);
                    $returnDataRi[strtoupper(trim($toArray['CONTENT']))] = ['name'=>$toArray['CONTENT'], 'data'=> $arrDataKelas3];
                }elseif(strtoupper(trim($toArray['CONTENT'])) == 'VIP A'){
                    array_push($arrDataVip, $toArray['JLH']);
                    $returnDataRi[strtoupper(trim($toArray['CONTENT']))] = ['name'=>$toArray['CONTENT'], 'data'=> $arrDataVip];
                }

                

           }

            
        }

        $return = array_values($returnDataRi);
        echo '<pre>';
        print_r($return);
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
