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

		$query = "SELECT * FROM `issue_bookto_faculty` WHERE `branch_id`='$branch' and return_status='1' and issue_date between '$fromdt' AND '$todt'";
		$search_result = filterTable($query);
    }
	else if($branch!="" and $book!="All" and $fromdt!="" and $todt!=="")
	{
    // search in all table columns

		$query = "SELECT * FROM `issue_bookto_faculty` WHERE `branch_id`='$branch' and return_status='1' and book_id='$book' and issue_date between '$fromdt' AND '$todt'";
		$search_result = filterTable($query);
    }
	

function filterTable($query)
{
    include('connection.php');
    $filter_Result = mysqli_query($con, $query);
    return $filter_Result;
}

$columnHeader ='';
$columnHeader = "Faculty Name".","."Faculty ID".","."Faculty No".","."Book Name".","."Book Author".","."Book ISBN".","."Publisher Name".","."Issued Date".","."Return Date".","."Returned Date";


$data='';


while($res=mysqli_fetch_array($search_result))
{
	
$stid=$res['st_id'];
$q1=mysqli_query($con,"select * from staff where st_id='$stid'");
$r1=mysqli_fetch_array($q1);
$stname=$r1['staff_name'];
$staffid=$r1['staff_id'];
$mobno=$r1['mobno'];

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
$retddt = $res['returned_date'];
$returneddt=date("d-m-Y", strtotime($retddt));
										
$data .= $stname.",".$staffid.",".$mobno.",".$bkname.",".$author.",".$bkisbn.",".$pubname.",".$issuedt.",".$returndt.",".$returneddt."\n";
}
	
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');


$filename =  "Returnedbook_Detail".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

//echo $data;
echo ucwords($columnHeader)."\n".$data."\n"; 
//echo ucwords($columnHeader)."\n".$setData."\n";
exit; 

?>
