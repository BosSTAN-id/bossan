<?php

namespace app\modules\controltransfer\controllers;

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
        $modelp = new \app\models\TaTransSkpdPerubahan();
        $No_Perubahan = \app\models\TaTransSkpdPerubahan::find()->where(['Kd_Bidang' => $Kd_Bidang, 'Kd_Sub' => $Kd_Sub, 'Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3, 'Kd_Unit' => $Kd_Unit, 'Kd_Urusan' => $Kd_Urusan, 'Tahun' => $Tahun])->select('MAX(No_Perubahan) AS No_Perubahan')->one();

        if ($model->load(Yii::$app->request->post())) {
            //untuk histori perubahan
            $modelp->Tahun = $model->Tahun;
            $modelp->Kd_Trans_1 = $model->Kd_Trans_1;
            $modelp->Kd_Trans_2 = $model->Kd_Trans_2;
            $modelp->Kd_Trans_3 = $model->Kd_Trans_3;
            $modelp->Kd_Urusan = $model->Kd_Urusan;
            $modelp->Kd_Bidang = $model->Kd_Bidang;
            $modelp->Kd_Unit = $model->Kd_Unit;
            $modelp->Kd_Sub = $model->Kd_Sub;
            $modelp->No_Perubahan = $No_Perubahan->No_Perubahan + 1;
            $modelp->Pagu = $model->Pagu;
            $modelp->Referensi_Dokumen = $model->Referensi_Dokumen;


            IF($model->save() && $modelp->save()){
                return $this->redirect(Yii::$app->request->referrer);
            //     echo 1;
            // }ELSE{
            //     echo 0;
            }
        } else {
            return $this->renderAjax('skpd', [
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
        //delete perubahan terlebih dahulu baru kemduain transskpd
        \app\models\TaTransSkpdPerubahan::deleteAll(['Kd_Bidang' => $Kd_Bidang, 'Kd_Sub' => $Kd_Sub, 'Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3, 'Kd_Unit' => $Kd_Unit, 'Kd_Urusan' => $Kd_Urusan, 'Tahun' => $Tahun]);
        $this->findModel($Kd_Bidang, $Kd_Sub, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3, $Kd_Unit, $Kd_Urusan, $Tahun)->delete();
        

        return $this->redirect(Yii::$app->request->referrer);
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
