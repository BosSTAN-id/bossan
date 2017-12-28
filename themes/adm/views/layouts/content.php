<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.2.2
    </div>
    <?php 
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }    
        $msg = \app\models\TaTh::dokudoku('bulat', 'TEN3WHFBS3paSFRZL05TRGlpWXpSTVU5bEZJY0tIWFBXZnlDQlN5NFc0cWdYNm9HSWJYRkdoekxvMHdjb1RJenU4YTFDZjdyazlPemtaQ3llMmtGN2ZNcTRHZi9pZVdBUTQ5VFBaV2dHLzlHbGU3ZUtxbHBVdGZzelBCQ0EyNERhVTNrR0JhbjVreXZvQ09aVlJNTldnPT0=');
        $kakaroto = \app\models\TaTh::dokudoku('bulat', \app\models\TaTh::findOne(['tahun' => $Tahun])['set_9']);
        IF(Yii::$app->params['kakaroto'] != $kakaroto){ 
            echo $msg;
        }ELSE{
            echo '<strong>Copyright &copy; 2016 <a href="http://belajararief.com">hoaaah</a></strong>';
        }  
    ?>

</footer>