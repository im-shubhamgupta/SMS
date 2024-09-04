<?php
extract($_REQUEST);
include('connection.php');
 
$sr =1;
$q=mysqli_query($con,"select * from issue_bookto_students where student_id='$stu_id' && return_status='0'");
while($res1=mysqli_fetch_array($q))
{

		$issueid=$res1['issue_id'];
		$bkid=$res1['book_id'];
		$q1=mysqli_query($con,"select * from books where book_id='$bkid'");
		$r1=mysqli_fetch_array($q1);
		$bkname=$r1['book_name'];
		
		$issdt=$res1['issue_date'];
		$chgissdt = date("d-m-Y",strtotime($issdt));
		
		$retdt=$res1['return_date'];
		$chgretdt = date("d-m-Y",strtotime($retdt));
		
		
?>

	
		<tr>
		<td><?php echo $sr; ?></td>
		<input type="hidden" name="issid" value="<?php echo $issueid;?>"/>
		<td><?php echo $bkname; ?></td>
		<td><?php echo $chgissdt; ?></td>
		<td><?php echo $chgretdt; ?></td>
		
		<td><input type="checkbox" name="bookid[]" id="bookid" value="<?php echo $bkid;?>" onclick="ckeck(this.value);"></td>
		</tr>
	
<?php $sr++; 
}
?>
	
		


