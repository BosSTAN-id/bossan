<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaRPH */

$this->title = 'Rekomendasi Pelunasan Hutang';
$this->params['breadcrumbs'][] = 'Control Hutang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-rph-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
