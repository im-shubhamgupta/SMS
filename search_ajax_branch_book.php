<?php 

extract($_REQUEST);

include('connection.php');



$sr =1;

$q=mysqli_query($con,"select * from books where branch_id='$branch_id'");

while($res1=mysqli_fetch_array($q))

{



		$bkid=$res1['book_id'];

		$bkisbn=$res1['book_isbn'];

		$bkname=$res1['book_name'];

		$authorname=$res1['author'];

		$pubid=$res1['publisher_id'];

		$q1=mysqli_query($con,"select * from publisher where publisher_id ='$pubid'");

		$r1=mysqli_fetch_array($q1);

		$pubname=$r1['publisher_name'];

		

		$tbkqty=$res1['quantity'];

		$q2=mysqli_query($con,"select * from issue_bookto_students where book_id ='$bkid' && return_status='0'");

		$stuissueqty=mysqli_num_rows($q2);

		$q3=mysqli_query($con,"select * from issue_bookto_faculty where book_id ='$bkid' && return_status='0'");

		$facissueqty=mysqli_num_rows($q3);		

		$balbook=$tbkqty-$stuissueqty-$facissueqty;
		if($balbook<1){
			$disabled='disabled';
		}else{
			$disabled='';
		}
			

?>

	<tr>

		<td><?php echo $sr; ?></td>

		<td><?php echo $bkisbn; ?></td>

		<td><?php echo $bkname; ?></td>

		<td><?php echo $authorname; ?></td>

		<td><?php echo $pubname; ?></td>

		<td><?php echo $balbook; ?></td>

		<td><input type="checkbox" name="bookid[]" <?=$disabled?> onclick="check_avilable_book(this.value);ckeck(this.value);" id="<?php echo $bkid;?>" value="<?php echo $bkid;?>" ></td>
		<!--  -->
		<input type="hidden" name="avilable_book_qty" id='avilable_book_qty_<?=$bkid?>'  value="<?=$balbook?>">

	</tr>

	

<?php $sr++; 

}

?>

	

	





