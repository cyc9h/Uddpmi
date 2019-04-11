<?php
include '../../controller/connection.php';
include '../../controller/session_include.php';

include '../../model/kerjasama_instansi.php';

$title = 'Detail Event';


$y = new kerjasama_instansi();
$dy = $y->select_by_id($_GET);
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
                              <h4 class="title">Data Event</h4>
                          </div>
                          <div class="content">
                                  <div class="row">
                                    <div style="padding:10px;height:400px;width:900px center" class="col-md-6">
                                        <div id="map"></div>
                                    </div>
                                    <div class="col-md-6">
                                      <p>Nomor Kendaraan  : <?php echo $dy[0]['no_plat'] ?></p>
                                      <p>Waktu Mulai : <?php echo $dy[0]['waktu_mulai'] ?></p>
                                      <p>Waktu Selesai : <?php echo $dy[0]['waktu_selesai'] ?></p>
                                      <p>Target Donor : <?php echo $dy[0]['target'] ?></p>
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
    var latitude = <?php echo $dy[0]['latitude'] ?>; // YOUR LATITUDE VALUE
    var longitude = <?php echo $dy[0]['longitude'] ?>; // YOUR LONGITUDE VALUE

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

</script>
</html>
