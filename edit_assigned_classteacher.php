<?php

//error_reporting(1);

extract($_REQUEST);

$id = $_REQUEST['id'];



$q1 = mysqli_query($con,"select * from assign_clsteacher where assign_clst_id='$id'");

$r1 = mysqli_fetch_array($q1);

$clsid = $r1['class_id'];

$secid = $r1['section_id'];

$stid = $r1['st_id'];





// if(isset($update))

// {

// 	$qcls = mysqli_query($con,"select * from class where class_id='$class'");

// 	$rcls = mysqli_fetch_array($qcls);

// 	$clsname = $rcls['class_name'];

	

// 	$qsec = mysqli_query($con,"select * from section where section_id='$section'");

// 	$rsec = mysqli_fetch_array($qsec);

// 	$secname = $rsec['section_name'];



// 	$qst = mysqli_query($con,"select * from staff where st_id='$faculty'");

// 	$rst = mysqli_fetch_array($qst);

// 	$staffname = $rst['staff_name'];

	

// 	$q2 = mysqli_query($con,"select * from assign_clsteacher where class_id='$class' && 

// 	section_id='$section'");

// 	if(mysqli_num_rows($q2))

// 	{

// 		echo "<script>alert('Already Assigned Class Teacher to ".$clsname."')</script>";

		

// 	}

// 	else

// 	{

// 	$que="update assign_clsteacher set class_id='$class', section_id='$section',

// 	st_id='$faculty' where assign_clst_id='$id'";

	

// 	if(mysqli_query($con,$que))

// 	{

// 		$action = "Class Teacher ".$staffname. " assigned to ".$clsname." ".$secname; 

// 		$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

// 		machine_name,browser,date) 

// 		values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

// 	}

	

// 	echo "<script>alert('Class Teacher Updated')</script>";	 

		 

// 	echo "<script>window.location='dashboard.php?option=view_assign_classteacher'</script>";

// 	}

// }

		

?>	

	



<div id="right-panel" class="right-panel">

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





</style>



<nav class="breadcrumb" style="width:1000px;">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Management</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_assign_classteacher">View Assign Class Teacher</a>

  <span class="breadcrumb-item active"> Edit Assign Class Teacher</span>

</nav>



<form method="post" enctype="multipart/form-data">

  

	<div class="row" style="margin-top:50px;margin-left:20px;">

		

		<div class="col-md-2">Class :</div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:170px;margin-left:-100px;" name="class" id="class" class="form-control" onchange="search_sec(this.value);"  autofocus required>

		<option value="" selected="selected" disabled>Select Class</option>

		<?php

		$scls = mysqli_query($con,"select * from class");

		while( $rcls = mysqli_fetch_array($scls) ) {

		?>

		<option <?php if($clsid==$rcls['class_id']){echo "selected";}?> value="<?php echo $rcls['class_id']; ?>"><?php echo $rcls['class_name']; ?>

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

		document.getElementById("search_sect").innerHTML=xmlhttp.responseText;

		}

		} 

		}

		</script>

								

		<div class="col-md-2" style="margin-left:-40px;">Section :</div>

		<div class="col-md-2" style="margin-left:-80px;margin-top:-8px;">

		<select style="width:170px;" class="form-control" name="section" id="search_sect" onchange="search_assign_class_teacher(this.value);" required>

		<option value="" selected disabled>Select Section</option>

		<?php

		$qsec = mysqli_query($con,"select * from section where class_id='$clsid'");

		while($rsec = mysqli_fetch_array($qsec) ) {

		?>

		<option <?php if($secid==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name']; ?>

		</option>

		<?php } ?>

		</select>

		</div>		

		

		<div class="col-md-2" style="margin-left:60px;">Faculty Name :</div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-40px;">

		<select style="width:170px;" class="form-control" name="faculty" id="faculty" 

		onchange="search_assign_classteacher(this.value);" autofocus required>

		<option value="" selected="selected" disabled >Select Faculty</option>

		<?php

		$sst = mysqli_query($con,"select * from staff where status='1'");

		while($rst = mysqli_fetch_array($sst))

		{

		?>

		<option <?php if($stid==$rst['st_id']){echo "selected";}?> value="<?php echo $rst['st_id']; ?>"><?php echo $rst['staff_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

		

		<script>

		function search_assign_class_teacher(str)

		{

			var clsid = $("#class").val();

			$.ajax({

				url:'get_ajax_assign_classteacher.php?sec_id='+str+'&classid='+clsid,

				type:'get',

				success:function(data) {

					if(!data=='')	

					{

					// alert('Already Assigned Class Teacher to class '+data);

					// $('#search_sect').prop('selectedIndex',0);

					}

				}

				

			});

		}

		</script>

			

	</div>

		
	<input type="hidden" name="id" value="<?=$_GET['id']?>">
	<div class="row" style="margin-top:50px;margin-left:20px;">

		<input type="submit" name="update" value="Update" style="margin-left:400px;">

	</div>

	

<br><br><br>

</form>





</div><!-- /#right-panel -->

 <?php// include('bootstrap_datatable_javascript_library.php'); ?>
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

  var action ="Update_classTeacher";
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
			console.log(responce);
			if(result.type=="success"){
				// alert('success');
				toastr.success(result.msg); 
				setInterval(function(){ 
				window.location.href='dashboard.php?option=view_assign_classteacher';
				},3000);
			}
		
			else if(result.type=="error"){
				toastr.error(result.msg); 
			

			}
			  $("input[type='submit']").val("Update");  
	      $("input[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>
