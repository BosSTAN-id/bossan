<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'sekolah.nama_sekolah',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'perubahan.riwayat',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'no_peraturan',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'format' => 'date',
        'attribute'=>'tgl_peraturan',
        'width' => '100px',
    ],
    [
        'label' => 'Preview',
        'format' => 'raw',
        'value' => function($model){
            ob_start();
            echo "<div class='col-md-6'>";
            $form = ActiveForm::begin(['id' => 'preview-form-'.$model->sekolah_id.".".$model->perubahan_id]);
            echo Html::hiddenInput('no_peraturan', $model->no_peraturan);
            echo Html::hiddenInput('perubahan_id', $model->perubahan_id);
            echo Html::hiddenInput('sekolah_id', $model->sekolah_id);
            echo Select2::widget([
                'name' => 'kd_laporan',
                'data' => [
                    // '1' => 'BOS-K1 Rencana Anggaran Pendapatan dan Belanja Sekolah',
                    '2' => 'BOS-K2',               
                    // '3' => 'BOS-K3 Buku Kas Umum',
                    // '4' => 'BOS-K4 Buku Pembantu Kas Tunai',
                    // '5' => 'BOS-K5 Buku Pembantu Kas Bank',
                    // '9' => 'BOS-K6 Buku Pembantu Pajak',   
                    // '6' => 'BOS-K7 Realisasi Penggunaan Dana Tiap Jenis Anggaran',
                    // '7' => 'BOS-K7A Realisasi Penggunaan Dana Tiap Komponen BOS',
                    '8' => 'BOS-03',
                    '10' => 'RKA 2.2.1',              
                ],
                'size' => 'sm',
                'options' => [
                    'placeholder' => 'Laporan ...',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            
            $dataSumber = ArrayHelper::map(\app\models\RefPenerimaanSekolah2::find()->where(['sekolah' => 1])->andWhere('abbr IS NOT NULL')->all(), 'kode', 'abbr');
            $dataSumber['0.0'] = 'Semua';
            ksort($dataSumber);
            echo Select2::widget([
                'name' => 'penerimaan2',
                'data' => $dataSumber,
                'size' => 'sm',
                'options' => [
                    'placeholder' => 'Sumber ...',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            echo "</div><div class='col-md-6'>";
            echo Html::submitButton('<i class="fa fa-print"></i> preview', [
                'class' => 'btn btn-xs btn-default form-preview'
            ]);
            ActiveForm::end();
            echo "</div>";
            $return = ob_get_contents();
            ob_end_clean();
            return $return;
        }
    ],
    // [
    //     'class' => 'kartik\grid\ActionColumn',
    //     'template' => '<li>{k2all}</li> <li>{k2bos}</li> <li>{bos}</li>',
    //     'controller' => 'baperrinc',
    //     'noWrap' => true,
    //     'vAlign'=>'middle',
    //     'dropdown' => true,
    //     'dropdownOptions' => ['class' => 'dropdown pull-right'],
    //     'dropdownMenu' => ['class'=>'text-left'],
    //     'dropdownButton' => [
    //         'class'=> 'btn btn-xs btn-info',
    //         'label' => 'Preview'
    //     ],
    //     'buttons' => [
    //             'k2all' => function ($url, $model) {
    //                 return Html::a('<span class="glyphicon glyphicon-print"></span> FORM-K2', $url,
    //                 [  
    //                    'title' => Yii::t('yii', 'FORM BOS K-2 Semua Dana'),
    //                    'onClick' => "return !window.open(this.href, 'RKA 1', 'width=1024,height=768')"
    //                 ]);
    //             },
    //             'k2bos' => function ($url, $model) {
    //                 return Html::a('<span class="glyphicon glyphicon-print"></span> FORM-K2 BOS', $url,
    //                 [  
    //                    'title' => Yii::t('yii', 'FORM BOS K-2 Sumber Dana BOS'),
    //                    'onClick' => "return !window.open(this.href, 'RKA 1', 'width=1024,height=768')"
    //                 ]);
    //             },
    //             'bos' => function ($url, $model) {
    //                 return Html::a('<span class="glyphicon glyphicon-print"></span> BOS-03', $url,
    //                 [  
    //                    'title' => Yii::t('yii', 'FORM BOS-03 Sumber Dana BOS'),
    //                    'onClick' => "return !window.open(this.href, 'RKA 1', 'width=1024,height=768')"
    //                 ]);
    //             },
    //     ]
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'format' => 'raw',
        'label'=>'Terlampir',
        'value' => function ($model) use($no_ba){
            if($model['terlampir']['no_peraturan'] != NULL){
                // return '<i class="glyphicon glyphicon-ok"></i>';
                return Html::a('<span class="glyphicon glyphicon-ok"></span>', ['deleterinc', 'tahun' => $model->tahun, 'no_ba' => $no_ba, 'sekolah_id' => $model->sekolah_id, 'no_peraturan' => $model->no_peraturan],
                [  
                    'title' => Yii::t('yii', 'Hapus dari Rincian'),           
                    'data-confirm' => "Yakin menghapus dari berita acara ini?",
                    'data-method' => 'POST',
                    'data-pjax' => 1
                ]);
            }
            if($model['terlampir']['no_peraturan'] == NULL) return '';
        }
    ],
];   