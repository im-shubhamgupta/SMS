<?php

include('connection.php');

extract($_REQUEST);



$todt = $_REQUEST['todt'];

$chg_tdate = date("d-m-Y", strtotime($todt));



$class = $_REQUEST['class'];

$section = $_REQUEST['section'];





	if($class!="" and $section!="")

	{

	$query="select * from student_transport_due_fees where class_id='$class' and section_id='$section' and status=4 and session='".$_SESSION['session']."'";	

	

	$search_result = filterTable($query);

    }

	

	else if($class!="" and $section=="")

	{

	$query="select * from student_transport_due_fees where class_id='$class' and status=4 and session='".$_SESSION['session']."'";					

	$search_result = filterTable($query);

    }

	

	else if($class=="" and $section=="")

	{

	$query="select * from student_transport_due_fees where status=4 and session='".$_SESSION['session']."'";					

	$search_result = filterTable($query);

    }



function filterTable($query)

{

    include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}



$columnHeader ='';

$columnHeader = "Receipt No".","."Name".","."Father Name".","."Class".","."Section".","."Amount".","."Deleted Date".","."Reason";



$data='';



$sr=1;

$gtotal = 0;
if(mysqli_num_rows($search_result)>0){
while($res1=mysqli_fetch_array($search_result))

	{									

	

$logid=$res1['student_trans_fee_id'];

$stuid=$res1['student_id'];



// $que2=mysqli_query($con,"select * from students where student_id='$stuid' and stu_status='0'");
$que2=mysqli_query($con,"select `student_id`,`register_no`,`student_name`,father_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$stuid' && stu_status='0'  && sr.session='".$_SESSION['session']."'");
if(mysqli_num_rows($que2)>0){
while($res2=mysqli_fetch_array($que2))

{



$cid=$res2['class_id'];

$qcls=mysqli_query($con,"select * from class where class_id='$cid'");

$rcls=mysqli_fetch_array($qcls);



$sectid=$res2['section_id'];

$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");

$rsec=mysqli_fetch_array($qsec);



$totalamt=$res1['total_amount'];

$act_dt = $res1['action_date'];

$nactdt = date("d-m-Y",strtotime($act_dt));

									

 $data .= $logid.",".$res2['student_name'].",".$res2['father_name'].",".$rcls['class_name'].",".$rsec['section_name'].",".$totalamt.",".$nactdt.",".$res1['reason']."\n";



$sr++;									

}
}

}
}

	



$filename =  "DeletedTransportReport.csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

