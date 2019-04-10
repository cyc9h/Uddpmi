<?php
include '../../controller/connection.php';
include '../../controller/session_include.php';

include '../../model/users.php';

$title = 'New User';

$user = new User();

if(isset($_POST['submit'])){
  $result=$user->insert($_POST);
  if($result=="Insert_Error"){
    header('Location:?'.$result);
  }else{
    header('Location:user.php?'.$result);
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
                              <h4 class="title">Create Profile</h4>
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
                                              <input type="text" class="form-control" placeholder="Password" name="password">
                                          </div>
                                      </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Nama</label>
                                              <input type="text" class="form-control" placeholder="Nama" name="nama">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Jenis Kelamin</label>
                                              <select class="form-control" name="jenis_kelamin">
                                                <option value="Pria" selected>Pria</option>
                                                <option value="Wanita">Wanita</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>No. Handphone</label>
                                              <input type="text" class="form-control" name="no_handphone">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <br>
                                              <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-fill pull-right">
                                          </div>
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
