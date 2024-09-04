<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);

$q = mysqli_query($con,"select * from assign_syllabus_staff where assign_syllabus_id ='$id'");
$r = mysqli_fetch_array($q);


if(isset($update))
{
	
	$q1 = mysqli_query($con,"update assign_syllabus_staff set chapter='$nchapter', days='$ndays', from_dt='$nfromdt', 
	to_dt='$ntodt', description='$ndescription' where assign_syllabus_id ='$id'");
	
	echo "<script>window.location='dashboard.php?option=view_syllabus_allocated_staff'</script>";
}
?>

<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  
<script src="multi.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<style>
	tr th{
		
		font-size:11px;
	}

	tr td{
		
		font-size:11px;
	}

	</style>
	
<script type="text/javascript">
$(document).ready(function(){
    $(".menu a").each(function(){
        if($(this).hasClass("disabled")){
            $(this).removeAttr("href");
        }
    });
});
</script>
<!-- breadcrumb-->
<style>

input[type=checkbox] {
    zoom: 1.8;
	margin-top:5px;
}
</style>
<nav class="breadcrumb" style="width:1000px;">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Staff Panel</a>
  <a class="breadcrumb-item" href="#">Syllabus Management</a>  
  <a class="breadcrumb-item" href="dashboard.php?option=view_syllabus_allocated_staff">View Syllabus Allocated to Staff</a>  
  <span class="breadcrumb-item active">Update Allocated Syllabus</span>
</nav>
<!-- breadcrumb -->

<form method="post" enctype="multipart/form-data"> 
	<div class="row" style="margin-top:50px;margin-left:20px;">
		<div class="col-md-2">Chapter : </div>
		<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">
		<input type="text" name="nchapter" value="<?php echo $r['chapter'];?>" class="form-control" style="width:175px;" required autofocus>
		</div>
		
		<div class="col-md-2" style="margin-left:50px;">Days : </div>
		<div class="col-md-2" style="margin-top:-8px;margin-left:-70px;">
		<input type="number" name="ndays" value="<?php echo $r['days'];?>" class="form-control" style="width:175px;" required autofocus>
		</div>
	</div>
	
	<div class="row" style="margin-top:50px;margin-left:20px;">	
		<div class="col-md-2">From Date : </div>
		<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">
		<input type="date" name="nfromdt" value="<?php echo $r['from_dt'];?>" class="form-control" style="width:175px;" required autofocus>
		</div>
		
		<div class="col-md-2" style="margin-left:50px;">To Date : </div>
		<div class="col-md-2" style="margin-top:-8px;margin-left:-70px;">
		<input type="date" name="ntodt" value="<?php echo $r['to_dt'];?>" class="form-control" style="width:175px;" required autofocus>
		</div>
		
	</div>
	
	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2" style="font-size:16px;">Description : </div>
	<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">
	<textarea name="ndescription" class="form-control" style="width:580px;height:80px;" required autofocus><?php echo $r['description'];?></textarea>
	</div>
	</div>
	<br><br>
	
	<div>
	<input type="submit" name="update" value="Update" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>
	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-primary btn-sm"/>
	</div>

</form>
