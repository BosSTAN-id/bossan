<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaSPJ */

$this->title = 'Create Ta Spj';
$this->params['breadcrumbs'][] = ['label' => 'Ta Spjs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-spj-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
