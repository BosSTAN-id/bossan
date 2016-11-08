<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaSubUnit */

$this->title = Yii::t('app', 'Create Ta Sub Unit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ta Sub Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-sub-unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
