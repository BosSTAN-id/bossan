<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1>
        <?= Html::encode($this->title) ?>
        <div class="pull-right">
            <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-warning']) ?>
            <?= Html::a(Yii::t('app', 'Ubah Password'), ['ubahpassword'], [
                'class' => 'btn btn-primary',
                'title' => Yii::t('yii', 'ubah password'),
                'data-toggle'=>"modal",
                'data-target'=>"#myModal",
                'data-title'=> "Ubah Password ",                 
                ]) ?>
            <?php
            //  echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], ['class' => 'btn btn-danger',
            //     'data' => [
            //         'confirm' => Yii::t('app', 'Are you sure you want to delete this user?'),
            //         'method' => 'post',
            //     ],
            // ]);
            ?>
        </div>
    </h1>

    <?=
        DetailView::widget([
            'model' => $model,
            'condensed'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'enableEditMode' => true,
            'hideIfEmpty' => false, //sembunyikan row ketika kosong
            'panel'=>[
                'heading'=>'<i class="fa fa-tag"></i> Profil Pengguna</h3>',
                'type'=>'default',
                'headingOptions' => [
                    'tag' => 'h3', //tag untuk heading
                ],
            ],
            'buttons1' => '{update}', // tombol mode default, default '{update} {delete}'
            'buttons2' => '{save} {view}', // tombol mode kedua, default '{view} {reset} {save}'
            'viewOptions' => [
                'label' => '<span class="glyphicon glyphicon-remove-circle"></span>',
            ],        
            'attributes' => [
                [
                    'attribute' => 'username',
                    'displayOnly' => true,
                ],
                [
                    'attribute' => 'sekolah_id',
                    'value' => $model['refSekolah']['nama_sekolah'],
                    'displayOnly' => true,
                ],
                'email',
            ],
        ]);
    ?>

</div>

<?php
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();

$this->registerJs("
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");
?>