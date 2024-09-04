<?php
	//error_reporting(1);
	// extract($_REQUEST);

	
?>
<div class="card">
<!-- breadcrumb-->
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Fees
  <a class="breadcrumb-item" href="dashboard.php?option=view_fees_header">Fees Header </a>
  <span class="breadcrumb-item active">Add Fees Header</span>
</nav>
<!-- breadcrumb -->
<form action="" method="post">
	<div class="card-header">
		<strong>Add</strong> Fees
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>
	</div>
	<div class="card-body card-block">
		
			
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Fee Heading</label>
			<input type="text" name="feehead" class="form-control" placeholder="Enter Fees Heading" required>
			</div>									    <div class="form-group">                     <label for="nf-email" class=" form-control-label">Fee Heading</label>					
					<select name="type" class="form-control" style="width:175px;" autofocus required>						
						<option value="0" selected="selected" >Yearly</option>		
											<option value="1">Monthly</option>		
																						</select>				
																										            </div><br>
			
			
	</div>
	<div class="card-footer">
		<button type="submit" name="add" class="btn btn-primary btn-sm">
		<i class="fa fa-plus"></i> Add Header
		</button>
		
		<a href="dashboard.php?option=view_fees_header" class="btn btn-info btn-sm"> 
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
  var action = "add_fees_header";
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
				window.location.href='dashboard.php?option=add_fees_header&smid=5';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('button[type="submit"]').html('<i class="fa fa-plus"></i> Add Header');  
	      $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>