<?php

namespace app\modules\globalsetting\controllers;

use Yii;
use app\models\RefPenerimaanSekolah2;
use app\models\RefPenerimaanSekolahSisa;
use app\modules\globalsetting\models\RefPenerimaanSekolah2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MappingpendapatanController implements the CRUD actions for RefPenerimaanSekolah2 model.
 */
class MappingsisaController extends Controller
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
     * Lists all RefPenerimaanSekolah2 models.
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
        $searchModel = new RefPenerimaanSekolah2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['kd_penerimaan_1' => 1]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }



    public function actionUpdate($kd_penerimaan_1, $kd_penerimaan_2)
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
        $komponen = $this->findModel($kd_penerimaan_1, $kd_penerimaan_2);
        $model = RefPenerimaanSekolahSisa::findOne(['penerimaan_sisa_1' => $kd_penerimaan_1, 'penerimaan_sisa_2' => $kd_penerimaan_2]);
        if(!$model) $model = new RefPenerimaanSekolahSisa();
        $model->penerimaan_sisa_1 = $kd_penerimaan_1;
        $model->penerimaan_sisa_2 = $kd_penerimaan_2;

        if ($model->load(Yii::$app->request->post())) {
            IF($model->penerimaan2)
                list($model->kd_penerimaan_1, $model->kd_penerimaan_2) = explode('.', $model->penerimaan2);
            // var_dump($model);                
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'komponen' => $komponen,
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RefPenerimaanSekolah2 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $kd_penerimaan_1
     * @param integer $kd_penerimaan_2
     * @return mixed
     */
    public function actionDelete($kd_penerimaan_1, $kd_penerimaan_2)
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

        $this->findModel($kd_penerimaan_1, $kd_penerimaan_2)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the RefPenerimaanSekolah2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $kd_penerimaan_1
     * @param integer $kd_penerimaan_2
     * @return RefPenerimaanSekolah2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($kd_penerimaan_1, $kd_penerimaan_2)
    {
        if (($model = RefPenerimaanSekolah2::findOne(['kd_penerimaan_1' => $kd_penerimaan_1, 'kd_penerimaan_2' => $kd_penerimaan_2])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 109])->one();
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
