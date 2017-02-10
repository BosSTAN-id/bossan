<?php
namespace app\modules\management\controllers;

use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;
use Yii;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function actionIndex()
    {
        $id = Yii::$app->user->identity->id;
        return $this->render('view', ['model' => $this->findModel($id)]);
    }    

    protected function findModel($id)
    {
        $model = User::findOne($id);

        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        } 

        return $model;
    }
}
