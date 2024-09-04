<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



$id = $_REQUEST['id'];

$que = mysqli_query($con,"select * from previous_fees where prev_fee_id='$id'");

$res = mysqli_fetch_array($que);

$stuid = $res['student_id'];

$oldprev_fee = $res['previous_fees'];





$q1 = mysqli_query($con,"select * from students where student_id='$stuid'");

$r1 = mysqli_fetch_array($q1);

$stuname = $r1['student_name'];

$olddue = $r1['due'];



$clsid = $res['class_id'];

$q2 = mysqli_query($con,"select * from class where class_id='$clsid'");

$r2 = mysqli_fetch_array($q2);

$clsname = $r2['class_name'];



$secid = $res['section_id'];

$q3 = mysqli_query($con,"select * from section where section_id='$secid'");

$r3 = mysqli_fetch_array($q3);

$secname = $r3['section_name'];

									

$prevfees = $res['previous_fees'];

$remark = $res['remarks'];



/*if(isset($update))

{

	$newdue = $olddue - $oldprev_fee + $nprevfee;

	

	$q = "update previous_fees set previous_fees='$nprevfee', remarks='$nremark' 

	where prev_fee_id='$id'";

	

		if(mysqli_query($con,$q))

		{

			$action = "Previous Fees for ".$stuname." is Updated"; 

			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

			machine_name,browser,date) 

			values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

			

			mysqli_query($con,"update students set due='$newdue' where student_id='$stuid'");

		

			mysqli_query($con,"update student_due_fees set due_amount='$newdue' where student_id='$stuid'");

			

			mysqli_query($con,"update student_wise_fees set due_amount='$newdue' where student_id='$stuid'");

		}

			

	echo "<script>window.location='dashboard.php?option=view_previous_fees'</script>";

	

}
*/


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

  <a class="breadcrumb-item" href="#">Accounts Panel</a>

  <a class="breadcrumb-item" href="#"> Previous Fees</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_previous_fees"> View Previous Fees</a>

  <span class="breadcrumb-item active"> Edit Previous Fees</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Class : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="text" value="<?php echo $clsname; ?>" class="form-control" style="width:170px;" disabled>

	</div>



	<div class="col-md-2" style="font-size:16px;margin-left:80px;">Section : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

	<input type="text" value="<?php echo $secname; ?>" class="form-control" style="width:170px;" disabled>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Select Student : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="text" value="<?php echo $stuname; ?>" class="form-control" style="width:170px;" disabled>

	</div>

		

	<div class="col-md-2" style="font-size:16px;margin-left:80px;">Previous Fees : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="number" name="nprevfee" class="form-control" style="margin-left:-20px;width:170px;" 

	value="<?php echo $prevfees; ?>" required autofocus>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Remarks : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="nremark" class="form-control" style="width:545px;height:50px;" required autofocus><?=$remark;?></textarea>
	<input type="hidden" name="id" value="<?=$_GET['id']?>">

	</div>

	</div><br><br><br>

	

	

	<div>

	<button type="submit" name="update" id="add" style="margin-left:390px;" class="btn btn-secondary btn-sm"/>

	<i class='fa fa-edit'></i> Update

	</button>

	

	<a href="dashboard.php?option=view_previous_fees" class="btn btn-info btn-sm"> 

	<i class='fa fa-arrow-left'> Back</i></a>
</form>
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
  var action ="Edit_Previous_Fees";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
$("button[type='submit']").html("Please wait...");  
	$("button[type='submit']").attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/AccountFeesController.php",
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
				toastr.success(result.msg); 
				setInterval(function(){ 
				window.location.href='dashboard.php?option=view_previous_fees';
				},3000);
			}
			else if(result.status=="error"){
				toastr.error(result.msg); 
				
	    }
	    $("button[type='submit']").html("<i class='fa fa-edit'></i> Update"); 
	    $("button[type='submit']").attr("disabled", false);        
		}
	})
});

});

</script>
