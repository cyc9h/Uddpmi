<?php
include '../../controller/connection.php';
include '../../controller/session_include.php';
include '../../controller/datetime-formater.php';

include '../../model/kendaraan.php';
include '../../model/kerjasama_instansi.php';
include '../../model/instansi.php';

$title = 'New Event';

$x = new kerjasama_instansi();
$y = new kendaraan();
$z = new instansi();

$data = $y->select_all();
$data_z = $z->select_by_id($_GET['instansi_id']);

if(isset($_POST['submit'])){
  $_POST['waktu_mulai'] = format_local($_POST['waktu_mulai']);
  $_POST['waktu_selesai'] = format_local($_POST['waktu_selesai']);
  $_POST['instansi_id'] = $data_z[0]['instansi_id'];
  $result=$x->insert($_POST);

  if($result=="Insert_Error"){
    header('Location:?instansi_id='.$_GET['instansi_id'].'&'.$result);
  }else{
    header('Location:instansi_detail.php?id='.$_GET['instansi_id'].'&'.$result);
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
                                    <input type="hidden" name="latitude" id="latclicked">
                                    <input type="hidden" name="longitude" id="longclicked">

                                    <div style="padding:10px;height:400px;width:900px center">
                                        <div id="map"></div>
                                    </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Nomor Plat Kendaraan</label>
                                              <select class="form-control" name="no_plat">
                                                <?php foreach ($data as $key => $value): ?>
                                                  <option value="<?php echo $value['no_plat'] ?>"><?php echo $value['no_plat'] ?> - <?php echo $value['nama'] ?></option>
                                                <?php endforeach; ?>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Target</label>
                                              <input type="text" name="target" value="0" class="form-control">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Waktu Mulai</label>
                                              <input type="datetime-local" name="waktu_mulai" class="form-control">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Waktu Selesai</label>
                                              <input type="datetime-local" name="waktu_selesai" class="form-control">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-12">
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

<script type="text/javascript">
var map;

function initMap() {
    var latitude = <?php echo $data_z[0]['latitude'] ?>; // YOUR LATITUDE VALUE
    var longitude = <?php echo $data_z[0]['longitude'] ?>; // YOUR LONGITUDE VALUE

    var myLatLng = {lat: latitude, lng: longitude};

    document.getElementById('latclicked').value =   latitude;
    document.getElementById('longclicked').value =  longitude;

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

    // Create new marker on single click event on the map
    google.maps.event.addListener(map,'click',function(event) {
        marker.setPosition(event.latLng);
        document.getElementById('latclicked').value = event.latLng.lat();
        document.getElementById('longclicked').value =  event.latLng.lng();
    });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0kzi6RteUaeE-RID9pJjdR8TsYNqy88E&callback=initMap"
async defer></script>
</html>
