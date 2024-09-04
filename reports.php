<?php

include('connection.php');

date_default_timezone_set('Asia/Kolkata');

$Sque = mysqli_query($con, "select 	`year` from session  WHERE id='" . $_SESSION['session'] . "'");
$Sres = mysqli_fetch_assoc($Sque);
// echo $Sres['year'];
$only_year = explode('-', $Sres['year']);
$start_year = $only_year[0] . '-04-01';
$next_year = ($start_year + 1) . '-03-31';

if (isset($_REQUEST['Start']) && isset($_REQUEST['End'])) {
	$Start = date('Y-m-d', strtotime($_REQUEST['Start']));
	$End = date('Y-m-d', strtotime($_REQUEST['End']));
} else {
	// $Start = date('Y-m-d',strtotime("-1 Year"));
	// $End = date('Y-m-d');
	$Start = $start_year;
	$End = $next_year;
}
$swf_sql = "select * from student_wise_fees  WHERE 1 and  session='" . $_SESSION['session'] . "' ";
//and DATE(`create_date`) between '".$Start."' and '".$End."'
$que1 = mysqli_query($con, $swf_sql);

$totalfee_tocollect = 0;

while ($res1 = mysqli_fetch_assoc($que1)) {
	// echo "<pre>";
	// print_r($res1);
	// echo "</pre>";die;


	$discamount = $discamount + $res1['discount_amount'];

	$fee_header_id = $res1['fee_header_id'];

	$stramt = $res1['fee_amount'];

	$feeamt = explode(',', $stramt);

	$no_of_months = $res1['no_of_months'];


	$fee_header_id = explode(',', $fee_header_id);


	$NO_Of_Fee_Head = count($fee_header_id);
	$Student_Wise_Total_Amount = 0;
	for ($i = 0; $i < $NO_Of_Fee_Head; $i++) {
		$feeid = $fee_header_id[$i];

		$FHquery = mysqli_query($con, "select * from fee_header where fee_header_id='$feeid'");
		$FHRow = mysqli_fetch_array($FHquery);
		$fheadtype = $FHRow['type'];
		if ($fheadtype == '1') {  //yearly 
			$FeeHeadAmount = $feeamt[$i];

			$FeeHeadAmount = $FeeHeadAmount * $no_of_months;
			$Student_Wise_Total_Amount = $Student_Wise_Total_Amount + $FeeHeadAmount;
		} else {                  //monthly

			$FeeHeadAmount = $feeamt[$i];
			$Student_Wise_Total_Amount = $Student_Wise_Total_Amount + $FeeHeadAmount;
		}
	}

	$TotalFeeToCollect += $Student_Wise_Total_Amount;
}




$grandtotal += $TotalFeeToCollect


?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>

</style>




<!-- <div class="container" style="width:100%"> -->
<div>



	<form action="dashboard.php" method="get" name="SearchForm" id="SearchForm">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-3">
				<span>From</span>
				<input type="date" id="RentFrom" class="form-control RentFrom" name="Start" placeholder="From" min="<?= $start_year ?>" MAX="<?= $next_year ?>" value="<?= $Start; ?>" required />
			</div>
			<div class="col-md-3">
				<span>To</span>
				<input type="date" id="RentTo" class="form-control RentTo" name="End" placeholder="To" min="<?= $start_year ?>" MAX="<?= $next_year ?>" value="<?= $End; ?>" required />
			</div>
			<div class="col-sm-1" style="margin-left:35px;">

				<input type="submit" class="btn btn-primary site-btn float-xs-right" value="Search" style="margin-top: 23px;" required />
			</div>
		</div>
	</form> <br>
	<div class="row">
		<div class="col-sm-10">



			<?php

			if ($_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin" or $_SESSION['user_roles'] == "account" or $_SESSION['user_roles'] == "library" or $_SESSION['user_roles'] == "systemuser") {

			?>



				<button id="student" class="form-control text-white METALLICSEAWEED button" style="margin-bottom:20px">Student & Staff </button>

				<div class="row" id="studentinfo">

					<!-- Number Of students -->

					<div class="col-sm-6 col-lg-4">

						<div class="card text-white CRAYOLA">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								// $qstu=mysqli_query($con,"select student_id from students where  `admission_date` >= '".$Start."' AND `admission_date` <= '".$End."' ");
								$qstu = mysqli_query($con, "select `student_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where s.stu_status='0' && sr.session='" . $_SESSION['session'] . "' ");

								$rstu = mysqli_num_rows($qstu);

								?>



								<h4 class="mb-0">Total Number of Students</h4>
								<h4 class="mb-0">

									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<span class="count"><?php echo $rstu; ?></span>

								</h4><br>
								<a href="dashboard.php?option=view_students" target="_blank" class="btn btn-warning"><i class="fa fa-info-circle"></i> View Details</a><br>

								<div class="chart-wrapper px-0" style="height:70px;" height="70">

									<!--<h6>80%</h6>

					<div class="progress">

							<div class="value"></div>

					</div> -->



								</div>

							</div>

						</div>

					</div>

					<!-- Number Of students -->

					<!-- Number Of Staff -->

					<div class="col-sm-6 col-lg-4">

						<div class="card text-white CRAYOLA">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$qstf = mysqli_query($con, "select * from staff where status='1' ");
								// AND   (`joining_date` >= '".$Start."' AND `joining_date` <= '".$End."')

								$rstf = mysqli_num_rows($qstf);


								$qstt = mysqli_query($con, "select * from staff where status='1'  && teaching_type='Teaching'  ");
								// and (`joining_date` >= '".$Start."' AND `joining_date` <= '".$End."')

								$rstt = mysqli_num_rows($qstt);



								$qstn = mysqli_query($con, "select * from staff where status='1' && teaching_type='Non-Teaching' ");
								//  AND   (`joining_date` >= '".$Start."' AND `joining_date` <= '".$End."')

								$rstn = mysqli_num_rows($qstn);



								$qsto = mysqli_query($con, "select * from staff where status='1'  && teaching_type='Others'");
								// AND   (`joining_date` >= '".$Start."' AND `joining_date` <= '".$End."')

								$rsto = mysqli_num_rows($qsto);

								?>

								<h4 class="mb-0">

									Staff : <span class="count"><?php echo $rstf; ?></span>

								</h4><br>

								<p class="text-light">Teaching : <?php echo $rstt; ?></p>

								<p class="text-light">Non Teaching : <?php echo $rstn; ?></p>

								<p class="text-light">Others : <?php echo $rsto; ?></p>

								<!--<a href="dashboard.php?option=view_students" class="btn btn-warning"><i class="fa fa-info-circle"></i> View Details</a><br>-->

								<div class="chart-wrapper px-0" style="height:70px;" height="70">




								</div>

							</div>

						</div>

					</div>

					<!-- Number Of Staff -->

					<!-- Student Attendence -->

					<div class="col-sm-6 col-lg-4">

						<div class="card text-white CRAYOLA">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$tst = mysqli_query($con, "select `student_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where s.stu_status='0' && sr.session='" . $_SESSION['session'] . "' ");

								$rst = mysqli_num_rows($tst);



								$curdt = date("Y-m-d");

								$tp = mysqli_query($con, "select `student_att_id` from student_daily_attendance where date='$curdt' && type_of_attend='1' and  session='" . $_SESSION['session'] . "' ");

								$rp = mysqli_num_rows($tp);



								$ta = mysqli_query($con, "select `student_att_id` from student_daily_attendance where date='$curdt' && type_of_attend='2' and  session='" . $_SESSION['session'] . "' ");
								$ra = mysqli_num_rows($ta);

								$tl = mysqli_query($con, "select `student_att_id` from student_daily_attendance where date='$curdt' && type_of_attend='3' and  session='" . $_SESSION['session'] . "' ");

								$rl = mysqli_num_rows($tl);

								?>

								<h4 class="mb-0">

									Today's Student Attendence

								</h4><br>

								<p class="text-light">Total Students : <?php echo $rst; ?> </p>

								<p class="text-light">Present : <?php echo $rp; ?> </p>

								<p class="text-light">Absent : <?php echo $ra; ?></p>
								<p class="text-light">Leave : <?php echo $rl; ?></p>




							</div>

						</div>

					</div>

					<!-- Students Attendence -->

				</div>

			<?php

			}

			?>





			<?php

			if ($_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin" or $_SESSION['user_roles'] == "account") {

			?>

				<button id="account" class="form-control text-white METALLICSEAWEED button" style="margin-bottom:20px">Account </button>

				<div class="row" id="accountinfo">



					<!-- Accounts Related -->

					<div class="col-sm-6 col-lg-4">

						<div class="card text-white MARIGOLD">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$tamount = 0;
								$sql = "select * from expense WHERE DATE(`expensed_datetime`) between '" . $Start . "' and '" . $End . "' and  session='" . $_SESSION['session'] . "'  ";

								$sexp = mysqli_query($con, $sql); //DATE(`expensed_datetime`) >= '".$Start."' AND DATE(`expensed_datetime`) <= '".$End."')  and  session='".$_SESSION['session']."'

								while ($rexp = mysqli_fetch_array($sexp)) {

									$tamount += $rexp['amount'];
								}

								?>

								<h4 class="mb-0">

									<i class="fa fa-rupee"></i> <span class="count"> <?php echo $tamount; ?></span>

								</h4><br>

								<p class="text-light">Total Expenses</p>

								<br><br><br><br>

								<a href="dashboard.php?option=view_expense" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:-90px"><i class="fa fa-info-circle"></i> View Details</a>





							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white CRAYOLA">

							<div class="card-body pb-0" style="height:210px;">

								<h4 class="mb-0">

									<i class="fa fa-rupee"></i> <span class="count"><?php echo  "$grandtotal"; ?></span>

								</h4><br>

								<p class="text-light">Total Fees To Collect</p>

								<!--<a href="#" class="btn btn-info"><i class="fa fa-info-circle"></i> View Details</a><br>-->



							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white METALLICSEAWEED">

							<div class="card-body pb-0" style="height:210px;">

								<h4 class="mb-0">

									<i class="fa fa-rupee"></i> <span class="count"><?php echo $discamount; ?></span>

								</h4><br>

								<p class="text-light">Total Fee Discount</p>

								<br><br><br><br>

								<a href="dashboard.php?option=discountedfees_report" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:-90px"><i class="fa fa-info-circle"></i> View Details</a>


							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white CYAN">

							<div class="card-body pb-0" style="height:215px;">

								<?php

								$que3 = mysqli_query($con, "select * from student_due_fees where status!='2' && status!='4'  AND ( DATE(`issue_date`)>= '" . $Start . "' AND DATE(`issue_date`)<= '" . $End . "')  and  session='" . $_SESSION['session'] . "' ");

								while ($rque3 = mysqli_fetch_array($que3)) {

									$recdamt = $rque3['received_amount'];

									$arr = explode(',', $recdamt);

									$prevamt = $rque3['previous_amount'];

									//$tranamt=$rque3['transport_amount'];



									foreach ($arr as $k) {

										$tpaidamt1 = $tpaidamt1 + floatval($k);
									}



									$prev = $prev + $prevamt;

									//$trans = $trans + $tranamt;

									$tpaidamt = $tpaidamt1 + $prev;



									$ptid = $rque3['payment_type_id'];

									if ($ptid == 1) {

										foreach ($arr as $k) {

											$tcash = floatval($tcash) + floatval($k);
										}

										$tp1 = (int)$tp1 + (int)$rque3['previous_amount'];

										$totalcash = (int)$tcash + (int)$tp1;
									} else if ($ptid == 2) {

										foreach ($arr as $k) {

											$tcheque = floatval($tcheque) + floatval($k);
										}

										$tp2 = $tp2 + $rque3['previous_amount'];

										$totalchq = $tcheque + $tp2;
									} else if ($ptid == 3) {

										foreach ($arr as $k) {

											$tdd = floatval($tdd) + floatval($k);
										}

										$tp3 = (int)$tp3 + (int)$rque3['previous_amount'];

										$totaldd = (int)$tdd + (int)$tp3;
									} else if ($ptid == 4) {

										foreach ($arr as $k) {

											$tupi = (int)$tupi + (int)$k;
										}

										$tp4 = (int)$tp4 + (int)$rque3['previous_amount'];

										$totalupi = (int)$tupi + (int)$tp4;
									}
								}





								?>



								<h4 class="mb-0">

									Total Paid Fees - <i class="fa fa-rupee"></i> <span class="count"><?php echo $tpaidamt;; ?></span>

								</h4><br>

								<p class="text-light">Cash : <?php echo $totalcash; ?></p>

								<p class="text-light">Cheque : <?php echo $totalchq; ?></p>

								<p class="text-light">DD : <?php echo $totaldd; ?></p>

								<p class="text-light">UPI : <?php echo $totalupi; ?></p>

								<br><a href="dashboard.php?option=paidstudents_report" target="_blank" class="btn btn-warning btn-sm" style="margin-left:110px;margin-top:-150px"><i class="fa fa-info-circle"></i> View Details</a>



							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white ORIOLES">

							<div class="card-body pb-0" style="height:215px;">

								<?php

								$q1 = mysqli_query($con, "select * from student_wise_fees where session='" . $_SESSION['session'] . "'");

								while ($r1 = mysqli_fetch_array($q1)) {

									$dueamt = $dueamt + $r1['due_amount'];
								}

								?>

								<h4 class="mb-0">

									<i class="fa fa-rupee"></i> <span class="count"><?php echo $dueamt; ?></span>

								</h4><br>

								<p class="text-light">Total Due Fee</p>

								<br><br>

								<a href="dashboard.php?option=duestudents_report" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:10px"><i class="fa fa-info-circle"></i> View Details</a>


							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white DUSTSTORM">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$qdamt = mysqli_query($con, "select * from student_due_fees where status='2'  AND ( DATE(`issue_date`)>= '" . $Start . "' AND DATE(`issue_date`)<= '" . $End . "')  and  session='" . $_SESSION['session'] . "' ");

								$declined = 0;

								while ($rdamt = mysqli_fetch_array($qdamt)) {

									$decamt = $rdamt['received_amount'];

									$darr = explode(',', $decamt);



									foreach ($darr as $dk) {

										$declined = $declined + $dk;
									}
								}



								$qdamt = mysqli_query($con, "select * from student_due_fees where status='3'  AND ( DATE(`issue_date`)>= '" . $Start . "' AND DATE(`issue_date`)<= '" . $End . "' ) and  session='" . $_SESSION['session'] . "'  ");

								$paid = 0;

								while ($rdamt = mysqli_fetch_array($qdamt)) {

									$decamt = $rdamt['received_amount'];

									$darr = explode(',', $decamt);



									foreach ($darr as $dk) {

										$paid = $paid + $dk;
									}
								}



								$total = $declined + $paid;

								?>

								<h4 class="mb-0">

									Declined Amount

								</h4><br>

								<p class="text-light">Paid : <?php echo $paid; ?></p>

								<p class="text-light">Declined : <?php echo $declined; ?></p>

								<a href="dashboard.php?option=reconcile_report" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:18px"><i class="fa fa-info-circle"></i> View Details</a>



							</div>

						</div>

					</div>



					<!-- Accounts Related -->

				</div>

			<?php

			}

			?>





			<?php

			if ($_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin" or $_SESSION['user_roles'] == "systemuser") {

			?>

				<button id="administration" class="form-control text-white METALLICSEAWEED button" style="margin-bottom:20px">Administration </button>

				<div class="row" id="administrationinfo">

					<!-- Administration Related -->

					<div class="col-sm-6 col-lg-4">

						<div class="card text-white bg-flat-color-5">

							<div class="card-body pb-0" style="height:210px;">

								<?php
								//echo "select * from students where stu_status='0' WHERE session='".$_SESSION['session']."'";
								$qs = mysqli_query($con, "select * from students where stu_status='0' AND (`admission_date` >= '" . $Start . "' AND `admission_date` <= '" . $End . "') ");

								$rows = mysqli_num_rows($qs);

								if ($rows) {

									$msgapp = 0;

									$msgadopt = 0;

									$msgblock = 0;

									while ($rs = mysqli_fetch_array($qs)) {

										$msg_type = $rs['msg_type_id'];

										if ($msg_type == 1) {

											$msgapp = $msgapp + 1;
										} else if ($msg_type == 2) {

											$msgadopt = $msgadopt + 1;
										} else if ($msg_type == 3) {

											$msgblock = $msgblock + 1;
										}
									}
								}

								//$appper = round($rapp/$rs*100,2);



								?>

								<h4 class="mb-0">

									Student App Adoption

								</h4><br>

								<p class="text-light">App Adoption : <?php echo $msgapp; ?></p>

								<p class="text-light">Message Adoption : <?php echo $msgadopt; ?></p>

								<p class="text-light">Blocked : <?php echo $msgblock; ?></p>

								<br><a href="dashboard.php?option=view_appadoption_detail" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:-90px"><i class="fa fa-info-circle"></i> View Details</a>

								<br><br><br>

							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white bg-info">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$qfeed = mysqli_query($con, "select * from feedback WHERE  (`submission_date` >= '" . $Start . "' AND `submission_date` <= '" . $End . "')");

								$rfeed = mysqli_num_rows($qfeed);



								$qfeed1 = mysqli_query($con, "select * from feedback where status='1' AND (`submission_date` >= '" . $Start . "' AND `submission_date` <= '" . $End . "')");

								$rfeed1 = mysqli_num_rows($qfeed1);



								$qfeed2 = mysqli_query($con, "select * from feedback where status='0' AND (`submission_date` >= '" . $Start . "' AND `submission_date` <= '" . $End . "')");

								$rfeed2 = mysqli_num_rows($qfeed2);

								?>

								<h4 class="mb-0">

									No of Feedback Submitted : <span class="count"><?php echo $rfeed; ?></span>

								</h4><br>

								<p class="text-light">Responded : <?php echo $rfeed1; ?></p>

								<p class="text-light">Not Responded : <?php echo $rfeed2; ?></p>

								<br><a href="dashboard.php?option=response_feedback" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:-40px"><i class="fa fa-info-circle"></i> View Details</a>

								<br><br><br>

							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white bg-danger">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$qleave = mysqli_query($con, "select * from student_leave WHERE  (`submission_date` >= '" . $Start . "' AND `submission_date` <= '" . $End . "') and  session='" . $_SESSION['session'] . "' ");

								$rleave = mysqli_num_rows($qleave);



								$qresp = mysqli_query($con, "select * from student_leave where status='1' || status='2' AND (`submission_date` >= '" . $Start . "' AND `submission_date` <= '" . $End . "') and  session='" . $_SESSION['session'] . "' ");

								$rresp = mysqli_num_rows($qresp);



								$qnresp = mysqli_query($con, "select * from student_leave where status='0' AND (`submission_date` >= '" . $Start . "' AND `submission_date` <= '" . $End . "') and  session='" . $_SESSION['session'] . "' ");

								$rnresp = mysqli_num_rows($qnresp);

								?>

								<h4 class="mb-0">

									No of Leave Submitted : <span class="count"><?php echo $rleave; ?></span>

								</h4><br>

								<p class="text-light">Responded : <?php echo $rresp; ?></p>

								<p class="text-light">Not Responded : <?php echo $rnresp; ?></p>

								<br><a href="dashboard.php?option=approve_leaves" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:-10px"><i class="fa fa-info-circle"></i> View Details</a>

								<br><br><br>

							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white MARIGOLD">

							<div class="card-body pb-0" style="height:210px;">

								<?php
								$qoldadm = mysqli_query($con, "select `student_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where adm_type_id='1' and stu_status='0' and sr.session='" . $_SESSION['session'] . "' ");

								// $qoldadm=mysqli_query($con,"select * from students where adm_type_id='1' AND (`admission_date` >= '".$Start."' AND `admission_date` <= '".$End."')");

								$oldadm = mysqli_num_rows($qoldadm);



								// $qnewadm=mysqli_query($con,"select * from students where adm_type_id='2' AND (`admission_date` >= '".$Start."' AND `admission_date` <= '".$End."')");
								$qnewadm = mysqli_query($con, "select `student_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where adm_type_id='2' and stu_status='0'  and sr.session='" . $_SESSION['session'] . "' ");


								$newadm = mysqli_num_rows($qnewadm);



								// $qmidadm=mysqli_query($con,"select * from students where adm_type_id='3' AND (`admission_date` >= '".$Start."' AND `admission_date` <= '".$End."')");
								$qmidadm = mysqli_query($con, "select `student_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where adm_type_id='3' and stu_status='0'  and sr.session='" . $_SESSION['session'] . "' ");

								$midadm = mysqli_num_rows($qmidadm);

								?>

								<h4 class="mb-0">

									Admission Details

								</h4><br>

								<p class="text-light">Old Admission : <?php echo $oldadm; ?></p>

								<p class="text-light">New Admission : <?php echo $newadm; ?></p>

								<p class="text-light">Mid-Year Admission: <?php echo $midadm; ?></p>

								<br><a href="dashboard.php?option=view_students" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:-80px"><i class="fa fa-info-circle"></i> View Details</a>

								<br><br><br>

							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white DUSTSTORM">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$qstu = mysqli_query($con, "select * from installed_app WHERE (`date` >= '" . $Start . "' AND `date` <= '" . $End . "') ");

								$rstu = mysqli_num_rows($qstu);

								?>

								<h4 class="mb-0">

									App User : <span class="count"><?php echo $rstu; ?></span>

								</h4><br>

								<p class="text-light">Total Number of Installed App</p>

								<!--<a href="dashboard.php?option=view_students" class="btn btn-warning"><i class="fa fa-info-circle"></i> View Details</a><br>-->

								<div class="chart-wrapper px-0" style="height:70px;" height="70">

								</div>

								<br><a href="dashboard.php?option=view_appinstalled_detail" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:-60px"><i class="fa fa-info-circle"></i> View Details</a>



							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white bg-flat-color-4">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$que1 = mysqli_query($con, "SELECT * FROM `remedy` where 1 and  session='" . $_SESSION['session'] . "' ");

								$totalremedy = mysqli_num_rows($que1);



								$que2 = mysqli_query($con, "SELECT * FROM `remedy` where status='1' and  session='" . $_SESSION['session'] . "' ");

								$approvedremedy = mysqli_num_rows($que2);



								$que3 = mysqli_query($con, "SELECT * FROM `remedy` where status='0' and  session='" . $_SESSION['session'] . "' ");

								$inprogressremedy = mysqli_num_rows($que3);

								?>

								<h4 class="mb-0">

									No of Remedies Submitted : <span class="count"><?php echo $totalremedy; ?></span>

								</h4><br>

								<p class="text-light">Aprroved Remedies : <?php echo $approvedremedy; ?></p>

								<p class="text-light">In Progress Remedies : <?php echo $inprogressremedy; ?></p>

								<br><a href="dashboard.php?option=view_approval_remedy" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:-40px"><i class="fa fa-info-circle"></i> View Details</a>

								<br><br><br>

							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white bg-success">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$qal = mysqli_query($con, "select * from allocate_budget where `session` = '" . $_SESSION['session'] . "'");

								$allocated_budget = 0;

								while ($rql = mysqli_fetch_array($qal)) {

									$allocated_budget += $rql['allocate_amount'];
								}


								$qbe = mysqli_query($con, "select * from allocate_budget_expense  WHERE (`expense_date` >= '" . $Start . "' AND `expense_date` <= '" . $End . "') and  session='" . $_SESSION['session'] . "' ");

								$expensed_amount = 0;

								while ($rbe = mysqli_fetch_array($qbe)) {

									$expensed_amount += $rbe['expensed_amount'];
								}



								$remaining_amount = $allocated_budget - $expensed_amount;



								?>

								<h4 class="mb-0">

									Budget Details

								</h4><br>

								<p class="text-light">Allocated Budget : <?php echo $allocated_budget; ?></p>

								<p class="text-light">Utilized Budget : <?php echo $expensed_amount; ?></p>

								<p class="text-light">Remaining Budget : <?php echo $remaining_amount; ?></p>

								<br><a href="dashboard.php?option=view_allocated_budget_expense" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:-80px"><i class="fa fa-info-circle"></i> View Details</a>

								<br><br><br>

							</div>

						</div>

					</div>

					<!-- Administration Related -->

				</div>

			<?php

			}

			?>





			<?php

			if ($_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin" or $_SESSION['user_roles'] == "stock" or $_SESSION['user_roles'] == "systemuser") {

			?>

				<button id="stock" class="form-control text-white METALLICSEAWEED button" style="margin-bottom:20px">Stock </button>

				<div class="row" id="stockinfo">

					<!--Stock Related-->

					<div class="col-sm-6 col-lg-4">

						<div class="card text-white bg-flat-color-4">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$quantity1 = 0;

								$quantity2 = 0;

								$quantity3 = 0;

								$quantity4 = 0;

								$que1 = mysqli_query($con, "SELECT * FROM `purchase_order` WHERE 1 ");

								while ($r1 = mysqli_fetch_array($que1)) {

									$quantity1 += $r1['quantity'];
								}



								$que2 = mysqli_query($con, "SELECT * FROM `issue_order` ");  // and  session='".$_SESSION['session']."'

								while ($r2 = mysqli_fetch_array($que2)) {

									$quantity2 += $r2['quantity'];
								}



								$que3 = mysqli_query($con, "SELECT * FROM `return_stock`");

								while ($r3 = mysqli_fetch_array($que3)) {

									$quantity3 += $r3['return_qty'];
								}



								$que4 = mysqli_query($con, "SELECT * FROM `dead_stock`");

								while ($r4 = mysqli_fetch_array($que4)) {

									$quantity4 += $r4['dead_stock_qty'];
								}



								$availablestock = $quantity1 - $quantity2 - $quantity3 - $quantity4;

								?>

								<h4 class="mb-0">

									Total Number of Stock : <span class="count"><?php echo $quantity1; ?></span>

								</h4><br>

								<p class="text-light">Issued Stock : <?php echo $quantity2; ?></p>

								<p class="text-light">Returned Stock : <?php echo $quantity3; ?></p>

								<p class="text-light">Avialable Stock : <?php echo $availablestock; ?></p>

								<p class="text-light">Dead Stock : <?php echo $quantity4; ?></p>

								<br><a href="dashboard.php?option=stock_available" target="_blank" class="btn btn-warning btn-sm" style="margin-left:110px;margin-top:-140px"><i class="fa fa-info-circle"></i> View Details</a>

								<br><br><br>

							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white bg-flat-color-5">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$qsto = mysqli_query($con, "select * from stock_vendor");

								$rsto = mysqli_num_rows($qsto);



								$qpub = mysqli_query($con, "select * from publisher");

								$rpub = mysqli_num_rows($qpub);



								$qbranch = mysqli_query($con, "select * from branch");

								$rbranch = mysqli_num_rows($qbranch);

								?>

								<h4 class="mb-0">

									Stock Vendor Details

								</h4><br>

								<p class="text-light">Total No. of Vendors : <?php echo $rsto; ?></p>

								<br><a href="dashboard.php?option=view_stock_vendor" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:40px"><i class="fa fa-info-circle"></i> View Details</a>

								<br><br><br>

							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white bg-info">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$q1 = mysqli_query($con, "select * from purchase_order where 1 and  session='" . $_SESSION['session'] . "' ");

								//$total_amt = 0;

								while ($r1 = mysqli_fetch_array($q1)) {

									$quantity = $r1['quantity'];

									$amt_per_item = $r1['amt_per_item'];

									$total_amt = $total_amt + $quantity * $amt_per_item;



									$paidamount += $r1['amount'];



									$discount = $total_amt - $paidamount;
								}

								?>

								<h4 class="mb-0">

									Stock Amount Summary

								</h4><br>

								<p class="text-light">Total Purchase Amount : <?php echo $total_amt; ?></p>

								<p class="text-light">Paid Amount : <?php echo $paidamount; ?></p>

								<p class="text-light">Discount : <?php echo $discount; ?></p>

								<br><a href="dashboard.php?option=view_purchase_report" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:-80px"><i class="fa fa-info-circle"></i> View Details</a>

								<br><br><br>

							</div>

						</div>

					</div>

					<!--Stock Related-->

				</div>

			<?php

			}

			?>





			<?php

			if ($_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin" or $_SESSION['user_roles'] == "library" or $_SESSION['user_roles'] == "systemuser") {

			?>

				<button id="library" class="form-control text-white METALLICSEAWEED button" style="margin-bottom:20px">Library </button>

				<div class="row" id="libraryinfo">

					<!-- Library -->

					<div class="col-sm-6 col-lg-4">

						<div class="card text-white CRAYOLA">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$qbooks = mysqli_query($con, "select * from books");

								while ($rbooks = mysqli_fetch_array($qbooks)) {

									$totalbooks += $rbooks['quantity'];
								}



								$q4 = mysqli_query($con, "select * from issue_bookto_students where return_status='0' and  session='" . $_SESSION['session'] . "' ");

								$stureturnqty = mysqli_num_rows($q4);

								$q5 = mysqli_query($con, "select * from issue_bookto_faculty where return_status='0' and  session='" . $_SESSION['session'] . "' ");

								$facreturnqty = mysqli_num_rows($q5);



								$issuedbook = $stureturnqty + $facreturnqty;

								$balbook = $totalbooks - $issuedbook;

								?>

								<h4 class="mb-0">

									Book Details

								</h4><br>

								<p class="text-light">Total No. of Books : <?php echo $totalbooks; ?></p>

								<p class="text-light">Issued Books : <?php echo $issuedbook; ?></p>

								<p class="text-light">Balance Books: <?php echo $balbook; ?></p>

								<br><a href="dashboard.php?option=book_available_detail" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:-80px"><i class="fa fa-info-circle"></i> View Details</a>

								<br><br><br>

							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white DUSTSTORM">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$qven = mysqli_query($con, "select * from vendor");

								$rven = mysqli_num_rows($qven);



								$qpub = mysqli_query($con, "select * from publisher");

								$rpub = mysqli_num_rows($qpub);



								$qbranch = mysqli_query($con, "select * from branch");

								$rbranch = mysqli_num_rows($qbranch);

								?>

								<h4 class="mb-0">

									Vendor & Publisher Details

								</h4><br>

								<p class="text-light">Total No. of Vendors : <?php echo $rven; ?></p>

								<p class="text-light">Total No. of Publishers : <?php echo $rpub; ?></p>

								<p class="text-light">Total No. of Branches : <?php echo $rbranch; ?></p>

								<br>

								<br><br><br>

							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white ORIOLES">

							<div class="card-body pb-0" style="height:210px;">

								<?php

								$query = mysqli_query($con, "SELECT * FROM `issue_bookto_students` WHERE `return_status`='0' and session='" . $_SESSION['session'] . "'");

								while ($res = mysqli_fetch_array($query)) {

									$retdt = $res['return_date'];

									$curdate = date("Y-m-d");

									$date1 = date_create($curdate);

									$date2 = date_create($retdt);

									$diff = date_diff($date2, $date1);

									$tdays = $diff->format("%R%a days");



									$rettypeid = $res['return_type_id'];

									$q3 = mysqli_query($con, "select * from book_return_type where book_return_type_id ='$rettypeid'");

									$r3 = mysqli_fetch_array($q3);

									$amt = $r3['book_fine_per_day'];



									if ($tdays > 0) {

										$tpenalty += $tdays * $amt;
									} else {

										$tpenalty = 0;
									}



									$q4 = mysqli_query($con, "select * from library_payment");

									$tpaid = 0;

									while ($r4 = mysqli_fetch_array($q4)) {

										$tpaid += $r4['paid_amount'];
									}

									$tdue = $tpenalty - $tpaid;
								}



								?>

								<h4 class="mb-0">

									<i class="fa fa-rupee"></i> <span class="count"><?php echo $tdue; ?></span>

								</h4><br>

								<p class="text-light">Total Penalty Due</p>

								<br><a href="dashboard.php?option=penalty_collection" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:40px"><i class="fa fa-info-circle"></i> View Details</a>



							</div>

						</div>

					</div>

					<!-- Library -->

				</div>

			<?php

			}

			?>





			<?php

			if ($_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin" or $_SESSION['user_roles'] == "transport") {

			?>

				<button id="transport" class="form-control text-white METALLICSEAWEED button" style="margin-bottom:20px">Transport</button>

				<div class="row" id="transportinfo">

					<!--Transport Related-->

					<div class="col-sm-6 col-lg-4">

						<div class="card text-white bg-flat-color-4">

							<div class="card-body pb-0" style="height:230px;">

								<?php

								$qta = mysqli_query($con, "select * from student_route WHERE  (`create_date` >= '" . $Start . "' AND `create_date` <= '" . $End . "')  and session='" . $_SESSION['session'] . "' ");

								$rta = mysqli_num_rows($qta);

								$transamt = 0;

								while ($res = mysqli_fetch_array($qta)) {

									$transamt = $transamt + $res['price'];
								}

								?>

								<h4 class="mb-0">

									<i class="fa fa-rupee"></i> <span class="count"><?php echo $transamt; ?></span>

								</h4><br>

								<p class="text-light">Tranport Availed : <span class="count"><?php echo $rta; ?></span></p>

								<br><a href="dashboard.php?option=view_route_to_student" target="_blank" class="btn btn-warning btn-sm" style="margin-left:100px;margin-top:60px"><i class="fa fa-info-circle"></i> View Details</a>

								<br><br><br>

							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white bg-info">

							<div class="card-body pb-0" style="height:230px;">

								<?php

								$qta = mysqli_query($con, "select * from student_route WHERE (`create_date` >= '" . $Start . "' AND `create_date` <= '" . $End . "')   and session='" . $_SESSION['session'] . "'");

								$rta = mysqli_num_rows($qta);

								$transamt = 0;

								while ($res = mysqli_fetch_array($qta)) {

									$transamt = $transamt + $res['price'];
								}



								$q1 = mysqli_query($con, "select * from driver where designation='Driver' and status='0' AND (`modify_date` >= '" . $Start . "' AND `modify_date` <= '" . $End . "') ");

								$rdriver = mysqli_num_rows($q1);



								$q2 = mysqli_query($con, "select * from driver where designation='Cleaner' and status='0' AND (`modify_date` >= '" . $Start . "' AND `modify_date` <= '" . $End . "') ");

								$rcleaner = mysqli_num_rows($q2);



								$q3 = mysqli_query($con, "select * from vehicle where status='0' and session='".$_SESSION['session']."' ");

								$rvehicle = mysqli_num_rows($q3);



								$q4 = mysqli_query($con, "select * from transports WHERE 1 and session='".$_SESSION['session']."' ");
								// (`modify_date` >= '".$Start."' AND `modify_date` <= '".$End."')

								$rroute = mysqli_num_rows($q4);



								?>

								<h4 class="mb-0">

									Transport Details

								</h4><br>

								<p class="text-light">Total No. of Drivers : <?php echo $rdriver; ?></p>

								<p class="text-light">Total No. of Cleaners : <?php echo $rcleaner; ?></p>

								<p class="text-light">Total No. of Vehicles : <?php echo $rvehicle; ?></p>

								<p class="text-light">Total No. of Routes : <?php echo $rroute; ?></p>

								<br>

								<br><br><br>

							</div>

						</div>

					</div>



					<div class="col-sm-6 col-lg-4">

						<div class="card text-white bg-success">

							<div class="card-body pb-0" style="height:230px;">

								<?php



								$qtr = mysqli_query($con, "select * from previous_transport_fees WHERE (`modify_date` >= '" . $Start . "' AND `modify_date` <= '" . $End . "')  and session='" . $_SESSION['session'] . "'");

								$totalcollected = 0;

								$totalprevfee = 0;

								$totaldiscfee = 0;

								while ($rtr = mysqli_fetch_array($qtr)) {

									$totalprevfee = $totalprevfee + $rtr['previous_transport_fees'];
								}



								$qta = mysqli_query($con, "select * from student_route where 1 and session='" . $_SESSION['session'] . "'");

								while ($res = mysqli_fetch_array($qta)) {

									$totaltransamt = $totaltransamt + $res['price'];

									$totaldiscfee = $totaldiscfee + $res['discount'];
								}



								$q1 = mysqli_query($con, "select * from student_transport_due_fees where status!='2' and status!='4' AND (`modify_date` >= '" . $Start . "' AND `modify_date` <= '" . $End . "')  and session='" . $_SESSION['session'] . "' ");

								while ($r1 = mysqli_fetch_array($q1)) {

									$totalcollected += $r1['trans_amount'] + $r1['previous_trans_amount'];
								}



								$totalpending = $totaltransamt + $totalprevfee - $totalcollected;

								$totalfee_tocollect = $totalprevfee + $totaltransamt;



								?>

								<h4 class="mb-0">

									Transport Fee Details

								</h4><br>

								<p class="text-light">

									Total Fee to Collect : <?php echo $totalfee_tocollect; ?><br />

									Fees Collected : <?php echo $totalcollected; ?><br />

									Fees Pending : <?php echo $totalpending; ?><br />

									Previous Fees : <?php echo $totalprevfee; ?><br />

									Discounted Fees : <?php echo $totaldiscfee; ?><br />

									<a href="dashboard.php?option=paid_transport_report" target="_blank" class="btn btn-warning btn-sm" style="margin-left:150px;margin-top:10px"><i class="fa fa-info-circle"></i> View</a>

								</p>



							</div>

						</div>

					</div>

					<!--Transport Related-->

				</div>

			<?php

			}

			?>



		</div>
	



		<?php

		if (
			$_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin"

		) {

		?>

			<!-- <div class="col-sm-2 form-control text-white METALLICSEAWEED">Quick Actions -->
			<div class="col-sm-2 ">
				<span style="margin-bottom:20px" class="form-control text-white METALLICSEAWEED">Quick Actions</span>

				<!-- <p></p> -->

				<a href="dashboard.php?option=view_expense">Add/View Expenses</a><br />

				<a href="dashboard.php?option=view_student_fees_detail">Collect Fees</a><br />

				<a href="dashboard.php?option=duestudents_report">Due Fees Report</a>

				<a href="dashboard.php?option=expense_report">Expense Report</a>



			</div>

		<?php

		}

		?>

	</div>	



</div>



<br />



<script>
	$(document).ready(function() {

		$("#student").click(function() {

			$("#studentinfo").fadeToggle();

		});


	});



	$(document).ready(function() {

		$("#account").click(function() {

			$("#accountinfo").fadeToggle();



		});

	});



	$(document).ready(function() {

		$("#administration").click(function() {

			$("#administrationinfo").fadeToggle();



		});

	});



	$(document).ready(function() {

		$("#stock").click(function() {

			$("#stockinfo").fadeToggle();

		});

	});



	$(document).ready(function() {

		$("#library").click(function() {

			$("#libraryinfo").fadeToggle();



		});

	});



	$(document).ready(function() {

		$("#transport").click(function() {

			$("#transportinfo").fadeToggle();



		});

	});
</script>