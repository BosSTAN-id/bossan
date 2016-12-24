<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaSaldoAwal */

$this->title = 'Create Ta Saldo Awal';
$this->params['breadcrumbs'][] = ['label' => 'Ta Saldo Awals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-saldo-awal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
