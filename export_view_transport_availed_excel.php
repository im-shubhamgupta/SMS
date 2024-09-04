<?php
include('connection.php');
extract($_REQUEST);

$columnHeader ='';
$columnHeader = "Register No".","."Student Name".","."Class".","."Section".","."Route".","."Transport Fees".","."Paid".","."Balance"."\n";

$data='';
$query=mysqli_query($con,"select * from students where stu_status='0' and trans_id!=''");
	
while($res=mysqli_fetch_array($query))
{
$stuid=$res['student_id'];
									$clid=$res['class_id'];
									$quec=mysqli_query($con,"select * from class where class_id='$clid'");
									$resc=mysqli_fetch_array($quec);
									
									$seid=$res['section_id'];
									$qse=mysqli_query($con,"select * from section where section_id='$seid'");
									$rsec=mysqli_fetch_array($qse);
									
									$transid=$res['trans_id'];
									$qtr=mysqli_query($con,"select * from transports where trans_id='$transid'");
									$rtr=mysqli_fetch_array($qtr);
									$transfee=$rtr['price']-$res['transfee_disc'];
									
									$qbil=mysqli_query($con,"select * from bill where student_id='$stuid'");
									$tpaid=0;
									while($rbill=mysqli_fetch_array($qbil))
									{
									$tpaid=$tpaid+$rbill['transfeepaid'];
									
									}
									$bal=$transfee-$tpaid;						

 $data .= $res['register_no'].",".$res['student_name'].",".$resc['class_name'].",".$rsec['section_name'].",".$rtr['route_name'].",".$transfee.",".$tpaid.",".$bal.","."\n";
}
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');

$filename =  "transportavailed_students_details".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
echo ucwords($columnHeader)."\n".$data."\n"; 
exit; 
?>
