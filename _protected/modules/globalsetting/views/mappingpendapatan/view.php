<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefPenerimaanSekolah2 */

$this->title = $model->kd_penerimaan_1;
$this->params['breadcrumbs'][] = ['label' => 'Ref Penerimaan Sekolah2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-penerimaan-sekolah2-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'kd_penerimaan_1' => $model->kd_penerimaan_1, 'kd_penerimaan_2' => $model->kd_penerimaan_2], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'kd_penerimaan_1' => $model->kd_penerimaan_1, 'kd_penerimaan_2' => $model->kd_penerimaan_2], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kd_penerimaan_1',
            'kd_penerimaan_2',
            'uraian',
            'abbr',
        ],
    ]) ?>

</div>
