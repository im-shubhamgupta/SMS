<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



/*if(isset($save))

{

	

	$que = mysqli_query($con,"select * from students where student_id='$student'");

	$res = mysqli_fetch_array($que);

	$stuname = $res['student_name'];

	$olddue = $res['due'];

	$newdue = $olddue + $prevfee;

	

	$que1 = mysqli_query($con,"select * from student_wise_fees where student_id='$student'");

	$res1 = mysqli_fetch_array($que1);

	$oldfee1 = $res1['due_amount'];

	$newdue1 = $oldfee1 + $prevfee;

	

	$q1 = mysqli_query($con,"select * from previous_fees where student_id='$student'");

	$row = mysqli_num_rows($q1);

	if($row)

	{

		echo "<script>alert('Previous Fees for ".$stuname." Already Entered.')</script>";

	}

	else

	{

		$q2 = "insert into previous_fees (student_id,class_id,section_id,previous_fees,remarks) 

		values('$student','$classid','$sectionid','$prevfee','$remark')";

	

		if(mysqli_query($con,$q2))

		{

			

			$action = "Previous Fees for ".$stuname." is Created"; 

			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

			machine_name,browser,date) 

			values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

		

		mysqli_query($con,"update students set due='$newdue' where student_id='$student'");

		

		mysqli_query($con,"update student_due_fees set due_amount='$newdue' where student_id='$student'");

		

		mysqli_query($con,"update student_wise_fees set due_amount='$newdue1' where student_id='$student'");

		}

		echo "<script>alert('Previous Fees Entered.')</script>";

	}

	

}*/

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

  <span class="breadcrumb-item active"> Create Previous Fees</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Class : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:170px;" name="classid" id="classid" class="form-control" 

	onchange="searchstudent(this.value);search_sec(this.value);" required autofocus>

	<option value="" selected="selected" disabled>Select Class</option>

	<?php

	$scls = "select * from class";

	$rcls = mysqli_query($con, $scls);

	while( $rescls = mysqli_fetch_array($rcls) ) {

	?>

	<option <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

	</option>

	<?php } ?>							

	</select>

	</div>



<script>

function search_sec(str)

{

var xmlhttp= new XMLHttpRequest();	

xmlhttp.open("get","search_ajax_section_withoutall.php?cls_id="+str,true);

xmlhttp.send();

xmlhttp.onreadystatechange=function()

{

if(xmlhttp.status==200  && xmlhttp.readyState==4)

{

document.getElementById("sectionid").innerHTML=xmlhttp.responseText;

}

} 

}

</script>



	<div class="col-md-2" style="font-size:16px;margin-left:80px;">Section : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

	<select style="width:170px;" name="sectionid" id="sectionid" class="form-control" onchange="searchstudent(this.value);" required autofocus>

	<option value="" selected="selected" disabled>Select Section</option>							

	</select>

	</div>

	</div>

	

<script>

function searchstudent(str)

{

var xmlhttp= new XMLHttpRequest();	

xmlhttp.open("get","search_ajax_student_report.php?sec_id="+str,true);

xmlhttp.send();

xmlhttp.onreadystatechange=function()

{

if(xmlhttp.status==200  && xmlhttp.readyState==4)

{

document.getElementById("student").innerHTML=xmlhttp.responseText;

}

}

}

</script>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Select Student : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:170px;" name="student" id="student" class="form-control" required autofocus>

	<option value="" selected="selected" disabled> Select Student </option>

	</select>

	</div>

		

	<div class="col-md-2" style="font-size:16px;margin-left:80px;">Previous Fees : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="number" name="prevfee" class="form-control" style="margin-left:-20px;width:170px;" required autofocus>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Remarks : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="remark" class="form-control" style="width:545px;height:50px;" required autofocus></textarea>

	</div>

	</div><br><br><br>

	

	

	<div>

	<input type="submit" name="save" value="Save" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-info btn-sm"/>

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
  var action ="Create_Previous_Fees";
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
			console.log(responce);
			if(result.status=="success"){
				// alert('success');
				toastr.success(result.msg); 
				setInterval(function(){ 
				window.location.href='dashboard.php?option=create_previous_fees&smid=34';
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

