<?php
include '../../controller/connection.php';

include '../../model/users.php';
include '../../model/pemeriksaan_paramedik.php';
include '../../model/jenis_kantong.php';

$title = 'Form Pemeriksaan Paramedik';

$user = new User();
$pemeriksaan = new pemeriksaan_paramedik();
$jkantong = new jenis_kantong();

$jkdata = $jkantong->select_all();

if(isset($_POST['submit'])){
  $_POST['nik'] = $_GET['nik'];
  $_POST['no_datang'] = $_GET['no'];

  $check = $user->select_one_with_role($_POST)[0];
  print_r($check);
  if(isset($check['user_id'])){
    if($check['paramedik_id']!=''){
      $_POST['paramedik_id'] = $check['paramedik_id'];
      $result = $pemeriksaan->insert($_POST);
      if($result=="Insert_Error"){
        header('Location:?nik='.$_GET['nik'].'&no='.$_GET['no'].'&'.$result);
      }else{
        header('Location:paramedik.php?'.$result);
      }
    }else{
      header('Location:?nik='.$_GET['nik'].'&no='.$_GET['no'].'&False_Account');
    }
  }else{
    header('Location:?nik='.$_GET['nik'].'&no='.$_GET['no'].'&Auth_Error');
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
                              <h4 class="title">Input Hasil Pemeriksaan</h4>
                          </div>
                          <div class="content">
                              <form method="post">
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Username</label>
                                              <input type="text" class="form-control" placeholder="Username" name="username">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Password</label>
                                              <input type="password" class="form-control" placeholder="Password" name="password">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Tensi</label>
                                        <input type="text" name="tensi" value="0" class="form-control">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Suhu</label>
                                        <input type="text" name="suhu" value="0" class="form-control">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Nadi</label>
                                        <input type="text" name="nadi" value="0" class="form-control">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Riwayat Medis</label>
                                        <input type="text" name="riwayat_medis" class="form-control">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Jenis Kantong</label>
                                        <select class="form-control" name="jkantong_id">
                                          <?php foreach ($jkdata as $key => $value): ?>
                                            <option value="<?php echo $value['jkantong_id'] ?>"><?php echo $value['keterangan'] ?></option>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Jumlah Pengambilan</label>
                                        <input type="text" name="jumlah_pengambilan" value="0" class="form-control">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
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
</html>
