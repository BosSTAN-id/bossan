<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaSPM */

$this->title = 'Create Ta Spm';
$this->params['breadcrumbs'][] = ['label' => 'Ta Spms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-spm-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
