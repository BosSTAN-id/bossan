<?php

namespace app\modules\kasharian\controllers;

use Yii;
use app\models\TaKasHarian;
use app\modules\kasharian\models\TaKasHarianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KasharianController implements the CRUD actions for TaKasHarian model.
 */
class KasharianController extends Controller
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
     * Lists all TaKasHarian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaKasHarianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new TaKasHarian();   
        IF($model->load(Yii::$app->request->post())){
            IF($model->save()){
                return $this->redirect(['index']);
            }
        }     

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TaKasHarian model.
     * @param integer $Kd_Bank
     * @param string $Tanggal
     * @return mixed
     */
    public function actionView($Kd_Bank, $Tanggal)
    {
        return $this->render('view', [
            'model' => $this->findModel($Kd_Bank, $Tanggal),
        ]);
    }

    /**
     * Creates a new TaKasHarian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaKasHarian();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Kd_Bank' => $model->Kd_Bank, 'Tanggal' => $model->Tanggal]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaKasHarian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Kd_Bank
     * @param string $Tanggal
     * @return mixed
     */
    public function actionUpdate($Kd_Bank, $Tanggal)
    {
        $model = $this->findModel($Kd_Bank, $Tanggal);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Kd_Bank' => $model->Kd_Bank, 'Tanggal' => $model->Tanggal]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaKasHarian model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Kd_Bank
     * @param string $Tanggal
     * @return mixed
     */
    public function actionDelete($Kd_Bank, $Tanggal)
    {
        $this->findModel($Kd_Bank, $Tanggal)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaKasHarian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Kd_Bank
     * @param string $Tanggal
     * @return TaKasHarian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Kd_Bank, $Tanggal)
    {
        if (($model = TaKasHarian::findOne(['Kd_Bank' => $Kd_Bank, 'Tanggal' => $Tanggal])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
