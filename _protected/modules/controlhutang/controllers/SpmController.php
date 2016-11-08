<?php

namespace app\modules\controlhutang\controllers;

use Yii;
use app\models\TaSPM;
use app\modules\controlhutang\models\TaSPMSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SpmController implements the CRUD actions for TaSPM model.
 */
class SpmController extends Controller
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
     * Lists all TaSPM models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaSPMSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaSPM model.
     * @param string $No_SPM
     * @param integer $Tahun
     * @return mixed
     */
    public function actionView($No_SPM, $Tahun)
    {
        return $this->render('view', [
            'model' => $this->findModel($No_SPM, $Tahun),
        ]);
    }

    /**
     * Creates a new TaSPM model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaSPM();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'No_SPM' => $model->No_SPM, 'Tahun' => $model->Tahun]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaSPM model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $No_SPM
     * @param integer $Tahun
     * @return mixed
     */
    public function actionUpdate($No_SPM, $Tahun)
    {
        $model = $this->findModel($No_SPM, $Tahun);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'No_SPM' => $model->No_SPM, 'Tahun' => $model->Tahun]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaSPM model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $No_SPM
     * @param integer $Tahun
     * @return mixed
     */
    public function actionDelete($No_SPM, $Tahun)
    {
        $this->findModel($No_SPM, $Tahun)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaSPM model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $No_SPM
     * @param integer $Tahun
     * @return TaSPM the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($No_SPM, $Tahun)
    {
        if (($model = TaSPM::findOne(['No_SPM' => $No_SPM, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
