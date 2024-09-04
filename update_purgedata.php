 <?php

	//error_reporting(1);

	include('connection.php');

	extract($_REQUEST);

	$pid=$_REQUEST['pid'];

	$sql=mysqli_query($con,"select * from purge_data where purge_id='$pid'");

	$res=mysqli_fetch_array($sql);

	$pdate=$res['purge_date'];

	$desc=$res['description'];

	

	

?> 

<div class="card">

<form action="" method="post">

	<div class="card-header">

		<strong>Update</strong> Purge Data

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:red"><?php echo @$err; ?></label>

	</div>

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Select Date : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="date" name="npurgedate" class="form-control" style="width:175px;" value="<?php echo $pdate;?>" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Description : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="ndescription" class="form-control" style="width:580px;height:50px;" required autofocus><?php echo $desc;?></textarea>
	<input	type='hidden' name='pid' value="<?=$_GET['pid']?>">
	</div>

	</div>

	<br><br>

	

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class='fa fa-edit'></i> Update

		</button>

		

		<a href="dashboard.php?option=view_purge_data" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

		

	</div>

</form>

</div>
<?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "update_purgedata";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/AdministrationControllers.php",
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
				window.location.href='dashboard.php?option=view_purge_data';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$("button[type='submit']").html(" <i class='fa fa-edit'></i> Update");  
	        $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>
