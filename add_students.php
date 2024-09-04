<?php
	error_reporting(1);
	
?>

<script type="text/javascript"
src="https://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.min.js"></script>      
<div class="card">

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Student Panel</a>
  <a class="breadcrumb-item" href="#">Student</a>
  <a class="breadcrumb-item" href="dashboard.php?option=view_students">View Students</a>
  <span class="breadcrumb-item active">Add Students</span>
</nav>
<!-- breadcrumb -->
<?php
if(isset($_REQUEST['ref_stu']) ){

	// if(getStudent_byAdmission_id($_REQUEST['ref_stu'])['name']=='4'){
		if(getStudent_byAdmission_id($_REQUEST['ref_stu'])['status']=='4'){
		
		echo "<script>alert('Already Admission Taken')</script>";
		echo "<script>window.location.href='dashboard.php?option=view_accept_admission';</script>";
		die;
	}else{
		$ssql= "SELECT * From admission where `status`='2' AND `admission_id`='".$_REQUEST['ref_stu']."'  ";
		$sql=mysqli_query($con,$ssql);
		$res=mysqli_fetch_array($sql);
		$admission_id=$res['admission_id'];
		$name=$res['name'];
		$fathername=$res['fathername'];
		$gender=$res['gender'];
		$dob=$res['dob'];
		$email=$res['email'];
		$phone=$res['phone'];
		$aadhar=$res['aadhar'];
		$qualification = $res['qualification'];
		$address = $res['address'];
		$city=$res['city'];
		$pincode=$res['pincode'];
		$state=$res['state'];
		$religion=$res['religion'];
		$grade=$res['grade'];
		$previous_school=$res['previous_school'];

	}



}else{
	$admission_id='';
    $name='';
    $fathername='';
    $gender='';
    $dob='';
    $email='';
    $phone='';
    $aadhar='';
    $qualification = '';
    $address ='';
    $city='';
    $pincode='';
    $state='';
    $religion='';
	$grade='';
	$previous_school='';
    
}	?>


<form action="" method="post" enctype="multipart/form-data" id="add_student_data">
	<div class="card-header">
	
		<strong>Add</strong> Student
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>
	</div>
	<!-- style="height:2000px;" -->
	<div class="card-body card-block">
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Student Name <span style="color:red;font-weight:bold;">*</span></label>
			<input type="text" name="stuname" class="form-control" placeholder="Enter Student Name" value="<?=$name?>" required>
			</div>
			</div>
			<input type="hidden" name="admission_id"value="<?=$admission_id?>" <?=isset($_REQUEST['ref_stu']) ? 'required' : ''; ?> >
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Registration Number <span style="color:red;font-weight:bold;">*</span></label>
			<input type="text" onchange="registration()" name="regisnumber" id="txt_uname" class="form-control" placeholder="Enter Registration Number" required autocomplete="off"><span id="res1" style="color:red;"></span>
			</div>
			</div>
			</div>
			
			<div class="row">			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Father's Name <span style="color:red;font-weight:bold;">*</span></label>
			<input type="text" name="stufname" class="form-control" placeholder="Enter Father's Name" value="<?=$fathername?>" required>
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Mother's Name <span style="color:red;font-weight:bold;">*</span></label>
			<input type="text" name="stumname" class="form-control" placeholder="Enter Mother's Name" required>
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class="form-control-label" style="margin-top:10px">Select Gender <span style="color:red;font-weight:bold;">*</span></label><br>
            <?php
               
            ?>

			<input type="radio" name="gender" 
            <?php if(strtoupper($gender)=='MALE'){
                   echo 'checked';  }?>
                    value="MALE" checked>&nbsp;MALE &nbsp;
			<input type="radio" name="gender"
            <?php if(strtoupper($gender)=='FEMALE'){
                   echo 'checked';  }?>
            value="FEMALE">&nbsp;FEMALE
			</div>
			</div>
						
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class="form-control-label" style="margin-top:10px">Select Date Of Birth <span style="color:red;font-weight:bold;">*</span></label><br>
			<input type="date" name="dob" class="form-control" value="<?=$dob?>" required>
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Admission Date <span style="color:red;font-weight:bold;">*</span></label>
			<input type="date" name="admissiondate" class="form-control" value="<?=date('Y-m-d')?>" required>
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class="form-control-label">Student Contact Number <span style="color:red;font-weight:bold;">*</span></label>
			<input type="number" id="stucontact" name="stucontact" class="form-control mobile" 
			placeholder="Enter Student Contact" value="<?=$phone?>" required><span class="mobile_error"></span>
			</div>
			</div>
			</div>
			
			<div class="row">			
			<div class="col-md-6">		
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Select Class <span style="color:red;font-weight:bold;">*</span></label>
			<select class="form-control" name="stuclass" id="class_id" onchange="subcat(this.value)" required>
					<option value="" selected disabled>---Select Class--</option>
					<?php
						$sql = "SELECT * FROM class";
						$resultset = mysqli_query($con, $sql);
						while( $rows = mysqli_fetch_array($resultset) ) {
						?>
                        <?php $selected=!empty($grade==$rows['class_id']) ? 'selected' : '' ?>
						<option <?=$selected?> value="<?php echo $rows['class_id']; ?>"><?php echo $rows['class_name']; ?>
						</option>
					<?php } ?>	
			</select>
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Select Section <span style="color:red;font-weight:bold;">*</span></label>
			<select class="form-control" name="stusection"  id="sub_cat" required>
					<option value="" selected disabled>---Select Section--</option>
			</select>
				<script>
					function subcat(str='')
					{
						if(str==''){
							// var str=$('class_id :selected').val();
							var e = document.getElementById("class_id");
							var value = e.value;
							var str = e.options[e.selectedIndex].value;
							// alert(str);
						}
						
					var xmlhttp= new XMLHttpRequest();	
					xmlhttp.open("get","view_ajax_section.php?sub_id="+str,true);
					xmlhttp.send();
					xmlhttp.onreadystatechange=function()
					{
					if(xmlhttp.status==200  && xmlhttp.readyState==4)
					{
					document.getElementById("sub_cat").innerHTML=xmlhttp.responseText;
					}
					} 
					}
					subcat(); //onload
				</script>
			</div>
			</div>
			</div>
				
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Parents Number <span style="color:red;font-weight:bold;">*</span></label>
			<input type="number" id="parentcontact" name="stuparentcontact" class="form-control mobile" placeholder="Enter Parent's Number" value="<?=$phone?>" required><span class="mobile_error"></span>
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Password <span style="color:red;font-weight:bold;">*</span></label>
			<input type="text" id="password" name="password" class="form-control" placeholder="Enter Password" value="<?=$phone?>"  required><span id="wm2"></span>
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Student Address <span style="color:red;font-weight:bold;">*</span></label>
			<textarea class="form-control" name="stuaddress" required> <?=$address?></textarea>
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label class="form-control-label">Present Address <span style="color:red;font-weight:bold;">*</span></label>
			<textarea class="form-control" name="present_address" required> <?=$address?></textarea>
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Admission Type<span style="color:red;font-weight:bold;">*</span></label>
			<select class="form-control" name="admtype" required>
			<?php
			$qadm = mysqli_query($con,"select * from admission_type");
			while($radm = mysqli_fetch_array($qadm))
			{
			?>	
			<option value="<?php echo $radm['adm_type_id'];?>" <?=($radm['adm_type_id'] == '2') ? 'selected' : '' ?>  ><?php echo $radm['adm_type_name'];?></option>
			<?php
			}
			?>
			</select>
			</div>
			</div>
												
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Message Type <span style="color:red;font-weight:bold;">*</span></label>
			<select class="form-control" name="msg_type" required>
			<?php
			$qmsg = mysqli_query($con,"select * from message_type");
			while($rmsg = mysqli_fetch_array($qmsg))
			{
			?>	
			<option value="<?php echo $rmsg['msg_type_id'];?>"><?php echo $rmsg['msg_name'];?></option>
			<?php
			}
			?>
			</select>
			</div>
			</div>
			</div>
				
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class="form-control-label">Session Year <span style="color:red;font-weight:bold;">*</span></label>
			<select class="form-control" name="academic_year" required>
					<option value="" selected disabled>--- Select Year ---</option>
					<!-- <option value="2022-23">2022–23</option> -->
					<?php
				$sesquery = mysqli_query($con,"select * from session");
				while($sesmsg = mysqli_fetch_assoc($sesquery)){

				?>	
				<option value="<?php echo $sesmsg['id'];?>" <?=($sesmsg['id']==$_SESSION['session']) ? 'selected' : '' ?>><?php echo $sesmsg['year'];?></option>
				<?php
				  }
			   ?>
			</select>
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label class="form-control-label">Nationality <span style="color:red;font-weight:bold;">*</span></label>
			<select class="form-control" name="nationality">
			<option selected value="Indian">Indian</option>
			<option value="Others">Others</option>
			</select>
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Admin RTE</label>
			<select class="form-control" name="rte">
				<option selected value="No">No</option>
				<option value="Yes">Yes</option>
			</select>
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Religion</label>
			<select class="form-control" name="religion">
			<?php
			$qrl = mysqli_query($con,"select * from religion");
			while($rrl = mysqli_fetch_array($qrl))
			{
			?>	
			<option selected  value="<?php echo $rrl['religion_id'];?>"  <?=(strtoupper($rrl['religion_name'])==strtoupper($religion)) ? 'selected' : '' ?>><?php echo $rrl['religion_name'];?></option>
			<?php
			}
			?>
			</select>
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Caste</label>
			<input type="text"  name="caste" class="form-control" placeholder="Enter Caste">
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Social Category</label>
			<select class="form-control" name="category">
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
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Blood Group</label>
			<input type="text" name="bldgrp" class="form-control" placeholder="Enter Blood Group">
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Mother Tongue</label>
			<input type="text" name="lang" class="form-control" placeholder="Enter Your Mother Tongue">
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Aadhar No </label>
			<input type="number" id="aadhar" name="aadhar" class="form-control aadhar" value="<?=$aadhar?>" placeholder="Enter Aadhar Number"><span class="aadhar_error"></span>
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Student Image</label>
			<input type="file" name="file1" class="form-control">
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Place of Birth</label>
			<input type="text" name="birth_place" class="form-control" placeholder="Enter Your Birth Place">
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email"  class=" form-control-label">Village/Town/Taluk/District</label>
			<input type="text" name="village"  class="form-control" placeholder="Enter Village/ Town/ Taluk/ District">
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Father's Qualification</label>
			<input type="text" name="fqualification" class="form-control" placeholder="Enter Father Qualification">
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Mother's Qualification</label>
			<input type="text" name="mqualification" class="form-control" placeholder="Enter Mother Qualification">
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Father's Occupation</label>
			<input type="text" name="foccupation" class="form-control" placeholder="Enter Father Occupation">
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Mother's Occupation</label>
			<input type="text" name="moccupation" class="form-control" placeholder="Enter Mother Occupation">
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Father's Annual Income</label>
			<input type="number" name="fannual_income" class="form-control" placeholder="Enter Father Annual Income in Numbers">
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">No of Dependents</label>
			<input type="number" name="dependent" class="form-control" placeholder="Enter No of Dependents">
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Guardians Name & Address</label>
			<input type="text" name="guardians" class="form-control" placeholder="Enter No of Dependents">
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Sub Caste</label>
			<input type="text" name="subcaste" class="form-control" placeholder="Enter Subcaste">
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Any Other Language Spoken</label>
			<input type="text" name="other_language" class="form-control" placeholder="Other Language Spoken">
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Previous School</label>
			<input type="text" name="previous_school" class="form-control" value="<?=$previous_school?>" placeholder="Enter Previous School Name">
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Father's Aadhar Card</label>
			<input type="number" id="f_aadhar" name="f_aadhar" class="form-control aadhar" placeholder="Enter Father Aadhar Card"><span class="aadhar_error"></span>
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Mother's Aadhar Card</label>
			<input type="number" id="m_aadhar" name="m_aadhar" class="form-control aadhar" placeholder="Enter Mother Aadhar Card"><span class="aadhar_error"></span>
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Student Bank A/c No.</label>
			<input type="number" name="bank_acc" class="form-control" placeholder="Enter Student Bank A/c No.">
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">IFSC Code</label>
			<input type="text" name="ifsc" class="form-control" placeholder="Enter IFSC Code">
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Branch</label>
			<input type="text" name="branch" class="form-control" placeholder="Enter Branch">
			</div>
			</div>
			
			<div class="col-md-6">	
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Bus Facility <span style="color:red;font-weight:bold;">*</span></label>
			<select class="form-control" name="bus_facility" required>
				<option value="No">No</option>
				<option value="Yes">Yes</option>
			</select>
			</div>
			</div>
			</div>
			
			
	</div>
	
	<div class="card-footer">
		<button type="submit" name="add_student" id="add_stu" class="btn btn-primary btn-sm" style="background-image: linear-gradient(-90deg, #cc9216, #9c6c05);border:2px solid #f0f3f5;padding:10px;">
			<i class="fa fa-plus"></i> Add Student
		</button>
		
	</div>
	</form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = $("#add_stu").attr("name");
  // var action=$.trim($('button').prop("name");
	// var action=$('button').attr("name");
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("#add_stu").text("Sending, please wait...");  
	//$("#add_stu").attr("disabled", true);

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
				// setInterval(function(){ 
				// window.location.href='dashboard.php?option=add_students';
				// },3000);
			<?php	if(isset($_REQUEST['ref_stu'])){ ?>
					setInterval(function(){ 
				window.location.href='dashboard.php?option=view_accept_admission';
				},3000);
			<?php }else{ ?>	
				setTimeout(function(){ 
						$('#add_student_data')[0].reset();
						$("#add_stu").text("Add Student");  
						$("#add_stu").attr("disabled", false);
					},3000);	
			<?php } ?>		

			}
			else if(result.type=="ADD_FEE"){
				toastr.error(result.message); 
				$("#add_stu").text("Add Student");  
	      $("#add_stu").attr("disabled", false);

			}else if(result.type=="MAX_STU"){
				toastr.error(result.message); 
				$("#add_stu").text("Add Student");  
	      $("#add_stu").attr("disabled", false);

			}else if(result.type=="ERROR"){
				toastr.error(result.message); 
				$("#add_stu").text("Add Student");  
	      $("#add_stu").attr("disabled", false);

			}else if(result.type=="ALREADY"){
				toastr.error(result.message);
				$("#add_stu").text("Add Student");  
	      $("#add_stu").attr("disabled", false);
	      

			}


			// body...
		}
	})
});

});

</script>

	