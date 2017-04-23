<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefDesa */

$this->title = 'Create Ref Desa';
$this->params['breadcrumbs'][] = ['label' => 'Ref Desas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-desa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
