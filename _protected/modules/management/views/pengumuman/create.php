<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaPengumuman */

$this->title = 'Tambah Pengumuman';
$this->params['breadcrumbs'][] = 'Management';
$this->params['breadcrumbs'][] = ['label' => 'Pengumuman', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-pengumuman-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
