<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefKomponenBos */

$this->title = 'Create Ref Komponen Bos';
$this->params['breadcrumbs'][] = ['label' => 'Ref Komponen Bos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-komponen-bos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
