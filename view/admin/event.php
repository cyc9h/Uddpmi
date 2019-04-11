<?php
include '../../controller/connection.php';
include '../../controller/session_include.php';

include '../../model/kerjasama_instansi.php';

$title = 'Event List';

$x = new kerjasama_instansi();
$data = $x->select_all();

if(isset($_POST['delete'])){
  $result = $x->delete($_POST);
  header('Location:?'.$result);
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
                          <table id="table_id" class="display">
                                                        <thead>
                                                          <tr>
                                                            <th rowspan="2">Nomor Kendaraan</th>
                                                            <th colspan="2">Waktu</th>
                                                            <th rowspan="2">Target</th>
                                                            <th colspan="2">Action</th>
                                                          </tr>
                                                          <tr>
                                                            <th>Mulai</th>
                                                            <th>Selesai</th>
                                                            <th>Detail</th>
                                                            <th>Delete</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          <?php foreach ($data as $key => $value): ?>
                                                              <tr>
                                                                <td><?php echo $value['no_plat'] ?></td>
                                                                <td><?php echo $value['waktu_mulai'] ?></td>
                                                                <td><?php echo $value['waktu_selesai'] ?></td>
                                                                <td><?php echo $value['target'] ?></td>
                                                                <td>
                                                                  <a href="event_detail.php?no_plat=<?php echo $value['no_plat'] ?>&waktu_mulai=<?php echo $value['waktu_mulai'] ?>" class="btn btn-primary btn-fill">Detail</a>
                                                                </td>
                                                                <td>
                                                                  <form method="post">
                                                                    <input type="hidden" name="no_plat" value="<?php echo $value['no_plat'] ?>">
                                                                    <input type="hidden" name="waktu_mulai" value="<?php echo $value['waktu_mulai'] ?>">
                                                                    <input type="submit" name="delete" value="delete" class="btn btn-danger btn-fill">
                                                                  </form>
                                                                </td>
                                                              </tr>
                                                          <?php endforeach; ?>
                                                        </tbody>
                                                      </table>
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
