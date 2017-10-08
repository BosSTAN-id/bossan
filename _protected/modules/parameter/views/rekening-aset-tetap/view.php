<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefRekAset1 */

$this->title = $model->Kd_Aset1;
$this->params['breadcrumbs'][] = ['label' => 'Ref Rek Aset1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-rek-aset1-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Kd_Aset1',
            'Nm_Aset1',
        ],
    ]) ?>

</div>
