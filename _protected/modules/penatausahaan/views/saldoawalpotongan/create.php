<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaSaldoAwalPotongan */

$this->title = 'Create Ta Saldo Awal Potongan';
$this->params['breadcrumbs'][] = ['label' => 'Ta Saldo Awal Potongans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-saldo-awal-potongan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
