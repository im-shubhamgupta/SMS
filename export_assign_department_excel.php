<?php
include('connection.php');
extract($_REQUEST);

$deptid = $_REQUEST['deptid'];

$columnHeader ='';
$columnHeader = "Department Name".","."Staff Name";


$data='';

$query = mysqli_query($con,"SELECT * from assign_department where dept_id='$deptid'");
while($res=mysqli_fetch_array($query))
{
	
$depid=$res['dept_id'];
$q1 = mysqli_query($con,"select * from department where dept_id='$depid'");
$r1 = mysqli_fetch_array($q1);
$depname = $r1['dept_name'];

$stid=$res['staff_id'];
$q2 = mysqli_query($con,"select * from staff where st_id='$stid'");
$r2 = mysqli_fetch_array($q2);
$stname = $r2['staff_name'];

						
$data .= $depname.",".$stname."\n";
}
	
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');


$filename =  "Assigndepartment_".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

//echo $data;
echo ucwords($columnHeader)."\n".$data."\n"; 
//echo ucwords($columnHeader)."\n".$setData."\n";
exit; 

?>
