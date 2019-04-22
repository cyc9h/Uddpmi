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
      header('Location:print.php?month='.$_POST['month'].'&year='.$_POST['year']);
      break;

    default:
      header('Location:print2.php?month='.$_POST['month'].'&year='.$_POST['year']);
      break;
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
                                      <option value="1">Whole Blood</option>
                                      <option value="2">Rekap Rencana Jadwal Mobil</option>
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
