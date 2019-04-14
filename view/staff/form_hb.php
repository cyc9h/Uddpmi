<?php
include '../../controller/connection.php';

include '../../model/users.php';
include '../../model/pemeriksaan_hb.php';

$title = 'Form Pemeriksaan HB';

$user = new User();
$pemeriksaan = new pemeriksaan_hb();

if(isset($_POST['submit'])){
  $_POST['nik'] = $_GET['nik'];
  $_POST['no_datang'] = $_GET['no'];

  $check = $user->select_one_with_role($_POST)[0];
  print_r($check);
  if(isset($check['user_id'])){
    if($check['hb_id']!=''){
      $_POST['hb_id'] = $check['hb_id'];
      $result = $pemeriksaan->insert($_POST);
      if($result=="Insert_Error"){
        header('Location:?nik='.$_GET['nik'].'&no='.$_GET['no'].'&'.$result);
      }else{
        header('Location:hb.php?'.$result);
      }
    }else{
      header('Location:?nik='.$_GET['nik'].'&no='.$_GET['no'].'&Auth_Error');
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
                                        <label>Jumlah HB</label>
                                        <input type="text" name="hb" value="0" class="form-control">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Jumlah HCT</label>
                                        <input type="text" name="hct" value="0" class="form-control">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Berat Badan</label>
                                        <input type="text" name="berat_badan" value="0" class="form-control">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Golongan Darah</label>
                                        <select class="form-control" name="gol_darah">
                                          <option value="A">A</option>
                                          <option value="B">B</option>
                                          <option value="AB">AB</option>
                                          <option value="O">O</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Rhesus</label>
                                        <select class="form-control" name="rh">
                                          <option value="+">Positif</option>
                                          <option value="-">Negatif</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <br>
                                      <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-fill pull-right">
                                    </div>
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
