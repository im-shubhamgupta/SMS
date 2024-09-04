<?php

	error_reporting(1);

	// extract($_REQUEST);

	// if(isset($add_driver))

	// {			
	// 	date_default_timezone_set('Asia/Kolkata');
	// 	$create_date=date('Y-m-d H:i:s');
	//   $modify_date=$create_date;
	//   $session=$_SESSION['session'];


	// 	$name=ucwords($name);


	// 	$query=mysqli_query($con,"insert into driver (name,father_name,gender,mobile,alternate_no,address,city,designation,

	// 	experience,dlno,aadhar_no,previous_exp,description,status,date,modify_date,session) 

	// 	values ('$name','$fathername','$gender','$mobno','$altmobno','$address','$city','$designation','$experience','$dlno',

	// 	'$aadharno','$preexp','$description','0','$create_date','$modify_date','$session' ) ") ;
  // if($query){

  // 		$messagetype="Add_driver";
  // 		$sset=mysqli_query($con,"select * from setting");
	// 		$rsset=mysqli_fetch_array($sset);

	// 		$sclname=$rsset['company_name'];
	// 		$set=mysqli_query($con,"select * from sms_setting where sms_id=2 ");

	// 		$rset=mysqli_fetch_array($set);

	// 		$status=$rset['status'];
	// 			$msg="Dear ".$name.",%0aNow you are appoint as a  ".ucwords($designation)." in our school on the basis of your experience .%0aSo, Now you can join with us and do your job well.%0aRegards%0a".$sclname."  ";		
	// 			$nmsg="Dear ".$name.",<br>Now you are appoint as a  ".ucwords($designation)." in our school on the basis of your experience .<br>So, Now you can join with us and do your job well.<br>Regards<br>".$sclname."  ";		

	// 		if($status==1){
	// 						sendwhatsappMessage($mobno, $msg, $messagetype);

	// 		}else{
	// 					sendtextMessage($mobno, $nmsg, $messagetype);

	// 		}


  // 		$err="<span id='err_successful'>[ ".$name." ".$designation." Added Successfully ]</span>";

  // }else{
  // 		$err="<span id='err_successful' style='color:red;'>[ Something Wrong Please Try Again ]</span>";
  // }
			

	

	// }

?>



<link href="datejquery/jquery.datepicker2.css" rel="stylesheet">

<script type="text/javascript" src="https://pagead2.googlesyndication.com/pagead/show_ads.js"></script>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.min.js"></script>      

<style>
.col-md-6{
	padding:0 10px 0 10px;  /*if we take .row before form-group then its no need*/
}

</style>	


<div class="card">

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_driver">View Driver & Cleaner</a>

  <span class="breadcrumb-item active">Add Driver & Cleaner</span>

</nav>

<!-- breadcrumb -->



<form action="" method="post" enctype="multipart/form-data">

	<div class="card-header">

	

		<strong>Add</strong> Driver & Cleaner

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block" style="height:700px;">

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Name <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="name" pattern="[a-z A-Z]*" class="form-control" placeholder="Enter Name" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Father Name <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="fathername" pattern="[a-z A-Z]*" class="form-control" placeholder="Enter Father Name" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label" style="margin-top:10px">Select Gender <span style="color:red;font-weight:bold;">*</span></label><br>

			<input type="radio" name="gender" value="MALE" checked>&nbsp;MALE &nbsp;

			<input type="radio" name="gender" value="FEMALE">&nbsp;FEMALE

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Mobile Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" id="mobno" name="mobno" class="form-control" placeholder="Enter Mobile No" required>	

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Alternate Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" id="altmobno" name="altmobno" class="form-control" placeholder="Enter Alternate Mobile No" required>	

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Address <span style="color:red;font-weight:bold;">*</span></label>

			<textarea class="form-control" name="address" placeholder="Enter Address" required></textarea>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label">City <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="city" class="form-control" placeholder="Enter City" required>	

			</div>

			</div>

			

			

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Designation <span style="color:red;font-weight:bold;">*</span></label>

			<select class="form-control" name="designation" id="teachtype" onchange="designationtype(this.value)" required selected="selected">

				<option value="" selected="selected" disabled>Select</option>

				<option value="Driver">Driver</option>

				<option value="Cleaner">Cleaner</option>

				<option value="Others">Others</option>

			</select>

			</div>

			</div>

											

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Experience <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" name="experience" class="form-control" placeholder="Enter Experience" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">DL Number <span  id="dlstar" style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="dlno" id="dlno" class="form-control" placeholder="Enter DL Number" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Aadhar No <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" class="form-control" id="aadharno" name="aadharno" placeholder="Enter Aadhar No" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Previous Experience <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="preexp" class="form-control" placeholder="Enter Previous Experience" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">About Him/Her <span style="color:red;font-weight:bold;">*</span></label>

			<textarea class="form-control" name="description" placeholder="Enter Description" required></textarea>

			</div>

			</div>			

				

		

	</div>

	<div class="card-footer">

		<button type="submit" name="add_driver" id="add_driver" class="btn btn-primary btn-sm">

			<i class="fa fa-plus"></i> Add

		</button>

		

		<a href="dashboard.php?option=view_driver" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

		

	</div>

	</form>

</div>
<script>
	function designationtype(type){
		if(type=='Cleaner' || type=='Others' ){
			document.getElementById('dlno').required=false;
			document.getElementById('dlstar').style.display='none';
		}else{
			document.getElementById('dlno').required=true;
			document.getElementById('dlstar').style.display='';
		}
	

	}
	</script>





<script>

$("#mobno").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 10) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>



<script>

$("#altmobno").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 10) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>



<script>

$("#aadharno").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 12	) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>





<script>			

	function chkstafid() 													

	{

	var sid=$("#staffid").val();

	var dataString={'sid':sid};

				$.ajax({  

				 url:"view_ajax_staffid.php",  

				 method:"POST",  

			   data:dataString, 

				 success:function(data)

				 {  

					   $('#res1').html(data);

				 }  

			});

	}		

</script>	



<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>

<script src="datejquery/jquery.datepicker2.js"></script>

<script type="text/javascript">



  var _gaq = _gaq || [];

  _gaq.push(['_setAccount', 'UA-36251023-1']);

  _gaq.push(['_setDomainName', 'jqueryscript.net']);

  _gaq.push(['_trackPageview']);



  (function() {

    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

  })();



</script>

<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = $("#add_driver").attr("name");

	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("#add_driver").text("Sending, please wait...");  
	$("#add_driver").attr("disabled", true);
	$.ajax({
		url:"AjaxHandler.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			console.log(responce);
			if(result.type=="SUCCESS"){
				// alert('success');
				toastr.success(result.message); 
				setInterval(function(){ 
				window.location.href='dashboard.php?option=add_driver';
				},3000);
			}
			else if(result.type=="FAILED"){
				toastr.error(result.message); 
				$("#add_driver").text("Add ");  
	      $("#add_driver").attr("disabled", false);

			}
		}
	})
});

});

</script>