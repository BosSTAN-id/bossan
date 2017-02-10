<?php

namespace app\modules\parameter\controllers;

use Yii;
use app\models\TaSubUnit;
use app\modules\management\models\TaSubUnitSearch;
use app\modules\parameter\models\TaSekolahJabSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UnitController implements the CRUD actions for TaSubUnit model.
 */
class DatasekolahController extends Controller
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
                    'add' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TaSubUnit models.
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

        $sekolah_id = Yii::$app->user->identity['sekolah_id'];
        $model = $this->findModel($sekolah_id);
        $searchModel = new TaSekolahJabSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['Tahun' => $Tahun, 'sekolah_id' => $sekolah_id]);

        if ($model && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('kv-detail-success', 'Perubahan disimpan');
            return $this->redirect(['index']);
        } else {
            return $this->render('index', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionCreate()
    {
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }
        $model = new \app\models\TaSekolahJab();        
        $model->tahun = $Tahun;
        $model->sekolah_id =  Yii::$app->user->identity->sekolah_id;
        
        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }


    public function actionUpdate($tahun, $sekolah_id, $kd_jabatan, $no_jabatan)
    {
        $model =  \app\models\TaSekolahJab::findOne(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'kd_jabatan' => $kd_jabatan, 'no_jabatan' => $no_jabatan]);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($tahun, $sekolah_id, $kd_jabatan, $no_jabatan)
    {
        \app\models\TaSekolahJab::findOne(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'kd_jabatan' => $kd_jabatan, 'no_jabatan' => $no_jabatan])->delete();

        return $this->redirect(['index']);
    }

 
    /**
     * Finds the TaSubUnit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Tahun
     * @param integer $Kd_Urusan
     * @param integer $Kd_Bidang
     * @param integer $Kd_Unit
     * @param integer $Kd_Sub
     * @return TaSubUnit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = \app\models\RefSekolah::findOne(['id' => $id]);
        return $model;
    }

    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 202])->one();
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
