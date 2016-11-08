<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaRASKArsipHutang */

$this->title = 'Create Ta Raskarsip Hutang';
$this->params['breadcrumbs'][] = ['label' => 'Ta Raskarsip Hutangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-raskarsip-hutang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
