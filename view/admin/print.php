<?php
include '../../controller/session_include.php';
include '../../controller/connection.php';
include '../../controller/report.php';

$monthNum  = $_GET['month'];
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); // March

$x=1;

$data = [];
$data = report_a($_GET['month'],$_GET['year']);

$datab = [];
$datab = report_b($_GET['month'],$_GET['year']);
  if(count($data)!=0){
    $header_data = count($data[0])/2;
    for ($i=0; $i <= $header_data; $i++) {
      unset($data[0][$i]);
    }
  }

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
<h3 style='margin-bottom:0'><center>Laporan Donasi Darah Lengkap (Whole Blood/WB)</center></h3>
<h4 style='margin:0'><center>UDD PMI Kota Padang</center></h4>
<h4 style='margin-top:0'><center>Bulan : <?php echo $monthName.' '.$_GET['year'] ?></center></h4>

<p>A. Donasi(Jumlah Kantong Darah Yang Didapatkan Dari Pendonor Darah)</p>
  <table id="table_id">
    <thead>
      <tr>
        <th rowspan="3">NO</th>
        <th rowspan="3">Kelompok Umur</th>
        <th rowspan="3">Jumlah Donasi (Kantong)</th>
        <th colspan="4">Jumlah Donasi Dalam Gedung(Jumlah Kantong)</th>
        <th colspan="2" rowspan="2">Jumlah Donasi Sukarela Dari Kegiatan Mobile Unit(Jumlah Kantong)</th>
        <th colspan="2">Jumlah Donasi</th>
        <th colspan="8">Jumlah Darah Menurut Gol Darah dan Rhesus</th>
      </tr>
      <tr>
        <th colspan="2">Donor Sukarela</th>
        <th rowspan="2">Donor Pengganti</th>
        <th rowspan="2">Donor Bayaran</th>
        <th rowspan="2">Pria</th>
        <th rowspan="2">Wanita</th>
        <th colspan="2">O</th>
        <th colspan="2">A</th>
        <th colspan="2">B</th>
        <th colspan="2">AB</th>
      </tr>
      <tr>
        <th>Baru</th>
        <th>Ulang</th>
        <th>Baru</th>
        <th>Ulang</th>
        <th>Pos</th>
        <th>Neg</th>
        <th>Pos</th>
        <th>Neg</th>
        <th>Pos</th>
        <th>Neg</th>
        <th>Pos</th>
        <th>Neg</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($data as $key => $value): ?>
        <tr>
          <td>
          <?php if (count($data)!=$key+1): ?>
            <?php echo $x;$x++; ?>
            <?php else: ?>
              <?php echo ' '; ?>
          <?php endif; ?></td>
          <?php foreach ($data[0] as $key2 => $value2): ?>
            <td><?php echo $data[$key][$key2] ?></td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<br>
  <?php if (count($data)!=0): ?>
    <p>B. Jumlah Donasi Yang Ditolak Berdasarkan Alasan Penolakan</p>
    <table id="b">
      <thead>
        <tr>
          <th>NO.</th>
          <?php $x=1; ?>
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

  <br>
  <div class="col-md-8">

  </div>
  <div class="col-md-4"><center>
    <p style="margin:0">Padang,<?php echo date('d F Y'); ?></p>
    <p style="margin:0">UDD PMI Kota Padang</p>
    <p style="margin:0">Direktur</p>
    <br><br>
    <p style="margin:0"><?php echo $_SESSION['data']['nama'] ?></p>
  </div></center>

</body>
<?php include '../script.html'; ?>

<script type="text/javascript">
  $(document).ready( function () {
    var table = $('#table_id').DataTable(
      {paging:false,
      searching:false,
      info:false}
    );
    table
      .column('1:visible')
      .order('asc')
      .draw();

  } );

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
var css = '@page { size: landscape; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

style.type = 'text/css';
style.media = 'print';

if (style.styleSheet){
  style.styleSheet.cssText = css;
} else {
  style.appendChild(document.createTextNode(css));
}

head.appendChild(style);

  window.print();
</script>
</html>
