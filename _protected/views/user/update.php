<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$this->title = Yii::t('app', 'Update User') . ': ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="row">
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-12 well bs-component">

        <?= $this->render('_form', ['user' => $user]) ?>

    </div>

</div>
</div>