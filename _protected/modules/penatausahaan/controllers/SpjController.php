<?php

namespace app\modules\penatausahaan\controllers;

use Yii;
use app\models\TaSPJ;
use app\modules\penatausahaan\models\TaSPJSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SpjController implements the CRUD actions for TaSPJ model.
 */
class SpjController extends Controller
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
     * Lists all TaSPJ models.
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
        $searchModel = new TaSPJSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    /**
     * Displays a single TaSPJ model.
     * @param string $tahun
     * @param string $no_spj
     * @return mixed
     */
    public function actionView($tahun, $no_spj)
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
            'model' => $this->findModel($tahun, $no_spj),
        ]);
    }

    public function actionSpjbukti($tahun, $no_spj)
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
        $model = $this->findModel($tahun, $no_spj);
        $searchModel = new \app\modules\penatausahaan\models\TaSPJRincSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun]);
        $dataProvider->query->andWhere('(Kd_Rek_1 = 5)');
        IF(Yii::$app->user->identity->sekolah_id && $sekolah_id = Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => $sekolah_id]);
        }
        $dataProvider->query->andWhere("tgl_bukti <= '".$model->tgl_spj."'");

        IF($model->kd_sah == 1){
            $dataProvider->query->andWhere("no_spj  IS NULL OR no_spj = '$no_spj' ");
            $dataProvider->query->orderBy('no_spj, tgl_bukti ASC');
        }ELSE{
            $dataProvider->query->andWhere(['no_spj' => $model->no_spj]);
        }

        IF(isset($_POST) AND $_POST <> NULL){
            // var_dump($_POST); 
            foreach ($_POST['selection'] as $value) {
                //convert to array, array key tahun, no_bukti, tgl_bukti
                $data = \yii\helpers\Json::decode($value);
                $bukti = \app\models\TaSPJRinc::findOne(['tahun' => $data['tahun'], 'no_bukti' => $data['no_bukti'] ]);
                $bukti->no_spj = $no_spj;

                $bukti->save();

                // print_r($data);
                // echo '-';
                // print_r($data['tahun']);
                // echo '-';
                // print_r($data['no_bukti']);
                // echo '</br>';
            }
        }

        return $this->render('spjbukti', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }  

    public function actionAssign()
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
        var_dump($_POST);   
        // return $this->render('spjbukti', [
        //     'model' => $model,
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        //     'Tahun' => $Tahun,
        // ]);
    }        

    /**
     * Creates a new TaSPJ model.
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

        $model = new TaSPJ();
        $model->tahun = $Tahun;
        $model->sekolah_id = Yii::$app->user->identity->sekolah_id;
        $model->kd_sah = 1;
        $model->kd_verifikasi = 0;
        $model->user_id = Yii::$app->user->identity->id;

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
     * Updates an existing TaSPJ model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $tahun
     * @param string $no_spj
     * @return mixed
     */
    public function actionUpdate($tahun, $no_spj)
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

        $model = $this->findModel($tahun, $no_spj);
        IF($model->kd_sah <> 1){
            Yii::$app->getSession()->setFlash('warning',  'SPJ ini sudah diproses Tata Usaha, tidak dapat diubah atau dihapus.');
            return $this->redirect(Yii::$app->request->referrer);
        }        

        if ($model->load(Yii::$app->request->post())) {
            \app\models\TaSPJRinc::updateAll(['no_spj' => $model->no_spj], 'no_spj = \''.$no_spj.'\'');
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
     * Deletes an existing TaSPJ model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $tahun
     * @param string $no_spj
     * @return mixed
     */
    public function actionDelete($tahun, $no_spj)
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
        $model = $this->findModel($tahun, $no_spj);
        IF($model->kd_sah == 1){
            $model->delete();
        }ELSE{
            Yii::$app->getSession()->setFlash('warning',  'SPJ ini sudah diproses Tata Usaha, tidak dapat diubah atau dihapus.');
        }
        

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the TaSPJ model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $tahun
     * @param string $no_spj
     * @return TaSPJ the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tahun, $no_spj)
    {
        if (($model = TaSPJ::findOne(['tahun' => $tahun, 'no_spj' => $no_spj])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 502])->one();
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
