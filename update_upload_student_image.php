<?php

include('connection.php');

extract($_REQUEST);

$id=$_REQUEST['id'];

$sql=mysqli_query($con,"select * from idcard where id='$id'");

$res=mysqli_fetch_array($sql);



$clid=$res['class_id'];

$quec=mysqli_query($con,"select * from class where class_id='$clid'");

$resc=mysqli_fetch_array($quec);

$clsname = $resc['class_name'];



$seid=$res['section_id'];

$qse=mysqli_query($con,"select * from section where section_id='$seid'");

$rsec=mysqli_fetch_array($qse);

$secname = $rsec['section_name'];



$oldpic=$res['pic'];





if(isset($update))

{



	$img=$_FILES['file']['name'];



	$q1 = "update idcard set pic='$img' where id='$id'";

	if(mysqli_query($con,$q1))

	{

		

	unlink("gallery/idcard/$clsname/$secname/$oldpic");

	

	move_uploaded_file($_FILES['file']['tmp_name'],"gallery/idcard/$clsname/$secname/".$img);

	

	}

	echo "<script>window.location='dashboard.php?option=view_upload_student_image'</script>";	

	

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

			<label for="nf-email" class=" form-control-label">Class</label>

				<input type="text" value="<?php echo $resc['class_name']; ?>" readonly class="form-control" name="nclass">

			</div>

			

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Section</label>

			<input type="text" name="nsection" value="<?php echo $rsec['section_name'];?>" readonly class="form-control" required>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Register No</label>

			<input type="text" name="nsection" value="<?php echo $res['regno'];?>" readonly class="form-control" required>

			</div>

			

			<div class="row">

			<div class="col-md-3">

			<label for="nf-email" class=" form-control-label">Student Image</label>

			<input type="file" name="file" class="form-control" style="width:240px;">

			</div>

			<div class="col-md-3">	

			<div class="form-group">

			<a href="gallery/idcard/<?php echo $clsname; ?>/<?php echo $secname; ?>/<?php echo $oldpic;?>"><img src="gallery/idcard/<?php echo $clsname; ?>/<?php echo $secname; ?>/<?php echo $oldpic;?>" width='90px' height='90px' style="border-radius:50%"/>

			</div>

			</div>

			</div>

		

	</div>

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class='fa fa-edit'></i> Update

		</button>

		

		<a href="dashboard.php?option=view_upload_student_image" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

	</div>

	</form>

</div>