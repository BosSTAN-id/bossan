<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaTransSts */

$this->title = 'Create Ta Trans Sts';
$this->params['breadcrumbs'][] = ['label' => 'Ta Trans Sts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-trans-sts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
