<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaKasHarian */

$this->title = 'Create Ta Kas Harian';
$this->params['breadcrumbs'][] = ['label' => 'Ta Kas Harians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-kas-harian-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
