<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>

<style>
    /* set width action button crud */
    .btn-fix-w {
        width: 50px;
    }

    /* set font size dropdown select2 */
    select.form-control-sm~.select2-container--default {
        font-size: .720rem !important;
    }

    /* set font size input form */
    .form-control-sm {
        font-size: .720rem !important;
    }



    body {
        background-color: grey;
    }

    html,
    body,
    #map {
        height: 100%;
        margin: 0;
        padding: 0;
    }
</style>


<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Header content -->
    <section class="content-header">
        <div class="container-fluid">
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-3">
                    <h1></h1>
                    <div id="googleMap" style="width:100%;height:250px;"></div>
                </div>
                <div class="col-sm-3">
                    <h1></h1>
                    <div id="googleMap1" style="width:100%;height:250px;"></div>
                </div>
                <div class="col-sm-3">
                    <h1></h1>
                    <div id="googleMap2" style="width:100%;height:250px;"></div>
                </div>
                <div class="col-sm-3">
                    <h1></h1>
                    <div id="googleMap3" style="width:100%;height:250px;"></div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-12">
                    <h1></h1>
                    <div id="map" style="width:100%;height:250px;"></div>
                </div>

            </div>

            <!-- ------ -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
</script>

<script>
    function myMap() {
        var mapProp = {
            center: new google.maps.LatLng(51.508742, -0.120850),
            zoom: 5,
        };
        var mapOptions1 = {
            center: new google.maps.LatLng(51.508742, -0.120850),
            zoom: 8,
        };
        var mapOptions2 = {
            center: new google.maps.LatLng(51.508742, -0.120850),
            zoom: 5,
        };
        var mapOptions3 = {
            center: new google.maps.LatLng(51.508742, -0.120850),
            zoom: 8,
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
        var map1 = new google.maps.Map(document.getElementById("googleMap1"), mapOptions1);
        var map2 = new google.maps.Map(document.getElementById("googleMap2"), mapOptions2);
        var map3 = new google.maps.Map(document.getElementById("googleMap3"), mapOptions3);
        // var map4 = new google.maps.Map(document.getElementById("googleMap4"), mapOptions4);

        var marker = new google.maps.Marker({
            position: myCenter
        });

        marker.setMap(map);
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAIwTPctnSM2PWcbK6cMdlZaSgEYIKp5U&callback=myMap" async defer></script>

<!-- <script>
    var map;

    function initMap() {
        var directionsService = new google.maps.DirectionsService;
        map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: -6.293711863008,
                lng: 106.82752941917083
            },
            zoom: 8
        });

        var listPos = [{
                arriveeLat: -6.290128688498794,
                arriveeLng: 106.82031964169538,
                departLat: -6.293711863008,
                departLng: 106.82752941917083
            },
            {
                arriveeLat: -6.2993425158701255,
                arriveeLng: 106.81413983243073,
                departLat: -6.290128688498794,
                departLng: 106.82031964169538
            },
            {
                arriveeLat: -6.318622773257076,
                arriveeLng: 106.82375286906462,
                departLat: -6.2993425158701255,
                departLng: 106.81413983243073
            },
        ];
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0; i < listPos.length; i++) {

            var startPoint = new google.maps.LatLng(listPos[i]['departLat'], listPos[i]['departLng']);
            var endPoint = new google.maps.LatLng(listPos[i]['arriveeLat'], listPos[i]['arriveeLng']);
            var directionsDisplay = new google.maps.DirectionsRenderer({
                map: map,
                preserveViewport: true
            });
            calculateAndDisplayRoute(directionsService, directionsDisplay, startPoint, endPoint, bounds);
        }

    }


    function calculateAndDisplayRoute(directionsService, directionsDisplay, startPoint, endPoint, bounds) {
        directionsService.route({
            origin: startPoint,
            destination: endPoint,
            travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
                console.log(response);
                directionsDisplay.setDirections(response);
                bounds.union(response.routes[0].bounds);
                map.fitBounds(bounds);
            } else {
                window.alert('Impossible d afficher la route ' + status);
            }
        });
    }
</script> -->
<!--<script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap&key=AIzaSyCkUOdZ5y7hMm0yrcCQoCvLwzdM6M8s5qk"></script>-->
<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap&key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg"></script> -->


<?= $this->endSection('script'); ?>