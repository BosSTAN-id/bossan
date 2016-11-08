<?php

namespace app\modules\controlhutang\controllers;

use Yii;
use app\models\TaTransSKPD;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransskpdController implements the CRUD actions for TaTransSKPD model.
 */
class TransskpdController extends Controller
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
     * Lists all TaTransSKPD models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TaTransSKPD::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaTransSKPD model.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @param integer $Kd_Trans_3
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param integer $Tahun
     * @return mixed
     */
    public function actionView($Kd_Bidang, $Kd_Sub, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Kd_Unit, $Kd_Urusan, $Tahun)
    {
        return $this->render('view', [
            'model' => $this->findModel($Kd_Bidang, $Kd_Sub, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Kd_Unit, $Kd_Urusan, $Tahun),
        ]);
    }

    /**
     * Creates a new TaTransSKPD model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaTransSKPD();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'Tahun' => $model->Tahun]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaTransSKPD model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @param integer $Kd_Trans_3
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param integer $Tahun
     * @return mixed
     */
    public function actionUpdate($Kd_Bidang, $Kd_Sub, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Kd_Unit, $Kd_Urusan, $Tahun)
    {
        $model = $this->findModel($Kd_Bidang, $Kd_Sub, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Kd_Unit, $Kd_Urusan, $Tahun);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'Tahun' => $model->Tahun]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaTransSKPD model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @param integer $Kd_Trans_3
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param integer $Tahun
     * @return mixed
     */
    public function actionDelete($Kd_Bidang, $Kd_Sub, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Kd_Unit, $Kd_Urusan, $Tahun)
    {
        $this->findModel($Kd_Bidang, $Kd_Sub, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Kd_Unit, $Kd_Urusan, $Tahun)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaTransSKPD model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @param integer $Kd_Trans_3
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param integer $Tahun
     * @return TaTransSKPD the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Kd_Bidang, $Kd_Sub, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Kd_Unit, $Kd_Urusan, $Tahun)
    {
        if (($model = TaTransSKPD::findOne(['Kd_Bidang' => $Kd_Bidang, 'Kd_Sub' => $Kd_Sub, 'Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3, 'Kd_Unit' => $Kd_Unit, 'Kd_Urusan' => $Kd_Urusan, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
