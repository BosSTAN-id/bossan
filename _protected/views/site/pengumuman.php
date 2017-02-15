<?php
use yii\helpers\Html;
/* @var $this NotificationController */
/* @var $data Notification */
$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="view">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><b><?php echo Html::a($model->title, ['view', 'id' => $model->id], ['class' => '']); ?></b></h3>
            Oleh <?php echo $model->user->username; ?>
        </div>
        <div class="panel-body">
            <?php
                    echo $model->content
             ?>
                
        </div>
    </div>
</div>