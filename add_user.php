<?php

//error_reporting(1);

// include('connection.php');


?>	



<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>



<div class="card">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Setting Panel</a>

  <a class="breadcrumb-item" href="#">User Panel</a>

  <span class="breadcrumb-item active">Add User</span>

</nav>

<!-- breadcrumb -->

<form method="post" enctype="multipart/form-data">

	<div class="card-header">

		<strong>Add</strong> User

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Eneter Username</label>

			<input type="text" name="username" class="form-control" placeholder="Enter Username" required>

			</div>

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">User Type</label>

			<select class="form-control" name="designation" required>

			<option value="" selected disabled>Select User Type</option>

			<option value="admin">Admin</option>

			<option value="account">Account</option>

			<option value="stock">Stock</option>

			<option value="library">Library</option>

			<option value="systemuser">System User</option>

			</select>

			</div>

					

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Phone Number</label>

			<input type="number" id="contactno" name="phone" class="form-control" placeholder="Enter Phone Number" required>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Enter Email</label>

			<input type="email" name="email" class="form-control" placeholder="Enter Email" required>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Enter Password</label>

			<input type="text" id="password" name="password" class="form-control" placeholder="Enter Password" required><span id="wm2"></span>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Select Image</label>

			<input type="file" name="file" class="form-control">

			</div>

			

	</div>

	<div class="card-footer">

		<button type="submit" name="add" class="btn btn-primary btn-sm">

		<i class="fa fa-plus"></i> Add User

		</button>

		

	</div>

	</form>

</div>



<script>

$("#contactno").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || (k >= 48 && k <= 57)) { if ($(this).val().length == 10) { if (k == 8) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>
<?php include('datatable_links.php')?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "add_user";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/SettingControllers.php",
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
				window.location.href='dashboard.php?option=view_user';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('button[type="submit"]').html('<i class="fa fa-plus"></i> Add User');  
	      $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>



