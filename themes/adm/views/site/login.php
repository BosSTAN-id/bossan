<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" type="text/css" href="images/font-awesome.min.css">
<link href="images/login.css" rel="stylesheet" type="text/css">
</style></head>
<body>
<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = \Yii::$app->name;

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

    <div class="login-container">
        <div class="login-bg"></div>
        <div class="login-form">
            <h1><?= \Yii::$app->name ?></h1>
                           <div id="notification" class="information">
                <p>
                   Silahkan masukkan username dan password anda!..
                </p>
              </div>
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
                <div class="control">
                    <?= $form
                        ->field($model, 'username', $fieldOptions1)
                        ->label(false)
                        ->textInput(['class' => 'inputbox','placeholder' => $model->getAttributeLabel('username')]) ?>
                </div>
                <div class="control">
                    <?= $form
                        ->field($model, 'password', $fieldOptions2)
                        ->label(false)
                        ->passwordInput(['class' => 'inputbox', 'placeholder' => $model->getAttributeLabel('password')]) ?>
                </div>
                <div class="control">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                </div>
                <div class="buttonset">
                    <?= Html::submitButton('Sign in', ['class' => 'button', 'style' => 'background:#e14d24', 'name' => 'login-button']) ?>                
                </div>               
        <?php ActiveForm::end(); ?>
        </div>
    </div>
    <style type="text/css">
        .preloader{visibility: hidden;}
        .preloader.on{visibility: visible;}
    </style>
    <script type="text/javascript" src="images/jquery-1.7.2.min.js"></script>
    <script type="text/javascript">

        function preloader(){
            localStorage.setItem("preloader", 'true');
        }
        $(function(){
                        $(window).load(function(){
                if(localStorage.getItem("preloader") == 'true'){
                   $('.preloader').addClass('on').show().delay(3000).fadeIn(function(){$(this).addClass('pull')});
                   setTimeout(function(){$('.preloader').addClass('pull')},10000);
                   localStorage.setItem("preloader", "false");
                } else {
                    $('.preloader').hide();
                }
                
            });
                        $('[data-toggle="modal"]').click(function(){
                var el = $(this).data('target');

                if($('.overlay').hasClass('active')){
                    //document.getElementById("video").pause();
                    $('.overlay').removeClass('active').hide();
                } else {
                    $(el).show().addClass('active in');
                }
                //setTimeout(function() { $(".inputbox[name=username]").focus(); }, 100);  
            });

            $('.overlay').click(function(){
                $(this).removeClass('active');
                var url = $('#youtube-iframe').attr('src');
                //Then assign the src to null, this then stops the video been playing
                $('#youtube-iframe').attr('src', '');
                // Finally you reasign the URL back to your iframe, so when you hide and load it again you still have the link
                $('#youtube-iframe').attr('src', url);
            });
            $('.overlay .box').click(function(e){
                e.stopPropagation();     
            });
            $('.overlay .close').click(function(){
                $(this).parents('.overlay').removeClass('active');
                //document.getElementById("video").pause();
                var url = $('#youtube-iframe').attr('src');
                //Then assign the src to null, this then stops the video been playing
                $('#youtube-iframe').attr('src', '');
                // Finally you reasign the URL back to your iframe, so when you hide and load it again you still have the link
                $('#youtube-iframe').attr('src', url);
            });
            $('select[name=kabupaten]').change(function(){
                var value = $(this).val();
                $('select.kecamatan').hide();
                $('.'+value+'').show();
            }).change();

            $('select[name=jenis_informasi]').change(function(){
                var value = $(this).val();
                if(value == 'detail'){
                    $('.form-group.detail').show();
                } else {
                    $('.form-group.detail').hide();
                }
            }).change();
            
            $('#videobox').on('hidden', function () {
                alert('tes');
            });
        });
    </script>


</body>