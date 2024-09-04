<?php

include('connection.php');

extract($_REQUEST);



	$query = mysqli_query($con,"select * from vehicle where status='0' and `session`='".$_SESSION['session']."' ORDER BY 'modify_date' DESC");	

	

$columnHeader ='';

$columnHeader = "Vehicle Name".","."Vehicle Type".","."Vehicle No".","."Chassis No".","."Purchased Year".","."Vehicle Status".","."About Vehicle".","."Previous Experience".","."Description";



$data='';



while($res=mysqli_fetch_array($query))

{

						

$data .= $res['vehicle_name'].",".$res['vehicle_type'].",".$res['vehicle_number'].",".$res['chassis_no'].",".$res['purchased_year'].","

.$res['vehicle_status'].",".$res['about_vehicle'].",".$res['prev_exp'].",".$res['description']."\n";

}

	

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');





$filename =  "Vehicledetail_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



echo ucwords($columnHeader)."\n".$data."\n"; 

exit; 



?>

