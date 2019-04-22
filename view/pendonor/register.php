<?php
include '../../controller/connection.php';

include '../../model/jenis_donor.php';
include '../../model/pilihan_kondisi.php';
include '../../model/kondisi.php';
include '../../model/registrasi.php';
include '../../model/kondisi_registrasi.php';

$jdonor = new jenis_donor();
$pkondisi = new pilihan_kondisi();
$kondisi = new kondisi();
$reg = new registrasi();
$kreg = new kondisi_registrasi();

$jdata = $jdonor->select_all();
$pdata = $pkondisi->select_all();
$kdata = $kondisi->select_all();

if(isset($_POST['submit'])){
  $_POST['nik']=$_GET['nik'];
  $result = $reg->insert($_POST);
  if($result=='Insert_Error'){
    header('Location:?nik='.$_POST['nik'].'&'.$result);
  }else{
    $result2 = $kreg->insert($_POST['nik'],$_POST['kondisi_registrasi']);
    header('Location:index.php?Registration_Success');
  }


}



// $member = new member();
// if(isset($_POST['submit'])){
//   $_POST['nik'] = $_GET['nik'];
//   $result = $member->insert($_POST);

// }

?>
<!doctype html>
<html lang="en">
<?php include '../head.html'; ?>
<body>
  <br>
  <div class="content">
      <div class="container-fluid">
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Registrasi Donor Darah</h4>
                    </div>
                    <div class="content">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Jenis Donor Darah</label>
                                        <select class="form-control" name="jenis_id">
                                          <?php foreach ($jdata as $key => $value): ?>
                                            <?php if ($value['jenis_id']>2&&isset($_COOKIE['location1'])): ?>
                                            <?php else: ?>
                                              <option value="<?php echo $value['jenis_id'] ?>"><?php echo $value['nama'] ?></option>
                                            <?php endif; ?>                                            
                                          <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Kondisi Pendonor Saat Ini</label>
                                        <table id="table_id" class="display">
                                          <thead>
                                            <tr>
                                              <th rowspan="2">Kondisi</th>
                                              <th colspan="<?php echo count($pdata); ?>">Pilihan</th>
                                            </tr>
                                            <tr>
                                              <?php foreach ($pdata as $key => $value): ?>
                                                <th><?php echo $value['keterangan'] ?></th>
                                              <?php endforeach; ?>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php foreach ($kdata as $key => $con): ?>
                                              <tr>
                                                <td><?php echo $con['kondisi'] ?></td>
                                                <?php foreach ($pdata as $key => $pil): ?>
                                                  <td>
                                                    <input checked type="radio" name="kondisi_registrasi[<?php echo $con['kondisi_id'] ?>]" value="<?php echo $pil['pilihan_id'] ?>">
                                                  </td>
                                                <?php endforeach; ?>
                                              </tr>
                                            <?php endforeach; ?>
                                          </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-fill pull-right">
                        </form>
                    </div>
                </div>
            </div>
          </div>

      </div>
  </div>
    <br><br>
    <?php include '../footer.html'; ?>
</body>

<?php include '../script.html'; ?>

<script type="text/javascript">
  $(document).ready( function () {
    $('#table_id').DataTable({
      paging:false
    });
  } );
</script>

</html>
