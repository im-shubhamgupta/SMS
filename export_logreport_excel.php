<?php

include('connection.php');

extract($_REQUEST);



$query=mysqli_query($con,"select * from student_due_fees where status=4  and session='".$_SESSION['session']."'");

	

$columnHeader ='';

$columnHeader = "Deleted By".","."Deleted Date".","."Action Type".","."Amount".","."Action".","."Reason";



$data='';



while($res=mysqli_fetch_array($query))

{

$stuid=$res['student_id'];

$q1=mysqli_query($con,"select * from students where student_id='$stuid'  and session='".$_SESSION['session']."'");

$r1=mysqli_fetch_array($q1);

$stuname=$r1['student_name'];

$regno=$r1['register_no'];

$tamt = $res['total_amount'];							

$user=$res['loginuser'];	

$actdt = $res['action_date'];

$nactdt = date("d-m-Y H:i:s", strtotime($actdt));	

$action = "The Paid Fees of amount $tamt for the Student '$stuname' Register Number '$regno' is deleted by '$user'.";	

						

$data .= $res['loginuser'].",".$nactdt.",".$res['action_type'].",".$tamt.",".$action.",".$res['reason']."\n";

}

	

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');





$filename =  "Logreport_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

