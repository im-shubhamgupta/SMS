<?php

error_reporting(1);

include('connection.php');

// extract($_REQUEST);

$email=$_SESSION['user_logged_in'];

$user=$res['username'];
$que = mysqli_query($con,"select * from remedy order by rid desc limit 1");

$row = mysqli_num_rows($que);
if($row){
	$r2 = mysqli_fetch_array($que);

	$rid=explode('REM',$r2['rid']);
	$srid=$rid[1]+'1';
    $newrid='REM'.$srid;

}else{
	$newrid  = "REM1";

}




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

  <a class="breadcrumb-item" href="#"> Remedies Management</a>

  <span class="breadcrumb-item active"> Create Remedy</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

				

		<div class="col-md-2">Class : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:170px;" name="classid" id="classid" class="form-control" 

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

		

		<div class="col-md-2" style="margin-left:60px;">Section : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:0px;">

		<select style="width:170px;" name="sectionid" id="sectionid" onchange="searchstudent(this.value);" 

		class="form-control" required autofocus>

		<option value="" selected="selected" disabled>Select Section</option>							

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

	<div class="col-md-2">Student : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:170px;" name="student" id="student" class="form-control" required autofocus>

	<option value="" selected="selected" disabled>Select Student</option>							

	</select>

	</div>

	

	<div class="col-md-2" style="margin-left:59px;">Assigned to Staff : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:170px;" name="staffid" class="form-control" required autofocus>

	<option value="" selected="selected" disabled>Select Staff</option>

	<?php

	$qst = mysqli_query($con,"select * from staff");

	while( $rst = mysqli_fetch_array($qst) ) {

	?>

	<option <?php if($staff==$rst['st_id']){echo "selected";}?> value="<?php echo $rst['st_id']; ?>"><?php echo $rst['staff_name']; ?>

	</option>

	<?php } ?>							

	</select>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Observations : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="observe" class="form-control" style="width:545px;height:50px;" autofocus required></textarea>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Observations Proofs: </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="file" name="file" style="margin-top:5px;" accept="image/*" autofocus required />

	</div>

	</div>

		

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Remedies Taken : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="remedy" class="form-control" style="width:545px;height:90px;" required autofocus></textarea>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-1">Duration: </div>

	<div class="col-md-1" style="margin-top:-8px;">

	<input type="number" name="duration" class="form-control" style="width:70px;" required autofocus>

	</div>

	<div class="col-md-1">Days </div>

	

	<div class="col-md-2">Start Date : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="date" name="startdate" class="form-control" style="width:180px;margin-left:-70px;" required autofocus>

	</div>

	

	<div class="col-md-2">End Date : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="date" name="enddate" class="form-control" style="width:180px;margin-left:-70px;" required autofocus>
	<input type="hidden" name="newrid" value="<?=$newrid?>" required autofocus>

	</div>

	</div>

	

	<br/><br/>

	<div>

	<input type="submit" name="save" value="Save" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-info btn-sm"/>

	</div>
</form>
<?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "create_remedy";
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
				window.location.href='dashboard.php?option=create_remedy';
							// $('form')[0].reset(); 
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

