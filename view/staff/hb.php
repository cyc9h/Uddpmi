<?php
include '../../controller/connection.php';

include '../../model/registrasi.php';

$title = 'Registration List';

$x = new registrasi();
$data = $x->select_by_status_id(1);

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
                                                              <th>NIK</th>
                                                              <th>Datang ke-</th>
                                                              <th>Nama</th>
                                                              <th>Waktu Registrasi</th>
                                                              <th>Action</th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>
                                                            <?php foreach ($data as $key => $value): ?>
                                                                <tr>
                                                                  <td><?php echo $value['nik'] ?></td>
                                                                  <td><?php echo $value['no_datang'] ?></td>
                                                                  <td><?php echo $value['nama'] ?></td>
                                                                  <td><?php echo $value['date_trunc'] ?></td>
                                                                  <td>
                                                                    <form method="post">
                                                                      <a href="reg_detail.php?nik=<?php echo $value['nik'] ?>&no=<?php echo $value['no_datang'] ?>" class="btn btn-primary btn-fill">Detail</a>
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
