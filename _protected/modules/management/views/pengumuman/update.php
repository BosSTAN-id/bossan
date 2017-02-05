<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaPengumuman */

$this->title = 'Ubah Pengumuman: ' . $model->title;
$this->params['breadcrumbs'][] = 'Management';
$this->params['breadcrumbs'][] = ['label' => 'Pengumuman', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-pengumuman-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
