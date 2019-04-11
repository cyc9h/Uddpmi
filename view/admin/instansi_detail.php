<?php
include '../../controller/connection.php';
include '../../controller/session_include.php';

include '../../model/instansi.php';
include '../../model/kerjasama_instansi.php';

$title = 'Detail Instansi';

$x = new instansi();
$data = $x->select_by_id($_GET['id']);

$y = new kerjasama_instansi();
$dy = $y->select_all_by_instansi($_GET['id']);

if(isset($_POST['delete'])){
  $result = $y->delete($_POST);
  header('Location:?id='.$_GET['id'].'&'.$result);
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
                              <h4 class="title">Data Instansi <?php echo $data[0]['nama'] ?></h4>
                              <a href="event_new.php?instansi_id=<?php echo $_GET['id'] ?>" class="pull-right">Add Event</a>
                          </div>
                          <div class="content">
                                  <div class="row">
                                    <div style="padding:10px;height:400px;width:900px center" class="col-md-6">
                                        <div id="map"></div>
                                    </div>
                                    <div class="col-md-6">
                                      <table id="table_id" class="display">
                                                                    <thead>
                                                                      <tr>
                                                                        <th rowspan="2">No Plat</th>
                                                                        <th colspan="2">Waktu</th>
                                                                        <th rowspan="2">Action</th>
                                                                      </tr>
                                                                      <tr>
                                                                        <th>Mulai</th>
                                                                        <th>Akhir</th>
                                                                      </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                      <?php foreach ($dy as $key => $value): ?>
                                                                          <tr>
                                                                            <td><?php echo $value['no_plat'] ?></td>
                                                                            <td><?php echo $value['waktu_mulai'] ?></td>
                                                                            <td><?php echo $value['waktu_selesai'] ?></td>
                                                                            <td>
                                                                              <form method="post">
                                                                                <input type="hidden" name="no_plat" value="<?php echo $value['no_plat'] ?>">
                                                                                <input type="hidden" name="waktu_mulai" value="<?php echo $value['waktu_mulai'] ?>">
                                                                                <input type="submit" name="delete" value="Delete" class="btn btn-danger btn-fill">
                                                                              </form>
                                                                            </td>
                                                                          </tr>
                                                                      <?php endforeach; ?>
                                                                    </tbody>
                                                                  </table>
                                    </div>
                                  </div>
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
var map;

function initMap() {
    var latitude = <?php echo $data[0]['latitude'] ?>; // YOUR LATITUDE VALUE
    var longitude = <?php echo $data[0]['longitude'] ?>; // YOUR LONGITUDE VALUE

    var myLatLng = {lat: latitude, lng: longitude};

    map = new google.maps.Map(document.getElementById('map'), {
      center: myLatLng,
      zoom: 14,
      disableDoubleClickZoom: true, // disable the default map zoom on double click
    });


    var marker = new google.maps.Marker({
      position: myLatLng,
      map: map,
      title: latitude + ', ' + longitude
    });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0kzi6RteUaeE-RID9pJjdR8TsYNqy88E&callback=initMap"
async defer></script>

<script type="text/javascript">
  $(document).ready( function () {
    $('#table_id').DataTable();
  } );
</script>
</html>
