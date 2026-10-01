<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- Button datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<!-- datepicker styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
<!-- fullCalendar -->
<link rel="stylesheet" href="<?= base_url('plugins/fullcalendar/main.css') ?>">

<style>
    /* set width action button crud */
    .btn-fix-w {
        width: 60px;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    /* set font size dropdown select2 */
    select.form-control-sm~.select2-container--default {
        font-size: .720rem !important;
    }

    /* set font size input form */
    .form-control-sm {
        font-size: .720rem !important;
    }

    .fc-day[data-date^="2017-11-14"] {
        background: blue !important;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6">
                    <!-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">patient</li>
                    </ol> -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-body p-2">
                            <!-- THE CALENDAR -->
                            <!-- <div class="col-sm-12"> -->
                            <div id="calendar"></div>
                            <!-- </div> -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                    <div class="sticky-top mb-3">
                        <div class="card">
                            <!-- <div class="card-header">
                                <h4 class="card-title">Dokter</h4>
                            </div> -->
                            <div class="card-body">

                                <div id="viewdokter"></div>
                            </div>
                            <!-- /.card-body -->
                        </div>

                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div>

                <!-- Modal -->
                <div class="modal fade" id="calendarModal" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel">Jadwal Dokter</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-sm-12">
                                    <span id="viewjadwal"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<!-- Toastr -->
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>

<!-- Button datatable -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- Select2 -->
<script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>

<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
</script>

<!-- fullCalendar 2.2.5 -->
<script src="<?= base_url('plugins/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('plugins/fullcalendar/main.js') ?>"></script>

<script>
    $(".select").select2({
        minimumResultsForSearch: Infinity
    });
    $('#birth_dt').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
</script>

<script>
    function jadwalDokter() {
        $.ajax({
            method: "get",
            url: "<?= site_url('jadwaldokter/fetchDokter'); ?>",
            success: function(data) {
                $('#viewdokter').html(data);
            }
        });
    }
    $(document).ready(function() {

        jadwalDokter();
    });
</script>

<script>
    $(document).ready(function() {
        //     var calendar = $('#calendar').fullCalendar({
        //         editable: true,
        //         header: {
        //             left: 'prev,next today',
        //             center: 'title',
        //             right: 'month,agendaWeek,agendaDay'
        //         },
        //         events: "<?= base_url(); ?>fullcalendar/load",
        //         selectable: true,
        //         selectHelper: true,
        //         select: function(start, end, allDay) {
        //             var title = prompt("Enter Event Title");
        //             if (title) {
        //                 var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
        //                 var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
        //                 $.ajax({
        //                     url: "<?= base_url(); ?>fullcalendar/insert",
        //                     type: "POST",
        //                     data: {
        //                         title: title,
        //                         start: start,
        //                         end: end
        //                     },
        //                     success: function() {
        //                         calendar.fullCalendar('refetchEvents');
        //                         alert("Added Successfully");
        //                     }
        //                 })
        //             }
        //         },
        //         editable: true,
        //         eventResize: function(event) {
        //             var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        //             var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");

        //             var title = event.title;

        //             var id = event.id;

        //             $.ajax({
        //                 url: "<?= base_url(); ?>fullcalendar/update",
        //                 type: "POST",
        //                 data: {
        //                     title: title,
        //                     start: start,
        //                     end: end,
        //                     id: id
        //                 },
        //                 success: function() {
        //                     calendar.fullCalendar('refetchEvents');
        //                     alert("Event Update");
        //                 }
        //             })
        //         },
        //         eventDrop: function(event) {
        //             var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        //             //alert(start);
        //             var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
        //             //alert(end);
        //             var title = event.title;
        //             var id = event.id;
        //             $.ajax({
        //                 url: "<?= base_url(); ?>fullcalendar/update",
        //                 type: "POST",
        //                 data: {
        //                     title: title,
        //                     start: start,
        //                     end: end,
        //                     id: id
        //                 },
        //                 success: function() {
        //                     calendar.fullCalendar('refetchEvents');
        //                     alert("Event Updated");
        //                 }
        //             })
        //         },
        //         eventClick: function(event) {
        //             if (confirm("Are you sure you want to remove it?")) {
        //                 var id = event.id;
        //                 $.ajax({
        //                     url: "<?= base_url(); ?>fullcalendar/delete",
        //                     type: "POST",
        //                     data: {
        //                         id: id
        //                     },
        //                     success: function() {
        //                         calendar.fullCalendar('refetchEvents');
        //                         alert('Event Removed');
        //                     }
        //                 })
        //             }
        //         }
        //     });

        $(document).on('click', '.view', function() {
            var kode_dokter = $(this).data('kode_dokter');
            $.ajax({
                url: "<?= site_url('jadwaldokter/fetchJadwalByDokter'); ?>",
                method: "GET",
                data: {
                    kode_dokter: kode_dokter
                },
                // dataType: "JSON",
                success: function(data) {
                    $('#calendarModal').modal();
                    $('#viewjadwal').html(data);
                }
            })
        });
    });
</script>

<!-- Page specific script -->
<script>
    $(function() {

        /* initialize the external events
         -----------------------------------------------------------------*/
        // function ini_events(ele) {
        //     ele.each(function() {

        //         // create an Event Object (https://fullcalendar.io/docs/event-object)
        //         // it doesn't need to have a start or end
        //         var eventObject = {
        //             title: $.trim($(this).text()) // use the element's text as the event title
        //         }

        //         // store the Event Object in the DOM element so we can get to it later
        //         $(this).data('eventObject', eventObject)

        //         // make the event draggable using jQuery UI
        //         $(this).draggable({
        //             zIndex: 1070,
        //             revert: true, // will cause the event to go back to its
        //             revertDuration: 0 //  original position after the drag
        //         })

        //     })
        // }

        // ini_events($('#external-events div.external-event'))

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        // var Draggable = FullCalendar.Draggable;

        // var containerEl = document.getElementById('external-events');
        // var checkbox = document.getElementById('drop-remove');
        var calendarEl = document.getElementById('calendar');

        // initialize the external events
        // -----------------------------------------------------------------

        // new Draggable(containerEl, {
        //     itemSelector: '.external-event',
        //     eventData: function(eventEl) {
        //         return {
        //             title: eventEl.innerText,
        //             backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
        //             borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
        //             textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
        //         };
        //     }
        // });

        var calendar = new Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
                // right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'bootstrap',
            selectable: true,
            dateClick: function(info) {
                var tgl_praktek = info.dateStr;
                $.ajax({
                    url: "<?= site_url('jadwaldokter/fetchJadwalByTgl'); ?>",
                    method: "GET",
                    data: {
                        tgl_praktek: tgl_praktek
                    },
                    // dataType: "JSON",
                    success: function(data) {
                        $('#calendarModal').modal();
                        $('#viewjadwal').html(data);

                    }
                })

                // $('#modalTitle').html("");
                // $('#modalBody').html(info.dateStr);
                // $('#eventUrl').attr('href', event.url);
                // jadwalPerTgl()
                // $('#calendarModal').modal();
                // alert('Clicked on: ' + info.dateStr);
                // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                // alert('Current view: ' + info.view.type);
                // change the day's background color just for fun
                // info.dayEl.style.backgroundColor = 'red';
            }
            //Random default events

        });

        calendar.render();
        $('.fa-sun').css({
            'background': 'red'
        });
        // $('#calendar').fullCalendar()



        // /* ADDING EVENTS */
        // var currColor = '#3c8dbc' //Red by default
        // // Color chooser button
        // $('#color-chooser > li > a').click(function(e) {
        //     e.preventDefault()
        //     // Save color
        //     currColor = $(this).css('color')
        //     // Add color effect to button
        //     $('#add-new-event').css({
        //         'background-color': currColor,
        //         'border-color': currColor
        //     })
        // })
        // $('#add-new-event').click(function(e) {
        //     e.preventDefault()
        //     // Get value and make sure it is not null
        //     var val = $('#new-event').val()
        //     if (val.length == 0) {
        //         return
        //     }

        //     // Create events
        //     var event = $('<div />')
        //     event.css({
        //         'background-color': currColor,
        //         'border-color': currColor,
        //         'color': '#fff'
        //     }).addClass('external-event')
        //     event.text(val)
        //     $('#external-events').prepend(event)

        //     // Add draggable funtionality
        //     ini_events(event)

        //     // Remove event from text input
        //     $('#new-event').val('')
        // })
    })
</script>

<?= $this->endSection('script'); ?>