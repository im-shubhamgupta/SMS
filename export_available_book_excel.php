<?php
include('connection.php');
extract($_REQUEST);

$branch = $_REQUEST['branchid'];

	if($branch!="")
	{
    // search in all table columns

		$query="select * from books where branch_id='$branch'";
		$search_result = filterTable($query);
    }
	

function filterTable($query)
{
    include('connection.php');
    $filter_Result = mysqli_query($con, $query);
    return $filter_Result;
}

$columnHeader ='';
$columnHeader = "Book Name".","."Publisher Name".","."Total No. of Books".","."Issued Book".","."Returned Book".","."Available Book";


$data='';

while($res1=mysqli_fetch_array($search_result))
{
$bkid=$res1['book_id'];
$bkname=$res1['book_name'];
$pubid=$res1['publisher_id'];
$tbkqty=$res1['quantity'];

$q=mysqli_query($con,"select * from publisher where publisher_id='$pubid'");
$r=mysqli_fetch_array($q);
$pubname=$r['publisher_name'];
										
$q2=mysqli_query($con,"select * from issue_bookto_students where book_id ='$bkid'");
$stuissueqty=mysqli_num_rows($q2);
$q3=mysqli_query($con,"select * from issue_bookto_faculty where book_id ='$bkid'");
$facissueqty=mysqli_num_rows($q3);	

$q4=mysqli_query($con,"select * from issue_bookto_students where book_id ='$bkid' && return_status='1'");
$stureturnqty=mysqli_num_rows($q4);
$q5=mysqli_query($con,"select * from issue_bookto_faculty where book_id ='$bkid' && return_status='1'");
$facreturnqty=mysqli_num_rows($q5);	

$total_book_issue=$stuissueqty+$facissueqty;
$total_book_return=$stureturnqty+$facreturnqty;
$balbook=$tbkqty-$total_book_issue+$total_book_return;

						
$data .= $bkname.",".$pubname.",".$tbkqty.",".$total_book_issue.",".$total_book_return.",".$balbook."\n";
}
	
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');


$filename =  "Availablebook_detail".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

//echo $data;
echo ucwords($columnHeader)."\n".$data."\n"; 
//echo ucwords($columnHeader)."\n".$setData."\n";
exit; 

?>
