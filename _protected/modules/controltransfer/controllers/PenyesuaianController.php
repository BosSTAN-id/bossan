<?php

namespace app\modules\controltransfer\controllers;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use app\models\TaTrans3;
use app\modules\controltransfer\models\TaTrans3Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReferensiController implements the CRUD actions for TaTrans3 model.
 */
class PenyesuaianController extends Controller
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
        $searchModel = new TaTrans3Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=50;           

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
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
        $model = $this->findModel($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun);
        $modelp = new \app\models\TaTrans3Perubahan();
        $No_Perubahan = \app\models\TaTrans3Perubahan::find()->where(['Tahun' => $Tahun, 'Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3])->select('MAX(No_Perubahan) AS No_Perubahan')->one();

        if ($model->load(Yii::$app->request->post())) {
            $modelp->Tahun = $model->Tahun;
            $modelp->Kd_Trans_1 = $model->Kd_Trans_1;
            $modelp->Kd_Trans_2 = $model->Kd_Trans_2;
            $modelp->Kd_Trans_3 = $model->Kd_Trans_3;
            $modelp->No_Perubahan = $No_Perubahan->No_Perubahan + 1;
            $modelp->Pagu = $model->Pagu; 
            IF($model->save() && $modelp->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'No_Perubahan' => $No_Perubahan
            ]);
        }
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
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 208])->one();
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
