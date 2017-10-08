<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaInfoBos */

$this->title = 'Update Ta Info Bos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ta Info Bos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-info-bos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
