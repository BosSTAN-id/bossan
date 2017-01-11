<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaSP3B */

$this->title = 'Create Ta Sp3 B';
$this->params['breadcrumbs'][] = ['label' => 'Ta Sp3 Bs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-sp3-b-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
