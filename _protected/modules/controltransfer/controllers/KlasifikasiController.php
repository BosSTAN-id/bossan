<?php

namespace app\modules\controltransfer\controllers;

use Yii;
use app\models\TaTrans2;
use app\modules\controltransfer\models\TaTrans2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * ReferensiController implements the CRUD actions for TaTrans3 model.
 */
class KlasifikasiController extends Controller
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
        $searchModel = new TaTrans2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=50;           

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSkpd($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun)
    {
        $model = new \app\models\TaTransSKPD();
        IF($model->load(Yii::$app->request->post())){
            $model->Tahun = $Tahun;
            $model->Kd_Trans_1 = $Kd_Trans_1;
            $model->Kd_Trans_2 = $Kd_Trans_2;
            $model->Kd_Trans_3 = $Kd_Trans_3;
            list($model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub) = explode('.', $model->kd_skpd);

            IF($model->save()){
                //return $this->redirect(['index']);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }     
        return $this->renderAjax('skpd', [
            'model' => $model,
            //$this->findModel($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun),
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
        return $this->render('view', [
            'model' => $this->findModel($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun),
        ]);
    }

    public function actionView($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun)
    {
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
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }        
        $model = new TaTrans2();
        $model->Tahun = $Tahun;

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

    public function actionCreatejenis()
    {
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => \app\models\TaTrans1::find()->where(['Tahun' => $Tahun]),
        ]);
        $dataProvider->pagination->pageSize = 50; 

        $model = new \app\models\TaTrans1();
        $model->Tahun = $Tahun;

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formjenis', [
                'model' => $model,
                'dataProvider' => $dataProvider,
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
    public function actionUpdate($Kd_Trans_1, $Kd_Trans_2, $Tahun)
    {
        $model = $this->findModel($Kd_Trans_1, $Kd_Trans_2, $Tahun);

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
     * Deletes an existing TaTrans3 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @param integer $Kd_Trans_3
     * @param integer $Tahun
     * @return mixed
     */
    public function actionDelete($Kd_Trans_1, $Kd_Trans_2, $Tahun)
    {
        $this->findModel($Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Tahun)->delete();

        return $this->redirect(['index']);
    }

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
    protected function findModel($Kd_Trans_1, $Kd_Trans_2, $Tahun)
    {
        if (($model = TaTrans2::findOne(['Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
