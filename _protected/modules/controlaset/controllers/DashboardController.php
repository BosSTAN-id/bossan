<?php

namespace app\modules\controlaset\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DashboardController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$koneksi = $this->findKoneksi();
    	$model = NULL;
    	IF($koneksi <> NULL){
    		$model = new \yii\data\ActiveDataProvider([
					    'query' => \app\models\Bmd::find(),
					]);
    	}

        return $this->render('index',[
        	'model' => $model,
			'koneksi' => $koneksi
        	]);
    }

    public function actionKoneksi()
    {
    	$koneksi = $this->findKoneksi();

        $model = new \app\models\RefKoneksiBMD();
        IF($model->load(Yii::$app->request->post())){
        	$model->adi = \app\models\RefKoneksiBMD::dokudoku('donat', $model->adi);
        	$model->erzo = \app\models\RefKoneksiBMD::dokudoku('donat', $model->erzo);
        	$model->bram = \app\models\RefKoneksiBMD::dokudoku('donat', $model->bram);
        	$model->isbandi = \app\models\RefKoneksiBMD::dokudoku('donat', $model->isbandi);
            IF($model->save()){
                return $this->redirect(['index']);
            }
        } 

        return $this->render('koneksi',[
        		'model' => $model,
        		'koneksi' => $koneksi
        	]);
    }    

    protected function findKoneksi()
    {
        $model = \app\models\RefKoneksiBMD::find()->one();
        return $model;
    }    

}
