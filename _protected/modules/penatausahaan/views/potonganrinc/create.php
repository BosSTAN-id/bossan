<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaSetoranPotonganRinc */

$this->title = 'Create Ta Setoran Potongan Rinc';
$this->params['breadcrumbs'][] = ['label' => 'Ta Setoran Potongan Rincs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-setoran-potongan-rinc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
