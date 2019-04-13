<?php
include '../../controller/connection.php';

include '../../model/member.php';

$member = new member();
$data = $member->select_by_nik($_GET['nik'])[0];
if(count($data)==0){
  header('Location:new.php?nik='.$_GET['nik']);
}

?>
<!doctype html>
<html lang="en">
<?php include '../head.html'; ?>
<body>
  <br><br><br><br><br><br><br><br>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Data Pendonor</h4>
                            </div>
                            <div class="content">
                              <div class="row">
                                <div class="col-md-4">
                                  <label for="nik">Nomor Induk Kependudukan</label>
                                </div>
                                <div class="col-md-8">
                                  <?php echo $data['nik'] ?>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-4">
                                  <label for="nik">Nama</label>
                                </div>
                                <div class="col-md-8">
                                  <?php echo $data['nama'] ?>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-4">
                                  <label for="nik">Jenis Kelamin</label>
                                </div>
                                <div class="col-md-8">
                                  <?php echo $data['jenis_kelamin'] ?>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-4">
                                  <label for="nik">Alamat</label>
                                </div>
                                <div class="col-md-8">
                                  <?php echo $data['alamat'] ?>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-4">
                                  <label for="nik">Pekerjaan</label>
                                </div>
                                <div class="col-md-8">
                                  <?php echo $data['pekerjaan'] ?>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-4">
                                  <label for="nik">Tempat Lahir</label>
                                </div>
                                <div class="col-md-8">
                                  <?php echo $data['tempat_lahir'] ?>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-4">
                                  <label for="nik">Tanggal Lahir</label>
                                </div>
                                <div class="col-md-8">
                                  <?php echo $data['tanggal_lahir'] ?>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <a href="update.php?nik=<?php echo $data['nik'] ?>" class="btn btn-warning btn-fill pull-left">Update</a>
                                  <a href="register.php?nik=<?php echo $data['nik'] ?>" class="btn btn-primary btn-fill pull-right">Donor Sekarang</a>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <br><br><br><br><br><br><br>
    <?php include '../footer.html'; ?>
</body>

<?php include '../script.html'; ?>
</html>
