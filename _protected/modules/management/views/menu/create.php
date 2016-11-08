<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefUser */

$this->title = 'Create Ref User';
$this->params['breadcrumbs'][] = ['label' => 'Ref Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
