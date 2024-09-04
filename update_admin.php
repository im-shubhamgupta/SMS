<?php
//error_reporting(1);
include('connection.php');
$email=$_SESSION['user_logged_in'];
$query=mysqli_query($con,"select * from users where email='$email'");
$res=mysqli_fetch_array($query);
?>

<div class="card">
<form method="post" enctype="multipart/form-data">
	<div class="card-header">
		<strong>Upadte</strong> Admin
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>
	</div>
	<div class="card-body card-block">
			
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Enter Username</label>
			<input type="text" name="username" value="<?php echo $res['username']; ?>" class="form-control" required>
			</div>
		
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Admin Email</label>
			<input type="email" name="email" value="<?php echo $res['email']; ?>" class="form-control" required readonly>
			</div>
			
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Enter Password</label>
			<input type="text" value="<?php echo $res['pass']; ?>" name="password" placeholder="Enter Password." class="form-control" required>
			</div>
			
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Select Admin Image</label>
			<input type="file" name="file" class="form-control">
			</div>
			
			<div class="form-group">
			<img src="images/admin/<?php echo $res['profile_image']; ?>" height="150px" width="150px" style="border-radius:50%;border:3px solid grey"/>
			</div>
			
		
	</div>
	<div class="card-footer">
		<button type="submit" name="update" class="btn btn-primary btn-sm">
			<i class="fa fa-dot-circle-o"></i> Update
		</button>
		
	</div>
	</form>
</div>

<?php
extract($_REQUEST);
if (isset($update))
{
	$pic=$_FILES['file']['name'];
	if ($pic=="")
	{
		$que="update users set username='$username', pass='$password' where email='$email'";
		$chk=mysqli_query($con,$que);
		echo "<script>window.location='dashboard.php?option=update_admin'</script>";
	}
	else
	{
		$que="update users set username='$username', pass='$password', profile_image='$pic' where email='$email'";
		$picture=$res['profile_image'];
		unlink ("images/admin/$picture");
		mysqli_query($con,$que);
		move_uploaded_file($_FILES['file']['tmp_name'],"images/admin/".$_FILES['file']['name']);
		echo "<script>window.location='dashboard.php?option=update_admin'</script>";	
			
	}
}
?>	
