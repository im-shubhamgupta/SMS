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
/* 
	tr th{

		

		font-size:11px;

	}



	tr td{

		

		font-size:11px;

	} */



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

  <a class="breadcrumb-item" href="#">Transport Panel</a>

  <a class="breadcrumb-item" href="#">Previous Transport Fees</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_previous_transport_fees"> View Previous Transport Fees</a>

  <span class="breadcrumb-item active"> Create Previous Transport Fees</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Class : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:170px;" name="classid" id="classid" class="form-select" 

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

	<select style="width:170px;" name="sectionid" id="sectionid" class="form-select" onchange="searchstudent(this.value);" required autofocus>

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

	<select style="width:170px;" name="student" id="student" class="form-select" required autofocus>

	<option value="" selected="selected" disabled> Select Student </option>

	</select>

	</div>

		

	<div class="col-md-2" style="font-size:16px;margin-left:80px;">Previous Transport Fees : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="number" name="prevtransfee" class="form-control" style="margin-left:-20px;width:170px;" required autofocus>


	<input  type="hidden" name="paneli" value="<?=$panelid?>">
	<input  type="hidden" name="menuid" value="<?=$menuid?>">
	<input  type="hidden" name="submenuname" value="<?=$submenuname?>">
	<input  type="hidden" name="machinename" value="<?=$machinename?>">
	<input  type="hidden" name="ExactBrowserNameBR" value="<?=$ExactBrowserNameBR?>">
	

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

	

	<input type="button" onclick="history.back()" value="Cancel" style="margin-left:30px;" class="btn btn-info btn-sm"/>

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
  var action ="Create_Previous_transport_fees";
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
				window.location.href='dashboard.php?option=create_previous_transport_fees';
					// $('form')[0].reset();
					// document.getElementById("assign_driver").reset();
				},3000);
			}
		
			else if(result.type=="error"){
				toastr.error(result.msg); 
			}
			  $("input[type='submit']").val('Save');  
	      $("input[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>

