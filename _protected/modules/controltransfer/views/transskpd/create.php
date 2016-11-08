<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaTransSKPD */

$this->title = 'Create Ta Trans Skpd';
$this->params['breadcrumbs'][] = ['label' => 'Ta Trans Skpds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-trans-skpd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
