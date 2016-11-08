<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\management\models\RefUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?php echo $form->field($model, 'name')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Nama Grup')])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
