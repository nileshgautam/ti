<script type="text/javascript">
  var startDate,
    endDate;

  $('#weekpicker').datepicker({
    autoclose: true,
    format: 'mm/dd/yyyy',
    forceParse: false,
    calendarWeeks: true
  }).on("changeDate", function(e) {
    //console.log(e.date);
    var date = e.date;

    startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 1);
    endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 7);
    //$('#weekpicker').datepicker("setDate", startDate);

    $('#weekpicker').datepicker('update', startDate);
    $('#weekpicker').val((startDate.getMonth() + 1) + '/' + startDate.getDate() + '/' + startDate.getFullYear() + ' - ' + (endDate.getMonth() + 1) + '/' + endDate.getDate() + '/' + endDate.getFullYear());

  });

  //new
  $('#prevWeek').click(function(e) {
    var date = $('#weekpicker').datepicker('getDate');
    //dateFormat = "mm/dd/yy"; //$.datepicker._defaults.dateFormat;
    startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() - 7);
    endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() - 1);
    $('#weekpicker').datepicker("setDate", new Date(startDate));
    $('#weekpicker').val((startDate.getMonth() + 1) + '/' + startDate.getDate() + '/' + startDate.getFullYear() + ' - ' + (endDate.getMonth() + 1) + '/' + endDate.getDate() + '/' + endDate.getFullYear());

    return false;
  });

  $('#nextWeek').click(function() {
    var date = $('#weekpicker').datepicker('getDate');
    //dateFormat = "mm/dd/yy"; // $.datepicker._defaults.dateFormat;
    startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 7);
    endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 13);
    $('#weekpicker').datepicker("setDate", new Date(startDate));
    $('#weekpicker').val((startDate.getMonth() + 1) + '/' + startDate.getDate() + '/' + startDate.getFullYear() + ' - ' + (endDate.getMonth() + 1) + '/' + endDate.getDate() + '/' + endDate.getFullYear());

    return false;
  });

  $("#getData").click(function() {
    var date = $("#weekpicker").val();
    var fullDateString = date;
    if (date != "") {
      date = date.split("-");
      var startDate = $.trim(date[0]);
      var endDate = $.trim(date[1]);

      var previousDate = new Date(startDate);
      previousDate.setDate(previousDate.getDate() - 1);

      var dateString = previousDate.getFullYear() + "-" + previousDate.getMonth() + 1 + "-" + previousDate.getDate();

      window.location = "<?php echo base_url(); ?>Manager/allUser/<?php echo base64_encode(+1); ?>/" + btoa(dateString);
    }
  });

  $(".timesheet").click(function() {

    var date = $("#weekpicker").val();
    if (date != "") {
      console.log(date);
      date = date.split("-");
      var startDate = $.trim(date[0]);
      var endDate = $.trim(date[1]);

      console.log(startDate);

      console.log(endDate);

      var userId = btoa($(this).attr('id'));
      var previousDate = new Date(startDate);

      // console.log('prev month: '+previousDate.getMonth());
      // console.log('prev month: '+previousDate);

      previousDate.setDate(previousDate.getDate() - 1);
   
      var newDate = "0" + previousDate.getDate();

      newDate = newDate.slice(-2);
     
      var dateString = previousDate.getFullYear() + "-" + (parseInt(previousDate.getMonth()) + 1) + "-" + newDate;

      // console.log('prev date: '+previousDate.getMonth());

      // alert(dateString);

      var href =  "<?php echo base_url(); ?>Manager/userTimesheet/"+userId+"/"+btoa(+1)+"/"+btoa(dateString);

      window.location = href;
    }

  });
</script>