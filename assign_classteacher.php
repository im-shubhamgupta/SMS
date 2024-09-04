<?php

//error_reporting(1);

extract($_REQUEST);




		

?>	

	



<div id="right-panel" class="right-panel">



<nav class="breadcrumb" style="width:1000px;">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Management</a>

  <span class="breadcrumb-item active">Assign Class Teacher</span>

</nav>



<form method="post" enctype="multipart/form-data" id="assign_cls_tchr">

  

	<div class="row" style="margin-top:50px;margin-left:20px;">

		

		<div class="col-md-2">Class :</div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:170px;margin-left:-100px;" name="class" id="class" class="form-control" onchange="search_assign_class_teacher(this.value);search_sec(this.value);"  autofocus required>

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

								

		<div class="col-md-2" style="margin-left:-40px;">Section :</div>

		<div class="col-md-2" style="margin-left:-80px;margin-top:-8px;">

		<select style="width:170px;" class="form-control" name="section" id="search_sect" onchange="search_assign_class_teacher(this.value);" required>

		<option value="" selected disabled>Select Section</option>

		</select>

		</div>		

		

		<div class="col-md-2" style="margin-left:60px;">Faculty Name :</div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-40px;">

			<?php
				$tsq='';
			$squt = "select distinct(st_id) from assign_clsteacher where session='".$_SESSION['session']."'";
			$rsqut = mysqli_query($con, $squt);

			if(mysqli_num_rows($rsqut)>0){

			
				while( $resstt = mysqli_fetch_array($rsqut) ) {
					$not_show[]=$resstt['st_id'];
				}
				 $narr=implode(',',$not_show);
				if(!empty($narr)){
					$tsq= " and `st_id` NOT IN ($narr)";
				}else{
					$tsq='';
				}
		  }

			?>

		<select style="width:170px;" class="form-control" name="faculty" id="faculty" onchange="check_class_assign(this.value);" 

		 autofocus required>
<!-- onchange="search_assign_classteacher(this.value);" -->
		<option value="" selected="selected" disabled >Select Faculty</option>

		<?php


		$squ = "select * from staff where status='1' "; //$tsq

		$rsqu = mysqli_query($con, $squ);

		while( $resst = mysqli_fetch_array($rsqu) ) {

		?>

		<option value="<?php echo $resst['st_id']; ?>"><?php echo $resst['staff_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

		

		<script>

		function search_assign_class_teacher(str){

			var clsid = $("#class").val();

			$.ajax({

				url:'get_ajax_assign_classteacher.php?sec_id='+str+'&classid='+clsid,

				type:'get',

				success:function(data1) {
					var data=$.trim(data1);
					if(!data=='')	

					{
					alert('Already Assigned Class Teacher to class '+data+'');

					// $('#search_sect').prop('selectedIndex',0);
					}
				}
			});

		}

		</script>
		<script>

		function check_class_assign(str){
			$.ajax({

				url:'search_data.php?tchr_id='+str+'&check_class_teacher_assign=0',

				type:'get',

				success:function(res) {
					var data=$.trim(res);
					console.log(res);
					if(data=='1'){
					  alert("This Teacher is already assign to another Class");
					// $('#search_sect').prop('selectedIndex',0);
					}else{

					}
				}
			});

		}

		</script>

			

	</div>

		

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<input type="submit" name="assign" value="Assign" style="margin-left:400px;" class="btn btn-primary btn-sm col-2">

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

  var action ="Assign_classTeacher";
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
				// setInterval(function(){ 
				// window.location.href='dashboard.php?option=assign_classteacher&smid=19';
				// },3000);
				setTimeout(function(){ 
				// window.location.href='dashboard.php?option=assign_classteacher&smid=19';
					$('#assign_cls_tchr')[0].reset();
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
