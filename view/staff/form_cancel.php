<?php
include '../../controller/connection.php';

include '../../model/status_registrasi.php';
include '../../model/registrasi.php';

$title = 'Tolak Request Donor Darah';

$x = new status_registrasi();
$reg = new registrasi();
$sts = $x->select_fail();

if(isset($_POST['submit'])){
  $_POST['nik'] = $_GET['nik'];
  $_POST['no_datang'] = $_GET['no'];
  $result = $reg->change_status($_POST);
  if($result=="Insert_Error"){
    header('Location:?'.$result);
  }else{
    header('Location:hb.php?'.$result);
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
                              <h4 class="title">Cancel Request</h4>
                          </div>
                          <div class="content">
                              <form method="post">
                                  <div class="row">
                                      <div class="col-md-10">
                                          <div class="form-group">
                                              <label>Alasan Penolakan</label>
                                              <select class="form-control" name="status_id">
                                                <?php foreach ($sts as $key => $value): ?>
                                                  <option value="<?php echo $value['status_id'] ?>"><?php echo $value['keterangan'] ?></option>
                                                <?php endforeach; ?>
                                              </select>
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

<script type="text/javascript">
var map;

function initMap() {
    var latitude = -0.908487; // YOUR LATITUDE VALUE
    var longitude = 100.383027; // YOUR LONGITUDE VALUE

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
