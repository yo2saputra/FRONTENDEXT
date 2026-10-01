<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script>
<script src="https://www.mapquestapi.com/sdk/leaflet/v2.2/mq-map.js?key=8nIoYUx9GyjZsdehJySzjprSvZIqgM42"></script>
<script src="https://www.mapquestapi.com/sdk/leaflet/v2.2/mq-routing.js?key=8nIoYUx9GyjZsdehJySzjprSvZIqgM42"></script>

<script type="text/javascript">
    window.onload = function() {

        var map,
            dir;

        map = L.map('map', {
            layers: MQ.mapLayer(),
            center: [42.346353, -71.415958],
            zoom: 9
        });

        dir = MQ.routing.directions();

        dir.route({
            locations: [
                'worcester ma',
                {
                    latLng: {
                        lat: 42.346797,
                        lng: -71.547966
                    }
                },
                {
                    city: 'boston',
                    state: 'ma'
                }
            ]
        });

        map.addLayer(MQ.routing.routeLayer({
            directions: dir,
            fitBounds: true
        }));
    }
</script>
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
                <div class="col-sm-12">
                    <h1></h1>
                    <div id='map' style='width: 100%; height:530px;'></div>
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




<?= $this->endSection('script'); ?>