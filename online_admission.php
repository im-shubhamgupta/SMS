<?php 

include("connection.php");

// extract($_REQUEST);

	

// if(isset($save))

// {

// 	$que = mysqli_query($con,"select * from admission order by admission_id desc limit 1");

// 	$row = mysqli_num_rows($que);

// 	if($row)

// 	{

// 		$res = mysqli_fetch_array($que);

// 		$refno = $res['reference_no'];

// 		//$nrefno = preg_split('#(?=\d)(?<=[a-z])#i', "$refno");

// 		$nerefno = $nrefno[1];

		

// 		$nerefno++;

// 		$newrefno = "ref".$nerefno;

		

// 	}

// 	else

// 	{

// 		$newrefno = "ref"."1";

// 	}	

		

// 	$q1 = mysqli_query($con,"insert into admission (reference_no,name,fathername,gender,dob,age,email,phone,aadhar,qualification,grade,

// 	address,city,state,pincode,religion,caste,category,previous_school,previous_grade,previous_result,previous_percentage,

// 	apply_date) 

// 	values ('$newrefno','$name','$fathername','$gender','$dob','$age','$email','$phone','$aadhar','$qualification','$grade','$address',

// 	'$city','$state','$pincode','$religion','$caste','$category','$previous_school','$previous_grade','$previous_result',

// 	'$previous_percentage',now())");	

		

		

// 	// $q1 = mysqli_query($con,"insert into admission (reference_no,name,fathername,gender,dob,age,email,phone,aadhar,qualification,grade,

// 	// address,city,state,pincode,religion,caste,category,previous_school,previous_grade,previous_result,previous_percentage,

// 	// apply_date) 

// 	// values ('$newrefno','$name','$fathername','$gender','$dob','$age','$email','$phone','$aadhar','$qualification','$grade','$address',

// 	// '$city','$state','$pincode','$religion','$caste','$category','$previous_school','$previous_grade','$previous_result',

// 	// '$previous_percentage',now())");

//   if($q1){

// 			$sset=mysqli_query($con,"select * from setting");

// 			$rsset=mysqli_fetch_array($sset);

// 			$sclname=$rsset['company_name'];

// 			$q1 = mysqli_query($con,"select * from class where class_id='$grade'");

// 			$r1 = mysqli_fetch_array($q1);

// 			$clsname = $r1['class_name'];

// 			$msg = "Dear ".$name.",%0aThanks for showing interest for the Admission of ".$clsname.", Please find the reference number "

// 					.$refno.", Once we short listed, we will call for Admission.%0aRegards,%0a".$sclname;

// 			$messagetype="online_addmission";

// 			sendwhatsappMessage($phone, $msg, $messagetype);
			
// 			sendtextMessage($phone, $msg, $messagetype);

// 		echo "<script>alert('Online Admission Request Sucessfully')</script>";
// 	}
		

// }

?>



<style type="text/css">

</style>

<!-- ========== MAIN ========== -->
<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Addmission Panel</a>

  <span class="breadcrumb-item active">Online Addmission</span>

</nav>

<!-- breadcrumb -->

<main id="content" role="main">

  <!-- Hero Section -->

  <div class="gradient-half-primary-v1">

    <div class="container text-center space-top-4 space-top-md-4 space-top-lg-3 space-bottom-1">

      <!-- Title -->

      <div class="w-md-80 w-lg-50 mx-auto mb-5">

        <h1 class="h1 text-black">

          <span class="font-weight-semi-bold"><u>Online Admission Form</u></span>

        </h1>

      </div>

      <!-- End Title -->

    </div>

  </div>

  <!-- End Hero Section -->



  <!-- About section starts -->

  <div class="gradient-half-primary-v3">

    <div class="container space-2 space-md-2">

      

    <form method="post">

		<div class="row">

			<div class="form-group col-md-2">

			  <label class="form-control-label">Name </label>

			</div>

			<div class="form-group col-md-4">

			  <input type="text" name="name" class="form-control" placeholder="Full Name" autofocus required/>

			</div>



			<div class="form-group col-md-2">

			  <label>Father Name </label>

			</div>

			<div class="form-group col-md-4">

			  <input type="text" name="fathername" class="form-control" placeholder="Father's Name" autofocus required/>

			</div>

		</div>

		<br/>

		

		<div class="row">

			<div class="form-group col-md-2">

			  <label class="form-control-label">Gender </label>

			</div>

			<div class="form-group col-md-4">

			  <select name="gender" class="form-control" autofocus required>

			  <option value="" selected disabled>Select Gender</option>

			  <option value="Male">Male</option>

			  <option value="Female">Female</option>

			  </select>

			</div>

			

			<div class="form-group col-md-2">

			  <label class="form-control-label">Date of Birth </label>

			</div>

			<div class="form-group col-md-4">

			  <input type="date" name="dob" class="form-control" placeholder="Date of Birth" autofocus required/>

			</div>

		</div>

		<br/>



		<div class="row">

			<div class="form-group col-md-2">

			  <label class="form-control-label">Age</label>

			</div>

			<div class="form-group col-md-4">

			  <input type="number" name="age" class="form-control" placeholder="Age" autofocus required/>

			</div>

			

			<div class="form-group col-md-2">

			  <label class="form-control-label">Email</label>

			</div>

			<div class="form-group col-md-4">

			  <input type="email" name="email" class="form-control" placeholder="Email Id" autofocus required/>

			</div> 

		</div>

		<br/> 

		

		<div class="row">

			<div class="form-group col-md-2">

			  <label class="form-control-label">Contact</label>

			</div>

			<div class="form-group col-md-4">

			  <input type="number" name="phone" class="form-control" placeholder="Contact No." autofocus required/>

			</div>

			

			<div class="form-group col-md-2">

			  <label class="form-control-label">Aadhar No.</label>

			</div>

			<div class="form-group col-md-4">

			  <input type="number" name="aadhar" class="form-control" placeholder="Aadhar Card Number" autofocus required/>

			</div>

		</div>

		<br/> 

		

		<div class="row">

			<div class="form-group col-md-2">

			  <label class="form-control-label">Qualification</label>

			</div>

			<div class="form-group col-md-4">

				<select class="form-control" name="qualification" autofocus required>

				<option value="" selected disabled>Select</option>

				<?php

					$sql = "SELECT * FROM class";

					$resultset = mysqli_query($con, $sql);

					while( $rows = mysqli_fetch_array($resultset) ) {

					?>

					<option value="<?php echo $rows['class_id']; ?>"><?php echo $rows['class_name']; ?>

					</option>

				<?php } ?>	

				</select>

			</div>

			

			<div class="form-group col-md-2">

			  <label class="form-control-label">Admission for Grade</label>

			</div>

			<div class="form-group col-md-4">

			 <select class="form-control" name="grade" required>

				<option value="" selected disabled>Select</option>

				<?php

					$sql = "SELECT * FROM class";

					$resultset = mysqli_query($con, $sql);

					while( $rows = mysqli_fetch_array($resultset) ) {

					?>

					<option value="<?php echo $rows['class_id']; ?>"><?php echo $rows['class_name']; ?>

					</option>

				<?php } ?>	

				</select>

			</div>

		</div>

		

		<div class="row">

			<div class="form-group col-md-2">

			  <label class="form-control-label">Address</label>

			</div>

			<div class="form-group col-md-10">

			  <input type="text" name="address" class="form-control" placeholder="Address" autofocus required/>

			</div>

		</div>

		<br/>

		

		<div class="row">

			<div class="form-group col-md-2">

			  <label class="form-control-label">City</label>

			</div>

			<div class="form-group col-md-4">

			  <input type="text" name="city" class="form-control" placeholder="City" autofocus required/>

			</div>

			

			<div class="form-group col-md-2">

			  <label class="form-control-label">State</label>

			</div>

			<div class="form-group col-md-4">

			  <input type="text" name="state" class="form-control" placeholder="State" autofocus required/>

			</div>

		</div>

		<br/>

		

		<div class="row">

			<div class="form-group col-md-2">

			  <label class="form-control-label">Pincode</label>

			</div>

			<div class="form-group col-md-4">

			  <input type="number" name="pincode" class="form-control" placeholder="Pincode" autofocus required/>

			</div>

			

			<div class="form-group col-md-2">

			  <label class="form-control-label">Religion</label>

			</div>

			<div class="form-group col-md-4">

			 <select class="form-control" name="religion" autofocus required>

				<?php

				$qrl = mysqli_query($con,"select * from religion");

				while($rrl = mysqli_fetch_array($qrl))

				{

				?>	

				<option value="<?php echo $rrl['religion_id'];?>"><?php echo $rrl['religion_name'];?></option>

				<?php

				}

				?>

			 </select>

			</div>

		</div>

		<br/>

		

		<div class="row">

			<div class="form-group col-md-2">

			  <label class="form-control-label">Caste</label>

			</div>

			<div class="form-group col-md-4">

			  <input type="text" name="caste" class="form-control" placeholder="Caste" autofocus required/>

			</div>

			

			<div class="form-group col-md-2">

			  <label class="form-control-label">Social Category</label>

			</div>

			<div class="form-group col-md-4">

			  <select class="form-control" name="category" autofocus required>

				<?php

				$qsc = mysqli_query($con,"select * from social_category");

				while($rsc = mysqli_fetch_array($qsc))

				{

				?>	

				<option value="<?php echo $rsc['soc_cat_id'];?>"><?php echo $rsc['soc_cat_name'];?></option>

				<?php

				}

				?>

				</select>

			</div>

		</div>

		<br/>	



		<div class="row">

			<div class="form-group col-md-3">

			  <label class="form-control-label">Previous School Studied</label>

			</div>

			<div class="form-group col-md-9">

			  <input type="text" name="previous_school" class="form-control" placeholder="Previous School Studied" autofocus required/>

			</div>

		</div>

		<br/>

		

		<div class="row">

			<div class="form-group col-md-2">

			  <label class="form-control-label">Previous Grade</label>

			</div>

			<div class="form-group col-md-4">

			  <select class="form-control" name="previous_grade" autofocus required>

				<option value="" selected disabled>Select Previous Grade</option>

				<?php

				$qrl = mysqli_query($con,"select * from grade");

				while($rrl = mysqli_fetch_array($qrl))

				{

				?>	

				<option value="<?php echo $rrl['grade_id'];?>"><?php echo $rrl['grade_name'];?></option>

				<?php

				}

				?>

			  </select>

			</div>

			

			<div class="form-group col-md-2">

			  <label class="form-control-label">Result of Previous Grade</label>

			</div>

			<div class="form-group col-md-4">

			  <select name="previous_result" class="form-control" autofocus required>

			  <option value="" selected disabled>Result of Previous Grade</option>

			  <option value="Pass">Pass</option>

			  <option value="Fail">Fail</option>

			  </select>

			</div>

		</div>

		

		<div class="row">

			<div class="form-group col-md-2">

			  <label class="form-control-label">Percentage of Previous Grade</label>

			</div>

			<div class="form-group col-md-4">

			  <input type="number" name="previous_percentage" class="form-control" placeholder="Percentage of Previous Grade" autofocus required/>

			</div>

		</div>



      <div class="row" style="margin-bottom:20px">

        <input type="submit" name="online_addmission" id="online_add" class="btn btn-primary btn-sm col-2" style="margin:auto;">

      </div>

    </form>

    </div>

  </div>

  <!-- About section ends -->

</main>

  <!-- ========== END MAIN ========== -->


<!-- 	//Send sms to sender and reciever

		// $set=mysqli_query($con,"select * from sms_setting");

		// $rset=mysqli_fetch_array($set);

		// $senderid=$rset['sender_id'];

		// $apiurl=$rset['api_url'];

		// $apikey=$rset['api_key'];

		

		// $senderId = "$senderid";

		// $route = 4;

		// $campaign = "OTP";

		// $sms = array(

		// 	'message' => "$msg",

		// 	'to' => array($phone)

		// );

		// //Prepare you post parameters

		// $postData = array(

		// 	'sender' => $senderId,

		// 	'campaign' => $campaign,

		// 	'route' => $route,

		// 	'sms' => array($sms)

		// );

		// $postDataJson = json_encode($postData);



		// $url="$apiurl";



		// $curl = curl_init();

		// curl_setopt_array($curl, array(

		// 	CURLOPT_URL => "$url",

		// 	CURLOPT_RETURNTRANSFER => true,

		// 	CURLOPT_CUSTOMREQUEST => "POST",

		// 	CURLOPT_POSTFIELDS => $postDataJson,

		// 	CURLOPT_HTTPHEADER => array(

		// 		"authkey:"."$apikey",

		// 		"content-type: application/json"

		// 	),

		// ));

		// $response = curl_exec($curl);

		// $err = curl_error($curl);

		// curl_close($curl);
 -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  // var action = $("#online_add").attr("name");
  var action = $("input[name='online_addmission']").attr("name");

	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[name='online_addmission']").val("Sending, please wait...");  
	$("input[name='online_addmission']").attr("disabled", true);

	// alert(name);

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
				window.location.href='dashboard.php?option=online_admission';
				},3000);
			}
			else if(result.type=="FAILED"){
				toastr.error(result.message); 
				$("#online_add").val("Submit");  
	      $("#online_add").attr("disabled", false);

			}
		}
	})
});
});
</script>