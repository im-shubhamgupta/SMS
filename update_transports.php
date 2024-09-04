<?php

	//error_reporting(1);

	include('connection.php');

	extract($_REQUEST);

	$tid=$_REQUEST['tid'];

	$sql=mysqli_query($con,"select * from transports where trans_id='$tid'");

	$res=mysqli_fetch_array($sql);

	

	

	// if(isset($update))

	// {

	// 	$rname = trim($rname, " ");

	// 	$price = trim($price, " ");

		

	// 	mysqli_query($con,"update transports set route_name='$rname', price='$price' where trans_id='$tid'");		

	// 	echo "<script>window.location='dashboard.php?option=view_transports'</script>";	

		

	// }	

	

?>

<div class="card">

<form method="post">

	<div class="card-header">

		<strong>Update</strong> Transport

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Route Name</label>

			<input type="text" name="rname" value="<?php echo $res['route_name']; ?>" class="form-control" required>

			

			</div>

			

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Price</label>

			<input type="text" name="price" value="<?php echo $res['price']; ?>" class="form-control" placeholder="Enter Price" required>
			<input type="hidden" name="tid" value="<?=$_GET['tid']?>">
			</div>

			

		

	</div>

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class="fa fa-edit"></i> Update

		</button>

		

		<a href="dashboard.php?option=view_transports" class="btn btn-info btn-sm">

		<i class='fa fa-arrow-left'> </i> Back</a>

		

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
  var action ="Update_Transport";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("Please wait...");  
	$("button[type='submit']").attr("disabled", true);
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
				window.location.href='dashboard.php?option=view_transports';
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