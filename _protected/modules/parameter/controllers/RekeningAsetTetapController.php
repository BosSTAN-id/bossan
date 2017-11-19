<?php

namespace app\modules\parameter\controllers;

use Yii;
use app\models\RefRekAset1;
use app\models\RefRekAset2;
use app\models\RefRekAset3;
use app\models\RefRekAset4;
use app\models\RefRekAset5;
use app\modules\parameter\models\RefRekAset1Search;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RekeningAsetTetapController implements the CRUD actions for RefRekAset1 model.
 */
class RekeningAsetTetapController extends Controller
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
     * Lists all RefRekAset1 models.
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
        $searchModel = new RefRekAset1Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    /**
     * Displays a single RefRekAset1 model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
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
            'model' => $this->findModel($id),
        ]);
    }

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

        $model = new RefRekAset1();

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

    public function actionUpdate($id)
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

        $model = $this->findModel($id);

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
    
    public function actionDelete($id)
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

        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    
    public function actionRekAset2($Kd_Aset1)
    {
        $model = RefRekAset1::findOne(['Kd_Aset1' => $Kd_Aset1]);
        $query = \app\models\RefRekAset2::find()->where(['Kd_Aset1' => $Kd_Aset1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);

        return $this->renderAjax('_rek-aset2', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    } 

    public function actionRekAset2Tambah($Kd_Aset1)
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

        $model = new RefRekAset2();
        $model->Kd_Aset1 = $Kd_Aset1;
        $model->Kd_Aset2 = RefRekAset2::find()->select('MAX(Kd_Aset2) AS Kd_Aset2')->where(['Kd_Aset1' => $Kd_Aset1])->one()['Kd_Aset2'] + 1;

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formaset2', [
                'model' => $model,
            ]);
        }
    }

    public function actionRekAset2Update($Kd_Aset1, $Kd_Aset2)
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

        $model = RefRekAset2::findOne(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2]);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formaset2', [
                'model' => $model,
            ]);
        }
    }

    public function actionRekAset2Delete($Kd_Aset1, $Kd_Aset2)
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

        $model = RefRekAset2::findOne(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2]);
        $model->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }    

    
    public function actionRekAset3($Kd_Aset1, $Kd_Aset2)
    {
        $model = RefRekAset2::findOne(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2]);
        $query = \app\models\RefRekAset3::find()->where(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);

        return $this->renderAjax('_rek-aset3', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionRekAset3Tambah($Kd_Aset1, $Kd_Aset2)
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

        $model = new RefRekAset3();
        $model->Kd_Aset1 = $Kd_Aset1;
        $model->Kd_Aset2 = $Kd_Aset2;
        $model->Kd_Aset3 = RefRekAset3::find()->select('MAX(Kd_Aset3) AS Kd_Aset3')->where(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2])->one()['Kd_Aset3'] + 1;

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formaset3', [
                'model' => $model,
            ]);
        }
    }

    public function actionRekAset3Update($Kd_Aset1, $Kd_Aset2, $Kd_Aset3)
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

        $model = RefRekAset3::findOne(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3]);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formaset3', [
                'model' => $model,
            ]);
        }
    }

    public function actionRekAset3Delete($Kd_Aset1, $Kd_Aset2, $Kd_Aset3)
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

        $model = RefRekAset3::findOne(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3]);
        $model->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }    
    
    
    public function actionRekAset4($Kd_Aset1, $Kd_Aset2, $Kd_Aset3)
    {
        $model = RefRekAset3::findOne(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3]);
        $query = \app\models\RefRekAset4::find()->where(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);

        return $this->renderAjax('_rek-aset4', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionRekAset4Tambah($Kd_Aset1, $Kd_Aset2, $Kd_Aset3)
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

        $model = new RefRekAset4();
        $model->Kd_Aset1 = $Kd_Aset1;
        $model->Kd_Aset2 = $Kd_Aset2;
        $model->Kd_Aset3 = $Kd_Aset3;
        $model->Kd_Aset4 = RefRekAset4::find()->select('MAX(Kd_Aset4) AS Kd_Aset4')->where(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3])->one()['Kd_Aset4'] + 1;

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formaset4', [
                'model' => $model,
            ]);
        }
    }

    public function actionRekAset4Update($Kd_Aset1, $Kd_Aset2, $Kd_Aset3, $Kd_Aset4)
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

        $model = RefRekAset4::findOne(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3, 'Kd_Aset4' => $Kd_Aset4]);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formaset4', [
                'model' => $model,
            ]);
        }
    }

    public function actionRekAset4Delete($Kd_Aset1, $Kd_Aset2, $Kd_Aset3, $Kd_Aset4)
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

        $model = RefRekAset4::findOne(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3, 'Kd_Aset4' => $Kd_Aset4]);
        $model->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }    
    
    public function actionRekAset5($Kd_Aset1, $Kd_Aset2, $Kd_Aset3, $Kd_Aset4)
    {
        $model = RefRekAset4::findOne(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3, 'Kd_Aset4' => $Kd_Aset4]);
        $query = \app\models\RefRekAset5::find()->where(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3, 'Kd_Aset4' => $Kd_Aset4]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);

        return $this->renderAjax('_rek-aset5', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    } 

    public function actionRekAset5Tambah($Kd_Aset1, $Kd_Aset2, $Kd_Aset3, $Kd_Aset4)
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

        $model = new RefRekAset5();
        $model->Kd_Aset1 = $Kd_Aset1;
        $model->Kd_Aset2 = $Kd_Aset2;
        $model->Kd_Aset3 = $Kd_Aset3;
        $model->Kd_Aset4 = $Kd_Aset4;
        $model->Kd_Aset5 = RefRekAset5::find()->select('MAX(Kd_Aset5) AS Kd_Aset5')->where(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3, 'Kd_Aset4' => $Kd_Aset4])->one()['Kd_Aset5'] + 1;

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formaset5', [
                'model' => $model,
            ]);
        }
    }

    public function actionRekAset5Update($Kd_Aset1, $Kd_Aset2, $Kd_Aset3, $Kd_Aset4, $Kd_Aset5)
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

        $model = RefRekAset5::findOne(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3, 'Kd_Aset4' => $Kd_Aset4, 'Kd_Aset5' => $Kd_Aset5]);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formaset5', [
                'model' => $model,
            ]);
        }
    }

    public function actionRekAset5Delete($Kd_Aset1, $Kd_Aset2, $Kd_Aset3, $Kd_Aset4, $Kd_Aset5)
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

        $model = RefRekAset5::findOne(['Kd_Aset1' => $Kd_Aset1, 'Kd_Aset2' => $Kd_Aset2, 'Kd_Aset3' => $Kd_Aset3, 'Kd_Aset4' => $Kd_Aset4, 'Kd_Aset5' => $Kd_Aset5]);
        $model->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }        

    /**
     * Finds the RefRekAset1 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RefRekAset1 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RefRekAset1::findOne($id)) !== null) {
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
