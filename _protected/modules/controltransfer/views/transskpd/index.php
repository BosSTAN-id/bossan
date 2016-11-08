<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ta Trans Skpds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-trans-skpd-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ta Trans Skpd', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Tahun',
            'Kd_Trans_1',
            'Kd_Trans_2',
            'Kd_Trans_3',
            'Kd_Urusan',
            // 'Kd_Bidang',
            // 'Kd_Unit',
            // 'Kd_Sub',
            // 'Pagu',
            // 'Referensi_Dokumen',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
