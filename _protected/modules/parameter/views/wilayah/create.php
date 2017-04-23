<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefKecamatan */

$this->title = 'Create Ref Kecamatan';
$this->params['breadcrumbs'][] = ['label' => 'Ref Kecamatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-kecamatan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
