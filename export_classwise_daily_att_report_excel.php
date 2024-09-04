<?php

include('connection.php');

extract($_REQUEST);



$class = $_REQUEST['class'];

$section = $_REQUEST['section'];

$fromdt = $_REQUEST['fromdt'];

$todt = $_REQUEST['todt'];



	$query=mysqli_query($con,"select distinct(date) from student_daily_attendance 

	where class_id='$class' && section_id='$section' && (date between '$fromdt' and '$todt') && session='".$_SESSION['session']."'");



$columnHeader ='';

$columnHeader.= "Name".",";

	

	while($res = mysqli_fetch_array($query))

	{

		$adatearr[] = $res['date'];

		$adate = $res['date'];

		$chgdt = date("d-m-Y",strtotime($adate));



$columnHeader.="$chgdt".",";



}

$columnHeader.="Attendance Percentage";
// ."\n"
$data='';



		$sr = 1;
		$ssql="select distinct(a.student_id), b.student_name , sr.roll_no from 

		student_daily_attendance a inner join students b on a.student_id=b.student_id join student_records as sr  ON `a`.`student_id`= `sr`.`stu_id`

		where a.class_id='$class' && a.section_id='$section' && sr.class_id='$class' && a.section_id='$section'  && sr.session='".$_SESSION['session']."' order by sr.roll_no asc";
		$que1=mysqli_query($con,$ssql);
		// $que1=mysqli_query($con,"select distinct(a.student_id), b.student_name from 

		// student_daily_attendance a inner join students b on a.student_id=b.student_id

		// where a.class_id='$class' && a.section_id='$section' && a.session='".$_SESSION['session']."'");

		

		while($res1 = mysqli_fetch_array($que1))

		{

		$stuid = $res1['student_id'];

		$stuname=$res1['student_name'];			

			

			$data.= $stuname.",";	

					

					$rowcount=0;

					$present=0;

					$absent=0;

					$leave=0;

					foreach($adatearr as $k)

					{



					$que2 = mysqli_query($con,"select * from student_daily_attendance where student_id='$stuid' && date='$k' && session='".$_SESSION['session']."'");

					if(mysqli_num_rows($que2))

					{

					$rowcount=$rowcount+1;

					}	

					

					$res2 = mysqli_fetch_array($que2);

					$attend=$res2['type_of_attend'];

						if($attend==1)

						 {

							$present=$present+1; 

						 }

						 else if($attend==2)

						 {

							 $absent=$absent+1;

						 }

						 else if($attend==3)

						 {

							 $leave=$leave+1;

						 }

					$queatt=mysqli_query($con,"select * from attendance_type where att_type_id='$attend'");

					$ratt=mysqli_fetch_array($queatt);

					// $attname=$ratt['short_name'];
					$attname=$ratt['att_type_name'];

																									

			$data.= $attname.",";

			

					}

						$att_percentage = round(($present+$leave)/$rowcount*100,2)." %";

					

			$data.= $att_percentage."\n";	

			

					}

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');



$filename =  "classwise_daily_attendance_report_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



echo ucwords($columnHeader)."\n".$data."\n"; 

exit; 



?>

