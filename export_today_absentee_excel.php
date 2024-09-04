<?php
include('connection.php');
extract($_REQUEST);

	$curdate = $_REQUEST['curdate'];

	$cond = '';
	
	if($_REQUEST['class']!='') 
	{
		 $cond.=" && sdt.class_id='$_REQUEST[class]'";
		 $cond.=" && sr.class_id='$_REQUEST[class]'";
	}
	if($_REQUEST['section']!='') 
	{
		 $cond.=" && sdt.section_id='$_REQUEST[section]'";
		 $cond.=" && sr.section_id='$_REQUEST[section]'";
	}
		$cond.=" && sdt.session='".$_SESSION['session']."' ";
		$cond.=" && sr.session='".$_SESSION['session']."' ";
	
	// $sqll="select * from student_daily_attendance where date='$curdate' && type_of_attend='2' $cond";
    $sqll="select sdt.student_id,sdt.class_id,sdt.section_id,sr.roll_no from student_daily_attendance as sdt join student_records as sr  ON `sdt`.`student_id`= `sr`.`stu_id`  where sdt.date='$curdate' && sdt.type_of_attend='2' $cond";

	 $sqll.=" order by sr.roll_no asc ";
	 // echo $sqll;
	 // die;
$query=mysqli_query($con,$sqll);
	
$columnHeader ='';
$columnHeader = "Name".","."Class".","."Section".","."Roll no.".","."Father Name".","."Father Contact";

$data='';

while($res=mysqli_fetch_array($query))
{
// print_r($res);
	
$stuid=$res['student_id'];
 $sql="select student_name,father_name,parent_no,sr.roll_no from students as s join student_records as sr  ON `s`.`student_id`= `sr`.`stu_id` where student_id='$stuid' && sr.session='".$_SESSION['session']."'";						
	 
$q1 = mysqli_query($con,$sql);
$r1 = mysqli_fetch_assoc($q1);
// print_r($r1); die;
$stuname = $r1['student_name'];
$fathername = $r1['father_name'];
$fathermob = $r1['parent_no'];

$clsid=$res['class_id'];
$q2 = mysqli_query($con,"select * from class where class_id='$clsid'");
$r2 = mysqli_fetch_array($q2);
$clsname = $r2['class_name'];

$secid=$res['section_id'];
$q3 = mysqli_query($con,"select * from section where section_id='$secid'");
$r3 = mysqli_fetch_array($q3);
$secname = $r3['section_name'];

$roll_no=($res['roll_no']) ? $res['roll_no'] : '0' ;

$data .= $stuname.",".$clsname.",".$secname.",".$roll_no.",".$fathername.",".$fathermob."\n";
}
	
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');


$filename =  "Todayabsantee_".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

//echo $data;
echo ucwords($columnHeader)."\n".$data."\n"; 
//echo ucwords($columnHeader)."\n".$setData."\n";
exit; 

?>
