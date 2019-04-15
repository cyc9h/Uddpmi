<?php
include '../../controller/session_include.php';
include '../../controller/connection.php';
include '../../controller/report.php';

$title = 'Dashboard';
$data = [];

  switch ($_GET['report_type']) {
    case '1':
      $data = report_01($_GET['month'],$_GET['year']);
      $til = "Jumlah Registrasi Berdasarkan Kelompok Umur, Jenis Kelamin Dalam 1 Bulan(".$_GET['month']."/".$_GET['year'].")";
      break;
    case '2':
      $data = report_02($_GET['month'],$_GET['year']);
      $til = "Jumlah Registrasi Berdasarkan Kelompok Umur, Lokasi Dan Jenis Donor Dalam 1 Bulan(".$_GET['month']."/".$_GET['year'].")";
      break;
    case '3':
      $data = report_03($_GET['month'],$_GET['year']);
      $til = "Jumlah Registrasi Berdasarkan Kelompok Umur Dalam 1 Bulan(".$_GET['month']."/".$_GET['year'].")";
      break;
    case '4':
      $data = report_04($_GET['month'],$_GET['year']);
      $til = "Jumlah Registrasi Berdasarkan Kelompok Umur, Golongan Darah Dan Rh Dalam 1 Bulan(".$_GET['month']."/".$_GET['year'].")";
      break;
    case '5':
      $data = report_05($_GET['month'],$_GET['year']);
      $til = "Jumlah Registrasi Yang Ditolak Berdasarkan Alasan Penolakan(".$_GET['month']."/".$_GET['year'].")";
      break;
    case '6':
      $data = report_06($_GET['month'],$_GET['year']);
      $til = "Catatan Kerjasama Instansi Bulanan(".$_GET['month']."/".$_GET['year'].")";
        break;
  }
  if(count($data)!=0){
    $header_data = count($data[0])/2;
    for ($i=0; $i <= $header_data; $i++) {
      unset($data[0][$i]);
    }
  }

?>
<!doctype html>
<html lang="en">
<?php include '../head.html'; ?>
<body>

<br>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><?php if (isset($til)): ?>
                                  <?php echo $til ?>
                                <?php else: ?>
                                  Report
                                <?php endif; ?></h4>
                            </div>
                            <div class="content">
                                <div class="row">
                                  <?php if (count($data)!=0): ?>
                                    <table id="table_id">
                                      <thead>
                                        <tr>
                                          <?php foreach ($data[0] as $key => $value): ?>
                                            <th><?php echo $key ?></th>
                                          <?php endforeach; ?>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php foreach ($data as $key => $value): ?>
                                          <tr>
                                            <?php foreach ($data[0] as $key2 => $value2): ?>
                                              <td><?php echo $data[$key][$key2] ?></td>
                                            <?php endforeach; ?>
                                          </tr>
                                        <?php endforeach; ?>
                                      </tbody>
                                    </table>
                                  <?php else: ?>
                                    Data Tidak Ditemukan
                                  <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

</body>
<?php include '../script.html'; ?>

<script type="text/javascript">
  $(document).ready( function () {
    $('#table_id').DataTable();
  } );
</script>

<script type="text/javascript">
  window.print();
</script>
</html>
