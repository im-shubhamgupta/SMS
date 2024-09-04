 <?php

	//error_reporting(1);

	include('connection.php');

	extract($_REQUEST);

	$eid=$_REQUEST['eid'];

	$sql=mysqli_query($con,"select * from book_return_type where book_return_type_id ='$eid'");

	$res=mysqli_fetch_array($sql);

	


	

?> 

<div class="card">

<form action="" method="post">

	<div class="card-header">

		<strong>Update</strong> Book Return Type

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

		<div class="row">

		<div class="col-md-6">

		<div class="form-group">

		<label for="nf-email" class=" form-control-label">Return Type</label>

		<input type="text" name="return_name" class="form-control" value="<?php echo $res['book_return_type_name'];?>" required>

		</div>

		</div>

		

		<div class="col-md-6">

		<div class="form-group">

		<label for="nf-email" class=" form-control-label">Book Return (Days)</label>

		<input type="number" name="return_days" class="form-control" value="<?php echo $res['return_type_days'];?>" required>

		</div>

		</div>

		</div>			

		

		

		<div class="row">

		<div class="col-md-6">

		<div class="form-group">

		<label for="nf-email" class=" form-control-label">Book Fine (Per Day) </label>

		<input type="number" name="book_fine" class="form-control" value="<?php echo $res['book_fine_per_day']; ?>" required>

		</div>

		</div>

		

		<div class="col-md-6">

		<div class="form-group">

		<label for="nf-email" class=" form-control-label">Remark</label>

		<input type="text" name="remark" class="form-control" value="<?php echo $res['remarks']; ?>" required>
		<input type="hidden" name="eid" value="<?=$_GET['eid']?>">
		</div>

		</div>

		</div>	

		

	</div>		



	

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class="fa fa-edit"></i> Update

		</button>

		

		<a href="dashboard.php?option=view_book_return_type" class="btn btn-info btn-sm"> 

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
  var action = "update_book_return_type";
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
				window.location.href='dashboard.php?option=view_book_return_type';
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