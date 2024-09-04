<?php

	//error_reporting(1);

	extract($_REQUEST);

/*	if(isset($add))

	{		

		$route_name = trim($route_name, " ");

		$price = trim($price, " ");

		

		$sql=mysqli_query($con,"select * from transports where route_name='$route_name'");

		$res=mysqli_num_rows($sql);

		if($res)

		{

			$err="<span id='err_notsuccessful'>[ This Route Is Already Exists. Plaese Select Another Route ]</span>";	

		}

		else

		{

			$query="insert into transports (trans_id, route_name, price) values('0','$route_name','$price')";	

			mysqli_query($con,$query);

			$err="<span id='err_successful'>[ Transport Added Successfully ]</span>";

		}

		

	}
*/
	

?>

<div class="card">

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport Panel</a>

  <a class="breadcrumb-item" href="#">Route</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_transports">View Route</a>  

  <span class="breadcrumb-item active">Add Route</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post">

	<div class="card-header">

		<strong>Add</strong> Route

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Route Name</label>

			<input type="text" name="route_name" class="form-control" placeholder="Enter Route Name" required>	

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Price Per Year</label>

			<input type="text" name="price" class="form-control" placeholder="Enter Price" required>

			</div>

	</div>

	<div class="card-footer">

		<button type="submit" name="add" class="btn btn-primary btn-sm">

			<i class="fa fa-plus"></i> Add Transport

		</button>

		

		<a href="dashboard.php?option=view_transports" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

	</div>

	</form>

</div>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
	$(document).ready(function(){	
  toastr.options = {		
 		"closeButton": true, 
		"debug": false,"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-bottom-right",	
		"preventDuplicates": false,	

		"onclick": null,	
		"showDuration": "300",
		"hideDuration": "1000",	
		"timeOut": "3000",		
		"extendedTimeOut": "1000",
		"showEasing": "swing",	
		"hideEasing": "linear",	
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"	
		};					}); 

	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
	// console.log(this);
  var action ="Add_Transport";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("Please wait...");  
	$("button[type='submit']").attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/TransportController.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			// console.log(responce);
			if(result.type=="success"){
				// alert('success');
				toastr.success(result.msg); 
				setInterval(function(){ 
				// window.location.href='dashboard.php?option=assign_driver_route';
					$('form')[0].reset();
					// document.getElementById("assign_driver").reset();
				},3000);
			}
		
			else if(result.type=="error"){
				toastr.error(result.msg); 
			}
			  $("button[type='submit']").html('<i class="fa fa-plus"></i> Add Transport');  
	      $("button[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>