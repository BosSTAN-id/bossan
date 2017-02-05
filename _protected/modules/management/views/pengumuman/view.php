<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaPengumuman */

$this->title = $model->title;
$this->params['breadcrumbs'][] = 'Management';
$this->params['breadcrumbs'][] = ['label' => 'Pengumuman', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-pengumuman-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'diumumkan_di',
            'sticky',
            'published',
            'user.username',
            'created_at:date',
            'updated_at:date',
            'content:raw',
        ],
    ]) ?>

</div>
