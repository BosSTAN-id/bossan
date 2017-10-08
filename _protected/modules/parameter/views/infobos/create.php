<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaInfoBos */

$this->title = 'Create Ta Info Bos';
$this->params['breadcrumbs'][] = ['label' => 'Ta Info Bos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-info-bos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
