<?php
use yii\helpers\Html;
$connection = \Yii::$app->db;           
$tahun = $connection->createCommand('SELECT Tahun FROM ta_th GROUP BY Tahun')->queryAll();
/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <!--<img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/> -->
            <span class"pull-left"><B>  <?= Yii::$app->user->identity->sekolah_id == NULL ? 'PEMERINTAH KABUPATEN BANYUASIN' : strtoupper(Yii::$app->user->identity->refSekolah->nama_sekolah) ?></B></span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <?php 
                IF(!Yii::$app->user->isGuest):
                ?>
                <li class="dropdown tahun user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">Tahun Anggaran: <?= Yii::$app->session->get('tahun') ? Yii::$app->session->get('tahun') : 'Pilih!' ?> </span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach($tahun as $tahun): ?>
                        <li><?= Html::a($tahun['Tahun'], ['/site/tahun', 'id' => $tahun['Tahun']]) ?></li>
                        <?php endforeach;?>
                    </ul>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?= Html::img('@web/images/logo.jpg', ['alt'=>'User Image', 'class'=>'user-image']);?> 
                        <?php /*<img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/> */ ?>
                        <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?= Html::img('@web/images/logo.jpg', ['alt'=>'User Image', 'class'=>'img-circle']);?>
                            <?php /*<img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                 alt="User Image"/> */ ?>
                            <p>
                               <?= Yii::$app->user->identity->username ?>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                               <?= Html::a(
                                    'Profile',
                                    ['/user'],
                                    ['class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
                <?php
                ELSE:
                ?>
                 <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">Login User/Registrasi</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><?= Html::a('Login', ['/site/login']) ?></li>
                        <li><?= Html::a('Registrasi', ['/site/signup']) ?></li>
                    </ul>
                </li>
                <?php ENDIF; ?>

            </ul>
        </div>
    </nav>
</header>
