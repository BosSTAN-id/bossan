<aside class="main-sidebar">

    <section class="sidebar">

<?php /*
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
*/ ?>

<?php
IF(isset(Yii::$app->user->identity->kd_user)){
    switch (Yii::$app->user->identity->kd_user) {
        case '1':
            $administrator = 1;
            $operator = 0;
            $supervisor = 1;
            $skpkd = 1;
            break;
        case '2':
            $administrator = 0;
            $operator = 1;
            $supervisor = 0;
            $skpkd = 0;
            break;
        case '3':
            $administrator = 0;
            $operator = 0;
            $supervisor = 1;
            $skpkd = 0;
            break;
        case '4':
            $administrator = 0;
            $operator = 1;
            $supervisor = 0;
            $skpkd = 1;
            break;
        
        default:
            $administrator = 0;
            $operator = 0;
            $supervisor = 0;
            $skpkd = 0;
            break;
    }
}ELSE{
    $administrator = 0;
    $operator = 0;
    $supervisor = 0;
    $skpkd = 0;    
}
function akses($menu){
    $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => $menu])->one();
    IF($akses){
        return true;
    }else{
        return false;
    }
}
?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Dashboard', 'icon' => 'fa fa-dashboard', 'url' => ['/'],],
                    ['label' => 'Pengaturan', 'icon' => 'circle-o','url' => '#', 'visible' => 1,'items'  =>
                        [
                            ['label' => 'Pengaturan Global', 'icon' => 'circle-o', 'url' => ['/management/setting'], 'visible' => akses(405)],
                            ['label' => 'User Management', 'icon' => 'circle-o', 'url' => ['/user/index'], 'visible' => akses(102)],
                            ['label' => 'Akses Grup', 'icon' => 'circle-o', 'url' => ['/management/menu'], 'visible' => akses(401)],
                            // ['label' => 'Mapping Komponen', 'icon' => 'circle-o', 'url' => ['/globalsetting/mappingkomponen'], 'visible' => akses(104)],
                            ['label' => 'Mapping Pendapatan', 'icon' => 'circle-o', 'url' => ['/globalsetting/mappingpendapatan'], 'visible' => akses(105)],  
                            ['label' => 'Blog/Pengumuman', 'icon' => 'circle-o', 'url' => ['/management/pengumuman'], 'visible' => akses(106)],  
                            ['label' => 'Seleksi Rekening', 'icon' => 'circle-o', 'url' => ['/globalsetting/selection'], 'visible' => akses(107)], 
                            ['label' => 'Program dan Kegiatan', 'icon' => 'circle-o', 'url' => ['/globalsetting/progker'], 'visible' => akses(108)],                                                        
                        ],
                    ],                    
                    ['label' => 'Parameter', 'icon' => 'circle-o','url' => '#', 'visible' => 1,'items'  =>
                        [
                            ['label' => 'Sekolah', 'icon' => 'circle-o', 'url' => ['/parameter/sekolah'], 'visible' => akses(201)],
                            ['label' => 'Data Sekolah', 'icon' => 'circle-o', 'url' => ['/parameter/datasekolah'], 'visible' => akses(202)],
                            ['label' => 'Wilayah (Kec-Kel)', 'icon' => 'circle-o', 'url' => ['/parameter/wilayah'], 'visible' => akses(204)],
                        ],
                    ],                    
                    ['label' => 'Batch Process', 'icon' => 'circle-o', 'url' => ['/management/batchprocess'], 'visible' => akses(301)],
                    ['label' => 'Anggaran', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => !Yii::$app->user->isGuest, 'items' => 
                        [
                            ['label' => 'RKAS', 'icon' => 'circle-o', 'url' => ['/anggaran/rkas'], 'visible' => akses(402)],
                            ['label' => 'Anggaran Kas', 'icon' => 'circle-o', 'url' => ['/anggaran/rencana'], 'visible' => akses(404)],
                            ['label' => 'Posting Anggaran', 'icon' => 'circle-o', 'url' => ['/anggaran/posting'], 'visible' => akses(403)],
                            ['label' => 'Verifikasi Anggaran', 'icon' => 'circle-o', 'url' => ['/anggaran/baper'], 'visible' => akses(406)],
                        ],
                    ],
                    ['label' => 'Penatausahaan', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => !Yii::$app->user->isGuest, 'items' => 
                        [
                            ['label' => 'Saldo Awal', 'icon' => 'circle-o', 'url' => ['/penatausahaan/saldoawal'], 'visible' => akses(507)],
                            ['label' => 'Penerimaan', 'icon' => 'circle-o', 'url' => ['/penatausahaan/penerimaan'], 'visible' => akses(501)],
                            ['label' => 'Mutasi Kas', 'icon' => 'circle-o', 'url' => ['/penatausahaan/mutasikas'], 'visible' => akses(508)],
                            // ['label' => 'Belanja', 'icon' => 'circle-o', 'url' => ['/penatausahaan/belanja'], 'visible' => akses(506)],
                            ['label' => 'Belanja', 'icon' => 'circle-o', 'url' => ['/penatausahaan/bukti'], 'visible' => akses(506)],
                            ['label' => 'SPJ', 'icon' => 'circle-o', 'url' => ['/penatausahaan/spj'], 'visible' => akses(502)],
                            ['label' => 'Setoran Potongan', 'icon' => 'circle-o', 'url' => ['/penatausahaan/potongan'], 'visible' => akses(509)],
                            ['label' => 'Verifikasi SPJ', 'icon' => 'circle-o', 'url' => ['/penatausahaan/verspj'], 'visible' => akses(503)],
                        ],
                    ],                   
                    ['label' => 'Pelaporan', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => !Yii::$app->user->isGuest, 'items' => 
                        [
                            ['label' => 'Pelaporan', 'icon' => 'circle-o', 'url' => ['/pelaporan/pelaporansekolah'], 'visible' => akses(601)],
                            ['label' => 'Pelaporan', 'icon' => 'circle-o', 'url' => ['/pelaporan/pelaporanrekap'], 'visible' => akses(602)],
                            ['label' => 'SP3B', 'icon' => 'circle-o', 'url' => ['/pelaporan/sp3b'], 'visible' => akses(604)],
                            ['label' => 'SP2B', 'icon' => 'circle-o', 'url' => ['/pelaporan/sp2b'], 'visible' => akses(605)],
                            ['label' => 'Verifikasi SPJ', 'icon' => 'circle-o', 'url' => ['/pelaporan/verpemda'], 'visible' => akses(603)],                           
                        ],
                    ],
                    ['label' => 'Panduan Penggunaan', 'icon' => 'fa fa-edit', 'url' => ['/images/bosstan v1.1.0 documentation book.pdf'], 'visible' => !Yii::$app->user->isGuest, 'options' => ['onclick' => "return !window.open('".yii\helpers\Url::to('/images/bosstan v1.1.0 documentation book.pdf', true)."', 'SPJ', 'width=1024,height=768')"]] 
                ],
            ]
        ) ?>

    </section>

</aside>
