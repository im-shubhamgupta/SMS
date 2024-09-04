<?php
$con=mysqli_connect("localhost","portalph_trainig","portalph_trainings","training_phptpoint");

$qry=mysqli_query($con,"select * from admission_enquiry");


$data = "";
while($row = mysqli_fetch_array($qry)) 
{
	
$data .= $row['name'].",".$row['mobile'].",".$row['email']."\n";
}



$getdate=getdate();
$m=$getdate['mon'];
$d=$getdate['mday'];
$y=$getdate['year'];
$date=$y."-".$m."-".$d;


$filename =  "$date.csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
 
echo $data;
exit; 
	
?>
