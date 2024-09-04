<?php 
session_start();
extract($_REQUEST);
include('connection.php');
$br_id=$_REQUEST['br_id'];

?>

<select class="form-control" style="width:175px;">
<option value="All" selected>All</option>

<?php
$sbk = mysqli_query($con,"select * from books where branch_id='$br_id'");
while( $rbk = mysqli_fetch_array($sbk) ) {
?>
<option <?php if($book==$rbk['book_id']){echo "selected";}?> value="<?php echo $rbk['book_id']; ?>"><?php echo $rbk['book_name']; ?>
</option>
<?php } ?>	
</select>