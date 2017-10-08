<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefRekAset1 */

$this->title = 'Create Ref Rek Aset1';
$this->params['breadcrumbs'][] = ['label' => 'Ref Rek Aset1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-rek-aset1-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
