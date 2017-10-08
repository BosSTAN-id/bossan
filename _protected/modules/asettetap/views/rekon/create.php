<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaAsetTetapBa */

$this->title = 'Create Ta Aset Tetap Ba';
$this->params['breadcrumbs'][] = ['label' => 'Ta Aset Tetap Bas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-aset-tetap-ba-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
