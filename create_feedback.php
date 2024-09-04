<?php

error_reporting(1);

include('connection.php');

// extract($_REQUEST);
// if(!empty($staffid))

	// {

	// 	$staffid = $staffid;

	// }else{

	// 	$staffid = 0;

	// }



?>



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

  <a class="breadcrumb-item" href="#"> Feedback Management</a>

  <span class="breadcrumb-item active"> Create Feedback</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Submission Date : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="date" name="submissiondate" class="form-control" style="width:175px;" required autofocus>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">Class : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<select style="width:175px;" name="classid" id="classid" class="form-select" 

		onchange="searchstudent(this.value);search_sec(this.value);" required autofocus>

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



	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2">Section : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:175px;" name="sectionid" id="sectionid" onchange="searchstudent(this.value);" 

		class="form-select" required autofocus>

		<option value="" selected="selected" disabled>Select Section</option>							

		</select>

		</div>



		<div class="col-md-2" style="margin-left:80px;">Student : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<select style="width:175px;" name="student" id="student" class="form-select" required autofocus>

		<option value="" selected="selected" disabled>Select Student</option>							

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

	<div class="col-md-2">Request Type : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select class="form-select" name="requestid" style="width:175px;" autofocus required>

	<option value="" selected="selected" disabled>Select Request</option>

	<?php

	$ql=mysqli_query($con,"select * from request_type");

	while($rl=mysqli_fetch_array($ql))

	{

	?>

	<option value="<?php echo $rl['request_id'];?>"><?php echo $rl['request_name'];?>

	</option>

	<?php 

	}

	?>							

	</select>

	</div>



	<script>

	function raised()

	{

		var p = document.getElementById("raisedfor").value;

		if(p == "Teacher")

		{
			searchteacher_by_assignsubject();
			document.getElementById("demo").style="display:block";

			document.getElementById("staffid").required=true;

		}

		else

		{

			document.getElementById("demo").style="display:none";

			document.getElementById("staffid").required=false;

		}

	}

	</script>
	<script>
		function searchteacher_by_assignsubject(){
			var cls_id=document.getElementById("classid").value;
			var sec_id=document.getElementById("sectionid").value;

		var xmlhttp= new XMLHttpRequest();	

		xmlhttp.open("get","search_data.php?assign_subject_thr='1'&cls_id="+cls_id+"&sec_id="+sec_id,true);

		xmlhttp.send();

		xmlhttp.onreadystatechange=function(){

		if(xmlhttp.status==200  && xmlhttp.readyState==4)

		{

		document.getElementById("staffid").innerHTML=xmlhttp.responseText;

		}

		}

        }
	</script>

	

	

	<div class="col-md-2" style="margin-left:80px;">Raised For : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

	<select class="form-select" name="raisedfor" id="raisedfor" style="width:175px;" onchange="raised()" autofocus required>

	<option value="" selected="selected" disabled>Select</option>

	<option value="Teacher">Teacher</option>

	<option value="Management">Management</option>

	<option value="Principal">Principal</option>

	</select>

	</div>

	</div>

	

	<div class="row">

	<div class="col-md-12">

	<div class="row" style="display:none;" id="demo">

	<div class="col-md-2" style="margin-left:35px;margin-top:50px;">Teacher Name : </div>

	<div class="col-md-2" style="margin-left:-5px;margin-top:50px;">

	<select class="form-select" name="staffid" id="staffid" style="width:175px;">

	<option value="" selected="selected" disabled>Select Teacher</option>

	<!-- <?php
// and session='".$_SESSION['session']."'
	$qsub=mysqli_query($con,"select * from assign_subject where class_id='$classid' && section_id='$sectionid' ");

	while($rsub=mysqli_fetch_array($qsub))	{
		$stid = $rsub['st_id'];
		$qst = mysqli_query($con,"select * from staff where st_id='$stid'");

		$rst = mysqli_fetch_array($qst);
	?>
	<option value="<?php echo $rst['st_id'];?>"><?php echo $rst['staff_name'];?>
	</option>
	<?php 

	}

	?>-->	

	</select>

	</div>

	</div>

	</div>

	</div>

		

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Title : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="title" class="form-control" style="width:580px;height:50px;" required autofocus></textarea>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Description : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="description" class="form-control" style="width:580px;height:180px;" required autofocus></textarea>

	</div>

	</div>

	<br><br>

	

	<div>

	<input onclick="return confirm('Do you want to save.');" type="submit" name="save" value="Save" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-primary btn-sm"/>

	</div>



</form>
<?php include('datatable_links.php')?>
<script>

$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "create_feedback";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("please wait...");  
	$('input[type="submit"]').attr("disabled", true);

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
				window.location.href='dashboard.php?option=response_feedback';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('input[type="submit"]').val('Save');  
	      $('input[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>
