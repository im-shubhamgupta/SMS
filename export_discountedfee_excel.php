<?php
include('connection.php');
extract($_REQUEST);

$class = $_REQUEST['class'];
$section = $_REQUEST['section'];


	if($class!="" and $section!="")
	{
	$query="select * from student_wise_fees where class_id='$class' and section_id='$section' and discount_amount>0";	
	
	$search_result = filterTable($query);
    }
	
	else if($class!="" and $section=="")
	{
	$query="select * from student_wise_fees where class_id='$class' and discount_amount>0";					
	$search_result = filterTable($query);
    }
	
	else if($class=="" and $section=="")
	{
	$query="select * from student_wise_fees where discount_amount>0";					
	$search_result = filterTable($query);
    }

function filterTable($query)
{
    include('connection.php');
    $filter_Result = mysqli_query($con, $query);
    return $filter_Result;
}

$columnHeader ='';
$columnHeader = "Student Name".","."Register No".","."Father Name".","."Class".","."Section".","."Fee Discount".","."Reason"."\n";

$data='';

$sr=1;
$gtotal = 0;
while($res1=mysqli_fetch_array($search_result))
	{									
	
$stuid=$res1['student_id'];

$que2=mysqli_query($con,"select * from students where student_id='$stuid' and stu_status='0'");
while($res2=mysqli_fetch_array($que2))
{

$cid=$res2['class_id'];
$qcls=mysqli_query($con,"select * from class where class_id='$cid'");
$rcls=mysqli_fetch_array($qcls);

$sectid=$res2['section_id'];
$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");
$rsec=mysqli_fetch_array($qsec);

$discount_amt=$res1['discount_amount'];
$reason=$res1['reason'];

 $data .= $res2['student_name'].",".$res2['register_no'].",".$res2['father_name'].",".$rcls['class_name'].",".$rsec['section_name'].",".$discount_amt.",".$reason."\n";
 
$sr++;									
}
}
	

$filename =  "Discountedfees_Report.csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

//echo $data;
echo ucwords($columnHeader)."\n".$data."\n"; 
//echo ucwords($columnHeader)."\n".$setData."\n";
exit; 

?>
