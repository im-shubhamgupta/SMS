<?php

//error_reporting(1);

include('connection.php');

extract($_REQUEST);

$id=$_REQUEST['id'];



$query=mysqli_query($con,"select * from users where user_id='$id'");

$res=mysqli_fetch_array($query);


?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>



<div class="card">

<form method="post" enctype="multipart/form-data">

	<div class="card-header">

		<strong>Update</strong> User

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Enter Username</label>

			<input type="text" name="username" value="<?php echo $res['username']; ?>" class="form-control" required readonly>

			</div>

			

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">User Type</label>

			<select class="form-control" name="designation" required>

			<!--option <?php if ($res['roles'] == 'superadmin' ) echo 'selected';?> value="superadmin">Super Admin</option-->

			<option <?php if ($res['roles'] == 'admin' ) echo 'selected';?> value="admin">Admin</option>

			<option <?php if ($res['roles'] == 'account' ) echo 'selected';?> value="account">Account</option>

			<option <?php if ($res['roles'] == 'stock' ) echo 'selected';?> value="stock">Stock</option>

			<option <?php if ($res['roles'] == 'library' ) echo 'selected';?> value="library">Library</option>

			<option <?php if ($res['roles'] == 'systemuser' ) echo 'selected';?> value="systemuser">System User</option>

			</select>

			</div>

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Phone Number</label>

			<input type="number" id="contactno" name="phone" value="<?php echo $res['phone']; ?>" class="form-control" placeholder="Enter Phone Number" required>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Enter Email</label>

			<input type="email" name="email" value="<?php echo $res['email']; ?>" class="form-control" required>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Enter Password</label>

			<input type="password" value="<?php echo $res['pass']; ?>" name="password" placeholder="Enter Password." class="form-control" required>

			</div>

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Status</label>

			<select class="form-control" name=status>
				<option value="1" <?php if($res['status']=='1'){echo  "selected";} ?> >Active</option>
				<option  value="0" <?php if($res['status']=='0'){echo "selected";} ?> >Deactive</option>
				
			</select>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Select Image</label>

			<input type="file" name="file" class="form-control">

			</div>

			

			<div class="form-group">

			<img src="images/admin/<?php echo $res['profile_image']; ?>" height="150px" width="150px" style="border-radius:50%;border:3px solid grey"/>

			<input type="hidden" name="id" value="<?=$_GET['id']?>">

			</div>

			

		

	</div>

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class='fa fa-edit'></i> Update

		</button>

		

		<a href="dashboard.php?option=view_user" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

		

	</div>

	</form>

</div>



<script>

$("#contactno").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8) { if ($(this).val().length == 10) { if (k == 8) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>	
<?php include('datatable_links.php')?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "update_user";
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
			$('button[type="submit"]').html('<i class="fa fa-edit"></i> Update');  
	      $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>


