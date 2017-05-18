<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaBaver */

$this->title = 'Create Ta Baver';
$this->params['breadcrumbs'][] = ['label' => 'Ta Bavers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-baver-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
