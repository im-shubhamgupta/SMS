<?php 
include('connection.php');
extract($_REQUEST);
//echo $id;

	$query1=mysqli_query($con,"insert into bill (student_id,admfeepaid,tutionfeepaid,miscfeepaid,transfeepaid,due,month,paidby,challan_no,issued_by,issued_date,date) 
	values ('$stuid','$nadmfee','$ntutnfee','$nmiscfee','$ntransfee','$amtdue','$nextpay','$paidby','$chlno','$issby','$issdate','$issdate')");
	
	mysqli_query($con,"update students set due='$amtdue' where student_id='$stuid'");
		
	$que2=mysqli_query($con,"select * from bill order by bill_id desc" );
	$res2=mysqli_fetch_array($que2);
	$bid=$res2['bill_id'];
	
	echo "<script>window.location='print_receipt.php?billid=$bid'</script>";
?>