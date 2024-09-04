 <?php

//error_reporting(1);

extract($_REQUEST);

$id = $_REQUEST['id'];



$q1 = mysqli_query($con,"select * from assign_subject where assign_sub_id='$id'");

$r1 = mysqli_fetch_array($q1);



$staffid = $r1['st_id'];

$clsid = $r1['class_id'];

$secid = $r1['section_id'];

$subid = $r1['subject_id'];





// if(isset($update))

// {

// 	$que=mysqli_query($con,"update assign_subject set st_id='$faculty', class_id='$class', 

// 	section_id='$section', subject_id='$subject' where assign_sub_id='$id'");



// 	 echo "<script>window.location='dashboard.php?option=view_assign_subject'</script>";

// }

		

?>	

	



<div id="right-panel" class="right-panel">



<nav class="breadcrumb" style="width:1000px;">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Subject Assignment</a> 

  <span class="breadcrumb-item active">Edit Assign Subject</span>

</nav>



<form method="post" enctype="multipart/form-data">

  

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Faculty Name :</div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:170px;" class="form-control" name="faculty" id="faculty" 

		autofocus required>

		<option value="" selected="selected" disabled >Select Faculty</option>

		<?php

		$sst = mysqli_query($con,"select * from staff where status='1'");

		while($rst = mysqli_fetch_array($sst) ) {

		?>

		<option <?php if($staffid==$rst['st_id']){echo "selected";}?> value="<?php echo $rst['st_id']; ?>"><?php echo $rst['staff_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

		

		

		<div class="col-md-2" style="font-size:16px;margin-left:80px;">Class :</div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:170px;margin-left:-70px;" name="class" class="form-control" onchange="search_sec(this.value); search_subject(this.value);" autofocus required>

		<option value="" selected="selected" disabled>Select Class</option>

		<?php

		$scls = mysqli_query($con,"select * from class");

		while($rcls = mysqli_fetch_array($scls)){

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

		<?php

		$ssec = mysqli_query($con,"select * from section where class_id='$clsid'");

		while( $rsec = mysqli_fetch_array($ssec) ) {

		?>

		<option <?php if($secid==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>

		</option>

		<?php } ?>	

		</select>

		</div>

		

		<div class="col-md-2" style="font-size:16px;margin-left:80px;">Subject :</div>

		<div class="col-md-2">
			<input type="hidden" name="id" value="<?=$_GET['id']?>">

		<select style="width:170px;margin-left:-70px;" name="subject" class="form-control" id="search_subj"

		onchange="search_assign_staff(this.value);" autofocus required>

		<option value="" selected="selected" disabled>Select Subject</option>

		<?php

		$ssub = mysqli_query($con,"select * from subject where class_id='$clsid'");

		while($rsub = mysqli_fetch_array($ssub)){

		?>

		<option <?php if($subid==$rsub['subject_id']){echo "selected";}?> value="<?php echo $rsub['subject_id']; ?>"><?php echo $rsub['subject_name'];?>

		</option>

		<?php } ?>

		</select>

		</div>

		

		<script>

		function search_assign_staff(str)

		{

			$.ajax({

				url:'get_ajax_assign_staff.php?subid='+str,

				type:'get',

				success:function(data) {
					var res=JSON.parse($.trim(data));
							// alert(res);
					if(res=='1'){

					alert('This Subject Already Assigned');

					$('#search_subj').prop('selectedIndex',0);

					}

				}

				

			});

		}

		</script>

		

		

		

	</div>

	

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<button type="submit" name="update" style="margin-left:350px;" class="btn btn-secondary btn-sm">

		<i class='fa fa-edit'></i> Update </button>

		

		<a href="dashboard.php?option=view_assign_subject" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

	</div>

	

		

		

<br><br><br>

</form>





</div><!-- /#right-panel -->

 <?php //include('bootstrap_datatable_javascript_library.php'); ?>
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
  var action ="UpdateAssignSubject";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("Please wait...");  
	$("input[type='submit']").attr("disabled", true);

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
				window.location.href='dashboard.php?option=view_assign_subject';
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