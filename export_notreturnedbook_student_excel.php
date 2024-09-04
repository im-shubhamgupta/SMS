<?php

include('connection.php');

extract($_REQUEST);



$branch = $_REQUEST['branchid'];

$book = $_REQUEST['bookid'];

$fromdt = $_REQUEST['fromdt'];

$todt = $_REQUEST['todt'];





	if($branch!="" and $book=="All" and $fromdt!="" and $todt!=="")

	{

    // search in all table columns

		$query = "SELECT * FROM `issue_bookto_students` WHERE `branch_id`='$branch' and return_status='0' and issue_date between '$fromdt' AND '$todt'";

		$search_result = filterTable($query);

    }

	else if($branch!="" and $book!="All" and $fromdt!="" and $todt!=="")

	{

    // search in all table columns



		$query = "SELECT * FROM `issue_bookto_students` WHERE `branch_id`='$branch' and book_id='$book' and return_status='0' and issue_date between '$fromdt' AND '$todt'";

		$search_result = filterTable($query);

    }

	



function filterTable($query)

{

    include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}



$columnHeader ='';

$columnHeader = "Student Name".","."Class".","."Section".","."Register No".","."Father Name".","."Father No".","."Book Name".

","."Book Author".","."Book ISBN".","."Publisher Name".","."Issued Date".","."Return Date".","."Penalty Amount";





$data='';





while($res=mysqli_fetch_array($search_result))

{

	

$stuid=$res['student_id'];

// $q1=mysqli_query($con,"select * from students where student_id='$stuid'");
$sql1="select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  student_id='$stuid' ";//and sr.session='".$_SESSION['session']."'
$q1=mysqli_query($con,$sql1);

$r1=mysqli_fetch_array($q1);

$stuname=$r1['student_name'];



$clid=$res['class_id'];

$quec=mysqli_query($con,"select * from class where class_id='$clid'");

$resc=mysqli_fetch_array($quec);

$clsname=$resc['class_name'];



$seid=$res['section_id'];

$qse=mysqli_query($con,"select * from section where section_id='$seid'");

$rsec=mysqli_fetch_array($qse);

$secname=$rsec['section_name'];



$bkid=$res['book_id'];

$q2=mysqli_query($con,"select * from books where book_id='$bkid'");

$r2=mysqli_fetch_array($q2);

$bkname=$r2['book_name'];

$author=$r2['author'];

$bkisbn=$r2['book_isbn'];

$pubid=$r2['publisher_id'];

$q=mysqli_query($con,"select * from publisher where publisher_id='$pubid'");

$r=mysqli_fetch_array($q);

$pubname=$r['publisher_name'];



$issdt=$res['issue_date'];

$issuedt=date("d-m-Y", strtotime($issdt));

$retdt = $res['return_date'];

$returndt=date("d-m-Y", strtotime($retdt));



$curdate = date("Y-m-d");

$date1=date_create($curdate);

$date2=date_create($returndt);

$diff=date_diff($date2,$date1);

$tdays = $diff->format("%R%a days");

										

$rettypeid=$res['return_type_id'];

$q3=mysqli_query($con,"select * from book_return_type where book_return_type_id ='$rettypeid'");

$r3=mysqli_fetch_array($q3);

$amt=$r3['book_fine_per_day'];



if($tdays > 0)

{

	$tpenalty = $tdays * $amt;

}

else

{

	$tpenalty = 0;

}

						

$data .= $stuname.",".$clsname.",".$secname.",".$res['register_no'].",".$res['father_name'].",".$res['mobile'].",".$bkname.",".$author.",".

$bkisbn.",".$pubname.",".$issuedt.",".$returndt.",".$tpenalty."\n";

}

	

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');





$filename =  "Notreturnedbook_detail".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

