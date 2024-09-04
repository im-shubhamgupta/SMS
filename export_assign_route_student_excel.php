<?php

include('connection.php');

extract($_REQUEST);


	$sql="select * from student_route where 1 and session='".$_SESSION['session']."'";
	$query = mysqli_query($con,$sql);	

	

$columnHeader ='';

$columnHeader = "Name".","."Class".","."Section".","."Route".","."Transport".","."Mode";




$data='';



while($res=mysqli_fetch_array($query)){

	// echo "<pre>";
	// print_r($query);
	// echo "</pre>";

	$stuid=$res['student_id'];

	$q1 = mysqli_query($con,"select * from students where student_id='$stuid' and session='".$_SESSION['session']."'");
	if(mysqli_num_rows($q1)>0){
	$r1 = mysqli_fetch_array($q1);

	$stuname = $r1['student_name'];

	

	$clsid = $r1['class_id'];

	$q2 = mysqli_query($con,"select * from class where class_id='$clsid'");

	$r2 = mysqli_fetch_array($q2);

	$clsname = $r2['class_name'];

	

	$secid = $r1['section_id'];

	$q3 = mysqli_query($con,"select * from section where section_id='$secid'");

	$r3 = mysqli_fetch_array($q3);

	$secname = $r3['section_name'];

	

	$tranid=$res['trans_id'];

	$q4 = mysqli_query($con,"select * from transports where trans_id='$tranid'");

	$r4 = mysqli_fetch_array($q4);

	$transname = $r4['route_name'];

	$transprice = $r4['price'];

	

	$feemodeid=$res['fee_mode_id'];

	$q5 = mysqli_query($con,"select * from fee_mode where fee_mode_id='$feemodeid'");

	$r5 = mysqli_fetch_array($q5);

	$mode = $r5['fee_mode_name'];

						

$data .= $stuname.",".$clsname.",".$secname.",".$transname.",".$transprice.",".$mode."\n";

}
}
	

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');





$filename =  "Assignroute_students".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



echo ucwords($columnHeader)."\n".$data."\n"; 

exit; 



?>

