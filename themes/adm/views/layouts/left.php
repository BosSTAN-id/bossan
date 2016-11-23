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
                    ['label' => 'Pengaturan', 'icon' => 'fa fa-circle-o','url' => '#', 'visible' => 1,'items'  =>
                        [
                            ['label' => 'Pengaturan Global', 'icon' => 'fa fa-circle-o', 'url' => ['/globalsetting/setting'], 'visible' => akses(202)
                            ],
                            ['label' => 'User Management', 'icon' => 'fa fa-circle-o', 'url' => ['/user/index'], 'visible' => akses(404)
                            ],
                            ['label' => 'Akses Grup', 'icon' => 'fa fa-circle-o', 'url' => ['/management/menu'], 'visible' => akses(401)
                            ],
                            ['label' => 'Mapping Komponen', 'icon' => 'fa fa-circle-o', 'url' => ['/globalsetting/mappingkomponen'], 'visible' => akses(104)
                            ],
                            ['label' => 'Mapping Pendapatan', 'icon' => 'fa fa-circle-o', 'url' => ['/globalsetting/mappingpendapatan'], 'visible' => akses(105)
                            ],                                                        
                        ],
                    ],                    
                    ['label' => 'Parameter', 'icon' => 'fa fa-circle-o','url' => '#', 'visible' => 1,'items'  =>
                        [
                            ['label' => 'Sekolah', 'icon' => 'fa fa-circle-o', 'url' => ['/parameter/sekolah'], 'visible' => akses(201)
                            ],
                            ['label' => 'Data Sekolah', 'icon' => 'fa fa-circle-o', 'url' => ['/parameter/datasekolah'], 'visible' => akses(202)
                            ],
                        ],
                    ],                    
                    ['label' => 'Batch Process', 'icon' => 'fa fa-circle-o', 'url' => ['/management/batchprocess'], 'visible' => akses(301)
                    ],
                    ['label' => 'Anggaran', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => !Yii::$app->user->isGuest, 'items' => 
                        [
                            ['label' => 'RKAS', 'icon' => 'fa fa-circle-o', 'url' => ['/anggaran/rkas'], 'visible' => akses(402)
                            ],
                            ['label' => 'Anggaran Kas', 'icon' => 'fa fa-circle-o', 'url' => ['/anggaran/rencana'], 'visible' => akses(404)
                            ],
                            ['label' => 'Posting Anggaran', 'icon' => 'fa fa-circle-o', 'url' => ['/anggaran/posting'], 'visible' => akses(403)
                            ],
                            // ['label' => 'Dana Transfer', 'icon' => 'fa fa-edit','url' => '#','items' => 
                            //     [
                            //         ['label' => 'Klasifikasi Transfer', 'icon' => 'fa fa-table', 'url' => ['/controltransfer/klasifikasi'], 'visible' => akses(209)],
                            //         ['label' => 'Pagu Dana Transfer', 'icon' => 'fa fa-table', 'url' => ['/controltransfer/referensi'], 'visible' => akses(204)],
                            //         ['label' => 'Penyesuaian Dana Transfer', 'icon' => 'fa fa-table', 'url' => ['/controltransfer/penyesuaian'], 'visible' => akses(208)],
                            //         // ['label' => 'Pembagian Pagu', 'icon' => 'fa fa-table', 'url' => ['/controltransfer/referensi'], 'visible' => $skpkd],
                            //         ['label' => 'Control Anggaran', 'icon' => 'fa fa-table', 'url' => ['/controltransfer/belanja'], 'visible' => akses(201)],
                            //         ['label' => 'Dana Talangan', 'icon' => 'fa fa-table', 'url' => '#', 'visible' => $skpkd],
                            //         ['label' => 'Pelaporan', 'icon' => 'fa fa-circle-o', 'url' =>  ['/controltransfer/laporananggaran'], 'visible' => akses(203)],
                            //     ],
                            // ],
                        ],
                    ],
                    ['label' => 'Penatausahaan', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => !Yii::$app->user->isGuest, 'items' => 
                        [
                            ['label' => 'Penerimaan', 'icon' => 'fa fa-circle-o', 'url' => ['/penatausahaan/penerimaan'], 'visible' => akses(501)
                            ],
                            ['label' => 'SPJ', 'icon' => 'fa fa-circle-o', 'url' => ['/penatausahaan/spj'], 'visible' => akses(502)
                            ],

                            ['label' => 'Verifikasi SPJ', 'icon' => 'fa fa-circle-o', 'url' => ['/penatausahaan/verspj'], 'visible' => akses(503)
                            ],
                            ['label' => 'Pengadaan Aset Tetap', 'icon' => 'fa fa-circle-o', 'url' => ['/penatausahaan/pengadaanaset'], 'visible' => akses(504)
                            ],
                            ['label' => 'Daftar Aset Tetap', 'icon' => 'fa fa-circle-o', 'url' => ['/penatausahaan/asettetap'], 'visible' => akses(505)
                            ],
                        ],
                    ],                   
                    ['label' => 'Pelaporan', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => !Yii::$app->user->isGuest, 'items' => 
                        [
                            ['label' => 'Pelaporan', 'icon' => 'fa fa-circle-o', 'url' => ['/pelaporan/pelaporansekolah'], 'visible' => akses(601)
                            ],
                            ['label' => 'Pelaporan', 'icon' => 'fa fa-circle-o', 'url' => ['/pelaporan/pelaporanpemda'], 'visible' => akses(602)
                            ],
                            ['label' => 'Verifikasi SPJ', 'icon' => 'fa fa-circle-o', 'url' => ['/pelaporan/verpemda'], 'visible' => akses(603)
                            ],                           
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
