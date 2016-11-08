<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaValidasiPembayaran */

$this->title = 'Create Ta Validasi Pembayaran';
$this->params['breadcrumbs'][] = ['label' => 'Ta Validasi Pembayarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-validasi-pembayaran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
