 <?php

	//error_reporting(1);

	include('connection.php');

	extract($_REQUEST);

	$eid=$_REQUEST['eid'];

	$sql=mysqli_query($con,"select * from books where book_id='$eid'");

	$res=mysqli_fetch_array($sql);

	


	

?> 

<div class="card">

<form action="" method="post">

	<div class="card-header">

		<strong>Update</strong> Book

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

		<div class="row">

		<div class="col-md-6">

		<div class="form-group">

		<label for="nf-email" class=" form-control-label">Name</label>

		<input type="text" name="bookname" class="form-control" value="<?php echo $res['book_name'];?>" required>

		</div>

		</div>

		

		<div class="col-md-6">

		<div class="form-group">

		<label for="nf-email" class=" form-control-label">Book ISBN</label>

		<input type="text" name="bookisbn" class="form-control" value="<?php echo $res['book_isbn'];?>" required>

		</div>

		</div>

		</div>			

		

		

		<div class="row">

		<div class="col-md-6">

		<div class="form-group">

		<label for="nf-email" class=" form-control-label">Author</label>

		<input type="text" name="author" class="form-control" value="<?php echo $res['author']; ?>" required>

		</div>

		</div>

		

		<div class="col-md-6">

		<div class="form-group">

		<label for="nf-email" class=" form-control-label">Publisher</label>

		<select name="publisherid" class="form-control" required>

		<option value="" selected="selected" disabled>Select Publisher</option>

		<?php

		$qpub = mysqli_query($con,"select * from publisher");

		while( $rpub = mysqli_fetch_array($qpub) ) {

		?>

		<option <?php if($res['publisher_id']==$rpub['publisher_id']){echo "selected";}?> value="<?php echo $rpub['publisher_id']; ?>"><?php echo $rpub['publisher_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

		</div>

		</div>	

		

		

		<div class="row">

		<div class="col-md-6">

		<div class="form-group">

		<label for="nf-email" class=" form-control-label">Books Category</label>

		<select name="booktypeid" class="form-control" required>

		<option value="" selected="selected" disabled>Select Books Category</option>

		<?php

		$qbk = mysqli_query($con,"select * from book_type");

		while( $rbk = mysqli_fetch_array($qbk) ) {

		?>

		<option <?php if($res['book_type_id']==$rbk['book_type_id']){echo "selected";}?> value="<?php echo $rbk['book_type_id']; ?>"><?php echo $rbk['book_type_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

		</div>

		

		<div class="col-md-6">

		<div class="form-group">

		<label for="nf-email" class=" form-control-label">Quantity</label>

		<input type="text" name="quantity" class="form-control" value="<?php echo $res['quantity']; ?>" required>

		</div>

		</div>

		</div>	

		

		<div class="row">

		<div class="col-md-6">

		<div class="form-group">

		<label for="nf-email" class=" form-control-label">Price</label>

		<input type="text" name="price" class="form-control" value="<?php echo $res['price']; ?>" required>

		</div>

		</div>

		

		<div class="col-md-6">

		<div class="form-group">

		<label for="nf-email" class=" form-control-label">Vendor</label>

		<select name="vendorid" class="form-control" required>

		<option value="" selected="selected" disabled>Select Vendor</option>

		<?php

		$qvn = mysqli_query($con,"select * from vendor");

		while( $rvn = mysqli_fetch_array($qvn) ) {

		?>

		<option <?php if($res['vendor_id']==$rvn['vendor_id']) {echo "selected";} ?> value="<?php echo $rvn['vendor_id']; ?>"><?php echo $rvn['vendor_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

		</div>

		</div>	

		

		<div class="row">

		<div class="col-md-6">

		<div class="form-group">

		<label for="nf-email" class=" form-control-label">Branch</label>

		<select name="branchid" class="form-control" required >

		<option value="" selected="selected" disabled>Select Branch</option>

		<?php

		$qbr = mysqli_query($con,"select * from branch");

		while( $rbr = mysqli_fetch_array($qbr) ) {

		?>

		<option <?php if($res['branch_id']==$rbr['branch_id']) {echo "selected";} ?> value="<?php echo $rbr['branch_id']; ?>"><?php echo $rbr['branch_name']; ?>

		</option>

		<?php } ?>							

		</select>
		<input type="hidden" name="eid" value="<?=$_GET['eid']?>">
		</div>

		</div>

		</div>	

		

	</div>		

	

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class="fa fa-edit"></i> Update

		</button>

		

		<a href="dashboard.php?option=view_books" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>						

		

	</div>

</form>

</div>
<?php include('datatable_links.php')?>
<script>

	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "update_books";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);
	$.ajax({
		url:"Controllers/LibraryControllers.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			console.log(responce);
			if(result.status=="success"){
				// alert('success');
				toastr.success(result.message);
				setInterval(function(){ 
				window.location.href='dashboard.php?option=view_books';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('button[type="submit"]').html('<i class="fa fa-edit"></i> Update ');  
	      $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>