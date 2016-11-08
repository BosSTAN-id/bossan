<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaRkasKegiatan */

$this->title = 'Create Ta Rkas Kegiatan';
$this->params['breadcrumbs'][] = ['label' => 'Ta Rkas Kegiatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-rkas-kegiatan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
