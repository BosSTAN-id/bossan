<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaSPJRinc */

$this->title = 'Create Ta Spjrinc';
$this->params['breadcrumbs'][] = ['label' => 'Ta Spjrincs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-spjrinc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
