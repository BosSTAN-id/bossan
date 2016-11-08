<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaDeposito */

$this->title = 'Create Ta Deposito';
$this->params['breadcrumbs'][] = ['label' => 'Ta Depositos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-deposito-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
