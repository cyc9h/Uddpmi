<?php
include '../../controller/connection.php';

include '../../model/registrasi.php';
include '../../model/Users.php';
include '../../model/jenis_kantong.php';

$title = 'Registration Data';

$x = new registrasi();
$user = new user();
$jkantong = new jenis_kantong();

$data = $x->select_by_primary($_GET);
$y = $data[0];

$locator = 'form_hb.php';
if($y['hb_id']!=''){
  $locator = 'form_paramedik.php';
}

if($y['paramedik_id']!=''){
  $locator = 'form_donor.php';
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
                <div class="card">
                  <div class="row">
                    <div class="col-md-6">
                      Nomor Induk Kependudukan
                    </div>
                    <div class="col-md-6">
                      <?php echo $y['nik'] ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      Nama Pendonor
                    </div>
                    <div class="col-md-6">
                      <?php echo $y['nama'] ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      Jenis Kelamin
                    </div>
                    <div class="col-md-6">
                      <?php echo $y['jenis_kelamin'] ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      Alamat
                    </div>
                    <div class="col-md-6">
                      <?php echo $y['alamat'] ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      Pekerjaan
                    </div>
                    <div class="col-md-6">
                      <?php echo $y['pekerjaan'] ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      Tempat Lahir
                    </div>
                    <div class="col-md-6">
                      <?php echo $y['tempat_lahir'] ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      Tanggal Lahir
                    </div>
                    <div class="col-md-6">
                      <?php echo $y['tanggal_lahir'] ?>
                    </div>
                  </div>
                  <div class="row">

                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      Jenis Donor
                    </div>
                    <div class="col-md-6">
                      <?php echo $y['nama_jenis'] ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      Waktu Registrasi
                    </div>
                    <div class="col-md-6">
                      <?php echo $y['tanggal'] ?>
                    </div>
                  </div>
                  <table id="table_id">
                    <thead>
                      <th>No.</th>
                      <th>Pertanyaan</th>
                      <th>Jawaban</th>
                    </thead>
                    <tbody>
                      <?php $i=1; ?>
                      <?php foreach ($data as $key => $value): ?>
                        <tr>
                          <td><?php echo $i;$i++; ?></td>
                          <td><?php echo $value['kondisi'] ?></td>
                          <td><?php echo $value['keterangan'] ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                  <br>
                  <?php if ($y['hb_id']!=''): ?>
                    <div class="row">
                      <div class="col-md-6">
                        Nama Petugas HB
                      </div>
                      <div class="col-md-6">
                        <?php echo $user->select_by_id($y['hb_id'])[0]['nama']; ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        Nilai HB
                      </div>
                      <div class="col-md-6">
                        <?php echo $y['hb']; ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        Nilai HCT
                      </div>
                      <div class="col-md-6">
                        <?php echo $y['hct']; ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        Berat Badan
                      </div>
                      <div class="col-md-6">
                        <?php echo $y['berat_badan']; ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        Golongan Darah
                      </div>
                      <div class="col-md-6">
                        <?php echo $y['gol_darah']; ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        Rhesus
                      </div>
                      <div class="col-md-6">
                        <?php if ($y['rh']=="+"): ?>
                          <?php echo "Positif" ?>
                        <?php else: echo "Negatif"?>
                        <?php endif; ?>
                      </div>
                    </div>
                    <br>
                  <?php endif; ?>

                  <?php if ($y['paramedik_id']!=''): ?>
                    <div class="row">
                      <div class="col-md-6">
                        Nama Petugas Paramedik
                      </div>
                      <div class="col-md-6">
                        <?php echo $user->select_by_id($y['paramedik_id'])[0]['nama']; ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        Tensi
                      </div>
                      <div class="col-md-6">
                        <?php echo $y['tensi']; ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        Suhu
                      </div>
                      <div class="col-md-6">
                        <?php echo $y['suhu']; ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        Nadi
                      </div>
                      <div class="col-md-6">
                        <?php echo $y['nadi']; ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        Riwayat Medis
                      </div>
                      <div class="col-md-6">
                        <?php echo $y['riwayat_medis']; ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        Jenis Kantong
                      </div>
                      <div class="col-md-6">
                        <?php echo $jkantong->select_by_id($y['jkantong_id'])[0]['keterangan'] ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        Jumlah Pengambilan
                      </div>
                      <div class="col-md-6">
                        <?php echo $y['jumlah_pengambilan'] ?>
                      </div>
                    </div>
                    <br>
                  <?php endif; ?>
                  <div class="row">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-5">
                      <a href="<?php echo $locator ?>?nik=<?php echo $_GET['nik'] ?>&no=<?php echo $_GET['no'] ?>" class="btn btn-primary btn-fill pull-left">Accept</a>
                    </div>
                    <div class="col-md-5">
                      <a href="form_cancel.php?nik=<?php echo $_GET['nik'] ?>&no=<?php echo $_GET['no'] ?>" class="btn btn-danger btn-fill pull-right">Reject</a>
                    </div>
                  </div>
                  <br>
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
    $('#table_id').DataTable({
    });
  } );
</script>
</html>
