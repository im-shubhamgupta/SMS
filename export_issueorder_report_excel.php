<?php
include('connection.php');
extract($_REQUEST);

$fromdt = $_REQUEST['fromdt'];
$todt = $_REQUEST['todt'];
$stock = $_REQUEST['stock'];
$vendorid = $_REQUEST['vendorid'];

	$cond = '';
	
	if($stock!='') 
	{
		$cond.=" && stock_type_id='$stock'";
	}
	if($vendorid!='') 
	{
		$cond.=" && stock_vendor_id='$vendorid'";
	}

	$query = mysqli_query($con,"SELECT * FROM issue_order WHERE issued_date between '$fromdt' AND '$todt' $cond");

$columnHeader ='';
$columnHeader = "Issued ID".","."Stock Type".","."Issued Date".","."Identification Number".","."Quantity".","."Discription".","."Vendor Detail";

$data='';

while($res=mysqli_fetch_array($query))
{
$id=$res['issue_ord_id'];
$issuedid=$res['ioid'];
$stockid=$res['stock_type_id'];
$qst=mysqli_query($con,"select * from stock_type where stock_type_id ='$stockid'");
$rst=mysqli_fetch_array($qst);
$stockname=$rst['stock_type_name'];
$issueddt=$res['issued_date'];
$newissueddt= date("d-m-Y",strtotime($issueddt));
$quantity = $res['quantity'];
$amount = $res['amount'];
$venid = $res['stock_vendor_id'];
$qvn=mysqli_query($con,"select * from stock_vendor where stock_vendor_id ='$venid'");
$rvn=mysqli_fetch_array($qvn);
$venname=$rvn['stock_vendor_name'];
						
$data .= $issuedid.",".$stockname.",".$newissueddt.",".$res['identification_no'].",".$quantity.",".$res['description'].",".$venname."\n";
}
	
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');


$filename =  "Issueorder_report_".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

//echo $data;
echo ucwords($columnHeader)."\n".$data."\n"; 
//echo ucwords($columnHeader)."\n".$setData."\n";
exit; 

?>
