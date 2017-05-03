<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaSetoranPotongan */

$this->title = 'Create Ta Setoran Potongan';
$this->params['breadcrumbs'][] = ['label' => 'Ta Setoran Potongans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-setoran-potongan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
