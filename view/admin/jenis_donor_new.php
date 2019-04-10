<?php
include '../../controller/connection.php';
include '../../controller/session_include.php';

include '../../model/jenis_donor.php';

$title = 'New Jenis Donor';

$x = new jenis_donor();

if(isset($_POST['submit'])){
  $result=$x->insert($_POST);
  if($result=="Insert_Error"){
    header('Location:?'.$result);
  }else{
    header('Location:jenis_donor.php?'.$result);
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
                              <h4 class="title">Create Data</h4>
                          </div>
                          <div class="content">
                              <form method="post">
                                  <div class="row">
                                      <div class="col-md-10">
                                          <div class="form-group">
                                              <label>Nama Jenis Donor</label>
                                              <input type="text" class="form-control" name="nama">
                                          </div>
                                      </div>
                                      <div class="col-md-2">
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
