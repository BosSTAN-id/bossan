<table class="table table-bordered">
  <tbody><tr>
    <th style="width: 10px">#</th>
    <th>Keterangan</th>
    <th>No_SPH</th>
    <th>No_SP2D</th>
    <th>Anggaran</th>
    <th>Realisasi</th>
    <th style="width: 40px">%</th>
  </tr>
  <?php $i = 1; foreach ($dataProvider AS $data): ?>
  <tr>
    <td><?= $i ?></td>
    <td><?= $data['Keterangan'] ?></td>
    <td><?= $data['No_SPH'] ?></td>
    <td><?= $data['No_SP2D'] ?></td>
    <td><?= number_format($data['Total'], 0, ',', '.') ?></td>
    <td><?= number_format($data['Nilai'], 0, ',', '.') ?></td>
    <?php  
    $persen = 100*$data['Nilai']/$data['Total']; 
    IF($persen < 50){
      $class = "badge bg-green";
    }ELSEIF($persen > 50 && $persen < 80){
      $class = "badge bg-yellow";
    }ELSE{
      $class = "badge bg-red";
    }
    $persen = (INT) ($persen); 
    ?>
    <td><span class=<?= $class ?> ><?php echo $persen." %" ?></span></td>
  </tr>
<?php endforeach;?>
</tbody>
</table>