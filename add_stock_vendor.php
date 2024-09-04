<?php

	//error_reporting(1);

	// extract($_REQUEST);


	

?>



<div class="card">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Stock Management</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_stock_vendor">View Vendor</a>

  <span class="breadcrumb-item active">Add Vendor</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post">

	<div class="card-header">

		<strong>Add</strong> Vendor

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Enter Vendor Name</label>

			<input type="text" name="vendor" placeholder="Enter Vendor Name" class="form-control" required></div>

			

		

	</div>

	<div class="card-footer">

		<button type="submit" name="add" class="btn btn-primary btn-sm">

			<i class="fa fa-plus"></i> Add

		</button>

		

	</div>

</form>

</div>
<?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "add_stock_vendor";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/StockControllers.php",
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
				window.location.href='dashboard.php?option=add_stock_vendor';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('button[type="submit"]').html('<i class="fa fa-plus"></i> Add ');  
	      $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>