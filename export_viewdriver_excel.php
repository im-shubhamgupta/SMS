<?php

include('connection.php');

extract($_REQUEST);



	$query = mysqli_query($con,"select * from driver where status='0' and session='".$_SESSION['session']."'");	

	

$columnHeader ='';

$columnHeader = "Name".","."Father Name".","."Gender".","."Mobile No.".","."Alternate No.".","."City".","."Address".","."Designation".","."Experience".","."DL Number".","."Aadhar No".","."Previous Experience".","."Description";



$data='';



while($res=mysqli_fetch_array($query))

{

						

$data .= $res['name'].",".$res['father_name'].",".$res['gender'].",".$res['mobile'].",".$res['alternate_no'].","

.$res['address'].",".$res['city'].",".$res['designation'].",".$res['experience'].",".$res['dlno'].",".$res['aadhar_no'].

",".$res['previous_exp'].",".$res['description']."\n";

}

	

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');





$filename =  "Driverdetail_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



echo ucwords($columnHeader)."\n".$data."\n"; 

exit; 



?>

