<?php

namespace app\modules\controltransfer\controllers;

use Yii;
use app\models\TaKontrak;
use app\modules\controltransfer\models\TaKontrakSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KontrakController implements the CRUD actions for TaKontrak model.
 */
class KontrakController extends Controller
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
     * Lists all TaKontrak models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaKontrakSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaKontrak model.
     * @param integer $ID_Prog
     * @param integer $Kd_Bidang
     * @param integer $Kd_Keg
     * @param integer $Kd_Prog
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_Kontrak
     * @param integer $Tahun
     * @return mixed
     */
    public function actionView($ID_Prog, $Kd_Bidang, $Kd_Keg, $Kd_Prog, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Kontrak, $Tahun)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID_Prog, $Kd_Bidang, $Kd_Keg, $Kd_Prog, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Kontrak, $Tahun),
        ]);
    }

    /**
     * Creates a new TaKontrak model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaKontrak();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_Prog' => $model->ID_Prog, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Prog' => $model->Kd_Prog, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_Kontrak' => $model->No_Kontrak, 'Tahun' => $model->Tahun]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaKontrak model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $ID_Prog
     * @param integer $Kd_Bidang
     * @param integer $Kd_Keg
     * @param integer $Kd_Prog
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_Kontrak
     * @param integer $Tahun
     * @return mixed
     */
    public function actionUpdate($ID_Prog, $Kd_Bidang, $Kd_Keg, $Kd_Prog, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Kontrak, $Tahun)
    {
        $model = $this->findModel($ID_Prog, $Kd_Bidang, $Kd_Keg, $Kd_Prog, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Kontrak, $Tahun);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_Prog' => $model->ID_Prog, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Prog' => $model->Kd_Prog, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_Kontrak' => $model->No_Kontrak, 'Tahun' => $model->Tahun]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaKontrak model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $ID_Prog
     * @param integer $Kd_Bidang
     * @param integer $Kd_Keg
     * @param integer $Kd_Prog
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_Kontrak
     * @param integer $Tahun
     * @return mixed
     */
    public function actionDelete($ID_Prog, $Kd_Bidang, $Kd_Keg, $Kd_Prog, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Kontrak, $Tahun)
    {
        $this->findModel($ID_Prog, $Kd_Bidang, $Kd_Keg, $Kd_Prog, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Kontrak, $Tahun)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaKontrak model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID_Prog
     * @param integer $Kd_Bidang
     * @param integer $Kd_Keg
     * @param integer $Kd_Prog
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_Kontrak
     * @param integer $Tahun
     * @return TaKontrak the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID_Prog, $Kd_Bidang, $Kd_Keg, $Kd_Prog, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Kontrak, $Tahun)
    {
        if (($model = TaKontrak::findOne(['ID_Prog' => $ID_Prog, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Keg' => $Kd_Keg, 'Kd_Prog' => $Kd_Prog, 'Kd_Sub' => $Kd_Sub, 'Kd_Unit' => $Kd_Unit, 'Kd_Urusan' => $Kd_Urusan, 'No_Kontrak' => $No_Kontrak, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
