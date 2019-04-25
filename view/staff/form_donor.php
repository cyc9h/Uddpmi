<?php
include '../../controller/connection.php';

include '../../model/users.php';
include '../../model/donor.php';

$title = 'Form Donor';

$user = new User();
$pemeriksaan = new donor();

if(isset($_POST['submit'])){
  $_POST['nik'] = $_GET['nik'];
  $_POST['no_datang'] = $_GET['no'];

  $check = $user->select_one_with_role($_POST)[0];
  print_r($check);
  if(isset($check['user_id'])){
    if($check['aftap_id']!=''){
      $_POST['aftap_id'] = $check['aftap_id'];
      $result = $pemeriksaan->insert($_POST);
      if($result=="Insert_Error"){
        // header('Location:?nik='.$_GET['nik'].'&no='.$_GET['no'].'&'.$result);
      }else{
        header('Location:donor.php?'.$result);
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
                                        <label>Nomor Kantong</label>
                                        <input type="text" name="nomor_kantong" value="0" class="form-control">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Reaksi Donor</label>
                                        <input type="text" name="reaksi_donor" class="form-control">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Jumlah Ambil</label>
                                        <input type="text" name="jumlah_ambil" value="0" class="form-control">
                                      </div>
                                    </div>
                                    <br>
                                    <div class="col-md-6">
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
