<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefPotongan */

$this->title = 'Create Ref Potongan';
$this->params['breadcrumbs'][] = ['label' => 'Ref Potongans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-potongan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
