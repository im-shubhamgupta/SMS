<?php
include('connection.php');
extract($_REQUEST);

$class = $_REQUEST['class'];

	$query =mysqli_query($con,"SELECT * FROM admission WHERE grade='$class' && status='1'");
		

$columnHeader ='';
$columnHeader = "Reference No".","."Requested On".","."Name".","."Father Name".","."Gender".","."Mobile No".","."Requested for Admission".","."Previous School".","."Previous Grade".","."Previous Grade Percentage".","."Address".","."City".","."State".","."Message";


$data='';


while($res=mysqli_fetch_array($query))
{
$refno=$res['reference_no'];
$reqdt=$res['requested_date'];
$newreqdt=date("d-m-y",strtotime($reqdt));
$name=$res['name'];
$fathername=$res['fathername'];
$gender=$res['gender'];
$phone=$res['phone'];
$grade=$res['grade'];
$scls = mysqli_query($con,"select * from class where class_id='$grade'");
$rescls = mysqli_fetch_array($scls);
$classname = $rescls['class_name'];
$prev_school=$res['previous_school'];
$prev_grade=$res['previous_grade'];
$scls1 = mysqli_query($con,"select * from class where class_id='$prev_grade'");
$rescls1 = mysqli_fetch_array($scls1);
$prevclassname = $rescls1['class_name'];
$prev_perc=$res['previous_percentage'];
$address=$res['address'];
$city=$res['city'];
$state=$res['state'];
$req_msg=$res['requested_message'];

						
$data .= $refno.",".$newreqdt.",".$name.",".$fathername.",".$gender.",".$phone.",".$classname.",".$prev_school.","
.$prevclassname.",".$prev_perc.",".$address.",".$city.",".$state.",".$req_msg."\n";
}
	
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');


$filename =  "Requestedforadmission_detail_".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

//echo $data;
echo ucwords($columnHeader)."\n".$data."\n"; 
//echo ucwords($columnHeader)."\n".$setData."\n";
exit; 

?>
