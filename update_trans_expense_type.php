 <?php

	//error_reporting(1);

	include('connection.php');

	extract($_REQUEST);

	$eid=$_REQUEST['eid'];

	$sql=mysqli_query($con,"select * from transport_expense_type where trans_expense_type_id ='$eid'");

	$res=mysqli_fetch_array($sql);

	$expname=$res['trans_expense_type_name'];

	

	// if(isset($update))

	// {		

	// 	$expense = trim($expense," ");

		

	// 	$sql1=mysqli_query($con,"select * from expense_type where expense_type_name='$expense'");

	// 	$res1=mysqli_num_rows($sql1);

	// 	if($res1)

	// 	{

	// 		$err="<span id='err_notsuccessful'>[ This Expense Type Is Already Exists ]</span>";	

	// 	}

	// 	else

	// 	{

	// 		$query = mysqli_query($con,"update transport_expense_type set trans_expense_type_name='$expense' where trans_expense_type_id ='$eid'");

						

	// 		echo "<script>window.location='dashboard.php?option=view_transport_expense_type'</script>";	

	// 	}	

	// }

	

?> 

<div class="card">

<form action="" method="post">

	<div class="card-header">

		<strong>Update</strong> Transport Expense

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Enter Transport Expense Name</label>

			<input type="text" name="expense" placeholder="Enter Transport Expense Name" class="form-control" value="<?php echo $expname ?>" required></div>
			<input type="hidden" name="eid" value="<?=$_GET['eid']?>">
			

		

	</div>

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class="fa fa-edit"></i> Update

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
  var action ="Update_Transport_Expense_Type";
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
				window.location.href='dashboard.php?option=view_transport_expense_type';
					// $('form')[0].reset();
					// document.getElementById("assign_driver").reset();
				},3000);
			}
		
			else if(result.type=="error"){
				toastr.error(result.msg); 
			}
			  $("button[type='submit']").html('<i class="fa fa-edit"></i> Update');  
	      $("button[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>