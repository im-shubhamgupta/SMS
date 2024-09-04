<?php
error_reporting(1);
include('myfunction.php');
extract($_REQUEST);

$stuid = $_REQUEST['stuid'];

// echo "hello world123"; die;

?>

<!DOCTYPE html>


<html>

<head>

	<title>Card</title>

	<!-- Latest compiled and minified CSS -->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">



	<!-- jQuery library -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>



	<!-- Popper JS -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>



	<!-- Latest compiled JavaScript -->

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>



	<script type='text/javascript'>
		window.print();
	</script>



	<style>
		@media print {



			.card {

				width: 29rem !important;

				/* height:530px!important; */
				height: 595px !important;

				margin-top: 50px;

				margin-bottom: 50px;



			}



			div {
				page-break-inside: avoid;
			}



			h6 {

				font-size: 19px !important;

			}



			.add {

				font-size: 11px !important;

			}



			.stuadd {

				//border:1px solid red;

				width: 300px;

				height: 60px;

			}

			.table-sm td,
			.table-sm th {
				padding: 2px;
			}



		}

		.table-sm td,
		.table-sm th {
			padding: 2px;
		}
		.table-sm .left{
			width:128px;

		}
	</style>





</head>

<body>



	<?php

	$qset = mysqli_query($con, "select * from setting");

	$rset = mysqli_fetch_array($qset);

	$sclname = $rset['company_name'];

	$scllogo = $rset['company_image'];

	$scladd = $rset['company_address'];

	$sclmob = $rset['company_number'];

	$sclemail = $rset['company_email'];



	$stuarr = explode(',', $stuid);

	foreach ($stuarr as $val) {
		$ssql = "SELECT `student_id`,admission_date,register_no,student_name,father_name,mother_name,dob,blood_grp,stuaddress,`parent_no`,`msg_type_id`,sr.class_id,sr.section_id,sr.roll_no   FROM students as s join student_records as sr on `s`.`student_id`=`sr`.`stu_id` WHERE stu_status='0' and sr.session='" . $_SESSION['session'] . "' and student_id='$val' ";


		$qstu = mysqli_query($con, $ssql);

		$rstu = mysqli_fetch_array($qstu);

		$regno = $rstu['register_no'];
		$student_id = $rstu['student_id'];

		$stuname = $rstu['student_name'];
		$father_name = $rstu['father_name'];
		$mother_name = $rstu['mother_name'];
		$roll_no = $rstu['roll_no'];



		$clsid = $rstu['class_id'];

		$qc = mysqli_query($con, "select * from class where class_id='$clsid'");

		$rc = mysqli_fetch_array($qc);

		$class = $rc['class_name'];



		$secid = $rstu['section_id'];

		$qs = mysqli_query($con, "select * from section where section_id='$secid'");

		$rs = mysqli_fetch_array($qs);

		$section = $rs['section_name'];



		$parentno = $rstu['parent_no'];

		$address = $rstu['stuaddress'];

		$dob = $rstu['dob'];

		$chgdob = date("d-M-Y", strtotime($dob));

		$bloodgrp = $rstu['blood_grp'];
		$stu_image_path = getStudent_byStudent_id($student_id)['stu_image_path'];

		$q1 = mysqli_query($con, "select * from idcard where class_id='$clsid' && section_id='$secid' && regno='$regno' && session='" . $_SESSION['session'] . "'");

		$r1 = mysqli_fetch_array($q1);

		$pic = $r1['pic'];

		// -------------------------------print slno---------------------------------------------------------------
		$type = 'id_card';
		$key = 'IDC';

		$sql1 = "select * from generate_certificate where certificate_type LIKE '$type'  order by id desc limit 1";
		$q2 = mysqli_query($con, $sql1);
		$r2 = mysqli_fetch_assoc($q2);
		$row2 = mysqli_num_rows($q2);
		if ($row2 > 0) {
			$Count2 = substr($r2['certificate_no'], 3);  //return character after 4 words
			if (is_numeric($Count2)) {
				$count = ltrim($Count2, '0');
			}
			$recptno = $key . str_pad($count + 1, 6, "0", STR_PAD_LEFT);
			$no = mysqli_query($con, "INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno','$student_id ', '" . $_SESSION['session'] . "',now())");
			if (!$no) {
				die("Error_description: " . mysqli_error($con));
			}
		} else {
			$recptno = $key . "000001";
			$sql = "INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno', '$student_id ','" . $_SESSION['session'] . "',now())";
			$no = mysqli_query($con, $sql);
			if (!$no) {
				// if(mysqli_error()){
				die("Error__desc: " . mysqli_error($con));
				// }
			}
		}
		$recptno_sch = get_school_details()['company_short_name'] . $recptno;

		// -------------------------------print slno---------------------------------------------------------------	

	?>



		<div class="container">

			<div class="row py-3 pl-3 d-flex" style="float:left;margin-top:20px;">

				<div class="col-md-10">

					<div class="row">

						<div class="col-10 col-md-10 col-lg-10">

							<div class="card" style="width:32rem;height:595px;border-radius:10px; border:3px solid #95C750; border-top:15px solid #95C750;">

								<div class="top_head mt-2 pb-2 " style="border-bottom:2px solid #000;">
									<div class="row">
										<div class="col-md-5" style="padding-left: 16px;margin:1px;font-size:10px;">
											Registration No.: <span><?= get_school_details()['registration_number'] ?></span>
										</div>
										<div class="col-md-6" style="margin:1px;font-size:10px;">
											Affiliation No. / UDISE Code: <span><?= get_school_details()['affiliation_number'] ?></span>
										</div>
									</div>

									<div class="row">

										<div class="col-md-3 col-3">

											<img src="images/profile/<?php echo $scllogo; ?>" class="img-fluid logo text-center ml-3" style="width:100px;height:70px">

										</div>

										<div class="col-md-9 col-9">

											<h6 class="text-center text-dark font-weight-bold" style="font-size:20px;"><?php echo $sclname; ?></h6>

											<p class="text-center pl-4 font-weight-bold add" style="font-size:13px; "><?php echo $scladd; ?> <span class="pl-3"><?php if (get_school_details()['show_number'] == '1') { ?> <?php echo $sclmob; ?> <?php } ?></span></p>

										</div>

									</div>

								</div>



								<div class="card-body">

									<div class="row">



										<div class="col-3 col-lg-3 col-md-3" style="width:100px;height:120px">

											<!-- <img src="gallery/idcard/<?php echo $class; ?>/<?php echo $section; ?>/<?php echo $pic; ?>" alt="" class="img-fluid" style="width:100px;height:120px"> -->
											<img src="<?= $stu_image_path ?>" title="Student Image" alt="" class="img-fluid" style="width:100px;height:120px">

										</div>



										<div class="col-9 col-lg-9 col-md-9">

											<table class="table-sm">

												<tbody>

													<tr>

														<td>Name :</td>

														<td><?php echo $stuname; ?></td>

													</tr>

													<tr>

														<td>Register No :</td>

														<td><?php echo $regno; ?></td>

													</tr>

													<tr>

														<td>Class/ Sec :</td>

														<td><?php echo $class . "-(" . $section . ")"; ?></td>

													</tr>
													<tr>

														<td>Roll no :</td>

														<td><?php echo $roll_no; ?></td>

													</tr>

													<tr>

														<td>Parents's Mobile :</td>

														<td><?php echo $parentno; ?></td>

													</tr>

												</tbody>

											</table>

										</div>



										<div class="col-12 col-lg-12 col-md-12">

											<table class="table-sm">

												<tbody>
													<tr>

														<td class="left">Address :</td>

														<td width="350" height="60px" class="stuadd"><?php echo $address; ?></td>

													</tr>
													<tr>

														<td class="left">Date of birth :</td>

														<td><?php echo $chgdob; ?></td>

														</tr>



													<tr>

														<td class="left">Blood Group :</td>

														<td><?php echo $bloodgrp; ?></td>

													</tr>
													<tr>

														<td class="left">Fathers Name :</td>

														<td><?php echo $father_name; ?></td>

													</tr>
													<tr>

														<td class="left">Mothers Name :</td>

														<td><?php echo $mother_name; ?></td>

													</tr>
												


													<tr>

														<td class="left">Session :</td>

														<td><?= getSessionByid($_SESSION['session'])['year'] ?></td>

													</tr>

												</tbody>

											</table>

										</div>





										<?php

										$q1 = mysqli_query($con, "select * from upload_sign where sign_id='1'");

										$r1 = mysqli_fetch_array($q1);

										$designation = $r1['designation'];

										$signature = $r1['signature'];

										?>

										<div class="col-sm-12" style="margin-top:10px;">

											<div class="row" style="margin-left:10px;">

												<div class="col-sm-6">


												</div>
												<div class="col-md-6" style="text-align:right;">
													<!-- //line-height: 124px; -->
													<?php
													if (!empty($signature) && file_exists('images/signature/' . $signature)) { ?>
														<img src="images/signature/<?php echo $signature; ?>" title='signature' alt="" class="img-fluid m-auto" style="width:100px;height:50px"><br>
													<?php
													} ?>

													<span style="margin-right:20px;"><?php echo $designation; ?></span><br>
													<span style="font-size:8px;text-align:right;">Sl no. : <?= $recptno_sch ?></span>
												</div>

											</div>

										</div>



										<br />

										<br />

										<br />

										<!--/col-->

									</div>

									<!--/row-->

								</div>

								<!--/card-block-->

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>



</body>



<?php

	}

?>



</html>