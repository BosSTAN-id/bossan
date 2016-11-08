<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaKontrak */

$this->title = 'Create Ta Kontrak';
$this->params['breadcrumbs'][] = ['label' => 'Ta Kontraks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-kontrak-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
