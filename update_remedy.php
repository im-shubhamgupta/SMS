<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



$rid = $_REQUEST['id'];

$que = mysqli_query($con,"select * from remedy where remedy_id='$rid'");

$res = mysqli_fetch_array($que);

$clsid = $res['class_id'];

$q1 = mysqli_query($con,"select * from class where class_id='$clsid'");

$r1 = mysqli_fetch_array($q1);

$clsname = $r1['class_name'];

 

$secid = $res['section_id']; 

$q2 = mysqli_query($con,"select * from section where section_id='$secid'");

$r2 = mysqli_fetch_array($q2);

$secname = $r2['section_name'];



$stuid = $res['student_id']; 

$q3 = mysqli_query($con,"select * from students where student_id='$stuid'");

$r3 = mysqli_fetch_array($q3);

$stuname = $r3['student_name'];



$staff = $res['staff_id']; 

$proof=$res['observations_proof'];







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

.breadcrumb {

    display: -ms-flexbox;

    display: flex;

    -ms-flex-wrap: wrap;

    flex-wrap: wrap;

    padding: .75rem 1rem;

    margin-bottom: 1rem;

    list-style: none;

	margin-left:-18px;

	margin-top:-17px;

    background-color: #237791;

    border-radius: .25rem;

	font-size:19px;

}

.breadcrumb-item{

	color:#fff;

}

.breadcrumb-item .fa fa-home{

	color:#fff;

}

.breadcrumb-item.active {

    color: #eff7ff;

}

.breadcrumb-item+.breadcrumb-item::before {

    display: inline-block;

    padding-right: .5rem;

    color: #eff4f9;

    content: "/";

} 



input[type=checkbox] {

    zoom: 1.8;

	margin-top:5px;

}

</style>

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Remedies Management</a>

  <span class="breadcrumb-item active"> Update Remedy</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

		

		<div class="col-md-2">Remedy No : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">

		<input type="text" name="class" class="form-control" value="<?php echo $res['rid'];?>" style="width:120px;" readonly />

		</div>

		

		<div class="col-md-2">Class : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-90px;">

		<input type="text" name="class" class="form-control" value="<?php echo $clsname;?>" style="width:120px;" readonly />

		</div>

		

		<div class="col-md-2">Section : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-70px;">

		<input type="text" name="class" class="form-control" value="<?php echo $secname;?>" style="width:120px;" readonly />

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

	<input type="text" name="class" class="form-control" value="<?php echo $stuname;?>" style="width:170px;" readonly />

	</div>

	

	<div class="col-md-2" style="margin-left:59px;">Assigned to Staff : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:170px;" name="nstaffid" class="form-control" required autofocus>

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

	<textarea name="nobserve" class="form-control" style="width:545px;height:50px;" autofocus required>	<?php echo $res['observations'];?>

	</textarea>

	</div>

	</div>

	

	<div class="row py-3" style="margin-left:20px;margin-top:30px;">

	<div class="col-md-2">Observations Proofs : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="file" name="file" style="margin-top:5px;"/>

	</div>

	<div class="col-md-2" style="margin-top:-8px">

	<a href="gallery/remedy/<?php echo $proof;?>"><img src="gallery/remedy/<?php echo $proof;?>" 

	height="70px" width="70px" style="margin-left:100px;border:1px solid grey;"></a>

	</div>

	</div>

		

	<div class="row" style="margin-left:20px;margin-top:20px;">

	<div class="col-md-2" style="font-size:16px;">Remedies Taken : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="nremedy" class="form-control" style="width:545px;height:90px;" required autofocus>	<?php echo $res['remedies_taken'];?>

	</textarea>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-1">Duration: </div>

	<div class="col-md-1" style="margin-top:-8px;">

	<input type="number" name="nduration" class="form-control" style="width:70px;" 

	value="<?php echo $res['duration'];?>" required autofocus>

	</div>

	<div class="col-md-1">Days </div>

	

	<div class="col-md-2">Start Date : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="date" name="nstartdate" class="form-control" style="width:170px;margin-left:-70px;" 

	value="<?php echo $res['start_date'];?>" required autofocus>

	</div>

	

	<div class="col-md-2">End Date : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="date" name="nenddate" class="form-control" style="width:170px;margin-left:-70px;" 

	value="<?php echo $res['end_date'];?>" required autofocus>

	</div>

	</div>
	<input	type='hidden' name='id' value="<?=$_GET['id']?>" >
	

	<br/><br/>

	<div>

	<input type="submit" name="update" value="Update" style="margin-left:390px;" class="btn btn-primary btn-md"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-primary btn-md"/>

	</div>



</form>
<?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "update_remedy";
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
				window.location.href='dashboard.php?option=view_remedy';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$("input[type='submit']").val("Update");  
	$('input[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>

