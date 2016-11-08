<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaTrans3 */

$this->title = 'Create Ta Trans3';
$this->params['breadcrumbs'][] = ['label' => 'Ta Trans3s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-trans3-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
