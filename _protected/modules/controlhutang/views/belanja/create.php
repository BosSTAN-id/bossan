<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaRASKArsip */

$this->title = 'Create Ta Raskarsip';
$this->params['breadcrumbs'][] = ['label' => 'Ta Raskarsips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-raskarsip-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
