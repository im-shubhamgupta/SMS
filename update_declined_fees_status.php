<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



$q=mysqli_query($con,"select * from student_due_fees where student_due_fee_id ='$id' and `session`='".$_SESSION['session']."' ");

$r=mysqli_fetch_array($q);

$stuid = $r['student_id'];

$dueamt = $r['due_amount'];



// $q1 = mysqli_query($con,"select * from students where student_id='$stuid' and `session`='".$_SESSION['session']."'");
$q1=mysqli_query($con,"select `student_name`,`register_no`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where student_id='$stuid' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."'");
$r1 = mysqli_fetch_array($q1);

$class = $r1['class_id'];

$q2 = mysqli_query($con,"select * from class where class_id='$class'");

$r2 = mysqli_fetch_array($q2);

$classname = $r2['class_name'];

$section = $r1['section_id'];

$q3 = mysqli_query($con,"select * from section where section_id='$section'");

$r3 = mysqli_fetch_array($q3);

$sectionname = $r3['section_name'];



$sfee=$r['received_amount'];

$sfeearr = explode(',',$sfee);	

$tfee1 = 0;

foreach($sfeearr as $v)

{

	$tfee1 = $tfee1 + $v;



}





// if(isset($save))

// {
// 	$modify_date=date('Y-m-d H:i:s');

// 	$query = "update student_due_fees set payment_detail='$payment_detail', issue_date='$date', date='$date', 

// 	comment='$comment', status=3,modify_date='$modify_date' where student_due_fee_id='$id' update_declined_fees";



// 	if(mysqli_query($con,$query))

// 	{

		

// 		$que1 = mysqli_query($con,"update students set due='$dueamt' ,modify_date='$modify_date'  where student_id='$stuid' and `session`='".$_SESSION['session']."'");

// 		$que2 = mysqli_query($con,"update student_wise_fees set due_amount='$dueamt' ,modify_date='$modify_date'  where student_id='$stuid' and `session`='".$_SESSION['session']."'");

		

// 		echo "<script>window.location='dashboard.php?option=update_declined_fees'</script>";

// 	}

// }







?>



<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  

<script src="multi.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

	



<style>



input[type=checkbox] {

    zoom: 1.8;

	margin-top:5px;

}

</style>



<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Accounts Panel</a>

  <a class="breadcrumb-item" href="dashboard.php?option=update_declined_fees">Update Declined Fees</a>

  <span class="breadcrumb-item active">Update Declined Fees Status</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Name : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="name" class="form-control" style="width:175px;" value="<?php echo $r1['student_name']; ?>" readonly>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">Register No : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="text" name="regno" class="form-control" style="width:175px;" value="<?php echo $r1['register_no']; ?>" readonly>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2">Class : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="class" class="form-control" style="width:175px;" value="<?php echo $classname; ?>" readonly>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">Section : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="text" name="class" class="form-control" style="width:175px;" value="<?php echo $sectionname; ?>" readonly>

		</div>

	</div>	

		

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Cheque No : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="text" name="payment_detail" class="form-control" style="width:175px;" value="<?php echo $r['payment_detail']; ?>"  autofocus>

	</div>



	<div class="col-md-2" style="margin-left:80px;">Payment Date : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

	<input type="date" name="date" class="form-control" style="width:175px;" value="<?php echo $r['date']; ?>" required autofocus>

	</div>

	</div>

	

		

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Amount Paid : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="number" name="amtpaid" class="form-control" style="width:175px;" value="<?php echo $tfee1 ?>" required autofocus>

	</div>

	

	<div class="col-md-2" style="margin-left:80px;">Reconciled Status: </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

	<select class="form-control" name="status" style="width:170px;">

	<option>Paid</option>											

	</select>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Comments : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="comment" class="form-control" style="width:580px;height:60px;" required autofocus><?php echo $r['comment'];?></textarea>

	</div>

	</div>

	<br><br>

	

	<div>
		<input type="hidden" name="id" value="<?=$_GET['id']?>">
	<input onclick="return confirm('Do you want to save.');" type="submit" name="save" value="Save" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-primary btn-sm"/>

	</div>



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
	// console.log(this);
  var action ="Update_declined_fee_status";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("Please wait...");  
	$("input[type='submit']").attr("disabled", true);

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
			// console.log(responce);
			if(result.status=="success"){
				// alert('success');
				toastr.success(result.msg); 
				setInterval(function(){ 
				window.location.href='dashboard.php?option=update_declined_fees';
				},3000);
			}
		
			else if(result.status=="error"){
				toastr.error(result.msg); 
			

			}
			  $("input[type='submit']").val("Save");  
	      $("input[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>


