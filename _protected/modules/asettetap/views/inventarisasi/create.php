<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaAsetTetap */

$this->title = 'Create Ta Aset Tetap';
$this->params['breadcrumbs'][] = ['label' => 'Ta Aset Tetaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-aset-tetap-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
