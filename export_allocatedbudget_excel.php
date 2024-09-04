<?php

include('connection.php');

extract($_REQUEST);



$columnHeader ='';

$columnHeader = "Allocated Budget Header".","."Allocated Amount";



$data='';



$q1 = mysqli_query($con,"SELECT * FROM allocate_budget and session='".$_SESSION['session']."' ");

while($r1=mysqli_fetch_array($q1))

{

	$headerid = $r1['budget_header_id'];

	$amount=$r1['allocate_amount'];

	$q2=mysqli_query($con,"select * from budget_header where budget_header_id ='$headerid'");

	$r2=mysqli_fetch_array($q2);

	$header_name = $r2['budget_header_name'];

	

	$tamt = $tamt + $amount;



 $data .= $header_name.",".$amount."\n";

}

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');



$filename =  "Allocatedbudget_Report".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



echo ucwords($columnHeader)."\n".$data."\n"; 

exit; 



?>

