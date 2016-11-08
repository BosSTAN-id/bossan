<?php

namespace app\modules\controltransfer\controllers;

use yii\web\Controller;

/**
 * Default controller for the `controltransfer` module
 */
class RealisasikontrakController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
		$connection = \Yii::$app->db;           
		$query = $connection->createCommand("
			SELECT a.Tahun, a.Kd_Trans_1, a.Kd_Trans_2, a.Kd_Trans_3, h.Nm_Sub_Bidang, a.No_Kontrak, 
			a.Kd_Urusan, a.Kd_Bidang, a.Kd_Unit, a.Kd_Sub, g.Nm_Sub_Unit,
			c.No_SPP,d.No_SPM, f.No_SP2D,
			a.Pagu, SUM(e.Nilai) AS Nilai_SP2D
			FROM Ta_Trans_Kontrak a
			INNER JOIN Ta_Kontrak b ON a.No_Kontrak = b.No_Kontrak
			LEFT JOIN Ta_SPP_Kontrak c ON a.No_Kontrak = c.No_Kontrak 
			LEFT JOIN Ta_SPM d ON c.No_SPP = d.No_SPP
			LEFT JOIN Ta_SPM_Rinc e ON d.No_SPM = e.No_SPM
			LEFT JOIN Ta_SP2D f ON d.No_SPM = f.No_SPM
			LEFT JOIN Ref_Sub_Unit g ON g.Kd_Urusan = a.Kd_Urusan AND a.Kd_Bidang = g.Kd_Bidang AND a.Kd_Unit = g.Kd_Unit AND a.Kd_Sub = g.Kd_Sub
			LEFT JOIN Ta_Trans_3 h ON a.Kd_Trans_1 = h.Kd_Trans_1 AND a.Kd_Trans_2 = h.Kd_Trans_2 AND a.Kd_Trans_3 = h.Kd_Trans_3
			GROUP BY a.Tahun, a.Kd_Trans_1, a.Kd_Trans_2, a.Kd_Trans_3, h.Nm_Sub_Bidang, a.No_Kontrak, a.Kd_Urusan, a.Kd_Bidang, a.Kd_Unit, a.Kd_Sub, g.Nm_Sub_Unit, c.No_SPP,d.No_SPM, f.No_SP2D, a.Pagu
		");
		/*$query->bindValue(':Kd_Urusan', $model->Kd_Urusan)
		    ->bindValue(':Kd_Bidang' , $model->Kd_Bidang)
		    ->bindValue(':Kd_Unit' , $model->Kd_Unit)
		    ->bindValue(':Kd_Sub' , $model->Kd_Sub)
		    ->bindValue(':Kd_Prog' , $model->Kd_Prog)
		    ->bindValue(':ID_Prog' , $model->ID_Prog)
		    ->bindValue(':Kd_Keg' , $model->Kd_Keg)
		    ->bindValue(':Kd_Rek_1' , $model->Kd_Rek_1)
		    ->bindValue(':Kd_Rek_2' , $model->Kd_Rek_2)
		    ->bindValue(':Kd_Rek_3' , $model->Kd_Rek_3)
		    ->bindValue(':Kd_Rek_4' , $model->Kd_Rek_4)
		    ->bindValue(':Kd_Rek_5' , $model->Kd_Rek_5);*/
		$dataProvider = $query->queryAll(); 

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
}
