<?php

error_reporting(1);

include('connection.php');



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

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Administration Panel</a>

  <a class="breadcrumb-item active" href="#">Assign Late Fees to Class</a>


</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

				

		<div class="col-md-2">Class : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:170px;" name="classid" id="classid" class="form-control" 
		 required autofocus>

		<option value="" selected="selected" disabled>Select Class</option>

		<?php

		$scls = mysqli_query($con,"select * from class");

		while( $rcls = mysqli_fetch_array($scls) ) {

		?>

		<option <?php if($class==$rcls['class_id']){echo "selected";}?> value="<?php echo $rcls['class_id']; ?>"><?php echo $rcls['class_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>


	</div>

		

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Late Fee Amount: </div>

	<div class="col-md-3" style="margin-top:-8px;">
		<input type="text" name="late_fee_amt"  class="form-control" required>

	</div>

	</div>

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Days of Late Fee: </div>

	<div class="col-md-3" style="margin-top:-8px;">
		<input type="text" name="late_fee_days"  class="form-control" required>

	</div>

	</div>

	


	

	<br/><br/>

	<div>

	<input type="submit" name="save" value="Assign" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<!-- <input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-info btn-sm"/> -->
		<a href="dashboard.php?option=view_late_fee_assign_to_class" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>
	</div>
</form>
<?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "assign_late_fee_to_class";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("please wait...");  
	$('input[type="submit"]').attr("disabled", true);

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
				// setInterval(function(){ 
				// window.location.href='dashboard.php?option=';
				// 			// $('form')[0].reset(); 
				// },3000);
				setTimeout(function(){ 
							$('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$("input[type='submit']").val("Submit");  
	$('input[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>

