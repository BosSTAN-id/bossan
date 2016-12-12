<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPJRinc */

$this->title = $model->no_bukti;
$this->params['breadcrumbs'][] = ['label' => 'Ta Spjrincs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-spjrinc-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tahun',
            'no_bukti',
            'tgl_bukti',
            'refRek5.Nm_Rek_5',
            'uraian',
            'bank_id',
        ],
    ]) ?>

</div>
