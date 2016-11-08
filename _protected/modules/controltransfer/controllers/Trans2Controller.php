<?php

namespace app\modules\controltransfer\controllers;

use Yii;
use app\models\TaTrans2;
use app\modules\controltransfer\models\TaTrans2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Trans2Controller implements the CRUD actions for TaTrans2 model.
 */
class Trans2Controller extends Controller
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
     * Lists all TaTrans2 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaTrans2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaTrans2 model.
     * @param integer $Tahun
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @return mixed
     */
    public function actionView($Tahun, $Kd_Trans_1, $Kd_Trans_2)
    {
        return $this->render('view', [
            'model' => $this->findModel($Tahun, $Kd_Trans_1, $Kd_Trans_2),
        ]);
    }

    /**
     * Creates a new TaTrans2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaTrans2();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Tahun' => $model->Tahun, 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaTrans2 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Tahun
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @return mixed
     */
    public function actionUpdate($Tahun, $Kd_Trans_1, $Kd_Trans_2)
    {
        $model = $this->findModel($Tahun, $Kd_Trans_1, $Kd_Trans_2);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Tahun' => $model->Tahun, 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaTrans2 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Tahun
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @return mixed
     */
    public function actionDelete($Tahun, $Kd_Trans_1, $Kd_Trans_2)
    {
        $this->findModel($Tahun, $Kd_Trans_1, $Kd_Trans_2)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaTrans2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Tahun
     * @param integer $Kd_Trans_1
     * @param integer $Kd_Trans_2
     * @return TaTrans2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Tahun, $Kd_Trans_1, $Kd_Trans_2)
    {
        if (($model = TaTrans2::findOne(['Tahun' => $Tahun, 'Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
