<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefPenerimaanSekolah2 */

$this->title = 'Create Ref Penerimaan Sekolah2';
$this->params['breadcrumbs'][] = ['label' => 'Ref Penerimaan Sekolah2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-penerimaan-sekolah2-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
