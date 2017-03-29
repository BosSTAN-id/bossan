<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\globalsetting\models\RefRek5Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seleksi Rekening';
$this->params['breadcrumbs'][] = 'Pengaturan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-rek5-index">
<div class="row">
    <div class="col-sm-4 col-xs-6 col-md-2">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <?= Html::img('@web/images/logo.jpg', ['alt'=>'Image', 'class'=>'profile-user-img img-responsive img-circle']);?> 

                <h3 class="profile-username text-center">Seleksi Akun</h3>

                <p class="text-muted text-center">Bagan Akun Standar</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Untuk menyeleksi akun bagan akun standar yang dapat digunakan sekolah.</b> 
                        <!--<a class="pull-right">1,322</a>-->
                    </li>
                    <li class="list-group-item">
                        <?= Html::a('Buka <i class="glyphicon glyphicon-log-in"></i>' , ['bas'], ['class' => 'btn btn-primary btn-block']) ?>
                    </li>
                </ul>
            </div>
        <!-- /.box-body -->
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-md-2">
        <div class="box box-danger">
            <div class="box-body box-profile">
                <?= Html::img('@web/images/logo.jpg', ['alt'=>'Image', 'class'=>'profile-user-img img-responsive img-circle']);?> 

                <h3 class="profile-username text-center">Sumber Dana</h3>

                <p class="text-muted text-center">Kode Penerimaan Sekolah</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Menyeleksi penerimaan untuk sekolah.</b> 
                        <!--<a class="pull-right">1,322</a>-->
                    </li>
                    <li class="list-group-item">
                        <?= Html::a('Buka <i class="glyphicon glyphicon-log-in"></i>' , ['penerimaansekolah'], ['class' => 'btn btn-danger btn-block']) ?>
                    </li>
                </ul>
            </div>
        <!-- /.box-body -->
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 col-md-2">
        <div class="box box-info">
            <div class="box-body box-profile">
                <?= Html::img('@web/images/logo.jpg', ['alt'=>'Image', 'class'=>'profile-user-img img-responsive img-circle']);?> 

                <h3 class="profile-username text-center">Pengesahan</h3>

                <p class="text-muted text-center">SP3B-SP2B</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Daftar sumber dana yang akan ditambahkan dalam SP3B dan SP2B</b> 
                        <!--<a class="pull-right">1,322</a>-->
                    </li>
                    <li class="list-group-item">
                        <?= Html::a('Buka <i class="glyphicon glyphicon-log-in"></i>' , ['pengesahan'], ['class' => 'btn btn-info btn-block']) ?>
                    </li>
                </ul>
            </div>
        <!-- /.box-body -->
        </div>
    </div>    
</div>
</div>
<?php Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();

Modal::begin([
    'id' => 'myModalubah',
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
$this->registerJs("
    $('#myModalubah').on('show.bs.modal', function (event) {
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