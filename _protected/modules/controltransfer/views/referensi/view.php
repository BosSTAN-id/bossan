<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaTrans3 */

$this->title = $model->Kd_Trans_1;
$this->params['breadcrumbs'][] = ['label' => 'Ta Trans3s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-trans3-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3, 'Tahun' => $model->Tahun], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3, 'Tahun' => $model->Tahun], [
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
            'Tahun',
            'Kd_Trans_1',
            'Kd_Trans_2',
            'Kd_Trans_3',
            'Nm_Sub_Bidang',
            'Kd_sub_DAK',
            'Pagu',
        ],
    ]) ?>

</div>
