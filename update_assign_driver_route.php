<?php

include('connection.php');

extract($_REQUEST);

$aid=$_REQUEST['aid'];

$sql=mysqli_query($con,"select * from assign_driver_route where assign_id ='$aid'");

$res=mysqli_fetch_array($sql);



		

?>	

	

<form method="post" enctype="multipart/form-data">

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport Panel</a>

  <a class="breadcrumb-item" href="#">Transport</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_assign_driver_route">View Assign Driver & Vehicle to Route</a>

  <span class="breadcrumb-item active">Update Assign Driver to Route</span>

</nav>

<!-- breadcrumb -->



  <div id="right-panel" class="right-panel" style="width:1000px">

  

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-3">Assign Driver :</div>

		<div class="col-md-3" style="margin-top:-8px;">

		<select style="margin-left:-100px;" name="driver_id" id="class" class="form-select" autofocus required>

		<option value="" selected="selected" disabled>Select Driver</option>

		<?php

		$qdr = mysqli_query($con,"select * from driver where session='".$_SESSION['session']."'");

		while( $rdr = mysqli_fetch_array($qdr)) {

		?>

		<option <?php if($res['driver_id']==$rdr['id']){echo "selected";}?> value="<?php echo $rdr['id']; ?>"><?php echo $rdr['name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

					

		<div class="col-md-3" style="margin-left:-40px;">Assign Vehicle :</div>

		<div class="col-md-3" style="margin-left:-80px;margin-top:-8px;">

		<select style="width:170px;" class="form-select" name="vehicle_id" onchange="search_vehicleno(this.value);" required>

		<option value="" selected disabled>Select Vehicle</option>

		<?php

		$qve = mysqli_query($con,"select * from vehicle where session='".$_SESSION['session']."'");

		while( $rve = mysqli_fetch_array($qve)) {

		?>

		<option <?php if($res['vehicle_id']==$rve['vehicle_id']){echo "selected";}?> value="<?php echo $rve['vehicle_id']; ?>"><?php echo $rve['vehicle_name']; ?>

		</option>

		<?php } ?>

		</select>

		</div>				

	</div>

		

		<script>

		function search_vehicleno(strr)

			{

			var datastr={"vehno":strr};

			

			$.ajax({

				url:'search_vehicleno.php',

				type:'post',

				data:datastr,

				success:function(str)

				{

					$("#vehicle_no").val(str);

				}

			});

			

			}

		

		</script>

		

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-3">Vehicle Number :</div>

		<div class="col-md-3" style="margin-top:-8px;">

		<input style="margin-left:-100px;" type="text" class="form-control" id="vehicle_no" name="vehicle_no" value="<?php echo $res['vehicle_number'];?>" readonly/>

		</div>

		

		<div class="col-md-3" style="margin-left:-40px;">Assign Route :</div>

		<div class="col-md-3" style="margin-left:-80px;margin-top:-8px;">

		<select style="width:170px;" class="form-select" name="route_id" onchange="search_vehicleno(this.value);" required>

		<option value="" selected disabled>Select Route</option>

		<?php

		$qrt = mysqli_query($con,"select * from transports where session='".$_SESSION['session']."'");

		while( $rrt = mysqli_fetch_array($qrt)) {

		?>

		<option <?php if($res['route_id']==$rrt['trans_id']){echo "selected";}?> value="<?php echo $rrt['trans_id']; ?>"><?php echo $rrt['route_name']; ?>

		</option>

		<?php } ?>

		</select>

		</div>		

	</div>

		

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-3">About Him/Her :</div>

		<div class="col-md-8" style="margin-top:-8px;">

		<textarea style="margin-left:-100px;height:100px" class="form-control" name="description" placeholder="Enter Description" required><?php echo $res['description'];?></textarea>
		<input type="hidden" name="aid" value="<?=$_GET['aid']?>">
		</div>	

	</div>	

		

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<input type="submit" name="update" value="Assign" style="margin-left:400px;" class="btn btn-primary btn-sm col-2">

		

		<input type="reset" name="reset" value="Cancel" style="margin-left:40px;" class="btn btn-info btn-sm col-2"/>		

		

	</div>

	

<br><br><br>

</div><!-- /#right-panel -->

</form>



<?php //include('bootstrap_datatable_javascript_library.php'); ?>
 
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
  var action ="Update_Assign_Driver_Route";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("Please wait...");  
	$("input[type='submit']").attr("disabled", true);

	// alert(name);

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
				window.location.href='dashboard.php?option=view_assign_driver_route';
					// $('#assign_driver')[0].reset();
					// document.getElementById("assign_driver").reset();
				},3000);
			}
		
			else if(result.type=="error"){
				toastr.error(result.msg); 
			}
			  $("input[type='submit']").val('Assign');  
	      $("input[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>