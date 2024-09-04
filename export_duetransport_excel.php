<?php

include('connection.php');

extract($_REQUEST);



$class = $_REQUEST['class'];

$section = $_REQUEST['section'];

$range = $_REQUEST['range'];

$r1 = $_REQUEST['r1'];

$r2 = $_REQUEST['r2'];

	



// if($range==1)

// 	{

// 		if($class!="" and $section!="")

// 		{		

// 		$query="select * from student_route where class_id='$class' and section_id='$section' and due_amount > 0 and due_amount < '$r1'";

// 		$search_result = filterTable($query);

// 		}

				

// 		else if($class!="" and $section=="")

// 		{

// 		$query="select * from student_route where class_id='$class' and due_amount > 0 and due_amount < '$r1'";					

// 		$search_result = filterTable($query);

// 		}

			

// 		else if($class=="" and $section=="")

// 		{

// 		$query="select * from student_route where due_amount > 0 and due_amount < '$r1'";

// 		$search_result = filterTable($query);

// 		}

		

// 	}

	

// 	else if($range==2)

// 	{

		

// 		if($class!="" and $section!="")

// 		{

// 		$query="select * from student_route where class_id='$class' and section_id='$section' and due_amount > '$r1'";			

// 		$search_result = filterTable($query);

// 		}

				

// 		else if($class!="" and $section=="")

// 		{

// 		$query="select * from student_route where class_id='$class' and due_amount > 0 and due_amount > '$r1'";					

// 		$search_result = filterTable($query);

// 		}

			

// 		else if($class=="" and $section=="")

// 		{

// 		$query="select * from student_route where due_amount > '$r1'";

// 		$search_result = filterTable($query);

// 		}

		

// 	}

	

// 	else if($range==3)

// 	{

		

// 		if($class!="" and $section!="")

// 		{

// 		$query="select * from student_route where class_id='$class' and section_id='$section' and due_amount between '$r1' and '$r2'";			

// 		$search_result = filterTable($query);

// 		}

				

// 		else if($class!="" and $section=="")

// 		{

// 		$query="select * from student_route where class_id='$class' and due_amount between '$r1' and '$r2'";					

// 		$search_result = filterTable($query);

// 		}

			

// 		else if($class=="" and $section=="")

// 		{

// 		$query="select * from student_route where due_amount between '$r1' and '$r2'";

// 		$search_result = filterTable($query);

// 		}

		

// 	}
if($class!="" and $section!=""){

		$query="select * from student_route where class_id='$class' and section_id='$section' ";			

	

		}	

		else if($class!="" and $section=="")

		{

		$query="select * from student_route where class_id='$class' ";					

 
		}

		else if($class=="" and $section=="")

		{

		$query="select * from student_route where 1 ";
 
		}

		

	
	if(!empty($range)){
		if($range==1){
			$query.=" and due_amount > 0 and due_amount < '$r1'";

		}elseif($range==2){
			$query.="  and due_amount > 0 and due_amount > '$r1' ";
		}elseif($range==3){
			$query.=" and due_amount between '$r1' and '$r2' ";

		}
	}
	$query.=" and session='".$_SESSION['session']."' ";
	
$search_result = filterTable($query);	


function filterTable($query)

{

    include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}



$columnHeader ='';

$columnHeader = "Student Name".","."Register No".","."Father Name".","."Parent Contact".","."Class".","."Section".","."Transport Fees".","."Previous Transport Fees".","."Total Fee".","."Total Discount".","."Total Paid".","."Total Due".","."Last Paid Date";



$data='';



$sr=1;

while($res=mysqli_fetch_array($search_result))

{

$stuid=$res['student_id'];

// $qst1 = mysqli_query($con,"select * from students where student_id='$stuid' and session='".$_SESSION['session']."' ");
$qst1=mysqli_query($con,"select `student_id`,`register_no`,`student_name`,father_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$stuid' && stu_status='0'  && sr.session='".$_SESSION['session']."'");
if(mysqli_num_rows($qst1)>0){
$rst1 = mysqli_fetch_array($qst1);

$stuname=$rst1['student_name'];

$regno=$rst1['register_no'];

$fname=$rst1['father_name'];

$parentno=$rst1['parent_no'];



$cid=$res['class_id'];

$qcls=mysqli_query($con,"select * from class where class_id='$cid'");

$rcls=mysqli_fetch_array($qcls);



$sectid=$res['section_id'];

$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");

$rsec=mysqli_fetch_array($qsec);

								

$due=$res['due_amount'];

$transid=$res['trans_id'];

$qtd = mysqli_query($con,"select * from transports where trans_id ='$transid'");

$rtd = mysqli_fetch_array($qtd);

$transamt = $rtd['price'];

$totaldiscount = $res['discount'];



$qp = mysqli_query($con,"select * from previous_transport_fees where student_id ='$stuid' and session='".$_SESSION['session']."' ");

$rp = mysqli_fetch_array($qp);



if(mysqli_num_rows($qp))

{

	$prevamt = $rp['previous_transport_fees'];

}

else

{

	$prevamt = 0;

}



$totalfee = $transamt + $prevamt;



$qt = mysqli_query($con,"select * from student_transport_due_fees where student_id ='$stuid' and status!='2' and status!='4' and session='".$_SESSION['session']."' ");

$transfeepaid = 0;

$prevfeepaid = 0;

while($rt = mysqli_fetch_array($qt))

{

$transfeepaid += $rt['trans_amount'];

$prevfeepaid += $rt['previous_trans_amount'];

$issdt=$rt['issue_date'];	

}



if($issdt){

	$chgedate = date('d-m-Y h:i:s',strtotime($issdt));	

}

else

{

	$chgedate = " ";

}	



$tfeepaid = $transfeepaid + $prevfeepaid;

											

 $data .= $stuname.",".$regno.",".$fname.",".$parentno.",".$rcls['class_name'].",".$rsec['section_name'].",".$transamt.",".$prevamt.",".$totalfee.",".$totaldiscount.",".$tfeepaid.",".$due.",".$chgdate."\n";

}
}//while

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');



$filename =  "DueTransportReport_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

