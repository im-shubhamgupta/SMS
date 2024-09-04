<?php 
extract($_REQUEST);
include('connection.php');

$sr =1;
$q=mysqli_query($con,"select * from books where branch_id='$branch_id'");
while($res1=mysqli_fetch_array($q))
{

		$bkid=$res1['book_id'];
		$bkname=$res1['book_name'];
		$tbkqty=$res1['quantity'];
	
		$q2=mysqli_query($con,"select * from issue_bookto_students where book_id ='$bkid' && return_status='0'");
		$stuissueqty=mysqli_num_rows($q2);
		$q3=mysqli_query($con,"select * from issue_bookto_faculty where book_id ='$bkid' && return_status='0'");
		$facissueqty=mysqli_num_rows($q3);	

		$q4=mysqli_query($con,"select * from issue_bookto_students where book_id ='$bkid' && return_status='1'");
		$stureturnqty=mysqli_num_rows($q2);
		$q5=mysqli_query($con,"select * from issue_bookto_faculty where book_id ='$bkid' && return_status='1'");
		$facreturnqty=mysqli_num_rows($q3);	
		
		$total_book_issue=$stuissueqty+$facissueqty;
		$total_book_return=$stureturnqty+$facreturnqty;
		$balbook=$tbkqty-$stuissueqty-$facissueqty;
		
?>
	<tr>
		<td><?php echo $sr; ?></td>
		<td><?php echo $bkname; ?></td>
		<td><?php echo $tbkqty; ?></td>
		<td><?php echo $total_book_issue; ?></td>
		<td><?php echo $total_book_return; ?></td>
		<td><?php echo $balbook; ?></td>
	</tr>
	
<?php $sr++; 
}
?>
	
	


