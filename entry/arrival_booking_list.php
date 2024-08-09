<?php 
include_once('../include/header.php');

include_once ("../include/pagination_function.php");
$pg_obj = new PaginationFunction();
include('is_login.php');

if(!empty($_GET['re_checkin_id'])){
  $re_checkin_id = $_GET['re_checkin_id'];
  $result_recheckin = $obj->getDataForRecheckin($re_checkin_id, $hotel_id);
}

if(isset($_GET["page"]))
  $page = (int)$_GET["page"];
  else
  $page = 1;
  $setLimit = 50;
  $pageLimit = ($page * $setLimit) - $setLimit;
  $booking_list = $obj->getTotalArrivalBookingList($setLimit, $pageLimit, $hotel_id);
  $cir_booking_list = $obj->getTotalCirArrivalBookingList($setLimit, $pageLimit, $hotel_id);


?>

<link rel="stylesheet" href="css/pagination.css">
<style type="text/css">
.popup1{
  background-color: #fff;
  border: 1px solid #d8d8d8;
  display: inline-block;
  left: 50%;
  color: #666;
  opacity: 0;
  padding: 15px;
  position: absolute;
  text-align: justify;
  top:0%;
  visibility: hidden;
  z-index: 10000;
  -webkit-transform: translate(-50%, -50%);
  -moz-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  -o-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  -webkit-border-radius: 10px;
  -moz-border-radius: 10px;
  -ms-border-radius: 10px;
  -o-border-radius: 10px;
  border-radius: 10px;
  -webkit-transition: opacity .5s, top .5s;
  -moz-transition: opacity .5s, top .5s;
  -ms-transition: opacity .5s, top .5s;
  -o-transition: opacity .5s, top .5s;
  transition: opacity .5s, top .5s;
}
.overlay:target+.popup1 {
  top: 90%;
  opacity: 1;
  visibility: visible;width:70%;
}
.popup1 h4{text-align:center;margin-top:30px;}
.popup1 h4 a{background:#f34343;padding:7px 20px;color:#fff;border-radius:4px;-moz-border-radius:4px;}
.popup1 h4 a:hover{background:#132fa4;text-decoration:none;}

</style>
<!-- Tab style-->
<style>
/* Style the tab */
div.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
div.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
#Active{
  display: block;
}

</style>

<!-- Paginator css-->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-datepicker.css" rel="stylesheet" media="screen">
<link href="css/bootstrap-datepaginator.css" rel="stylesheet" media="screen">

<!--end Paginator css-->

<div id="tablewrapper">
  <div id="tableheader">
    <form class="form-horizontal" name="search" role="form" method="POST" onkeypress="return event.keyCode != 13;">
      <div class="search">
        <input id="name" name="name" type="text" placeholder="Search by Booking Id" autocomplete="off"/>
        <button id="search_gks" type="button" class="btn btn-default" style="padding-top: 10px;padding-bottom: 9px;border: #499f4d 1px solid;background-color:#499f4d!important;border-radius: 0px;">
          <span class="glyphicon glyphicon-search"></span> Search
        </button>
        <img class="modallodar1" style="display: none" alt="" src="images/ajax-loader-search.gif" />
      </div>
    </form>
    <div class="tab">
      <button class="tablinks Active" onclick="openCity(event, 'Active')">Arrival Booking</button>
      <button class="tablinks Inactive" onclick="openCity(event, 'Inactive')">CIR Arrival Booking</button>
    </div>

    <!--<span class="details">
      <div id='loadingmessage' style="display: none;">
        <img src='ajax-loader.gif'/>
      </div>
      <div ><a class="button blue" href="download_data.php?type=allbooking">Download Full Data</a></div>
      <div ><a class="button blue" href="download_data.php?type=booking">Download Daily Data</a></div>
    </span>-->
  </div>
<!--Paginator html-->
<br/>
<div class="row">
  <div class="col-lg-1 col-md-1 col-sm-1"></div>
  <div class="col-lg-10 col-md-10 col-sm-10">
    <div id="paginator"></div>
    <div class="loader text-center" style="display: none;">
      <img src="ajax-loader.gif">
    </div>
  </div>
  <div class="col-lg-1 col-md-1 col-sm-1"></div>

</div>

<br/>
<div id="show_data"></div>

<div class="modallodar" style="display: none">
    <div class="center">
        <img alt="" src="ajax-loader1.gif" />
    </div>
</div>
<div id="tablesearch_top">
  <div id="Active" class="tabcontent">
    <section>
      <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
        <thead>
           <tr>
            <th><h5>S. N.</h5></th>
            <th><h5>ID</h5></th>
            <th><h5>Name</h5></th>
            <th><h5>Email / Phone</h5></th>
            <th><h5>Guest</h5></th>
            <th><h5>Room</h5></th>
            <th><h5>Country</h5></th>
            <th><h5>Room Category</h5></th>
            <th><h5>Booking Mode</h5></th>
            <th><h5>Amount</h5></th>
            <th><h5>Company</h5></th>
            <th><h5>Nights</h5></th>
            <th><h5>Checkin</h5></th>
            <th><h5>Checkout</h5></th>
            <th><h5>Booking Date</h5></th>
            <th><h5>&nbsp;</h5></th>
            <th><h5>&nbsp;</h5></th>
           
          </tr>
        </thead>
        <tbody>
          <?php
          //$count = count($booking_list);
          if(!empty($booking_list)){ 
            //for ($i=0; $i <$count ; $i++) { 
            $i=1;
              foreach ($booking_list as $booking) { 
                $date1 = $booking['checkin_date'];
                $date2 = $booking['checkout_date'];
                $date1 = DateTime::createFromFormat('d/m/Y', $date1);
                $date2 = DateTime::createFromFormat('d/m/Y', $date2);

                $ci_date = $date1->format('Y-m-d');
                $co_date = $date2->format('Y-m-d');

                $diff = abs(strtotime($co_date) - strtotime($ci_date));
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                
                $party_id = $booking['booking_via'];
                $company = $obj->getCompanyName($party_id,$hotel_id);

            ?>
            <tr>
              <td class="name" style="width:30px;overflow:hidden;"><?php echo $i++;?></td>
              <td class="name" style="width:10px;overflow:hidden;" ><?php echo $booking['booking_id'];?></td>
              <?php if($booking['pickup'] == 'Yes'){ ?>
              <td class="name"  style="width:150px;overflow:hidden;background-color:#EED7C1;"><?php echo $booking['guest_name'];?></td>
              <?php } else { ?>
              <td class="name"  style="width:150px;overflow:hidden;"><?php echo $booking['guest_name'];?></td>
              <?php } ?> 
              
              <td class="name" style="width:200px;overflow:hidden;"><a href="#" class="button-email" id="<?php echo $booking['guest_email'];?>" title="<?php echo $booking['guest_email'];?>"><?php echo $booking['guest_email'];?></a><br><?php echo $booking['guest_phone'];?></td>
              <td class="name" style="width:20px;overflow:hidden;"><?php echo $booking['no_of_guest'];?></td>
              <td class="name" style="width:20px;overflow:hidden;"><?php echo $booking['noof_room'];?></td>
              <td class="name" style="width:25px;overflow:hidden;"><?php echo $booking['country'] ;?></td>
              <td class="name" style="width:85px;overflow:hidden;"><?php echo $booking['room_category'];?></td>
              <td class="name"  style="width:80px;overflow:hidden;"><?php echo $booking['booking_mode'];?></td>
              <td class="name"  style="width:35px;overflow:hidden;"><?php echo $booking['room_charge'];?></td>
              <td class="name" style="width:60px;overflow:hidden;"><?php echo $company['name'];?></td>
              <td class="name" style="width:60px;overflow:hidden;"><?php echo $days;?></td>

              <?php if(isset($booking['checkin_date']) && $booking['checkin_date'] == CURR_DATE && $booking['booking_status'] != 'checkedin'){ ?>
              <td class="name" style="width:60px;overflow:hidden;background-color:#FF4646!important;color:#ffffff!important;"><?php echo $booking['checkin_date'];?></td>
              <?php } elseif(!empty($booking['booking_status']) && $booking['booking_status'] == 'checkedin') { ?>
              <td class="name" style="width:60px;overflow:hidden;background-color:#499f4d!important;color:#ffffff!important;"><?php echo $booking['checkin_date'];?></td>
              <?php } else { ?>
              <td class="name" style="width:60px;overflow:hidden;"><?php echo $booking['checkin_date'];?></td>
              <?php } ?>

              <td class="name" style="width:60px;overflow:hidden;"><?php echo $booking['checkout_date'];?></td>
              <td class="name" style="width:80px;overflow:hidden;"><?php echo $booking['inserted_date'];?></td>
              <td class="name" style="width:10px;overflow:hidden;"><a href="view_arrival_booking_list.php?arrival_b_id=<?php echo $booking['arrival_b_id'];?>" class="btn">View</a></td>
              <!--<td class="name"><a href="#checkin" data-toggle="modalcheckin"  id="<?php //echo $booking['arrival_b_id'];?>" class="btn">Checkin</a></td>-->
              
              <?php if(!empty($booking['booking_status']) && $booking['booking_status'] == 'confirmed'){ ?>
              <td class="name" style="width:20px;overflow:hidden!important;">
                <a style="color:#fff!important;background-color:#ECBC0D!important;width:99px;"  href="#empty" data-toggle="modal_quick_checkin" id="<?php echo $booking['arrival_b_id'];?>" class="btn">Check-In</a>
              </td>
              <?php } if(!empty($booking['booking_status']) && $booking['booking_status'] == 'checkedin'){ ?>
              <td class="name" style="width:10px;overflow:hidden!important;">
                <a style="" class="btn">Checked-In</a>
              </td>
              <?php } if (!empty($booking['booking_status']) && $booking['booking_status'] == 'cancelled') { ?>
              <td class="name" style="width:10px;overflow:hidden!important;">
                <a class="rejected_booking" style="width:99px;">Cancelled</a>
              </td>
              <?php } if (!empty($booking['booking_status']) && $booking['booking_status'] == 'transfered') { ?>
              <td class="name" style="width:10px;overflow:hidden!important;">
                <a class="rejected_booking" style="width:99px;">Transferred</a>
              </td>
              <?php } ?>
            </tr>
          <?php } } else { ?>
            <tr>
              <td colspan="16" style="color:#31708F;"><h3>No record found.</h3></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </section>
  </div>
  <div id="Inactive" class="tabcontent">
    <section>
      <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
        <thead>
           <tr>
            <th><h5>S. N.</h5></th>
            <th><h5>CIR Booking ID</h5></th>
            <th><h5>Booking ID</h5></th>
            <th><h5>Name</h5></th>
            <th><h5>Email / Phone</h5></th>
            <th><h5>Guest</h5></th>
            <th><h5>Room</h5></th>
            <th><h5>Room Category</h5></th>
            <th><h5>Booking Mode</h5></th>
            <th><h5>Amount</h5></th>
            <th><h5>Company</h5></th>
            <th><h5>Nights</h5></th>
            <th><h5>Checkin</h5></th>
            <th><h5>Checkout</h5></th>
            <th><h5>Booking Date</h5></th>
            <th><h5>&nbsp;</h5></th>
            <th><h5>&nbsp;</h5></th>
            <th><h5>&nbsp;</h5></th>
           
          </tr>
        </thead>
        <tbody>
          <?php
          //$count = count($booking_list);
          if(!empty($cir_booking_list)){ 
            //for ($i=0; $i <$count ; $i++) { 
            $i=1;
              foreach ($cir_booking_list as $booking) { 
                $date1 = $booking['checkin_date'];
                $date2 = $booking['checkout_date'];
                $date1 = DateTime::createFromFormat('d/m/Y', $date1);
                $date2 = DateTime::createFromFormat('d/m/Y', $date2);

                $ci_date = $date1->format('Y-m-d');
                $co_date = $date2->format('Y-m-d');

                $diff = abs(strtotime($co_date) - strtotime($ci_date));
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                
                $party_id = $booking['booking_via'];
                $company = $obj->getCompanyName($party_id,$hotel_id);

            ?>
            <tr>
              <td class="name" style="width:30px;overflow:hidden;"><?php echo $i++;?></td>
              <td class="name" style="width:10px;overflow:hidden;" ><?php echo $booking['booking_id1'];?></td>
              <td class="name" style="width:10px;overflow:hidden;" ><?php echo $booking['booking_id2'];?></td>
              <?php if($booking['pickup'] == 'Yes'){ ?>
              <td class="name"  style="width:150px;overflow:hidden;background-color:#EED7C1;"><?php echo $booking['guest_name'];?></td>
              <?php } else { ?>
              <td class="name"  style="width:150px;overflow:hidden;"><?php echo $booking['guest_name'];?></td>
              <?php } ?> 
              
              <td class="name" style="width:200px;overflow:hidden;"><a href="#" class="button-email" id="<?php echo $booking['guest_email'];?>" title="<?php echo $booking['guest_email'];?>"><?php echo $booking['guest_email'];?></a><br><?php echo $booking['guest_phone'];?></td>
              <td class="name" style="width:20px;overflow:hidden;"><?php echo $booking['no_of_adults'];?></td>
              <td class="name" style="width:20px;overflow:hidden;"><?php echo $booking['no_of_rooms'];?></td>
              <td class="name" style="width:85px;overflow:hidden;"><?php echo $booking['room_category'];?></td>
              <td class="name"  style="width:80px;overflow:hidden;">Pay At Hotel</td>
              <td class="name"  style="width:35px;overflow:hidden;"><?php echo $booking['room_charge'];?></td>
              <td class="name" style="width:60px;overflow:hidden;"><?php echo $company['name'];?></td>
              <td class="name" style="width:60px;overflow:hidden;"><?php echo $days;?></td>

              <?php if(isset($booking['checkin_date']) && $booking['checkin_date'] == CURR_DATE && $booking['booking_status'] != 'checkedin'){ ?>
              <td class="name" style="width:60px;overflow:hidden;background-color:#FF4646!important;color:#ffffff!important;"><?php echo $booking['checkin_date'];?></td>
              <?php } elseif(!empty($booking['booking_status']) && $booking['booking_status'] == 'checkedin') { ?>
              <td class="name" style="width:60px;overflow:hidden;background-color:#499f4d!important;color:#ffffff!important;"><?php echo $booking['checkin_date'];?></td>
              <?php } else { ?>
              <td class="name" style="width:60px;overflow:hidden;"><?php echo $booking['checkin_date'];?></td>
              <?php } ?>

              <td class="name" style="width:60px;overflow:hidden;"><?php echo $booking['checkout_date'];?></td>
              <td class="name" style="width:80px;overflow:hidden;"><?php echo $booking['inserted_date'];?></td>
              <td class="name" style="width:10px;overflow:hidden;"><a href="view_arrival_booking_list.php?arrival_b_id=<?php echo $booking['offlineb_id'];?>" class="btn">View</a></td>
              <td class="name" style="width:10px;overflow:hidden;"><a href="javascript:void(0);" class="btn send-voucher" id="<?php echo $booking['offlineb_id'];?>">Send Voucher</a></td>
              <!--<td class="name"><a href="#checkin" data-toggle="modalcheckin"  id="<?php //echo $booking['arrival_b_id'];?>" class="btn">Checkin</a></td>-->
              
              <?php if(!empty($booking['booking_status']) && $booking['booking_status'] == 'confirmed'){ ?>
              <td class="name" style="width:20px;overflow:hidden!important;">
                <a style="color:#fff!important;background-color:#ECBC0D!important;width:99px;"  href="#empty" data-toggle="modal_quick_checkin" id="<?php echo $booking['offlineb_id'];?>" class="btn">Check-In</a>
              </td>
              <?php } if(!empty($booking['booking_status']) && $booking['booking_status'] == 'checkedin'){ ?>
              <td class="name" style="width:10px;overflow:hidden!important;">
                <a style="" class="btn">Checked-In</a>
              </td>
              <?php } if (!empty($booking['booking_status']) && $booking['booking_status'] == 'cancelled') { ?>
              <td class="name" style="width:10px;overflow:hidden!important;">
                <a class="rejected_booking" style="width:99px;">Cancelled</a>
              </td>
              <?php } if (!empty($booking['booking_status']) && $booking['booking_status'] == 'transfered') { ?>
              <td class="name" style="width:10px;overflow:hidden!important;">
                <a class="rejected_booking" style="width:99px;">Transferred</a>
              </td>
              <?php } ?>
            </tr>
          <?php } } else { ?>
            <tr>
              <td colspan="16" style="color:#31708F;"><h3>No record found.</h3></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </section>
  </div>
<?php
  // Call the Pagination Function to load Pagination.
  echo $pg_obj->displayBookingListPagination($setLimit, $page, $hotel_id);
?>
</div>
<div id="tablesearch">
<section>
  <table cellpadding="0" cellspacing="0" border="0" id="resultTable" class="tinytable">
    <thead>
      <tr>
        <th><h5>S. N.</h5></th>
        <th><h3>ID</h3></th>
        <th><h3>Name</h3></th>
        <th><h3>Email</h3></th>
        <th><h3>N. Of Guest</h3></th>
        <th><h3>N. Of Room</h3></th>
        <th><h3>Country</h3></th>
        <th><h3>Room Category</h3></th>
        <th><h3>Booking Mode</h3></th>
        <th><h3>Amount</h3></th>
        <th><h5>Company</h5></th>
        <th><h5>Nights</h5></th>
        <th><h3>Checkin Date</h3></th>
        <th><h3>Checkout Date</h3></th>
        <th><h3>Booking Date</h3></th>
        <th><h3>&nbsp;</h3></th>
        <th><h3>&nbsp;</h3></th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</section>
</div>
<p>&nbsp;</p>
</div>

<!--Arrival list chekin Modal -->
<a href="#x" class="overlay" id="empty"></a>
<div class="popup1"> 
  
</div>

<?php include_once('../include/footer.php');?> 
<script src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/save_entry_fromdata.js"></script>

<script type="text/javascript">

  $('a[data-toggle="modal_quick_checkin"]').click(function(){
    var arrival_b_id = $(this).attr('id');
    $.ajax({
      url : 'quick_check_in.php?arrival_b_id='+arrival_b_id,
      success:function(data){
        $(".popup1").show().html(data);
      }
    });
  });

</script>
<script type="text/javascript">
  $("a[href='##']").click(function(){
    var booking_id = $(this).attr('title');
    $.ajax({
      url : "process.php?type=arrival_booking_check_status&booking_id="+booking_id,
      success:function(data){
        if(data == 0){
          $("#confirm"+booking_id).replaceWith('<img src="images/icona_ok_v.png" titel="confirmation image" width="40px" height="30px">');
        }else{
          
        }
      }
    });
  });
</script>
<!--<script type="text/javascript">
$(document).ready(function () {
  $('.button-email').click(function (e) { // Button which will activate our modal
    var title = $(this).attr('title');
    var title2 = $('.name').attr('title');
    document.getElementById("email").innerHTML = title.toString();
      $('#modal').reveal({ // The item which will be opened with reveal
          animation: 'fade',                   // fade, fadeAndPop, none
          animationspeed: 600,                       // how fast animtions are
          closeonbackgroundclick: true,              // if you click background will modal close?
          dismissmodalclass: 'close'    // the class of a button or element that will close an open modal
        });
      return false;
    });
});
</script> -->

<script type="text/javascript">

  $(document).ready(function() {  
    $("#tablesearch").hide();
    // Search
    $("#search_gks").on('click',function(){
      var query_value = $('input#name').val();
      if(query_value !== ''){
        $.ajax({
          type: "POST",
          url: "searching_arrival_booking.php",
          data: { query: query_value },
          cache: false,
          beforeSend: function () {
             $(".modallodar1").show();
          },
          success: function(html){
            $(".modallodar1").hide();
            $("table#resultTable tbody").html(html);
            $("#tablesearch_top").hide();
            $("#tablesearch").show();
          }
        });
      }return false;
    });

    $("input#name").on("keyup", function(e) {
      var search_string = $(this).val();
      // Do Search
      if (search_string == '') {
        $("#tablesearch_top").show();
        $("#tablesearch").hide();
      }
    });
  });    
</script>
<script type="text/javascript">
  $(".hotel").change(function(event){
    event.preventDefault();
    var hotel_id = $(this).attr("value");
    $.ajax({
      url : "hotel_based_arrival_booking_list.php?type=Save_hotel_id_in_session&hotel_id="+hotel_id,
      async: false,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {
         $(".modallodar").show();
      },
      success:function(data){
        $(".modallodar").hide();
        $("#tablesearch_top").hide();
        $("#tablesearch").hide();
        $("#show_data").show().html(data);
      }
    });
  });
</script>
  <script>
  $(document).ready(function () {

    $("#checkin").datepicker({ minDate: "01/07/2012", maxDate: "01/30/2012" });

    $("#checkout").datepicker({ beforeShow: setminDate });

    var start1 = $('#checkin');      
    function setminDate() {          
      var p = start1.datepicker('getDate');          
      if (p) { 
        var k ="01/30/2012";            
        return {
          minDate: p,
          maxDate:k
        }};         
      }           
      function clearEndDate(dateText, inst) {          
        end1.val('');      
      }  
    });
  $(function() {
    $( "#checkout" ).datepicker({ dateFormat: 'mm/dd/yyyy' });
    $( "#checkin" ).datepicker({ dateFormat: 'mm/dd/yyyy' });
  });
  $('#nights').click(function() {
    var start = $('#checkin').datepicker('getDate');
    var end   = $('#checkout').datepicker('getDate');
    var days   = (end - start)/1000/60/60/24;
    $("#nights").val(days);
  });
  </script>

<!-- Paginator js-->
  <script type="text/javascript" src="js/moment.min.js"></script>
  <script type="text/javascript" src="js/bootstrap-datepaginator.js"></script>
   <script type="text/javascript">
    $(window).ready(function(event){
      var d1 = new Date();
      var month = d1.getMonth()+1;
      var day = d1.getDate();
      var output = d1.getFullYear() + '-' +
          ((''+month).length<2 ? '0' : '') + month + '-' +
          ((''+day).length<2 ? '0' : '') + day;

      var options = {
        selectedDate: output,
        onSelectedDateChanged: function(event, date) {
          var d = new Date(date);
          var date1 = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate();
          $('.loader').show();
          $.get('date_paginator.php?date='+date1,function(data){
            $('table#resultTable tbody').show().html(data);
            $("#tablesearch_top").hide();
            $("#tablesearch").show();
            $('.loader').hide();
          });
          
        }
      }
      $('#paginator').datepaginator(options);
    });

  </script>
  <script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
        $(".Active").css("background-color","");
    }

    $(window).load(function(){
      $(".Active").css("background-color","#ccc");
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".send-voucher").on('click', function(){
        var id = $(this).attr('id');
        
        if(id){
          $.ajax({
            url : "send-voucher.php?id="+id,
            type : "POST",
            success:function(res){
              if(res == "sucess"){
                alert(res);
                $(".send-voucher").replaceWith('<a href="javascript:void(0);" class="btn send-voucher">SENT</a>');
              }else{
                alert(res);
              }
            }
          });
        }
      });
    });
  </script>
<!-- end Paginator js-->

<!--<script type="text/javascript" src="js/arrival_trigers.js"></script>-->
<script>

$(document).ready(function(){var touch=$('#touch-menu');var menu=$('.menu');$(touch).on('click',function(e){e.preventDefault();menu.slideToggle();});$(window).resize(function(){var w=$(window).width();if(w>767&&menu.is(':hidden')){menu.removeAttr('style');}});});

</script>

</body>

</html>