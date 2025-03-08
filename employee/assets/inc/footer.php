
<footer>
    <div class="copyright">
        copyright &copy; 2022. all right reserved.
    </div>
</footer>

</main>


<!-- important -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/simplebar.min.js"></script>
<script src="assets/js/apps.js"></script>
<script src="assets/js/preloader.js"></script>
<!-- jquery cdn -->
<script src="assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<!-- bootstrap bundle -->
<script src="assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<!-- database table js cdn -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(document).ready( function () {
    $('#myTable').DataTable();
  });
</script>
<!-- sweetalert or show alert js cdn -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php 
if(isset($_SESSION['status']) && $_SESSION['status'] !=''){
  ?>
    <script>
      swal({
        title: '<?php echo $_SESSION['status']; ?>',
        //text: "You clicked the button!",
        icon: '<?php echo $_SESSION['status_code']; ?>',
        button: 'Ok',
      });
    </script>
  <?php
  unset($_SESSION['status']);
}
?>

<!-- summer note js cdn -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $(".mySummernote").summernote({
          height: 250
        });
        $('.dropdown-toggle').dropdown();
    });
</script>

<!-- calendar event -->
<script src="assets/js/evo-calendar.min.js"></script>

<script>
  // Initialize evo-calendar in your script file or an inline <script> tag
$(document).ready(function() {
    $('#calendar').evoCalendar({
        theme: 'Royal Navy',


        calendarEvents: [
        {
          id: 'event1', // Event's ID (required)
          name: "Velentines Day", // Event name (required)
          date: "February/14/2025", // Event date (required)
          description:'Valentines Day is a celebration of love, and a reminder that love comes in all forms: friendship, family, kindness to others, and yes, even self-love.',
          type: "holiday", // Event type (required)
          everyYear: true // Same event every year (optional)
        },
        {
          id: 'event2', // Event's ID (required)
          name: "Capstone Defense", // Event name (required)
          date: "March/02/2025", // Event date (required)
          description:'Start Capstone Defense',
          type: "holiday", // Event type (required)
          everyYear: true // Same event every year (optional)
        },





        {
          name: "Vacation Leave",
          badge: "02/13 - 02/15", // Event badge (optional)
          date: ["February/20/2025", "February/28/2025"], // Date range
          description: "Vacation leave for 9 days.", // Event description (optional)
          type: "event",
          color: "#63d867" // Event custom color (optional)
        }
      ]


    })
})
</script>








<!-- Include jQuery -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src='assets/js/daterangepicker.js'></script>
<script src='assets/js/jquery.stickOnScroll.js'></script>
<script src="assets/js/tinycolor-min.js"></script>
<script src="assets/js/d3.min.js"></script>
<script src="assets/js/topojson.min.js"></script>
<script src="assets/js/Chart.min.js"></script>
<script src="assets/js/gauge.min.js"></script>
<script src="assets/js/jquery.sparkline.min.js"></script>
<script src="assets/js/apexcharts.min.js"></script>
<script src="assets/js/apexcharts.custom.js"></script>
<script src='assets/js/jquery.mask.min.js'></script>
<script src='assets/js/select2.min.js'></script>
<script src='assets/js/jquery.steps.min.js'></script>
<script src='assets/js/jquery.validate.min.js'></script>
<script src='assets/js/jquery.timepicker.js'></script>
<script src='assets/js/dropzone.min.js'></script>
<script src='assets/js/uppy.min.js'></script>
<script src='assets/js/quill.min.js'></script>
<script src='assets/js/jquery.dataTables.min.js'></script>
<script src='assets/js/dataTables.bootstrap4.min.js'></script>








<script src="../employee/assets/js/html5-qrcode.min.js"></script>
<!--<script src="../employee/assets/js/admin-script.js"></script>-->





</body>

</html>