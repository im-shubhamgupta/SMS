 <?php

	//error_reporting(1);

	include('connection.php');

	extract($_REQUEST);

	$eid=$_REQUEST['eid'];

	$sql=mysqli_query($con,"select * from expense_type where expense_type_id='$eid'");

	$res=mysqli_fetch_array($sql);

	$expname=$res['expense_type_name'];

	


?> 

<div class="card">

<form action="" method="post">

	<div class="card-header">

		<strong>Update</strong> Expense

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Enter Expense Name</label>

			<input type="text" name="expense" placeholder="Enter Expense Name" class="form-control" value="<?php echo $expname ?>" required></div>
			<input type="hidden" name="eid" value="<?=$_GET['eid']?>">
			

		

	</div>

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class="fa fa-edit"></i> Update

		</button>

		

		<a href="dashboard.php?option=view_expense_type" class="btn btn-info btn-sm"> 

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
  var action = "update_expense_type";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/ConfigurationControllers.php",
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
				window.location.href='dashboard.php?option=view_expense_type&smid=12';
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