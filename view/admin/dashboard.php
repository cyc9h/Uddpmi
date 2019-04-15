<?php
include '../../controller/session_include.php';
include '../../controller/connection.php';
include '../../controller/report.php';

$title = 'Dashboard';
$data = [];

if(isset($_POST['submit'])){
  if($_POST['year'] == ''){
    $_POST['year'] = date("Y");
  }
  switch ($_POST['report_type']) {
    case '1':
      $data = report_01($_POST['month'],$_POST['year']);
      $til = "Jumlah Registrasi Berdasarkan Kelompok Umur, Jenis Kelamin Dalam 1 Bulan(".$_POST['month']."/".$_POST['year'].")";
      break;
    case '2':
      $data = report_02($_POST['month'],$_POST['year']);
      $til = "Jumlah Registrasi Berdasarkan Kelompok Umur, Lokasi Dan Jenis Donor Dalam 1 Bulan(".$_POST['month']."/".$_POST['year'].")";
      break;
    case '3':
      $data = report_03($_POST['month'],$_POST['year']);
      $til = "Jumlah Registrasi Berdasarkan Kelompok Umur Dalam 1 Bulan(".$_POST['month']."/".$_POST['year'].")";
      break;
    case '4':
      $data = report_04($_POST['month'],$_POST['year']);
      $til = "Jumlah Registrasi Berdasarkan Kelompok Umur, Golongan Darah Dan Rh Dalam 1 Bulan(".$_POST['month']."/".$_POST['year'].")";
      break;
    case '5':
      $data = report_05($_POST['month'],$_POST['year']);
      $til = "Jumlah Registrasi Yang Ditolak Berdasarkan Alasan Penolakan(".$_POST['month']."/".$_POST['year'].")";
      break;
    case '6':
    $data = report_06($_POST['month'],$_POST['year']);
    $til = "Catatan Kerjasama Instansi Bulanan(".$_POST['month']."/".$_POST['year'].")";
      break;
  }
  if(count($data)!=0){
    $header_data = count($data[0])/2;
    for ($i=0; $i <= $header_data; $i++) {
      unset($data[0][$i]);
    }
  }

}

?>
<!doctype html>
<html lang="en">
<?php include '../head.html'; ?>
<body>

<div class="wrapper">
    <?php include 'sidebar.php'; ?>

    <div class="main-panel">
        <?php include 'nav.php'; ?>


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
                                <form method="post">
                                  <div class="col-md-4">
                                    <select class="form-control" name="report_type">
                                      <option value="1">Jumlah Registrasi Berdasarkan Kelompok Umur, Jenis Kelamin Dalam 1 Bulan</option>
                                      <option value="2">Jumlah Registrasi Berdasarkan Kelompok Umur, Lokasi Dan Jenis Donor Dalam 1 Bulan</option>
                                      <option value="3">Jumlah Registrasi Berdasarkan Kelompok Umur Dalam 1 Bulan</option>
                                      <option value="4">Jumlah Registrasi Berdasarkan Kelompok Umur, Golongan Darah Dan Rh Dalam 1 Bulan</option>
                                      <option value="5">Jumlah Registrasi Yang Ditolak Berdasarkan Alasan Penolakan</option>
                                      <option value="6">Catatan Kerjasama Instansi Bulanan</option>
                                    </select>
                                  </div>
                                  <div class="col-md-3">
                                    <select class="form-control" name="month">
                                      <option value="1">Januari</option>
                                      <option value="2">Februari</option>
                                      <option value="3">Maret</option>
                                      <option value="4">April</option>
                                      <option value="5">Mei</option>
                                      <option value="6">Juni</option>
                                      <option value="7">Juli</option>
                                      <option value="8">Agustus</option>
                                      <option value="9">September</option>
                                      <option value="10">Oktober</option>
                                      <option value="11">November</option>
                                      <option value="12">Desember</option>
                                    </select>
                                  </div>
                                  <div class="col-md-3">
                                    <input type="text" name="year" class="form-control" placeholder="Tahun">
                                  </div>
                                  <div class="col-md-2">
                                    <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-fill pull-right">
                                  </div>
                                </form>
                              </div>
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
                                    <div class="col-md-4">
                                      <a target="_blank" href="print.php?month=<?php echo $_POST['month'] ?>&year=<?php echo $_POST['year'] ?>&report_type=<?php echo $_POST['report_type'] ?>" class="btn btn-primary btn-fill pull-left">Print Report</a>
                                    </div>
                                  <?php else: ?>
                                    Data Tidak Ditemukan
                                  <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

<?php include '../footer.html'; ?>

    </div>
</div>


</body>
<?php include '../script.html'; ?>

<script type="text/javascript">
  $(document).ready( function () {
    $('#table_id').DataTable();
  } );
</script>
</html>
