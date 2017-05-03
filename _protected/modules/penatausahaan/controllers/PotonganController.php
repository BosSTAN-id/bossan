<?php

namespace app\modules\penatausahaan\controllers;

use Yii;
use app\models\TaSetoranPotongan;
use app\modules\penatausahaan\models\TaSetoranPotonganSearch;
use app\models\TaSetoranPotonganRinc;
use app\modules\penatausahaan\models\TaSetoranPotonganRincSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PotonganController implements the CRUD actions for TaSetoranPotongan model.
 */
class PotonganController extends Controller
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
     * Lists all TaSetoranPotongan models.
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
        $searchModel = new TaSetoranPotonganSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        IF(Yii::$app->user->identity->sekolah_id && $sekolah_id = Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => $sekolah_id]);
        }
        $dataProvider->query->orderBy('tgl_setoran DESC, no_setoran DESC');        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    public function actionView($tahun, $sekolah_id, $no_setoran)
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
            'model' => $this->findModel($tahun, $sekolah_id, $no_setoran),
        ]);
    }

    /**
     * Creates a new TaSetoranPotongan model.
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

        $model = new TaSetoranPotongan();
        $model->tahun = $Tahun;
        $model->sekolah_id = Yii::$app->user->identity->sekolah_id;

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
     * Updates an existing TaSetoranPotongan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $tahun
     * @param integer $sekolah_id
     * @param string $no_setoran
     * @return mixed
     */
    public function actionUpdate($tahun, $sekolah_id, $no_setoran)
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

        $model = $this->findModel($tahun, $sekolah_id, $no_setoran);

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
     * Deletes an existing TaSetoranPotongan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $tahun
     * @param integer $sekolah_id
     * @param string $no_setoran
     * @return mixed
     */
    public function actionDelete($tahun, $sekolah_id, $no_setoran)
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

        $this->findModel($tahun, $sekolah_id, $no_setoran)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }


    // Bagian Rincian Potongan
    public function actionRincian($tahun, $sekolah_id, $no_setoran)
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

        $searchModel = new TaSetoranPotonganRincSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_setoran' => $no_setoran]);

        return $this->render('rincian', [
            'model' => $this->findModel($tahun, $sekolah_id, $no_setoran),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($tahun, $sekolah_id, $no_setoran)
    {
        if (($model = TaSetoranPotongan::findOne(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_setoran' => $no_setoran])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 509])->one();
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
