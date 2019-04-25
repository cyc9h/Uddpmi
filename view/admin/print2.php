<?php
include '../../controller/session_include.php';
include '../../controller/connection.php';
include '../../controller/report.php';

$monthNum  = $_GET['month'];
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); // March

$x=1;

$datab = [];
$datab = report_c($_GET['month'],$_GET['year']);

  if(count($datab)!=0){
    $header_data = count($datab[0])/2;
    for ($i=0; $i <= $header_data; $i++) {
      unset($datab[0][$i]);
    }
  }

?>
<!doctype html>
<html lang="en">
<?php include '../head.html'; ?>
<body>
<h4 style='margin:0'><center>UDD PMI Kota Padang</center></h4>
<h4 style='margin-top:0'><center>Rekap Rencana Jadwal Unit Mobil</center></h4>
  <?php if (count($datab)!=0): ?>
    <table id="b">
      <thead>
        <tr>
          <th>NO.</th>
          <?php foreach ($datab[0] as $key => $value): ?>
            <th><?php echo $key ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($datab as $key => $value): ?>
          <tr>
            <td><?php echo $x;$x++ ?></td>
            <?php foreach ($datab[0] as $key2 => $value2): ?>
              <td><?php echo $datab[$key][$key2] ?></td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    Data Tidak Ditemukan
  <?php endif; ?>

</body>
<?php include '../script.html'; ?>

<script type="text/javascript">
  $(document).ready( function () {
    var table = $('#b').DataTable(
      {paging:false,
      searching:false,
      info:false}
    );
    table
      .column('0:visible')
      .order('asc')
      .draw();

  } );
</script>

<script type="text/javascript">

  window.print();
</script>
</html>
