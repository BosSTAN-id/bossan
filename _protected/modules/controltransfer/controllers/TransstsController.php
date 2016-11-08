<?php

namespace app\modules\controltransfer\controllers;

use Yii;
use yii\helpers\Json;
use app\models\TaTransSts;
use app\modules\controltransfer\models\TaTransStsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransstsController implements the CRUD actions for TaTransSts model.
 */
class TransstsController extends Controller
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
     * Lists all TaTransSts models.
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
        $model = new TaTransSts();
        if ($model->load(Yii::$app->request->post())){
            $model->Tahun = $Tahun;
            $model->D_K = 1;
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        }


        $searchModel = new TaTransStsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['D_K' => 1, 'Tahun' => $Tahun]);
        $connection = \Yii::$app->db;
        $now = DATE('Y-m-d');
        $query = $connection->createCommand("
            SELECT
                a.Tahun,
                a.Kd_Trans_1,
                a.Kd_Trans_2,
                a.Kd_Trans_3,
                a.Nm_Sub_Bidang,
                a.Pagu AS Anggaran,
                IFNULL(b.Nilai, 0) AS Realisasi
            FROM
                (
                    SELECT
                        *
                    FROM
                        ta_trans_3
                    WHERE
                        Tahun = $Tahun AND Pagu <> 0
                ) a
            LEFT JOIN (
                SELECT
                    Tahun,
                    Kd_Trans_1,
                    Kd_Trans_2,
                    Kd_Trans_3,
                    SUM(Nilai) AS Nilai
                FROM
                    ta_trans_sts
                WHERE
                    Tahun = $Tahun
                    AND Tgl_STS <= \"$now\" 
                    AND D_K = 1
                GROUP BY
                    Tahun,
                    Kd_Trans_1,
                    Kd_Trans_2,
                    Kd_Trans_3
            ) b ON a.Kd_Trans_1 = b.Kd_Trans_1
            AND a.Kd_Trans_2 = b.Kd_Trans_2
            AND a.Kd_Trans_3 = b.Kd_Trans_3          
            ");
        $posisikas = $query->queryAll();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'input' => $model,
            'Tahun' => $Tahun,
            'posisikas' => $posisikas,
        ]);
    }

    /**
     * Displays a single TaTransSts model.
     * @param integer $Tahun
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @param integer $Kd_Trans_3
     * @param string $No_STS
     * @return mixed
     */
    public function actionView($Tahun, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $No_STS)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('view', [
            'model' => $this->findModel($Tahun, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $No_STS),
        ]);
    }

    /**
     * Creates a new TaTransSts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model = new TaTransSts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Tahun' => $model->Tahun, 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3, 'No_STS' => $model->No_STS]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaTransSts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Tahun
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @param integer $Kd_Trans_3
     * @param string $No_STS
     * @return mixed
     */
    public function actionUpdate($Tahun, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $No_STS)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model = $this->findModel($Tahun, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $No_STS);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Tahun' => $model->Tahun, 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3, 'No_STS' => $model->No_STS]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaTransSts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Tahun
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @param integer $Kd_Trans_3
     * @param string $No_STS
     * @return mixed
     */
    public function actionDelete($Tahun, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $No_STS)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->findModel($Tahun, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $No_STS)->delete();

        return $this->redirect(['index']);
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

    public function actionSubbidang() {
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $Kd_Trans_1 = empty($ids[0]) ? null : $ids[0];
            $Kd_Trans_2 = empty($ids[1]) ? null : $ids[1];
            if ($Kd_Trans_1 != null) {
               //$data = self::getProdList($cat_id, $subcat_id);
               $data = \app\models\TaTrans3::find()
                           ->where([
                            'Tahun' => $Tahun,
                            'Kd_Trans_1'=>$Kd_Trans_1,
                            'Kd_Trans_2'=>$Kd_Trans_2,
                            ])
                           ->select(['Kd_Trans_3 AS id','Nm_Sub_Bidang AS name'])->asArray()->all();
                /**
                 * the getProdList function will query the database based on the
                 * cat_id and sub_cat_id and return an array like below:
                 *  [
                 *      'out'=>[
                 *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
                 *          ['id'=>'<prod_id_2>', 'name'=>'<prod-name2>']
                 *       ],
                 *       'selected'=>'<prod-id-1>'
                 *  ]
                 */
               
               echo Json::encode(['output'=>$data, 'selected'=>'']);
               return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }    

    /**
     * Finds the TaTransSts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Tahun
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @param integer $Kd_Trans_3
     * @param string $No_STS
     * @return TaTransSts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Tahun, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $No_STS)
    {
        if (($model = TaTransSts::findOne(['Tahun' => $Tahun, 'Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3, 'No_STS' => $No_STS])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 210])->one();
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
