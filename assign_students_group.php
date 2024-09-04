<?php

include('connection.php');

// extract($_REQUEST);






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

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Custom Group</a>

  <span class="breadcrumb-item active">Assign Students to Group</span>

</nav>

<form method="post" enctype="multipart/form-data"> 



<!---- Important Information ---->

	<div class="row" style="margin-top:50px;margin-left:20px;">

	<div class="col-md-2">Select Group : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:170px;margin-left:-30px;" name="group" id="group" class="form-control" required>

	<option value="" selected="selected" disabled>Select Group</option>

	<?php

	$qgrp = mysqli_query($con,"select * from custome_group");

	while( $rgrp = mysqli_fetch_array($qgrp) ) {

	?>

	<option value="<?php echo $rgrp['group_id']; ?>"><?php echo $rgrp['group_name']; ?>

	</option>

	<?php } ?>							

	</select>

	</div>

	</div>

	

	<div class="row" style="margin-top:50px;margin-left:20px;">

	<div class="col-md-2">Class : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:170px;margin-left:-30px;" name="classid" id="class" class="form-control" 

	onchange="showstu(this.value);search_sec(this.value)" required>

	<option value="" selected="selected" disabled>Select Class</option>

	<?php

	$scls = "select * from class";

	$rcls = mysqli_query($con, $scls);

	while( $rescls = mysqli_fetch_array($rcls) ) {

	?>

	<option value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

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

document.getElementById("section").innerHTML=xmlhttp.responseText;

}

} 

}

</script>



	<div class="col-md-2" style="margin-left:50px;">Section : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:170px;margin-left:-30px;" name="section" id="section" class="form-control" 

	onchange="showstu(this.value)" required>

	<option value="" selected="selected" disabled>Select Section</option>							

	</select>

	</div>

	</div>

	

<script>

function showstu(str)

{

var xmlhttp= new XMLHttpRequest();	

xmlhttp.open("get","search_ajax_impinfo_students.php?sec_id="+str,true);

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

	<div class="col-md-4" style="margin-left:20px;">Student List </div>

	<div class="col-md-1"></div>

	<div class="col-md-4" style="font-size:16px;margin-left:160px;">Selected Students </div>

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

<i class="fa fa-plus"></i> Save</button>

		

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

<?php include('datatable_links.php')?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "assign_students_group";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/CommunicationControllers.php",
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
				window.location.href='dashboard.php?option=view_group_students';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('button[type="submit"]').html('<i class="fa fa-plus"></i> Save');  
	      $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>



