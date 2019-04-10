aftap<?php
include '../../controller/connection.php';
include '../../controller/session_include.php';

include '../../model/users.php';
include '../../model/petugas_hb.php';
include '../../model/petugas_aftap.php';
include '../../model/petugas_paramedik.php';

$title = 'User List';

$user = new User();
$data = $user->select_all_with_role();

if(isset($_POST['delete'])){
  $result = $user->delete_by_id($_POST['id']);
  header('Location:?'.$result);
}

if(isset($_POST['hb'])){
  $hb = new petugas_hb();
  if($_POST['hb']=='Promote'){
    $x = $hb->promote($_POST['id']);
    header('Location:?'.$x);
  }else{
    $x = $hb->demote($_POST['id']);
    header('Location:?'.$x);
  }
}

if(isset($_POST['aftap'])){
  $aftap = new petugas_aftap();
  if($_POST['aftap']=='Promote'){
    $x = $aftap->promote($_POST['id']);
    header('Location:?'.$x);
  }else{
    $x = $aftap->demote($_POST['id']);
    header('Location:?'.$x);
  }
}

if(isset($_POST['paramedik'])){
  $paramedik = new petugas_paramedik();
  if($_POST['paramedik']=='Promote'){
    $x = $paramedik->promote($_POST['id']);
    header('Location:?'.$x);
  }else{
    $x = $paramedik->demote($_POST['id']);
    header('Location:?'.$x);
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
                    <div class="col-md-2">
                        <div class="card">
                            <a href="user_new.php" class="btn btn-primary btn-fill">Create New User</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                          <table id="table_id" class="display">
                                                        <thead>
                                                          <tr>
                                                            <th rowspan="2">Username</th>
                                                            <th rowspan="2">Nama</th>
                                                            <th rowspan="2">No Handphone</th>
                                                            <th colspan="4">Action</th>
                                                          </tr>
                                                          <tr>
                                                            <th>HB Staff</th>
                                                            <th>Aftap Staff</th>
                                                            <th>Paramedic Staff</th>
                                                            <th>Delete</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          <?php foreach ($data as $key => $value): ?>
                                                            <?php if ($value['user_id']!=1): ?>
                                                              <tr>
                                                                <td><?php echo $value['username'] ?></td>
                                                                <td><?php echo $value['nama'] ?></td>
                                                                <td><?php echo $value['no_handphone'] ?></td>
                                                                <td>
                                                                  <form method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $value['user_id'] ?>">
                                                                    <?php if ($value['hb_id']==$value['user_id']): ?>
                                                                      <input type="submit" name="hb" value="Demote" class="btn btn-danger btn-fill">
                                                                    <?php else: ?>
                                                                      <input type="submit" name="hb" value="Promote" class="btn btn-primary btn-fill">
                                                                    <?php endif; ?>
                                                                  </form>
                                                                </td>
                                                                <td>
                                                                  <form method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $value['user_id'] ?>">
                                                                    <?php if ($value['aftap_id']==$value['user_id']): ?>
                                                                      <input type="submit" name="aftap" value="Demote" class="btn btn-danger btn-fill">
                                                                    <?php else: ?>
                                                                      <input type="submit" name="aftap" value="Promote" class="btn btn-primary btn-fill">
                                                                    <?php endif; ?>
                                                                  </form>
                                                                </td>
                                                                <td>
                                                                  <form method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $value['user_id'] ?>">
                                                                    <?php if ($value['paramedik_id']==$value['user_id']): ?>
                                                                      <input type="submit" name="paramedik" value="Demote" class="btn btn-danger btn-fill">
                                                                    <?php else: ?>
                                                                      <input type="submit" name="paramedik" value="Promote" class="btn btn-primary btn-fill">
                                                                    <?php endif; ?>
                                                                  </form>
                                                                </td>
                                                                <td>
                                                                  <form method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $value['user_id'] ?>">
                                                                    <input type="submit" name="delete" value="delete" class="btn btn-danger btn-fill">
                                                                  </form>
                                                                </td>
                                                              </tr>
                                                            <?php endif; ?>
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
