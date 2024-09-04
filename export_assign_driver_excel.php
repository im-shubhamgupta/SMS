<?php

include('connection.php');

extract($_REQUEST);



	$query = mysqli_query($con,"select * from assign_driver_route where status='0' and session='".$_SESSION['session']."'");	

	

$columnHeader ='';

$columnHeader = "Driver Name".","."Vehicle Name".","."Vehicle Number".","."Route".","."Description";



$data='';



while($res=mysqli_fetch_array($query))

{

	

	$id=$res['assign_id'];

	$driverid=$res['driver_id'];

	$q1 = mysqli_query($con,"select * from driver where id='$driverid'");

	$r1 = mysqli_fetch_array($q1);

	

	$vehicleid=$res['vehicle_id'];

	$q2 = mysqli_query($con,"select * from vehicle where vehicle_id='$vehicleid'");

	$r2 = mysqli_fetch_array($q2);

	

	$routeid=$res['route_id'];

	$q3 = mysqli_query($con,"select * from transports where trans_id='$routeid'");

	$r3 = mysqli_fetch_array($q3);

						

$data .= $r1['name'].",".$r2['vehicle_name'].",".$res['vehicle_no'].",".$r3['route_name'].",".$res['description']."\n";

}

	

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');





$filename =  "Assigndriver".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



echo ucwords($columnHeader)."\n".$data."\n"; 

exit; 



?>

