<?php
include('../include/header2.php');
include('is_login.php');
// print_r($_COOKIE);
// echo $_COOKIE['full_name'];die;
$ground = $obj->getGroundFloorRoom($hotel_id);

$floor1 = $obj->getFirstFloorRoom($hotel_id);

$floor2 = $obj->getFirstSecondRoom($hotel_id);

$floor3 = $obj->getFirstThirdRoom($hotel_id);

$floor4 = $obj->getFirstFounthRoom($hotel_id);

$room_booked_count = $obj->getNumberOfBookedRoom($hotel_id);
$room_empty_count = $obj->getNumberOfEmptyRoom($hotel_id);
$room_clean_count = $obj->getNumberOfCleaningRoom($hotel_id);

$yesterday_booking = $obj->getYesterdayArrivalBooking($hotel_id);
$today_arrival_booking = $obj->getTodayArrivalBooking($hotel_id);
$tomorrow_arrival_booking = $obj->getTomorrowArrivalBooking($hotel_id);
$today_checkedin = $obj->getTodayCheckedin($hotel_id);

$emplyee_details = $obj->getEmployeeDetails($hotel_id);


$msg = "";

if (isset($_GET['room_status'])) {
	$room_status = $_GET['room_status'];
	$room_number = $_GET['room_number'];
	$update = $obj->updateRoomStatus($room_status, $room_number, $hotel_id);

	if ($update == "success") {
		die("<script>location.href = 'room_view.php'</script>");
	} else {
		$msg = "Error to updating room status.";
	}
}

if (isset($_GET['checkin_id'])) {
	$checkin_id = $_GET['checkin_id'];
	$room_number = $_GET['room_number'];
	$update = $obj->updateCheckoutFinal($checkin_id, $room_number, $hotel_id);
	if ($update == "success")
		die("<script>location.href = 'room_view.php'</script>");
	else
		$msg = "Error to updataing room status";
}
/*$alert = $obj->getAlertMessage($hotel_id);

if(isset($alert['message'])){
	echo "hi";
}else{
	echo "hello";
	$sss = $obj->sendSoldOutAlertEmail($hotel_id);
	//echo $ss
}*/

?>
<link rel="stylesheet" href="css/style.min.css">
<style type="text/css">
	.blink-text {
		animation-duration: 1200ms;
		animation-name: blink;
		animation-iteration-count: infinite;
		animation-direction: alternate;
		-webkit-animation: blink 1200ms infinite;
		/* Safari and Chrome */

		/*font-size: 20px!important;*/
	}

	@keyframes blink {
		from {
			color: yellow;
		}

		to {
			color: #33B530;
		}
	}

	@-webkit-keyframes blink {
		from {
			color: yellow;
		}

		to {
			color: #33B530;
		}
	}

	.size {
		font-size: 12px !important;
		color: #667480 !important;
	}

	.email {
		text-transform: lowercase;
	}

	/*Div blink css */
	.backgroundRed {
		background: #428BCA;
	}

	.divtoBlink {
		-webkit-transition: background 1.0s ease-in-out;
		-ms-transition: background 1.0s ease-in-out;
		transition: background 1.0s ease-in-out;
	}
</style>
<style type="text/css">
	#fname,
	#nextlocation,
	#lastlocation {
		text-transform: capitalize;
	}
</style>
<div class="col-md-3">
	<div class="o-section">
		<div id="tabs" class="c-tabs no-js">
			<div class="c-tabs-nav">

				<a href="#" class="c-tabs-nav__link is-active">
					<span style="font-size: 13px!important;">Today&nbsp;(&nbsp;<?php $today = count($today_arrival_booking);
																																			echo $today; ?>&nbsp;)</span>
				</a>
				<a href="#" class="c-tabs-nav__link">
					<span style="font-size: 13px!important;">Tomorrow&nbsp;(&nbsp;<?php $tomorrow = count($tomorrow_arrival_booking);
																																				echo $tomorrow; ?>&nbsp;)</span>
				</a>
				<a href="#" class="c-tabs-nav__link">
					<span style="font-size: 13px!important;">Yesterday&nbsp;(&nbsp;<?php $yesterday = count($yesterday_booking);
																																					echo $yesterday; ?>&nbsp;)</span>
				</a>
			</div>


			<div class="c-tab is-active">
				<div class="c-tab__content scrollbar" id="style-2">

					<?php foreach ($today_arrival_booking as $t_a_booking) { ?>
						<!--<a class="widget-list-link">-->
						<a style="text-decoration: none;" href="#empty" class="widget-list-link" data-toggle="modal_quick_checkin" id="<?php echo $t_a_booking['arrival_b_id']; ?>" class="btn">
							<h5 style="color: #dc446e!important;"><?php echo $t_a_booking['guest_name']; ?>
								<?php if ($t_a_booking['booking_mode'] == "Pay at hotel") { ?>
									<span style="padding:5px 5px 5px 5px;color:green;background-color:yellow;float:right;">Pay at Hotel</span>
								<?php } ?>
							</h5>
							<h5 style="color: #dc446e!important;"><b>No. of Room :-</b> <?php echo $t_a_booking['noof_room']; ?></h5>
							<span class="size"><b>BookingID :-</b> <?php echo $t_a_booking['booking_id']; ?></span><br>
							<span class="size"><b>Company :-</b> <?php echo $t_a_booking['compnay_name']; ?></span><br>
							<span class="size email"><b>Email:-</b> <?php echo $t_a_booking['guest_email']; ?></span><br>
							<span class="size"><b>Contact No:-</b> <?php echo $t_a_booking['guest_phone']; ?></span><br>
							<span class="size"><b>Room Category:-</b> <?php echo $t_a_booking['room_category']; ?></span><br>
							<span class="size"><b>Checkin Date:-</b> <?php echo date('d M, Y', strtotime(str_replace('/', '-', $t_a_booking['checkin_date']))); ?></span><br>
							<span class="size"><b>Checkout Date:-</b> <?php echo date('d M, Y', strtotime(str_replace('/', '-', $t_a_booking['checkout_date']))); ?></span><br>
							<?php if (!empty($t_a_booking['ex_ch_time'])) { ?>
								<span class="size"><b style="color: green;"><b>Expected Checkin Time-</b> <?php echo $t_a_booking['ex_ch_time']; ?></b><br>
								<?php } ?>
								<?php if ($t_a_booking['h_tax'] > 0) { ?>
									<span class="size"><b style="color: green;"><b>GST Tax:-</b> <?php echo $t_a_booking['h_tax']; ?></b>
									<?php  } ?>
						</a>
						<hr style="border:1px dotted #428BCA">
					<?php } ?>
				</div>
			</div>
			<div class="c-tab">
				<div class="c-tab__content">
					<?php foreach ($tomorrow_arrival_booking as $tom_a_booking) { ?>
						<a class="widget-list-link" style="text-decoration: none;">
							<h5 style="color: #dc446e!important;"><?php echo $tom_a_booking['guest_name']; ?>
								<?php if ($tom_a_booking['booking_mode'] == "Pay at hotel") { ?>
									<span style="padding:5px 5px 5px 5px;color:green;background-color:yellow;float:right;">Pay at Hotel</span>
								<?php } ?>
							</h5>
							<h5 style="color: #dc446e!important;"><b>No. of Room :-</b> <?php echo $tom_a_booking['noof_room']; ?></h5>
							<span class="size"><b>BookingID :-</b> <?php echo $tom_a_booking['booking_id']; ?></span></br>
							<span class="size"><b>Company :-</b> <?php echo $tom_a_booking['compnay_name']; ?></span><br>
							<span class="size"><b>Email:-</b> <?php echo $tom_a_booking['guest_email']; ?></span></br>
							<span class="size"><b>Contact No:-</b> <?php echo $tom_a_booking['guest_phone']; ?></span></br>
							<span class="size"><b>Room Category:-</b> <?php echo $tom_a_booking['room_category']; ?></span><br>
							<span class="size"><b>Checkin Date:-</b> <?php echo date('d M, Y', strtotime(str_replace('/', '-', $tom_a_booking['checkin_date']))); ?></span><br>
							<span class="size"><b>Checkout Date:-</b> <?php echo date('d M, Y', strtotime(str_replace('/', '-', $tom_a_booking['checkout_date']))); ?></span>

						</a>
						<hr>
					<?php } ?>
				</div>
			</div>
			<div class="c-tab">
				<div class="c-tab__content">
					<?php foreach ($yesterday_booking as $yesterday_book) { ?>
						<a class="widget-list-link" style="text-decoration: none;">
							<h5 style="color: #dc446e!important;"><?php echo $yesterday_book['guest_name']; ?>
								<?php if ($yesterday_book['booking_mode'] == "Pay at hotel") { ?>
									<span style="padding:5px 5px 5px 5px;color:green;background-color:yellow;float:right;">Pay at Hotel</span>
								<?php } ?>
							</h5>
							<h5 style="color: #dc446e!important;"><b>No. of Room :-</b> <?php echo $yesterday_book['noof_room']; ?></h5>
							<span class="size"><b>BookingID :-</b> <?php echo $yesterday_book['booking_id']; ?></span></br>
							<span class="size"><b>Company :-</b> <?php echo $yesterday_book['compnay_name']; ?></span><br>
							<span class="size"><b>Email:-</b> <?php echo $yesterday_book['guest_email']; ?></span></br>
							<span class="size"><b>Contact No:-</b> <?php echo $yesterday_book['guest_phone']; ?></span></br>
							<span class="size"><b>Room Category:-</b> <?php echo $yesterday_book['room_category']; ?></span><br>
							<span class="size"><b>Checkin Date:-</b> <?php echo date('d M, Y', strtotime(str_replace('/', '-', $yesterday_book['checkin_date']))); ?></span><br>
							<span class="size"><b>Checkout Date:-</b> <?php echo date('d M, Y', strtotime(str_replace('/', '-', $yesterday_book['checkout_date']))); ?></span>
						</a>
						<hr>
					<?php } ?>
				</div>
			</div>

		</div>
	</div>
</div>
<div class="col-md-7" style="margin-top:30px;">
	<div id="erro_ch"></div>
	<p>

		<!--<div class="col-md-6 btn_add"  style="padding-left:0px;padding-bottom:5px;padding-right:0px;"><a href="add_summary.php" style="float:left;" class="add_summary" title="add_summary">Add Room Summary</a>
			<a href="#advance" style="float:left;" data-toggle="modal">Add Room Advance</a>
		</div>-->
	<div class="col-md-6 btn_add" style="padding-left:0px;padding-bottom:5px;padding-right:92px;">
		<!--<img width="35px;" height="35px;" src="line.png" title="">-->
		<input style="padding-left:10px;padding-top:4px;padding-bottom:4px;width:160px" type="text" name="room_number" id="room_number" placeholder="Enter room number.">
		<a href="#" class="room_summary" title="view_summary">View Summary</a>
	</div>
	<!--<a href="#" class="room_summary" title="checkout"><i class="fa fa-sign-out">&nbsp;</i>Checkout</a>-->

	</p>
	<span id="show_data"></span>
	<div class="content_wrapper">
		<?php if (!empty($ground)) { ?>
			<div class="row mt10">

				<div class="col-md-12">

					<?php if (!empty($msg)) { ?>

						<span><?php echo $msg; ?></span>

					<?php } ?>
					<!--<h3 style="color:#0E3070;"><?php //echo $hotels['hotel_name']
																					?></h3>-->
					<?php if (isset($_SESSION['success'])) { ?>
						<span style="color:green;"><b><?php echo $_SESSION['success'];
																					unset($_SESSION['success']); ?></b></span>
					<?php } elseif (isset($_SESSION['error'])) { ?>
						<span style="color:red;"><b><?php echo $_SESSION['error'];
																				unset($_SESSION['error']); ?></b></span>
					<?php } ?>
					<h3 class="heading">Ground Floor</h3>

					<?php foreach ($ground as $ground_value) {
						$room_number = $ground_value['room_number'];
						if ($ground_value['room_status'] == "booked") {
							$details[] = $guest_details = $obj->getRoomGuestDetails($room_number, $hotel_id);
							$checkin_id = $guest_details && $guest_details['checkin_id'];
							$extended = $obj->getExtendedDateByCheckinId($checkin_id, $hotel_id);

							if (!empty($extended)) {
								$checkout_date_s = $extended['current_co_date'];
							} else {
								$checkout_date_s = $guest_details && $guest_details['current_co_date'];
							}
							$time = "10:00 PM";
							$current_time = date('H:i A');
							$current_date = date('Y-m-d');

							if (!empty($guest_details['id_proof'])) {
								if ($current_date == $checkout_date_s && $current_time >= $time) {
					?>

									<div class="col-md-2 rooms rooms_booked blink_div">

										<h4 class="text-center room_text">
											<div class="room_catg"><?php echo $ground_value['room_category']; ?></div>
											<a href="room_guest_details.php?room_number=<?php echo $ground_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $ground_value['room_number']; ?>"><?php echo $ground_value['room_number']; ?></a>
										</h4>
									</div>
								<?php } else { ?>
									<div class="col-md-2 rooms rooms_booked">
										<h4 class="text-center room_text">
											<div class="room_catg"><?php echo $ground_value['room_category']; ?></div>
											<a href="room_guest_details.php?room_number=<?php echo $ground_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $ground_value['room_number']; ?>"><?php echo $ground_value['room_number']; ?></a>
										</h4>
									</div>
								<?php } ?>

							<?php } else { ?>
								<div class="col-md-2 rooms rooms_booked">
									<h4 class="text-center room_text">
										<div class="room_catg"><?php echo $ground_value['room_category']; ?></div>
										<a class="blink-text" href="room_guest_details.php?room_number=<?php echo $ground_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $ground_value['room_number']; ?>"><?php echo $ground_value['room_number']; ?></a>
									</h4>
								</div>
							<?php } ?>

						<?php } elseif ($ground_value['room_status'] == "empty") { ?>

							<div class="col-md-2 rooms rooms_vacant">

								<h4 class="text-center room_text">
									<div class="room_catg"><?php echo $ground_value['room_category']; ?></div>
									<a href="#empty" data-toggle="modal" id="<?php echo $ground_value['room_number']; ?>"><?php echo $ground_value['room_number']; ?></a>
								</h4>

							</div>

						<?php } elseif ($ground_value['room_status'] == "cleaning") { ?>

							<div class="col-md-2 rooms rooms_ready">

								<h4 class="text-center room_text">
									<div class="room_catg"><?php echo $ground_value['room_category']; ?></div>
									<a href="#ready" data-toggle="modal" id="<?php echo $ground_value['room_number']; ?>"><?php echo $ground_value['room_number']; ?></a>
								</h4>

							</div>


					<?php }
					} ?>

				</div><!--col-md-12-->

			</div><!--row-->
		<?php }
		if (!empty($floor1)) { ?>

			<div class="row mt10">

				<div class="col-md-12">
					<?php if (isset($_SESSION['success'])) { ?>
						<span style="color:green;"><b><?php echo $_SESSION['success'];
																					unset($_SESSION['success']); ?></b></span>
					<?php } elseif (isset($_SESSION['error'])) { ?>
						<span style="color:red;"><b><?php echo $_SESSION['error'];
																				unset($_SESSION['error']); ?></b></span>
					<?php } ?>
					<h3 class="heading">First Floor</h3>

					<?php foreach ($floor1 as $floor1_value) {
						$room_number = $floor1_value['room_number'];
						if ($floor1_value['room_status'] == "booked") {
							$details[] = $guest_details =  $obj->getRoomGuestDetails($room_number, $hotel_id);

							$checkin_id = $guest_details && $guest_details['checkin_id'];
							$extended = $obj->getExtendedDateByCheckinId($checkin_id, $hotel_id);

							if (!empty($extended)) {
								$checkout_date_s = $extended['current_co_date'];
							} else {
								$checkout_date_s = $guest_details &&  $guest_details['current_co_date'];
							}
							$time = "10:00 PM";
							$current_time = date('H:i A');
							$current_date = date('Y-m-d');

							if (!empty($guest_details['id_proof'])) {
								if ($current_date == $checkout_date_s && $current_time >= $time) {
					?>

									<div class="col-md-2 rooms rooms_booked blink_div">

										<h4 class="text-center room_text">
											<div class="room_catg"><?php echo $floor1_value['room_category']; ?></div>
											<a href="room_guest_details.php?room_number=<?php echo $floor1_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $floor1_value['room_number']; ?>"><?php echo $floor1_value['room_number']; ?></a>
										</h4>

									</div>
								<?php } else { ?>

									<div class="col-md-2 rooms rooms_booked">

										<h4 class="text-center room_text">
											<div class="room_catg"><?php echo $floor1_value['room_category']; ?></div>
											<a href="room_guest_details.php?room_number=<?php echo $floor1_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $floor1_value['room_number']; ?>"><?php echo $floor1_value['room_number']; ?></a>
										</h4>

									</div>
								<?php } ?>

							<?php } else { ?>

								<div class="col-md-2 rooms rooms_booked">

									<h4 class="text-center room_text">
										<div class="room_catg"><?php echo $floor1_value['room_category']; ?></div>
										<a class="blink-text" href="room_guest_details.php?room_number=<?php echo $floor1_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $floor1_value['room_number']; ?>"><?php echo $floor1_value['room_number']; ?></a>
									</h4>

								</div>

							<?php } ?>

						<?php } elseif ($floor1_value['room_status'] == "empty") { ?>
							<!--arhse<div class="col-md-2 rooms text-center">Deluxe Room</div>-->

							<div class="col-md-2 rooms rooms_vacant">

								<h4 class="text-center room_text">
									<div class="room_catg"><?php echo $floor1_value['room_category']; ?></div>
									<a href="#empty" data-toggle="modal" id="<?php echo $floor1_value['room_number']; ?>"><?php echo $floor1_value['room_number']; ?></a>
								</h4>

							</div>

						<?php } elseif ($floor1_value['room_status'] == "cleaning") { ?>

							<div class="col-md-2 rooms rooms_ready">

								<h4 class="text-center room_text">
									<div class="room_catg"><?php echo $floor1_value['room_category']; ?></div>
									<a href="#ready" data-toggle="modal" id="<?php echo $floor1_value['room_number']; ?>"><?php echo $floor1_value['room_number']; ?></a>
								</h4>

							</div>

					<?php }
					} ?>

				</div><!--col-md-12-->

			</div><!--row-->

		<?php }
		if (!empty($floor2)) { ?>

			<div class="row mt10">

				<div class="col-md-12">
					<?php if (empty($floor1)) { ?>
						<h3 style="color:#0E3070;"><?php echo $hotels['hotel_name'] ?></h3>
						<?php if (isset($_SESSION['success'])) { ?>
							<span style="color:green;"><b><?php echo $_SESSION['success'];
																						unset($_SESSION['success']); ?></b></span>
						<?php } elseif (isset($_SESSION['error'])) { ?>
							<span style="color:red;"><b><?php echo $_SESSION['error'];
																					unset($_SESSION['error']); ?></b></span>
						<?php } ?>
					<?php } ?>
					<h3 class="heading">Second Floor</h3>

					<?php foreach ($floor2 as $floor2_value) {
						$room_number = $floor2_value['room_number'];
						if ($floor2_value['room_status'] == "booked") {
							$details[] = $guest_details = $obj->getRoomGuestDetails($room_number, $hotel_id);

							$checkin_id =  $guest_details && $guest_details['checkin_id'];
							$extended = $obj->getExtendedDateByCheckinId($checkin_id, $hotel_id);

							if (!empty($extended)) {
								$checkout_date_s = $extended['current_co_date'];
							} else {
								$checkout_date_s = $guest_details && $guest_details['current_co_date'];
							}
							$time = "10:00 PM";
							$current_time = date('H:i A');
							$current_date = date('Y-m-d');

							if (!empty($guest_details['id_proof'])) {
								if ($current_date == $checkout_date_s && $current_time >= $time) {
					?>

									<div class="col-md-2 rooms rooms_booked blink_div">

										<h4 class="text-center room_text">
											<div class="room_catg"><?php echo $floor2_value['room_category']; ?></div>
											<a href="room_guest_details.php?room_number=<?php echo $floor2_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $floor2_value['room_number']; ?>"><?php echo $floor2_value['room_number']; ?></a>
										</h4>

									</div>
								<?php } else { ?>
									<div class="col-md-2 rooms rooms_booked">

										<h4 class="text-center room_text">
											<div class="room_catg"><?php echo $floor2_value['room_category']; ?></div>
											<a href="room_guest_details.php?room_number=<?php echo $floor2_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $floor2_value['room_number']; ?>"><?php echo $floor2_value['room_number']; ?></a>
										</h4>

									</div>
								<?php } ?>

							<?php } else { ?>

								<div class="col-md-2 rooms rooms_booked">

									<h4 class="text-center room_text">
										<div class="room_catg"><?php echo $floor2_value['room_category']; ?></div>
										<a class="blink-text" href="room_guest_details.php?room_number=<?php echo $floor2_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $floor2_value['room_number']; ?>"><?php echo $floor2_value['room_number']; ?></a>
									</h4>

								</div>
							<?php } ?>


						<?php } elseif ($floor2_value['room_status'] == "empty") { ?>

							<div class="col-md-2 rooms rooms_vacant">

								<h4 class="text-center room_text">
									<div class="room_catg"><?php echo $floor2_value['room_category']; ?></div>
									<a href="#empty" data-toggle="modal" id="<?php echo $floor2_value['room_number']; ?>"><?php echo $floor2_value['room_number']; ?></a>
								</h4>

							</div>

						<?php } elseif ($floor2_value['room_status'] == "cleaning") { ?>

							<div class="col-md-2 rooms rooms_ready">

								<h4 class="text-center room_text">
									<div class="room_catg"><?php echo $floor2_value['room_category']; ?></div>
									<a href="#ready" data-toggle="modal" id="<?php echo $floor2_value['room_number']; ?>"><?php echo $floor2_value['room_number']; ?></a>
								</h4>

							</div>

					<?php }
					} ?>

				</div><!--col-md-12-->

			</div><!--row-->
		<?php }
		if (!empty($floor3)) { ?>
			<div class="row mt10">

				<div class="col-md-12">
					<?php if (empty($floor2)) { ?>
						<h3 style="color:#0E3070;"><?php echo $hotels['hotel_name'] ?></h3>
						<?php if (isset($_SESSION['success'])) { ?>
							<span style="color:green;"><b><?php echo $_SESSION['success'];
																						unset($_SESSION['success']); ?></b></span>
						<?php } elseif (isset($_SESSION['error'])) { ?>
							<span style="color:red;"><b><?php echo $_SESSION['error'];
																					unset($_SESSION['error']); ?></b></span>
						<?php } ?>
					<?php } ?>
					<h3 class="heading">Third Floor</h3>

					<?php foreach ($floor3 as $floor3_value) {
						$room_number = $floor3_value['room_number'];

						if ($floor3_value['room_status'] == "booked") {
							$details[] = $guest_details = $obj->getRoomGuestDetails($room_number, $hotel_id);

							$checkin_id = $guest_details && $guest_details['checkin_id'];
							$extended = $obj->getExtendedDateByCheckinId($checkin_id, $hotel_id);

							if (!empty($extended)) {
								$checkout_date_s = $extended['current_co_date'];
							} else {
								$checkout_date_s = $guest_details &&  $guest_details['current_co_date'];
							}
							$time = "10:00 PM";
							$current_time = date('H:i A');
							$current_date = date('Y-m-d');

							if (!empty($guest_details['id_proof'])) {
								if ($current_date == $checkout_date_s && $current_time >= $time) {
					?>

									<div class="col-md-2 rooms rooms_booked blink_div">

										<h4 class="text-center room_text">
											<div class="room_catg"><?php echo $floor3_value['room_category']; ?></div>
											<a href="room_guest_details.php?room_number=<?php echo $floor3_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $floor3_value['room_number']; ?>"><?php echo $floor3_value['room_number']; ?></a>
										</h4>

									</div>
								<?php } else { ?>
									<div class="col-md-2 rooms rooms_booked">

										<h4 class="text-center room_text">
											<div class="room_catg"><?php echo $floor3_value['room_category']; ?></div>
											<a href="room_guest_details.php?room_number=<?php echo $floor3_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $floor3_value['room_number']; ?>"><?php echo $floor3_value['room_number']; ?></a>
										</h4>

									</div>
								<?php } ?>

							<?php } else { ?>
								<div class="col-md-2 rooms rooms_booked">

									<h4 class="text-center room_text">
										<div class="room_catg"><?php echo $floor3_value['room_category']; ?></div>
										<a class="blink-text" href="room_guest_details.php?room_number=<?php echo $floor3_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $floor3_value['room_number']; ?>"><?php echo $floor3_value['room_number']; ?></a>
									</h4>

								</div>
							<?php } ?>

						<?php } elseif ($floor3_value['room_status'] == "empty") { ?>

							<div class="col-md-2 rooms rooms_vacant">

								<h4 class="text-center room_text">
									<div class="room_catg"><?php echo $floor3_value['room_category']; ?></div>
									<a href="#empty" data-toggle="modal" id="<?php echo $floor3_value['room_number']; ?>"><?php echo $floor3_value['room_number']; ?></a>
								</h4>

							</div>

						<?php } elseif ($floor3_value['room_status'] == "cleaning") { ?>

							<div class="col-md-2 rooms rooms_ready">

								<h4 class="text-center room_text">
									<div class="room_catg"><?php echo $floor3_value['room_category']; ?></div>
									<a href="#ready" data-toggle="modal" id="<?php echo $floor3_value['room_number']; ?>"><?php echo $floor3_value['room_number']; ?></a>
								</h4>

							</div>

					<?php }
					} ?>

				</div><!--col-md-12-->

			</div><!--row-->
		<?php }
		if (!empty($floor4)) { ?>
			<div class="row mt10">
				<div class="col-md-12">
					<?php if (empty($floor3)) { ?>
						<h3 style="color:#0E3070;"><?php echo $hotels['hotel_name'] ?></h3>
						<?php if (isset($_SESSION['success'])) { ?>
							<span style="color:green;"><b><?php echo $_SESSION['success'];
																						unset($_SESSION['success']); ?></b></span>
						<?php } elseif (isset($_SESSION['error'])) { ?>
							<span style="color:red;"><b><?php echo $_SESSION['error'];
																					unset($_SESSION['error']); ?></b></span>
						<?php } ?>
					<?php } ?>
					<h3 class="heading">Fourth Floor</h3>
					<?php foreach ($floor4 as $floor4_value) {
						$room_number = $floor4_value['room_number'];
						if ($floor4_value['room_status'] == "booked") {
							$details[] = $guest_details = $obj->getRoomGuestDetails($room_number, $hotel_id);

							$checkin_id = $guest_details['checkin_id'];
							$extended = $obj->getExtendedDateByCheckinId($checkin_id, $hotel_id);

							if (!empty($extended)) {
								$checkout_date_s = $extended['current_co_date'];
							} else {
								$checkout_date_s = $guest_details['current_co_date'];
							}
							$time = "10:00 PM";
							$current_time = date('H:i A');
							$current_date = date('Y-m-d');

							if (!empty($guest_details['id_proof'])) {
								if ($current_date == $checkout_date_s && $current_time >= $time) {
					?>
									<div class="col-md-2 rooms rooms_booked blink_div">
										<h4 class="text-center room_text">
											<div class="room_catg"><?php echo $floor4_value['room_category']; ?></div>
											<a href="room_guest_details.php?room_number=<?php echo $floor4_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $floor4_value['room_number']; ?>"><?php echo $floor4_value['room_number']; ?></a>
										</h4>
									</div>
								<?php } else { ?>
									<div class="col-md-2 rooms rooms_booked">
										<h4 class="text-center room_text">
											<div class="room_catg"><?php echo $floor4_value['room_category']; ?></div>
											<a href="room_guest_details.php?room_number=<?php echo $floor4_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $floor4_value['room_number']; ?>"><?php echo $floor4_value['room_number']; ?></a>
										</h4>
									</div>
								<?php } ?>


							<?php } else { ?>
								<div class="col-md-2 rooms rooms_booked">
									<h4 class="text-center room_text">
										<div class="room_catg"><?php echo $floor4_value['room_category']; ?></div>
										<a class="blink-text" href="room_guest_details.php?room_number=<?php echo $floor4_value['room_number']; ?>" data-toggle="tooltip" title="<?php echo $guest_details['name']; ?>" id="<?php echo $floor4_value['room_number']; ?>"><?php echo $floor4_value['room_number']; ?></a>
									</h4>
								</div>

							<?php } ?>
						<?php } elseif ($floor4_value['room_status'] == "empty") { ?>
							<div class="col-md-2 rooms rooms_vacant">
								<h4 class="text-center room_text">
									<div class="room_catg"><?php echo $floor4_value['room_category']; ?></div>
									<a href="#empty" data-toggle="modal" id="<?php echo $floor4_value['room_number']; ?>"><?php echo $floor4_value['room_number']; ?></a>
								</h4>
							</div>
						<?php } elseif ($floor4_value['room_status'] == "cleaning") { ?>
							<div class="col-md-2 rooms rooms_ready">
								<h4 class="text-center room_text">
									<div class="room_catg"><?php echo $floor4_value['room_category']; ?></div>
									<a href="#ready" data-toggle="modal" id="<?php echo $floor4_value['room_number']; ?>"><?php echo $floor4_value['room_number']; ?></a>
								</h4>
							</div>
					<?php }
					} ?>
				</div><!--col-md-12-->
			</div><!--row-->
		<?php } ?>
		<hr style="border:1px dotted;">

		<div class="col-md-12 bdr">

			<div class="col-md-4">

				<h4 class="booked"><i class="fa fa-square">&nbsp;<?php echo $room_booked_count; ?>&nbsp;</i><strong>Sold Out</strong></h4>

			</div>

			<div class="col-md-3">

				<h4 class="empty"><i class="fa fa-square">&nbsp;<?php echo $room_empty_count; ?>&nbsp;</i><strong>Empty</strong></h4>

			</div>
			<div class="col-md-5">
				<h4 class="ready"><i class="fa fa-square">&nbsp;<?php echo $room_clean_count; ?>&nbsp;</i><strong>Under Cleaning</strong></h4>
			</div>

		</div>
	</div>
</div>
<!--<div class="col-md-2 c-tab__content scrollbar" id="style-2">
	<div class="cir">
    <div class="cir-top">
      <h5 class="cir-top-title">Employee Details</h5>
     
    </div>
    
    <form class="form-horizontal" name="search" role="form" method="POST" onkeypress="return event.keyCode != 13;">
      <div class="search">
        <input  style="width:70%!important;background-color:#eee;border:1px solid #eee;padding: 5px 5px;" id="name" name="name" type="text" placeholder="Search by name" autocomplete="off"/>
      </div>
    </form>
    <ul class="main_ul replace">
    </ul>
  </div>	
</div>-->

<div class="col-md-2 c-tab__content scrollbar" id="style-2">
	<div class="cir">
		<div class="cir-top">
			<h5 class="cir-top-title">Guest Details</h5>
		</div>
		<form class="form-horizontal" name="search" role="form" method="POST" onkeypress="return event.keyCode != 13;">
			<div class="search">

				<input style="width:70%!important;background-color:#eee;border:1px solid #eee;padding: 5px 5px;" id="name" name="name" type="text" placeholder="Search by name" autocomplete="off" />
				<button type="button" id="search_guest"><img src="1495902950_search.ico"></button>
			</div>
		</form>
		<hr style="border: 1px solid #428BCA;">

		<ul class="main_ul">
			<?php /* <?php 
    		$current_date = CURR_DATE;
    		if($today_chec['checkout_date'] == $current_date){ ?>
    		<span cir-item-name style="font-size: 14px;"><a class="blink-text"><b>Room No. - <?php echo $today_chec['room_number'];?></b></a></span></br>
    		<?php } else { ?>
    		<span cir-item-name style="font-size: 14px;"><a><b>Room No. - <?php echo $today_chec['room_number'];?></b></a></span></br>
    		<?php } ?>*/ ?>

			<?php foreach ($today_checkedin as $today_chec) {
				$checkin_id = $today_chec['checkin_id'];
				$checkin_date = $today_chec['checkin_date'];
				$all_guest = $obj->getAllGuestNameByCheckinId($checkin_id, $checkin_date);
				$extended = $obj->getExtendedDateByCheckinId($checkin_id, $hotel_id);
			?>
				<li cir-item-name><a>
						<h5 style="color: #dc446e!important;">Room No. - <?php echo $today_chec['room_number']; ?></h5>
					</a></li>
				<li class="size"><a><?php echo $today_chec['name']; ?></a></li>

				<?php
				if (!empty($all_guest)) {
					foreach ($all_guest as $g_name) {
						$name = $g_name['name_title'] . ' ' . $g_name['name'];
				?>
						<li class="size"><a><?php echo $name; ?></a></li>
				<?php }
				} ?>
				<li class="size"><?php echo $today_chec['compnay_name']; ?></li>
				<li class="size"><?php echo $today_chec['phone']; ?></li>
				<li class="size"><?php echo $today_chec['email']; ?></li>
				<?php if (!empty($extended)) { ?>

					<li class="size"><?php echo date('d M, Y', strtotime(str_replace('/', '-', $extended['checkin_date']))) . ' - ' . date('d M, Y', strtotime(str_replace('/', '-', $extended['checkout_date']))); ?></li>
				<?php } else { ?>
					<li class="size"><?php echo date('d M, Y', strtotime(str_replace('/', '-', $today_chec['checkin_date']))) . ' - ' . date('d M, Y', strtotime(str_replace('/', '-', $today_chec['checkout_date']))); ?></li>
				<?php } ?>
				<hr style="border: 1px dotted #428BCA;">
			<?php } ?>
		</ul>
		<!--<div class="ul_replace">
          </div>-->
	</div>
</div>



<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class="booked_room"></div>
</div>

<div class="clearfix"></div>

<!--Quick Checkin Modal -->
<a href="#x" class="overlay" id="empty"></a>
<div class="popup1">
	<h3 class="text-center" style="font-size:25px" ;>Room is ready To Book</h3>
	<span id="success"></span>
	<form action="insert_data.php" class="idealforms" id="checkin_form" enctype="multipart/form-data" role="form" name="checkin_form" autocomplete="on">
		<span id="messsage" style="margin-left:22px;color:red;font-weight:bold;"></span>
		<div class="field">
			<label class="main">R. Entry Number<span style="color:red;"> * </span>:</label>
			<input name="serial" id="serial" type="text" value="<?php if (isset($_SESSION['serial'])) echo $_SESSION['serial']; ?>" class="ipt" placeholder="Enter serial number"></br>
		</div>
		<div class="clear"></div>
		<div class="wrapagain">
			<span id="wrapelement0">
				<div class="field">
					<label class="main">Full Name<span style="color:red;"> * </span>:</label>
					<?php if (isset($_SESSION['fname'])) { ?>
						<input name="fname[]" id="fname" value="<?php echo $_SESSION['fname'][0]; ?>" class="ipt" type="text" placeholder="Enter Your Full Name">
					<?php  } else { ?>
						<input name="fname[]" id="fname" class="ipt" type="text" placeholder="Enter Your Full Name">
					<?php } ?>
				</div>
				<div class="field">
					<label class="main">Gender:</label>
					<select name="gender[]" id="selectt" class="gender" style="width: 278px!important;">
						<?php $genders = array('Male', 'Female', 'Other');
						foreach ($genders as $gender) {
							if (isset($_SESSION['gender'])) {
						?>
								<option value="<?php echo $gender; ?>" <?php if ($_SESSION['gender'][0] == $gender) echo 'selected="selected"'; ?>><?php echo $gender; ?></option>
							<?php } else { ?>
								<option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
						<?php }
						} ?>
					</select>
				</div>
			</span>
			<div class="clear"></div>
			<!-- here code for updade only -->
			<?php
			if (isset($_SESSION['fname'])) {
				$i = 1;
				$count = count($_SESSION['fname']);
				if ($count > $i) {
					for ($y = 1; $y < $count; $y++) {  ?>
						<span id="wrapelement<?php echo $i; ?>">
							<div class="field">
								<label class="main">Full Name<span style="color:red;"> * </span>:</label>
								<?php if (isset($_SESSION['fname'])) { ?>
									<input name="fname[]" id="fname" value="<?php echo $_SESSION['fname'][$i]; ?>" class="ipt" type="text" placeholder="Enter Your Full Name">
								<?php  } else { ?>
									<input name="fname[]" id="fname" value="" class="ipt_small" type="text" placeholder="Enter Your Full Name">
								<?php } ?>
							</div>
							<div class="field">
								<label class="main">Gender:</label>
								<select name="gender[]" id="selectt" class="gender" style="width:278px!important;">
									<?php $genders = array('Male', 'Female', 'Other');

									foreach ($genders as $gender) {
										if (isset($_SESSION['gender'])) {
											//foreach ( $_SESSION['gender'] as $SSgender ) {
									?>
											<option value="<?php echo $gender; ?>" <?php if ($gender == $_SESSION['gender'][$i]) echo 'selected="selected"'; ?>><?php echo $gender; ?></option>
										<?php } else { ?>
											<option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
									<?php }
									}  ?>
								</select>
							</div>
						</span>
						<?php ++$i; ?>
					<?php } ?>
					<span id="wrapelement<?php echo $i; ?>"></span>
					<input type="hidden" id="i" value="<?php echo $i; ?>">
				<?php }
			} else { ?>
				<span id="wrapelement1"></span>
			<?php  } ?>
		</div>
		<div style="margin-left:520px" class="field buttons">
			<label class="main">&nbsp;</label>
			<input type="button" id="add_row" value="Add Person" class="add_person">
			<input type="button" id="delete_row" value="Delete Person" class="delete_person">
		</div>
		<div class="clear"></div>
		<div class="field">
			<label class="main">E-Mail<span style="color:red;"> * </span>:</label>
			<input name="email" id="email" type="text" value="<?php if (isset($_SESSION['email'])) echo $_SESSION['email']; ?>" class="ipt" placeholder="Enter your Email ID"></br>
			<span id="email_msg"></span>
		</div>

		<div class="field">
			<label class="main">Phone No<span style="color:red;"> * </span>:</label>
			<input name="phone" id="phone" value="<?php if (isset($_SESSION['phone'])) echo $_SESSION['phone']; ?>" type="text" class="ipt" placeholder="Enter your Phone Number">
			<br>
			<span id="phone_error"></span>
		</div>
		<div class="clear"></div>
		<div class="field">
			<label class="main">Check In Date<span style="color:red;"> * </span>:</label>
			<input class="date-pick ipt" type="text" value="<?php if (isset($_SESSION['checkin'])) echo $_SESSION['checkin']; ?>" id="checkin" name="checkin" placeholder="Check In Date">
		</div>

		<div class="field">
			<label class="main">Check Out Date<span style="color:red;"> * </span>:</label>
			<input class="date-pick ipt" type="text" id="checkout" value="<?php if (isset($_SESSION['checkout'])) echo $_SESSION['checkout']; ?>" name="checkout" placeholder="Check Out Date">
		</div>
		<div class="field">
			<label class="main">Coming From<span style="color:red;"> * </span>:</label>
			<input id="lastlocation" name="lastlocation" class="ipt" value="<?php if (isset($_SESSION['lastlocation'])) echo $_SESSION['lastlocation']; ?>" type="text" placeholder="Your Last Location">
		</div>
		<div class="field">
			<label class="main">Going To:<br>(Next Location)<span style="color:red;"> * </span>:</label>
			<input id="nextlocation" name="nextlocation" value="<?php if (isset($_SESSION['nextlocation'])) echo $_SESSION['nextlocation']; ?>" class="ipt" type="text" placeholder="Your Next Location">
		</div>
		<div class="field">
			<label class="main">Booking Nights<span style="color:red;"> * </span>:</label>
			<input name="nights" id="nights" type="number" value="<?php if (isset($_SESSION['nights'])) echo $_SESSION['nights']; ?>" class="ipt" placeholder="Enter Booking Nights">
		</div>
		<div class="field">
			<label class="main">Purpouse<span style="color:red;"> * </span>:</label>
			<select name="purpose" id="selectt" class="purpose">
				<option value="">Select an purpouse</option>
				<?php
				$purpouses = array('Tourist', 'Official/Bussiness', 'Medical', 'Exam', 'Interview', 'Other');
				foreach ($purpouses as $purpouse) {
					if (isset($_SESSION['purpose'])) {
				?>
						<option value="<?php echo $purpouse; ?>" <?php if ($_SESSION['purpose'] == $purpouse) echo 'selected="selected"'; ?>><?php echo $purpouse; ?></option>
					<?php } else { ?>
						<option value="<?php echo $purpouse; ?>"><?php echo $purpouse; ?></option>
				<?php }
				} ?>
			</select>
		</div>
		<div class="clear"></div>
		<h4><input type="button" class="reset" style="padding:5px 20px 5px 20px;" id="reset_room" value="Reset" />&nbsp;<a id="submitform" title="" href="##">Book Now</a></h4>
	</form>
	<a class="close" href=""></a>
</div>

<!--add room advance ppp-->

<a href="#x" class="overlay" id="advance"></a>
<div class="popup1">
	<h3 class="text-center">Add Room Advance</h3>
	<span id="add_v"></span>
	<form action="#" class="idealforms" id="advnce_form" enctype="multipart/form-data" role="form" name="checkin_form" autocomplete="on">
		<div class="clear"></div>
		<div class="field">
			<label class="main">Amount<span style="color:red;"> * </span>:</label>
			<input name="amount" id="amount" type="text" class="ipt" placeholder="Enter Room Advance Amount"></br>
		</div>
		<div class="field">
			<label class="main">Room Number<span style="color:red;"> * </span>:</label>
			<input name="room_num" id="room_num" type="text" class="ipt" placeholder="Enter Room Number">
		</div>
		<div class="clear"></div>
		<p>&nbsp;</p>
		<button style="float: right!important;margin-right:480px;" type="button" id="advance_btn" class="reset">Submit</button>

	</form>
	<a class="close" href=""></a>
</div>
<a href="#x" class="overlay" id="ready"></a>
<div class="popup1">
	<h3 class="text-center">Room is Under Cleaning</h3>
	<h4><a href="?room_status=empty" id="ready">Ready To Book</a></h4>
	<a class="close" href=""></a>
</div>
</div>
<?php include('../include/footer.php'); ?>

<script src="js/quantity-bt.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/save_entry_fromdata.js"></script>
<!--<script type="text/javascript" src="js/save_hotel_id.js"></script>-->
<!--url replacing -->
<script type="text/javascript">
	//replace white space
	$(function() {
		$('#phone').bind('input', function() {
			$(this).val(function(_, v) {
				return v.replace(/\s+/g, '');
			});
		});
	});


	$(".hotel").change(function() {
		var hotel_id = $(this).attr("value");
		$.ajax({
			url: "save_hotel_id.php?hotel_id=" + hotel_id,
			success: function(data) {
				window.location.href = 'room_view.php';
			}
		});
	});


	$("#advance_btn").click(function(e) {
		var formData = $("#advnce_form").serialize();
		$.ajax({
			url: 'insert_data.php?type=add_room_advance',
			type: 'post',
			data: formData,
			success: function(data) {
				if (data == 0) {
					$("#add_v").html("<div class='alert alert-success'>Your data has been saved.</div>");
				} else {
					$("#add_v").html("<div class='alert alert-danger'>Error please try again later.</div>");
				}

			}
		});
	});

	$('#advance_btn').click(function(e) {

		var amount = $('#amount');
		var room_num = $('#room_num');

		if (!amount.val()) {
			$('#amount').css("border", "1px solid red");
			$('#amount').focus();
			e.preventDefault();
			//return false;
		}

		if (!room_num.val()) {
			$('#room_num').css("border", "1px solid red");
			$('#room_num').focus();
			e.preventDefault();
			//return false;
		}
	});
</script>
<script type="text/javascript">
	$('.room_summary').click(function() {
		var room_number = $("#room_number").val();
		var type = $(this).attr('title');
		if (room_number) {
			$.ajax({
				url: 'check_room_is_booked.php?room_number=' + room_number + '&&type=' + type,
				success: function(res) {
					if (res == 0) {
						window.location.href = 'add_summary.php?room_number=' + room_number;
					} else if (res == 2) {
						window.location.href = 'bill.php?room_number=' + room_number;
					} else {
						$("#erro_ch").show().html('<div class="alert alert-danger">This Room is Empty</div>');
					}
				}
			});
		}
	});
</script>

<script type="text/javascript">
	//on howere showing guest details
	/*$("div.rooms_booked a").mouseover(function() {
		var room_number = $(this).attr('id');
		$.ajax({

			url: "room_by_guest_details.php?type=customer_name&room="+room_number,
			success:function(data){
				$(".booked_room"+room_number).show().html(data);
				$("div.description").css("display","block");
			}
		});
		
	}).mouseout(function() {
		$("div.description").css("display","none");
		$(this).children("#description").hide();
	});*/

	/*$("div.rooms_booked a").mouseover(function() {
		var room_number = $(this).attr('id');
		$.ajax({

			url: "room_by_guest_details.php?type=customer_name&room="+room_number,
			success:function(data){
				$(".booked_room").show().html(data);
				$("div.details").css("display","block");
			}
		});
	
	});*/
	$(document).ready(function() {
		var room_number = localStorage.getItem('room_number')
		$('a[title=""]').attr('title', room_number);
		$('a[href="?room_status=empty"]').attr('href', "?room_status=empty&room_number=" + room_number);
		$('form[action="insert_data.php"]').attr('action', "insert_data.php?room_number=" + room_number);
	});
	$("a[data-toggle=modal]").click(function() {
		var room_number = $(this).attr('id');
		localStorage.setItem('room_number', room_number);
		$('a[href="?room_status=empty"]').attr('href', "?room_status=empty&room_number=" + room_number);
		$('form[action="insert_data.php"]').attr('action', "insert_data.php?room_number=" + room_number);
		$('a[title=""]').attr('title', room_number);

	});
</script>
<!--script type="text/javascript">
		$(document).ready(function(){
			var title = $("#submitform").attr('title');
			$('a[title=""]').attr('title', $.session.get("room_number"));
		});
	</script>-->
<script>
	$(document).ready(function() {
		$("#checkin").datepicker({
			minDate: "01/30/2012",
			maxDate: "01/30/2012"
		});
		$("#checkout").datepicker({
			beforeShow: setminDate
		});

		var start1 = $('#checkin');

		function setminDate() {
			var p = start1.datepicker('getDate');
			if (p) {
				var k = "01/30/2012";
				return {
					minDate: p,
					maxDate: k
				}
			};
		}

		function clearEndDate(dateText, inst) {
			end1.val('');
		}
	});
	$(function() {
		$("#checkout").datepicker({
			dateFormat: 'mm/dd/yyyy'
		});
		$("#checkin").datepicker({
			dateFormat: 'mm/dd/yyyy'
		});
	});


	$('#checkout').on('change', function() {
		var start = $('#checkin').datepicker('getDate');
		var end = $('#checkout').datepicker('getDate');
		var days = (end - start) / 1000 / 60 / 60 / 24;
		$("#nights").val(days);
	});

	$('#nights').click(function() {
		var start = $('#checkin').datepicker('getDate');
		var end = $('#checkout').datepicker('getDate');
		var days = (end - start) / 1000 / 60 / 60 / 24;
		$("#nights").val(days);
	});
</script>

<script>
	$(document).ready(function() {
		var var_i = $('#i');
		if (var_i.val()) {
			var i = var_i.val();
			$("#delete_row").show();
		} else {
			var i = 1;
			$("#delete_row").hide();
		}


		$("#add_row").click(function() {
			$('#wrapelement' + i).html('<div class="field"><label class="main">Full Name:</label><input name="fname[]" id="fname" class="ipt" type="text" placeholder="Enter Your Full Name" ></div><div class="field"><label class="main">Gender:</label><select name="gender[]" id="selectt" class="gender" style="width: 278px!important;"><option value="Male">Male</option><option value="Female">Female</option><option value="Other">Other</option></select></div><div class="clear"></div>');
			$('.wrapagain').append('<span id="wrapelement' + (i + 1) + '"></span>');
			i++;
			$("#delete_row").show();
		});
		$("#delete_row").click(function() {
			if (i <= 2) {
				$("#delete_row").hide();
			}
			if (i > 1) {
				$("#wrapelement" + (i - 1)).html('');
				i--;
			}
		});
	});
</script>
<script type="text/javascript">
	$(document).on("keyup", "#email,#phone", function() {
		var email = $("#email").val();
		if (email) {
			$.ajax({
				url: 'validate.php?email=' + email,
				success: function(data) {
					//alert(data);
					if (data == 1) {
						$("#messsage").hide(data);
						$("#email_msg").show().html("<span style='margin-left:120px;font-size:10px;color:red;'>invalid Email-ID! please enter your valid Email-ID</span>");
						return false;
					} else {
						$("#email_msg").hide();
						$.ajax({
							url: 'insert_data.php?email=' + email,
							success: function(data) {
								$("#messsage").show().html(data);
							}
						});
					}
				}
			});
		} else {
			$("#email_msg").hide();
		}
	});
</script>
<script type="text/javascript">
	$(document).on("click", "#email,#phone", function() {
		var email = $("#email").val();
		if (email) {
			$.ajax({
				url: 'validate.php?email=' + email,
				success: function(data) {
					if (data == 1) {
						$("#messsage").hide(data);
						$("#email_msg").show().html("<span style='margin-left:120px;font-size:10px;color:red;'>invalid Email-ID! please enter your valid Email-ID</span>");
						return false;
					} else {
						$("#email_msg").hide();
						$.ajax({
							url: 'insert_data.php?email=' + email,
							success: function(data) {
								$("#messsage").show().html(data);
							}
						});
					}
				}
			});
		} else {
			$("#email_msg").hide();
		}
	});
</script>

<script type="text/javascript">
	$(document).on("keyup", "#email,#phone", function() {
		var phone = $("#phone").val();
		if (phone) {
			$.ajax({
				url: 'validate.php?phone=' + phone,
				success: function(data) {
					//alert(data);
					if (data == 1) {
						$("#messsage").hide(data);
						$("#phone_error").show().html("<span style='font-size:10px;color:red;'>Invalid Phone Number.. Please enter your valid Phone Number</span>");
						return false;
					} else {
						$("#phone_error").hide();
						$.ajax({
							url: 'insert_data.php?phone=' + phone,
							success: function(data) {
								//$("#messsage").show().html(data);
							}
						});
					}
				}
			});
		} else {
			$("#phone_error").hide();
		}
	});
</script>
<script type="text/javascript">
	$(document).on("click", "#email,#phone", function() {
		var phone = $("#phone").val();
		if (phone) {
			$.ajax({
				url: 'validate.php?phone=' + phone,
				success: function(data) {
					if (data == 1) {
						$("#messsage").hide(data);
						$("#phone_error").show().html("<span style='font-size:10px;color:red;'>Invalid Phone Number.. Please enter your valid Phone Number</span>");
						return false;
					} else {
						$("#phone_error").hide();
						$.ajax({
							url: 'insert_data.php?phone=' + phone,
							success: function(data) {
								//$("#messsage").show().html(data);
							}
						});
					}
				}
			});
		} else {
			$("#phone_error").hide();
		}
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {

		$('#fname,#email,#phone,.purpose,#checkin,#checkout,#lastlocation,#nextlocation,#serial,#room_number').click(function() {
			$('#fname').css("border", "");
			$('#email').css("border", "");
			$('#phone').css("border", "");
			$('.purpose').css("border", "");
			$('#checkin').css("border", "");
			$('#checkout').css("border", "");
			$('#lastlocation').css("border", "");
			$('#nextlocation').css("border", "");
			$('#serial').css("border", "");
			$('#room_number').css("border", "");
		})

	});


	$('a[href="##"]').on('click', function(e) {

		var fname = $('#fname');
		var email = $('#email');
		var phone = $('#phone');
		var purpose = $('.purpose');
		var checkin = $('#checkin');
		var checkout = $('#checkout');
		var nights = $('#nights');
		var lastlocation = $('#lastlocation');
		var nextlocation = $('#nextlocation');
		var serial = $('#serial');

		if (!serial.val()) {
			$('#serial').css("border", "1px solid red");
			$('#serial').focus();
			e.preventDefault();
			//return false;
		}

		if (!fname.val()) {
			$('#fname').css("border", "1px solid red");
			$('#fname').focus();
			e.preventDefault();
			//return false;
		}
		if (!email.val()) {
			$('#email').css("border", "1px solid red");
			$('#email').focus();
			e.preventDefault();
			//return false;
		}

		if (!phone.val()) {
			$('#phone').css("border", "1px solid red");
			$('#phone').focus();
			e.preventDefault();
			//return false;
		}

		if (!checkin.val()) {
			$('#checkin').css("border", "1px solid red");
			$('#checkin').focus();
			e.preventDefault();
			//return false;
		}
		if (!checkout.val()) {
			$('#checkout').css("border", "1px solid red");
			$('#checkout').focus();
			e.preventDefault();
			//return false;
		}
		if (!nights.val()) {
			$('#nights').css("border", "1px solid red");
			$('#nights').focus();
			e.preventDefault();
			//return false;
		}
		if (!lastlocation.val()) {
			$('#lastlocation').css("border", "1px solid red");
			$('#lastlocation').focus();
			e.preventDefault();
			//return false;
		}
		if (!nextlocation.val()) {
			$('#nextlocation').css("border", "1px solid red");
			$('#nextlocation').focus();
			e.preventDefault();
			//return false;
		}
		if (!purpose.val()) {
			$('.purpose').css("border", "1px solid red");
			$('.purpose').focus();
			e.preventDefault();
			//return false;
		}

		if (fname.val()) {
			$('#fname').css("border", "");
		}

		if (email.val()) {
			$('#email').css("border", "");
		}

		if (phone.val()) {
			$('#phone').css("border", "");
		}

		if (checkin.val()) {
			$('#checkin').css("border", "");
		}

		if (checkout.val()) {
			$('#checkout').css("border", "");
		}

		if (lastlocation.val()) {
			$('#lastlocation').css("border", "");
		}
		if (nextlocation.val()) {
			$('#nextlocation').css("border", "");
		}
		if (purpose.val()) {
			$('.purpose').css("border", "");
			$('a[href="##"]').attr('href', '#');
		}


	});

	$(".room_summary").on('click', function(e) {
		var room_number = $("#room_number");
		if (!room_number.val()) {
			$('#room_number').css("border", "1px solid red");
			$('#room_number').focus();
			e.preventDefault();
			//return false;
		}
	});
</script>
<script type="text/javascript">
	$('a[id="submitform"]').click(function() {
		var room_number = $(this).attr('title');
		$.ajax({
			url: 'insert_data.php?type=quickbooking_direct&room_number=' + room_number,
			type: 'POST',
			data: $('form').serialize(),
			cache: false,
			success: function(data) {
				if (data == 'Error! All field are required.') {
					alert(data)
				} else if (data == 'success') {
					//$.session.remove("room_number");
					window.location.href = 'room_view.php';
				} else {
					window.location.href = 'room_view.php';
				}
			}
		});
	});
</script>

<script type="text/javascript">
	$(".nametitle").change(function() {
		var nametitle = $(this).attr('value');
		if (nametitle == 'Mrs' || nametitle == 'Miss') {
			$(".gender").val('Female');
		} else {
			$(".gender").val('Male');
		}
	});
</script>
<script type="text/javascript">
	$(".gender").change(function() {
		var gender = $(this).attr('value');
		if (gender == 'Female') {
			$(".nametitle").val('Mrs');
		} else {
			$(".nametitle").val('Mr');
		}
	});
</script>

<script type="text/javascript">
	$('#email,#phone,.purpose,#checkin,#checkout,#lastlocation,#nextlocation').click(function() {
		var formData = $("#checkin_form").serialize();
		$.ajax({
			type: "POST",
			url: 'insert_data.php?type=save_formdata',
			data: formData,
			success: function(data) {}
		});

	});
</script>

<!--w kn -->
<script type="text/javascript">
	$("select.hotel").change(function(e) {
		var $this = $(this);
		if (!$this.hasClass('active')) {
			$this.addClass('active');
		}
		e.preventDefault();
	});
</script>

<!-- searching script here-->
<script type="text/javascript">
	$(document).ready(function() {
		$("#search_guest").on('click', function() {
			var query_value = $('input#name').val();
			if (query_value !== '') {
				$.ajax({
					type: "POST",
					url: "search_guest_details.php?type=guest_details",
					data: {
						query: query_value
					},
					cache: false,
					success: function(html) {
						$(".main_ul").html(html);
					}
				});
			}
			return false;
		});

		$("input#name").on("keyup", function(e) {
			var search_string = $('input#name').val();
			if (search_string == '') {
				$(".main_ul").show();
			}
		});
	});
</script>
<!--searching script end here-->


<!--tab style-->
<script src="js/tabs.js"></script>
<script>
	var myTabs = tabs({
		el: '#tabs',
		tabNavigationLinks: '.c-tabs-nav__link',
		tabContentContainers: '.c-tab'
	});

	myTabs.init();
</script>
<script type="text/javascript">
	$('a[data-toggle="modal_quick_checkin"]').click(function() {
		var arrival_b_id = $(this).attr('id');
		$.ajax({
			url: 'quick_check_in.php?arrival_b_id=' + arrival_b_id,
			success: function(data) {
				$(".popup1").show().html(data);
			}
		});
	});


	//div blink script
	var $div2blink = $(".blink_div"); // Save reference, only look this item up once, then save
	var backgroundInterval = setInterval(function() {
		$div2blink.toggleClass("backgroundRed");
	}, 300)
</script>
<style type="text/css">
	ul.main_ul {
		margin-left: 5px !important;
	}
</style>
</body>

</html>