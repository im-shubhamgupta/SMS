<?php

include('connection.php');

extract($_REQUEST);



// if(isset($save))

// {

// 	$dept = $_REQUEST['dept'];

// 	$staffid = $_REQUEST['to'];

	

// 	foreach($staffid as $k)

// 	{

// 		// $que1=mysqli_query($con,"select * from staff where st_id='$k'");

// 		// $r1 = mysqli_fetch_array($que1);

// 		// $regno=$r1['register_no'];

// 		// $stuname=$r1['student_name'];

// 		// $classid = $r1['class_id'];

// 		// $section = $r1['section_id'];

		

// 		$que2=mysqli_query($con,"insert into assign_department(dept_id,staff_id,date)

// 		values('$dept','$k',now())");

// 	}



// }	



?>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  

<script src="multi.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script type="text/javascript" src="http://www.google.com/jsapi"></script>

	

<!-- breadcrumb-->

<style>



input[type=checkbox] {

    zoom: 1.8;

	margin-top:5px;

}

</style>

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Management</a>

  <span class="breadcrumb-item active">Assign Department</span>

</nav>

<form method="post" enctype="multipart/form-data"> 



<!---- Important Information ---->

	<div class="row" style="margin-top:50px;margin-left:20px;">

	<div class="col-md-2" style="margin-right:10px;">Select Department : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:185px;margin-left:-30px;" name="dept" onchange="showstaff(this.value)" class="form-control">

	<option value="" selected="selected" disabled>Select Department</option>

	<?php

	$qgrp = mysqli_query($con,"select * from department");

	while( $rgrp = mysqli_fetch_array($qgrp) ) {

	?>

	<option value="<?php echo $rgrp['dept_id']; ?>"><?php echo $rgrp['dept_name']; ?>

	</option>

	<?php } ?>							

	</select>

	</div>

	</div>

	

	

	

<script>

function showstaff(str)

{

	//alert(str);

var xmlhttp= new XMLHttpRequest();	

xmlhttp.open("get","search_ajax_staff_dept.php",true);

xmlhttp.send();

xmlhttp.onreadystatechange=function()

{

if(xmlhttp.status==200  && xmlhttp.readyState==4)

{

document.getElementById("students").innerHTML=xmlhttp.responseText;

}

} 

}

</script>

	

	<div class="row" style="margin-top:40px;margin-left:20px;">

	<div class="col-md-4" style="margin-left:20px;">Staff List </div>

	<div class="col-md-1"></div>

	<div class="col-md-4" style="font-size:16px;margin-left:160px;">Selected Staff </div>

	</div>

	

	<div class="row">

	<div class="col-md-5">

        <select name="from[]" id="students" class="multiselect form-control" size="8" multiple="multiple" data-right="#multiselect_to_1" data-right-all="#right_All_1" data-right-selected="#right_Selected_1" data-left-all="#left_All_1" data-left-selected="#left_Selected_1">

        </select>

    </div>

    

    <div class="col-md-2">

        <button type="button" id="right_All_1" class="btn btn-block btn-light border"><i class="fa fa-forward"></i></button>

        <button type="button" id="right_Selected_1" class="btn btn-block btn-light border"><i class="fa fa-chevron-right"></i></button>

        <button type="button" id="left_Selected_1" class="btn btn-block btn-light border"><i class="fa fa-chevron-left"></i></button>

        <button type="button" id="left_All_1" class="btn btn-block btn-light border"><i class="fa fa-backward"></i></button>

    </div>

    

    <div class="col-md-5">

        <select name="to[]" id="multiselect_to_1" class="form-control" size="8" multiple="multiple"></select>

    </div>

	</div><br>

	<br>

	

<div>

<button type="submit" name="save" id="add" style="margin-left:350px;" class="btn btn-primary btn-sm"/>

<i class="fa fa-plus"></i> Save

		</button>

<input type="reset" name="reset" value="Cancel" style="margin-left:50px;" class="btn btn-info btn-sm"/>

</div>

	<br>

	

	<!---- Important Information ---->



</form>



<script type="text/javascript">

jQuery(document).ready(function($) {

    $('.multiselect').multiselect();

});

</script>
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
  var action ="AssignDepartment";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("Please wait...");  
	$("input[type='submit']").attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/StaffController.php",
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
				window.location.href='dashboard.php?option=assign_department';
				},3000);
			}
		
			else if(result.type=="error"){
				toastr.error(result.msg); 
			

			}
			  $("input[type='submit']").val("Assign");  
	      $("input[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>
