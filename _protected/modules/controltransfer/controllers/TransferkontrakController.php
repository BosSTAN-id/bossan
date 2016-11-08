<?php

namespace app\modules\controltransfer\controllers;

use Yii;
use app\models\TaTrans3;
use app\modules\controltransfer\models\TaTrans3Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReferensiController implements the CRUD actions for TaTrans3 model.
 */
class TransferkontrakController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TaTrans3 models.
     * @return mixed
     */
    public function actionIndex()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }         
        $searchModel = new \app\modules\controltransfer\models\TaTransSKPDSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['Tahun' => $Tahun]);
        $dataProvider->pagination->pageSize=50;           

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,            
        ]);
    }

    public function actionKontrak($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model = new \app\models\TaTransKontrak();
        IF($model->load(Yii::$app->request->post())){
            $model->Tahun = $Tahun;
            $model->Kd_Trans_1 = $Kd_Trans_1;
            $model->Kd_Trans_2 = $Kd_Trans_2;
            $model->Kd_Trans_3 = $Kd_Trans_3;
            //list($model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub) = explode('.', $model->kd_skpd);
            $model->Kd_Urusan = Yii::$app->user->identity->Kd_Urusan;
            $model->Kd_Bidang = Yii::$app->user->identity->Kd_Bidang;
            $model->Kd_Unit = Yii::$app->user->identity->Kd_Unit;
            $model->Kd_Sub = Yii::$app->user->identity->Kd_Sub;
            //ambil pagu kontrak
            $kontrak = \app\models\TaKontrak::findOne(['No_Kontrak' => $model->No_Kontrak]);
            $model->Pagu = $kontrak->Nilai;
            IF($model->save()){
                return $this->redirect(Yii::$app->request->referrer);
            //     echo 1;
            // }ELSE{
            //     echo 0;
            }
        }     
        return $this->renderAjax('skpd', [
            'model' => $model,
            'Tahun' => $Tahun,
            'Kd_Trans_1' => $Kd_Trans_1,
            'Kd_Trans_2' => $Kd_Trans_2,
            'Kd_Trans_3' => $Kd_Trans_3,
            //$this->findModel($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun),
        ]);
    }    

    /**
     * Displays a single TaTrans3 model.
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @param integer $Kd_Trans_3
     * @param integer $Tahun
     * @return mixed
     */
    public function actionView($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun)
    {
        return $this->render('view', [
            'model' => $this->findModel($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun),
        ]);
    }

    /**
     * Creates a new TaTrans3 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model = new TaTrans3();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3, 'Tahun' => $model->Tahun]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaTrans3 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @param integer $Kd_Trans_3
     * @param integer $Tahun
     * @return mixed
     */
    public function actionUpdate($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model = $this->findModel($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3, 'Tahun' => $model->Tahun]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    // public function actionDelete($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun)
    // {
    //     IF($this->cekakses() !== true){
    //         Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
    //         return $this->redirect(Yii::$app->request->referrer);
    //     }
    //     $this->findModel($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun)->delete();

    //     return $this->redirect(['index']);
    // }

    public function actionDelete($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $No_Kontrak)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        \app\models\TaTransKontrak::findOne(['Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3, 'Tahun' => $Tahun, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub, 'No_Kontrak' => $No_Kontrak])->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }    

    /**
     * Finds the TaTrans3 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @param integer $Kd_Trans_3
     * @param integer $Tahun
     * @return TaTrans3 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun)
    {
        if (($model = TaTrans3::findOne(['Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 205])->one();
            IF($akses){
                return true;
            }else{
                return false;
            }
        }ELSE{
            return false;
        }
    }  
}
