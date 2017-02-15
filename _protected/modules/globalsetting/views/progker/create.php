<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefKegiatanSekolah */

$this->title = 'Create Ref Kegiatan Sekolah';
$this->params['breadcrumbs'][] = ['label' => 'Ref Kegiatan Sekolahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-kegiatan-sekolah-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
