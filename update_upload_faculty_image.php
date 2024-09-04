<?php

include('connection.php');

extract($_REQUEST);

$id=$_REQUEST['id'];

$sql=mysqli_query($con,"select * from staff_idcard where id='$id'");

$res=mysqli_fetch_array($sql);



$oldpic=$res['pic'];





if(isset($update))

{



	$img=$_FILES['file']['name'];



	$q1 = "update staff_idcard set pic='$img',modify_date=now() where id='$id'";

	if(mysqli_query($con,$q1))

	{

		

	unlink("gallery/staffidcard/$oldpic");

	

	move_uploaded_file($_FILES['file']['tmp_name'],"gallery/staffidcard/".$img);

	

	}

	echo "<script>window.location='dashboard.php?option=view_upload_faculty_image'</script>";	

	

}	

?>

<div class="card">

<form method="post" enctype="multipart/form-data">

	<div class="card-header">

		<strong>Update</strong> Image

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:red"><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

					

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Staff ID</label>

			<input type="text" name="nsection" value="<?php echo $res['staff_id'];?>" readonly class="form-control" required>

			</div>

			

			<div class="row">

			<div class="col-md-3">

			<label for="nf-email" class=" form-control-label">Staff Image</label>

			<input type="file" name="file" class="form-control" style="width:240px;">

			</div>

			<div class="col-md-3">	

			<div class="form-group">

			<a href="gallery/staffidcard/<?php echo $oldpic;?>"><img src="gallery/staffidcard/<?php echo $oldpic;?>" width='90px' height='90px' style="border-radius:50%"/>

			</div>

			</div>

			</div>

		

	</div>

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class='fa fa-edit'></i> Update

		</button>

		

		<a href="dashboard.php?option=view_upload_faculty_image" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

	</div>

	</form>

</div>