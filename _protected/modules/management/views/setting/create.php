<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaTh */

$this->title = Yii::t('app', 'Create Ta Th');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ta Ths'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-th-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
