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
class ReferensiController extends Controller
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

    public function actionSkpd($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun)
    {       
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $trans3 = $this->findModel($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun);
        $model = new \app\models\TaTransSKPD();
        $modelp = new \app\models\TaTransSkpdPerubahan();

        IF($model->load(Yii::$app->request->post())){
            $model->Tahun = $Tahun;
            $model->Kd_Trans_1 = $Kd_Trans_1;
            $model->Kd_Trans_2 = $Kd_Trans_2;
            $model->Kd_Trans_3 = $Kd_Trans_3;
            list($model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub) = explode('.', $model->kd_skpd);

            //untuk histori perubahan
            $modelp->Tahun = $model->Tahun;
            $modelp->Kd_Trans_1 = $model->Kd_Trans_1;
            $modelp->Kd_Trans_2 = $model->Kd_Trans_2;
            $modelp->Kd_Trans_3 = $model->Kd_Trans_3;
            $modelp->Kd_Urusan = $model->Kd_Urusan;
            $modelp->Kd_Bidang = $model->Kd_Bidang;
            $modelp->Kd_Unit = $model->Kd_Unit;
            $modelp->Kd_Sub = $model->Kd_Sub;
            $modelp->No_Perubahan = 1;
            $modelp->Pagu = $model->Pagu;
            $modelp->Referensi_Dokumen = $model->Referensi_Dokumen;

            IF($model->save() && $modelp->save()){
                return $this->redirect(Yii::$app->request->referrer);
            //     echo 1;
            // }ELSE{
            //     echo 0;
            }
        }     
        return $this->renderAjax('skpd', [
            'model' => $model,
            'trans3' => $trans3,
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
    public function actionLihatpaguskpd( $Tahun, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Kd_Urusan, $Kd_Bidang, $Kd_UNit, $Kd_Sub)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('view', [
            'model' => $this->findModel($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun),
        ]);
    }

    public function actionView($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('view', [
            'model' => $this->findModel($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun),
        ]);
    }    

    public function actionCetak()
    {
        $connection = \Yii::$app->db;   
        $query = $connection->createCommand('SELECT
            a.Tahun, a.Kd_Trans_1, a.Kd_Trans_2, a.Kd_Trans_3, a.Nm_Sub_Bidang, 
            b.Kd_Urusan, b.Kd_Bidang, b.Kd_Unit, b.Kd_Sub, b.No_Kontrak,
            a.Pagu, b.Pagu AS Pagu_Kontrak, a.Pagu-B.Pagu AS Selisih_Pagu
            FROM Ta_Trans_3 a LEFT JOIN
            Ta_Trans_Kontrak b ON a.Tahun = b.Tahun AND a.Kd_Trans_1 = b.Kd_Trans_1 AND a.Kd_Trans_2 = b.Kd_Trans_2 AND a.Kd_Trans_3 = b.Kd_Trans_3
            WHERE b.Kd_Urusan LIKE :Kd_Urusan and B.Kd_Bidang LIKE :Kd_Bidang AND b.Kd_Unit LIKE :Kd_Unit AND b.Kd_Sub LIKE :Kd_Sub');
        IF(Yii::$app->user->identity->Kd_Urusan <> NULL ){
            $query->bindValue(':Kd_Urusan', Yii::$app->user->identity->Kd_Urusan); 
            $query->bindValue(':Kd_Bidang', Yii::$app->user->identity->Kd_Bidang); 
            $query->bindValue(':Kd_Unit', Yii::$app->user->identity->Kd_Unit); 
            $query->bindValue(':Kd_Sub', Yii::$app->user->identity->Kd_Sub);    
        }ELSE{
            $query->bindValue(':Kd_Urusan', '%'); 
            $query->bindValue(':Kd_Bidang', '%'); 
            $query->bindValue(':Kd_Unit', '%'); 
            $query->bindValue(':Kd_Sub', '%');    
        }
        
        $data = $query->queryAll();

        return $this->render('cetakrekapkontrak', [
            'data' => $data,
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
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }        
        $model = new TaTrans3();
        $modelp = new \app\models\TaTrans3Perubahan();
        $model->Tahun = $Tahun;

        if ($model->load(Yii::$app->request->post())) {
            $modelp->Tahun = $model->Tahun;
            $modelp->Kd_Trans_1 = $model->Kd_Trans_1;
            $modelp->Kd_Trans_2 = $model->Kd_Trans_2;
            $modelp->Kd_Trans_3 = $model->Kd_Trans_3;
            $modelp->No_Perubahan = 1;
            $modelp->Pagu = $model->Pagu; 
            IF($model->save() && $modelp->save()){
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
        $modelp = \app\models\TaTrans3Perubahan::findOne(['Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3, 'Tahun' => $Tahun, 'No_Perubahan' => 1]);

        if ($model->load(Yii::$app->request->post())) {
            $modelp->Tahun = $model->Tahun;
            $modelp->Kd_Trans_1 = $model->Kd_Trans_1;
            $modelp->Kd_Trans_2 = $model->Kd_Trans_2;
            $modelp->Kd_Trans_3 = $model->Kd_Trans_3;
            $modelp->No_Perubahan = 1;
            $modelp->Pagu = $model->Pagu;            
            IF($model->save() && $modelp->save()){
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
     * Deletes an existing TaTrans3 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @param integer $Kd_Trans_3
     * @param integer $Tahun
     * @return mixed
     */
    public function actionDelete($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        //hapus perubahan terlebi dahulu kemudian hapus record Trans3
        $modelp = \app\models\TaTrans3Perubahan::findOne(['Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3, 'Tahun' => $Tahun, 'No_Perubahan' => 1]);
        $modelp->delete();

        $this->findModel($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun)->delete();
        

        return $this->redirect(Yii::$app->request->referrer);
    }


    public function actionBidang() {
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }  

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $Kd_Trans_1 = $parents[0];
                $out = \app\models\TaTrans2::find()
                           ->where([
                            'Tahun' => $Tahun,
                            'Kd_Trans_1'=>$Kd_Trans_1,
                            ])
                           ->select(['Kd_Trans_2 AS id','Nm_Bidang AS name'])->asArray()->all();
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    // public function actionUnit() {
    //     $out = [];
    //     if (isset($_POST['depdrop_parents'])) {
    //         $ids = $_POST['depdrop_parents'];
    //         $urusan_id = empty($ids[0]) ? null : $ids[0];
    //         $bidang_id = empty($ids[1]) ? null : $ids[1];
    //         if ($urusan_id != null) {
    //            //$data = self::getProdList($cat_id, $subcat_id);
    //            $data = \common\models\Unit::find()
    //                        ->where([
    //                         'Kd_Urusan'=>$urusan_id,
    //                         'Kd_Bidang' => $bidang_id,
    //                         ])
    //                        ->select(['Kd_Unit AS id','Nm_Unit AS name'])->asArray()->all();
    //             /**
    //              * the getProdList function will query the database based on the
    //              * cat_id and sub_cat_id and return an array like below:
    //              *  [
    //              *      'out'=>[
    //              *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
    //              *          ['id'=>'<prod_id_2>', 'name'=>'<prod-name2>']
    //              *       ],
    //              *       'selected'=>'<prod-id-1>'
    //              *  ]
    //              */
               
    //            echo Json::encode(['output'=>$data, 'selected'=>'']);
    //            return;
    //         }
    //     }
    //     echo Json::encode(['output'=>'', 'selected'=>'']);
    // }

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
