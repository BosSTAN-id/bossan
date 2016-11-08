<?php

namespace app\modules\kasharian\controllers;

use Yii;
use app\models\TaDeposito;
use app\modules\kasharian\models\TaDepositoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DepositoController implements the CRUD actions for TaDeposito model.
 */
class PosisidepositoController extends Controller
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
     * Lists all TaDeposito models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaDepositoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,           
        ]);
    }

    /**
     * Finds the TaDeposito model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaDeposito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaDeposito::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
