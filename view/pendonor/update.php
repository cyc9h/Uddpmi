<?php
include '../../controller/connection.php';

include '../../model/member.php';

$member = new member();
$data = $member->select_by_nik($_GET['nik'])[0];
if(count($data)==0){
  header('Location:index.php');
}

if(isset($_POST['submit'])){
  $_POST['nik'] = $_GET['nik'];
  $result = $member->update($_POST);
  if($result=='Update_Error'){
    header('Location:?nik='.$_POST['nik'].'&'.$result);
  }else{
    header('Location:data.php?nik='.$_POST['nik'].'&'.$result);
  }
}

?>
<!doctype html>
<html lang="en">
<?php include '../head.html'; ?>
<body>
  <br><br>
  <div class="content">
      <div class="container-fluid">
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Update Data</h4>
                    </div>
                    <div class="content">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nomor Induk Kependudukan</label>
                                        <input type="text" class="form-control" name="nik" value="<?php echo $_GET['nik'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" name="nama" value="<?php echo $data['nama'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pekerjaan</label>
                                        <input type="text" class="form-control" name="pekerjaan" value="<?php echo $data['pekerjaan'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select class="form-control" name="jenis_kelamin">
                                          <option value="Pria" <?php if ($data['jenis_kelamin']=='Pria'): ?>
                                            selected
                                          <?php endif; ?>>Pria</option>
                                          <option value="Wanita" <?php if ($data['jenis_kelamin']=='Wanita'): ?>
                                            selected
                                          <?php endif; ?>>Wanita</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tempat Lahir</label>
                                        <input type="text" class="form-control" name="tempat_lahir" value="<?php echo $data['tempat_lahir'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control" value="<?php echo $data['tanggal_lahir'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Golongan Darah</label>
                                  <select class="form-control" name="gol_darah">
                                    <option value="A" <?php if ($data['gol_darah']=='A'): ?>
                                      selected
                                    <?php endif; ?>>A</option>
                                    <option value="B" <?php if ($data['gol_darah']=='B'): ?>
                                      selected
                                    <?php endif; ?>>B</option>
                                    <option value="AB" <?php if ($data['gol_darah']=='AB'): ?>
                                      selected
                                    <?php endif; ?>>AB</option>
                                    <option value="O" <?php if ($data['gol_darah']=='O'): ?>
                                      selected
                                    <?php endif; ?>>O</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Rhesus</label>
                                  <select class="form-control" name="rh">
                                    <option value="+" <?php if ($data['rh']=="+"): ?>
                                      selected
                                    <?php endif; ?>>Positif</option>
                                    <option value="-" <?php if ($data['rh']=="-"): ?>
                                      selected
                                    <?php endif; ?>>Negatif</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control" name="alamat" value="<?php echo $data['alamat'] ?>">
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
    <br>
    <?php include '../footer.html'; ?>
</body>

<?php include '../script.html'; ?>
</html>
