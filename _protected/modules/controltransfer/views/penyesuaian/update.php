<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaTrans3 */

$this->title = 'Update Ta Trans3: ' . $model->Kd_Trans_1;
$this->params['breadcrumbs'][] = ['label' => 'Ta Trans3s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Kd_Trans_1, 'url' => ['view', 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3, 'Tahun' => $model->Tahun]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-trans3-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
