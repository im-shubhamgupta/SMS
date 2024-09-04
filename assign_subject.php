<?php

//error_reporting(1);

extract($_REQUEST);



// if(isset($assign))

// {

	

// 	$qsub = mysqli_query($con,"select * from subject where subject_id='$subject'");

// 	$rsub = mysqli_fetch_array($qsub);

// 	$subname = $rsub['subject_name'];

	

// 	$qcls = mysqli_query($con,"select * from class where class_id='$class'");

// 	$rcls = mysqli_fetch_array($qcls);

// 	$clsname = $rcls['class_name'];

	

// 	$qsec = mysqli_query($con,"select * from section where section_id='$section'");

// 	$rsec = mysqli_fetch_array($qsec);

// 	$secname = $rsec['section_name'];	



// 	$q1 = mysqli_query($con,"select * from assign_subject where class_id='$class' && section_id='$section' && subject_id='$subject'");

// 	$row = mysqli_num_rows($q1);

// 	if($row)

// 	{

// 		echo "<script>alert('The Subject ".$subname." for Class ".$clsname.", Section ".$secname." is already Assigned')</script>";

		

// 	}

// 	else

// 	{

// 		$que=mysqli_query($con,"insert into assign_subject (st_id,class_id,section_id,subject_id) 

// 		values ('$faculty','$class','$section','$subject')");

	

// 		 echo "<script>alert('Subject Assigned')</script>";

// 		 echo "<script>window.location='dashboard.php?option=assign_subject'</script>";

// 	}

// }

		

?>	

	



<div id="right-panel" class="right-panel">



<nav class="breadcrumb" style="width:1000px;">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Subject Assignment</a>  

  <span class="breadcrumb-item active">Assign Subject</span>

</nav>



<form method="post" enctype="multipart/form-data">

  

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Faculty Name :</div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:170px;" class="form-control" name="faculty" id="faculty" 

		autofocus required>

		<option value="" selected="selected" disabled >Select Faculty</option>

		<?php

		$squ = "select * from staff where status='1'";

		$rsqu = mysqli_query($con, $squ);

		while( $resst = mysqli_fetch_array($rsqu) ) {

		?>

		<option value="<?php echo $resst['st_id']; ?>"><?php echo $resst['staff_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

		

		<script>

		function search_assign_staff(str)

		{

			$.ajax({

				url:'get_ajax_assign_staff.php?stid='+str,

				type:'get',

				success:function(data) {

					if(!data=='')	

					{

					alert('Already Assigned Subject to '+data);

					$('#faculty').prop('selectedIndex',0);

					}

				}

				

			});

		}

		</script>

		

		<div class="col-md-2" style="font-size:16px;margin-left:80px;">Class :</div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:170px;margin-left:-70px;" name="class" class="form-control" onchange="search_sec(this.value); search_subject(this.value);"  autofocus required>

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

		document.getElementById("search_sect").innerHTML=xmlhttp.responseText;

		}

		} 

		}

		</script>

		

		

		<script>

		function search_subject(str)

		{

		var xmlhttp= new XMLHttpRequest();	

		xmlhttp.open("get","search_ajax_assign_subject.php?cls_id="+str,true);

		xmlhttp.send();

		xmlhttp.onreadystatechange=function()

		{

		if(xmlhttp.status==200  && xmlhttp.readyState==4)

		{

		document.getElementById("search_subj").innerHTML=xmlhttp.responseText;

		}

		} 

		}

		</script>

			

	</div>

	

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Section :</div>

		<div class="col-md-2">

		<select style="width:170px;" class="form-control" name="section" id="search_sect" required>

		<option value="" selected disabled>Select Section</option>

		</select>

		</div>

		

		<div class="col-md-2" style="font-size:16px;margin-left:80px;">Subject :</div>

		<div class="col-md-2">

		<select style="width:170px;margin-left:-70px;" name="subject" class="form-control" id="search_subj" autofocus required>

		<option value="" selected="selected" disabled>Select Subject</option>

		</select>

		</div>

	</div>

	

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<input type="submit" name="assign" value="Assign" style="margin-left:350px;width:100px" class="btn btn-primary btn-sm">

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
	// console.log(this);
	// alert(12);
  var action ="AssignSubject";
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
				window.location.href='dashboard.php?option=assign_subject';
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