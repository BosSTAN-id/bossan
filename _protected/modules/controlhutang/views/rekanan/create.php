<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rekanan */

$this->title = 'Create Rekanan';
$this->params['breadcrumbs'][] = ['label' => 'Rekanans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rekanan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
