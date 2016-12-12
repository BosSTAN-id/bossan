<?php

namespace app\modules\penatausahaan\controllers;

use Yii;
use app\models\TaSPJRinc;
use app\modules\penatausahaan\models\TaSPJRincSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PenerimaanController implements the CRUD actions for TaSPJRinc model.
 */
class PenerimaanController extends Controller
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
     * Lists all TaSPJRinc models.
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
        $searchModel = new TaSPJRincSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun]);
        $dataProvider->query->andWhere('Kd_Rek_1 = 4 OR (Kd_Rek_1 = 6 AND Kd_Rek_2 = 1)');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    /**
     * Displays a single TaSPJRinc model.
     * @param string $tahun
     * @param string $no_bukti
     * @param string $tgl_bukti
     * @return mixed
     */
    public function actionView($tahun, $no_bukti, $tgl_bukti)
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
            'model' => $this->findModel($tahun, $no_bukti, $tgl_bukti),
        ]);
    }

    /**
     * Creates a new TaSPJRinc model.
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

        $model = new TaSPJRinc();
        $model->sekolah_id = Yii::$app->user->identity->sekolah_id;
        $model->tahun = $Tahun;
        $model->kd_program = 0;
        $model->kd_sub_program = 0;
        $model->kd_kegiatan = 0;
        $model->pembayaran = 1;
        $model->Kd_Rek_1 = 4;

        if ($model->load(Yii::$app->request->post())) {
            list($model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5) = explode('.', $model->rek5);
            $model->nilai = str_replace(',', '.', $model->nilai);
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'Tahun' => $Tahun,
            ]);
        }
    }

    /**
     * Updates an existing TaSPJRinc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $tahun
     * @param string $no_bukti
     * @param string $tgl_bukti
     * @return mixed
     */
    public function actionUpdate($tahun, $no_bukti, $tgl_bukti)
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

        $model = $this->findModel($tahun, $no_bukti, $tgl_bukti);

        if ($model->load(Yii::$app->request->post())) {
            list($model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5) = explode('.', $model->rek5);
            $model->nilai = str_replace(',', '.', $model->nilai);
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'Tahun' => $Tahun,
            ]);
        }
    }

    /**
     * Deletes an existing TaSPJRinc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $tahun
     * @param string $no_bukti
     * @param string $tgl_bukti
     * @return mixed
     */
    public function actionDelete($tahun, $no_bukti, $tgl_bukti)
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
        $model = $this->findModel($tahun, $no_bukti, $tgl_bukti);
        IF($model->no_spj == NULL){
            $model->delete();
        }ELSE{
            Yii::$app->getSession()->setFlash('warning',  'Sudah di SPJ kan, tidak dapat dihapus.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the TaSPJRinc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $tahun
     * @param string $no_bukti
     * @param string $tgl_bukti
     * @return TaSPJRinc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tahun, $no_bukti, $tgl_bukti)
    {
        if (($model = TaSPJRinc::findOne(['tahun' => $tahun, 'no_bukti' => $no_bukti, 'tgl_bukti' => $tgl_bukti])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 501])->one();
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
