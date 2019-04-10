<html>
    <head>
        <title>Google Map</title>
        <meta name="viewport" content="initial-scale=1.0">
        <meta charset="utf-8">
        <style>
          #map {
            height: 300px;
            width: 600px;
          }
        </style>
    </head>
    <body>
        <div id="latclicked"></div>
        <div id="longclicked"></div>

        <div style="padding:10px">
            <div id="map"></div>
        </div>

        <script type="text/javascript">
        var map;

        function initMap() {
            var latitude = -0.908487; // YOUR LATITUDE VALUE
            var longitude = 100.383027; // YOUR LONGITUDE VALUE

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

            // Create new marker on single click event on the map
            google.maps.event.addListener(map,'click',function(event) {
                marker.setPosition(event.latLng);
                document.getElementById('latclicked').innerHTML = event.latLng.lat();
                document.getElementById('longclicked').innerHTML =  event.latLng.lng();
            });
        }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0kzi6RteUaeE-RID9pJjdR8TsYNqy88E&callback=initMap"
        async defer></script>
    </body>
</html>
