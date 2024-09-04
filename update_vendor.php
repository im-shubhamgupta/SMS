 <?php

	//error_reporting(1);

	include('connection.php');

	extract($_REQUEST);

	$eid=$_REQUEST['eid'];

	$sql=mysqli_query($con,"select * from vendor where vendor_id='$eid'");

	$res=mysqli_fetch_array($sql);

	$vendorname=$res['vendor_name'];

	

	

?> 

<div class="card">

<form action="" method="post">

	<div class="card-header">

		<strong>Update</strong> Vendor

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Enter Vendor Name</label>

			<input type="text" name="vendor" placeholder="Enter Vendor" class="form-control" value="<?php echo $vendorname ?>" required></div>
				<input type="hidden" name="eid" value="<?=$_GET['eid']?>">
			

		

	</div>

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class='fa fa-edit'></i> Update

		</button>

		

		<a href="dashboard.php?option=view_vendor" class="btn btn-info btn-sm"> 

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
  var action = "update_vendor";
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
				window.location.href='dashboard.php?option=view_vendor';
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