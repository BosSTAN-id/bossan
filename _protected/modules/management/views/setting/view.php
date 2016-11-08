<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaTh */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ta Ths'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-th-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php    
    try {
        $hostname = \app\models\TaTh::dokudoku('bulat', $model->set_2);
        //$port = 10060;
        $dbname = \app\models\TaTh::dokudoku('bulat', $model->set_7);
        $username = \app\models\TaTh::dokudoku('bulat', $model->set_3);
        $pw = \app\models\TaTh::dokudoku('bulat', $model->set_1);
        // $dbh = new PDO ("dblib:host=$hostname;dbname=$dbname","$username","$pw"); //for linux user
        $dbh = new PDO("sqlsrv:Server=$hostname;Database=$dbname", $username , $pw); //for windows
    } catch (PDOException $e) {
        echo "Gagal menyambung ke database Keuangan: " . $e->getMessage() . "\n";
        exit;
    }

    // $stmt = $dbh->prepare("SELECT * FROM Ref_Rek_5");
    //   $stmt->execute();
    //   while ($row = $stmt->fetch()) {
    //     echo $row['Nm_Rek_5'].'</br>';
    //   }
    //   unset($dbh); unset($stmt);    

    try {
        $hostname = \app\models\TaTh::dokudoku('bulat', $model->set_4);
        //$port = 10060;
        $dbname = \app\models\TaTh::dokudoku('bulat', $model->set_8);
        $username = \app\models\TaTh::dokudoku('bulat', $model->set_6);
        $pw = \app\models\TaTh::dokudoku('bulat', $model->set_5);
        // $dbh = new PDO ("dblib:host=$hostname;dbname=$dbname","$username","$pw"); //for linux user
        $dbh = new PDO("sqlsrv:Server=$hostname;Database=$dbname", $username , $pw); //for windows
    } catch (PDOException $e) {
        echo "Gagal menyambung ke database BMD: " . $e->getMessage() . "\n";
        exit;
    }    
?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tahun',
            'set_1',
            'set_2',
            'set_3',
            'set_4',
            'set_5',
            'set_6',
            'set_7',
            'set_8',
            'set_9',
            'set_10',
            'set_11',
            'set_12',
        ],
    ]) ?>

</div>
