<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaMutasiKas */

$this->title = 'Create Ta Mutasi Kas';
$this->params['breadcrumbs'][] = ['label' => 'Ta Mutasi Kas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-mutasi-kas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
