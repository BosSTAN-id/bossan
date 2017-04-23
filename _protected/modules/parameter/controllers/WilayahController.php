<?php

namespace app\modules\parameter\controllers;

use Yii;
use app\models\RefKecamatan;
use app\models\RefDesa;
use app\modules\parameter\models\RefKecamatanSearch;
use app\modules\parameter\models\RefDesaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WilayahController implements the CRUD actions for RefKecamatan model.
 */
class WilayahController extends Controller
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
     * Lists all RefKecamatan models.
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
        $searchModel = new RefKecamatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['Kd_Prov' => Yii::$app->params['kode_pemda']['0'], 'Kd_Kab_Kota' => Yii::$app->params['kode_pemda']['1']]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    /**
     * Displays a single RefKecamatan model.
     * @param integer $Kd_Prov
     * @param integer $Kd_Kab_Kota
     * @param integer $Kd_Kecamatan
     * @return mixed
     */
    public function actionView($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan)
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
            'model' => $this->findModel($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan),
        ]);
    }

    /**
     * Creates a new RefKecamatan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
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

        $model = new RefKecamatan();
        $params = Yii::$app->params;
        $model->Kd_Prov = $params['kode_pemda']['0'];
        $model->Kd_Kab_Kota = $params['kode_pemda']['1'];

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

    /**
     * Updates an existing RefKecamatan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Kd_Prov
     * @param integer $Kd_Kab_Kota
     * @param integer $Kd_Kecamatan
     * @return mixed
     */
    public function actionUpdate($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan)
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

        $model = $this->findModel($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan);

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

    /**
     * Deletes an existing RefKecamatan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Kd_Prov
     * @param integer $Kd_Kab_Kota
     * @param integer $Kd_Kecamatan
     * @return mixed
     */
    public function actionDelete($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan)
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

        $this->findModel($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /*---------------------------------------------------------------
    ****************Kelurahan/Desa**********************************
    ----------------------------------------------------------------*/

    public function actionKelurahan($Kd_Kecamatan)
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

        $kecamatan = $this->findModel(Yii::$app->params['kode_pemda']['0'], Yii::$app->params['kode_pemda']['1'], $Kd_Kecamatan);
                
        $searchModel = new RefDesaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['Kd_Prov' => Yii::$app->params['kode_pemda']['0'], 'Kd_Kab_Kota' => Yii::$app->params['kode_pemda']['1']]);
        $dataProvider->query->andWhere(['Kd_Kecamatan' => $Kd_Kecamatan]);

        return $this->renderAjax('/kelurahan/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
            'Kd_Kecamatan' => $Kd_Kecamatan,
            'kecamatan' => $kecamatan,
        ]);
    }



    /**
     * Finds the RefKecamatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Kd_Prov
     * @param integer $Kd_Kab_Kota
     * @param integer $Kd_Kecamatan
     * @return RefKecamatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Kd_Prov, $Kd_Kab_Kota, $Kd_Kecamatan)
    {
        if (($model = RefKecamatan::findOne(['Kd_Prov' => $Kd_Prov, 'Kd_Kab_Kota' => $Kd_Kab_Kota, 'Kd_Kecamatan' => $Kd_Kecamatan])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 204])->one();
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
