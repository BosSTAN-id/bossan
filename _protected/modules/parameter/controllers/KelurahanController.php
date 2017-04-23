<?php

namespace app\modules\parameter\controllers;

use Yii;
use app\models\RefDesa;
use app\modules\parameter\models\RefDesaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KelurahanController implements the CRUD actions for RefDesa model.
 */
class KelurahanController extends Controller
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

    public function actionView($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan, $Kd_Desa)
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
        return $this->renderAjax('view', [
            'model' => $this->findModel($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan, $Kd_Desa),
        ]);
    }

    public function actionCreate($Kd_Kecamatan)
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

        $model = new RefDesa();
        $params = Yii::$app->params;
        $model->Kd_Prov = $params['kode_pemda']['0'];
        $model->Kd_Kab_Kota = $params['kode_pemda']['1'];
        $model->Kd_Kecamatan = $Kd_Kecamatan;

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'Kd_Kecamatan' => $Kd_Kecamatan,
            ]);
        }
    }

    /**
     * Updates an existing RefDesa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Kd_Prov
     * @param integer $Kd_Kab_Kota
     * @param integer $Kd_Kecamatan
     * @param integer $Kd_Desa
     * @return mixed
     */
    public function actionUpdate($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan, $Kd_Desa)
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

        $model = $this->findModel($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan, $Kd_Desa);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'Kd_Kecamatan' => $Kd_Kecamatan
            ]);
        }
    }

    /**
     * Deletes an existing RefDesa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Kd_Prov
     * @param integer $Kd_Kab_Kota
     * @param integer $Kd_Kecamatan
     * @param integer $Kd_Desa
     * @return mixed
     */
    public function actionDelete($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan, $Kd_Desa)
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

        $this->findModel($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan, $Kd_Desa)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the RefDesa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Kd_Prov
     * @param integer $Kd_Kab_Kota
     * @param integer $Kd_Kecamatan
     * @param integer $Kd_Desa
     * @return RefDesa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan, $Kd_Desa)
    {
        if (($model = RefDesa::findOne(['Kd_Prov' => $Kd_Prov, 'Kd_Kab_Kota' => $Kd_Kab_Kota, 'Kd_Kecamatan' => $Kd_Kecamatan, 'Kd_Desa' => $Kd_Desa])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 401])->one();
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
