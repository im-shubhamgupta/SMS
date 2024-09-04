<?php

include('myfunction.php');

extract($_REQUEST);



$class = $_REQUEST['class'];

$section = $_REQUEST['section'];

$student = $_REQUEST['student'];



$columnHeader ='';

$columnHeader.= "Name".","."Month".","."Present".","."Percentage";



$data='';



	$q = mysqli_query($con,"select * from students where student_id='$student'");

	$r = mysqli_fetch_array($q);

	$stuname = $r['student_name'];



	// $q1 = mysqli_query($con,"select * from academic_year");

	// $r1 = mysqli_fetch_array($q1);

	// $year = $r1['acd_year_start'];
	$year=getSessionByid($_SESSION['session'])['only_year'];



	$yr = "april".$year;

	$start = strtotime($yr);

	for ($i = 0; $i <= 11; $i++) 

	{

	$time = strtotime(sprintf('+%d months', $i), $start);

	$label = date('F Y', $time);

	$month = date('m', $time);

	$year = date('Y', $time);



	$qatt = mysqli_query($con,"select * from student_daily_attendance where student_id='$student' && month(date)='$month' && year(date)='$year'");

									

	$totalrow = mysqli_num_rows($qatt);

	$present=0;

	$absent=0;

	$leave=0;

	$monthlypercent=0;

	while($res = mysqli_fetch_array($qatt))

	{

		$attendance = $res['type_of_attend'];

		if($attendance==1)

		{

			$present = $present+1;

		}

		else if($attendance==2)

		{

			$absent = $absent+1;

		}

		else if($attendance==3)

		{

			$leave = $leave+1;

		}

	}

	

	$totalpresent = $present+$leave;

	$tpresent = $totalpresent."(".$totalrow.")";

	$monthlypercent = round($totalpresent/$totalrow*100,2)." %";

																										

	$data.= $stuname.",".$label.",". $tpresent.",".$monthlypercent."\n";



	}

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');



$filename =  "yearly_attendance_report_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



echo ucwords($columnHeader)."\n".$data."\n"; 

exit; 



?>

