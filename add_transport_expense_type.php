<?php

	//error_reporting(1);

	extract($_REQUEST);

	// if(isset($add))

	// {		

	// 	$expense = trim($expense, " ");

		

	// 	$sql=mysqli_query($con,"select * from transport_expense_type where trans_expense_type_name='$expense'");

	// 	$res=mysqli_num_rows($sql);

	// 	if($res)

	// 	{

	// 		$err="<span id='err_notsuccessful'>[ This Expense Type Is Already Exists ]</span>";	

	// 	}

	// 	else

	// 	{

	// 		$query=mysqli_query($con,"insert into transport_expense_type (trans_expense_type_id,trans_expense_type_name) values('0','$expense')");	

						

	// 		$err="<span id='err_successful'>[ Expense Type Added Successfully ]</span>";

	// 	}

		

	// }

	

?>



<div class="card">

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport Panel</a>

  <a class="breadcrumb-item" href="#">Transport Expense</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_transport_expense_type">View Transport Expense Type</a>

  <span class="breadcrumb-item active">Add Transport Expense Type</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post">

	<div class="card-header">

		<strong>Add</strong> Transport Expense Type

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Enter Transport Expense Name</label>

			<input type="text" name="expense" placeholder="Enter Transport Expense Name" class="form-control" required></div>

			

		

	</div>

	<div class="card-footer">

		<button type="submit" name="add" class="btn btn-primary btn-sm">

		<i class="fa fa-plus"></i> Add Transport Expense

		</button>

		

		<a href="dashboard.php?option=view_transport_expense_type" class="btn btn-info btn-sm"> 

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
  var action ="Add_Transport_Expense_Type";
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
			  $("button[type='submit']").html('<i class="fa fa-plus"></i> Add Transport Expense');  
	      $("button[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>