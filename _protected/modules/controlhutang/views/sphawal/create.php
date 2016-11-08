<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaSPH */

$this->title = 'Pembuatan Surat Pengakuan Hutang';
$this->params['breadcrumbs'][] = 'Control Hutang';
$this->params['breadcrumbs'][] = ['label' => 'Surat Pengakuan Hutang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-sph-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
