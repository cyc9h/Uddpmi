<?php
include '../../controller/connection.php';
include '../../controller/session_include.php';

include '../../model/jenis_kantong.php';

$title = 'Jenis Kantong';

$x = new jenis_kantong();
$data = $x->select_all();

if(isset($_POST['delete'])){
  $result = $x->delete($_POST['id']);
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
                    <div class="col-md-2">
                        <div class="card">
                            <a href="jenis_kantong_new.php" class="btn btn-primary btn-fill">Create New Jenis Kantong</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                          <table id="table_id" class="display">
                                                        <thead>
                                                          <tr>
                                                            <th>Nama Jenis Kantong</th>
                                                            <th>Action</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          <?php foreach ($data as $key => $value): ?>
                                                              <tr>
                                                                <td><?php echo $value['keterangan'] ?></td>
                                                                <td>
                                                                  <form method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $value['jkantong_id'] ?>">
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
