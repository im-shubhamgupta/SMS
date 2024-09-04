<?php 

extract($_REQUEST);

include('connection.php');



$sr =1;

$q=mysqli_query($con,"select * from issue_order where issue_ord_id='$issued_id'");

while($res=mysqli_fetch_array($q))

{



		$id=$res['issue_ord_id'];

		$issdt=$res['issued_date'];

		$nissdt=date("d-m-Y",strtotime($issdt));

		$stid=$res['stock_type_id'];

		$q1 = mysqli_query($con,"select * from stock_type where stock_type_id ='$stid'");

		$r1 = mysqli_fetch_array($q1);

		$stocktype = $r1['stock_type_name'];

		$venid=$res['stock_vendor_id'];

		$q2 = mysqli_query($con,"select * from stock_vendor where stock_vendor_id ='$venid'");

		$r2 = mysqli_fetch_array($q2);

		$venname = $r2['stock_vendor_name'];

		$tqty=$res['quantity'];

		$identno=$res['identification_no'];

		$purid=$res['pur_ord_id'];

		$q3 = mysqli_query($con,"select * from purchase_order where pur_ord_id ='$purid'");

		$r3 = mysqli_fetch_array($q3);

		$purname = $r3['poid'];

		

?>

	<tr>

		<td><?php echo $sr; ?></td>

		<td><?php echo $nissdt; ?></td>

		<td><?php echo $stocktype; ?></td>

		<input type="hidden" name="stockid" value="<?php echo $stid;?>">

		<td><?php echo $venname; ?></td>

		<input type="hidden" name="vendorid" value="<?php echo $venid;?>">

		<td><?php echo $tqty; ?></td>
		<input type="hidden" name="issue_qty" id="issue_qty" value="<?php echo $tqty;?>">
		<td><?php echo $identno; ?></td>

		<input type="hidden" name="purchaseid" value="<?php echo $purid;?>">

		<td><?php echo $purname; ?></td>

	</tr>

	

<?php $sr++; 

}

?>

	

	





