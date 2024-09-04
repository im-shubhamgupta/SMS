<?php

	error_reporting(1);

	include('connection.php');
	

	// extract($_REQUEST);

	$sid=$_REQUEST['usid'];

    $ssql= "SELECT `student_id`, `register_no`, `student_name`, `father_name`, `mother_name`,`student_contact`, `password`,`gender`, `dob`, `admission_date`, `sr`.`class_id` ,`sr`.`section_id`, `sr`.`roll_no`, `due`,  `parent_no`,  `stuaddress`,  `academic_year`, `admin_rte`, `religion_id`, `caste`, `soc_cat_id`, `blood_grp`, `mother_tongue`, `aadhar_card`, `stu_image`, `birth_place`, `village`, `fqualification`, `mqualification`, `foccupation`, `moccupation`, `fannual_income`, `dependents`, `guardians`, `nationality`, `subcaste`, `other_language`, `present_address`, `previous_school`, `father_aadhar`, `mother_aadhar`, `student_bankacc`, `ifsc_code`, `branch`, `bus_facility`, `stu_status`, `android_status`, `firebase_reg_id`, `create_date`, `modify_date`, `sr`.`session` FROM `students` as `s`  join `student_records` as `sr` on `s`.`student_id`=`sr`.`stu_id` where `stu_status`='0'  AND `sr`.`session`= '".$_SESSION['session']."' AND `sr`.`stu_id`='$sid' AND student_id='$sid'  ";

	$sql=mysqli_query($con,$ssql);
// $sql=mysqli_query($con,"select * from students where student_id='$sid'");
	$res=mysqli_fetch_array($sql);

	// echo "<pre>";
	// print_r($res);
	// echo "</pre>";

	$studid=$res['student_id'];

	$regisno=$res['register_no'];

	$odob=$res['dob'];
	$class=$res['class_id'];

	$section=$res['section_id'];
	if(!empty($res['roll_no'])){
		$roll_no=$res['roll_no'];
	}else{
		$roll_no='';
	}
	

	$msgid=$res['msg_type_id'];

		

	// $acdyear=$res['academic_year'];
	$acdyear=getSessionByid($res['session'])['year'];

	$password=$res['password'];

	$regid = $res['religion_id'];

	$scid = $res['soc_cat_id'];

	$admid=$res['adm_type_id'];

	$admrte=$res['admin_rte'];

	$simg=$res['stu_image'];

	$bus=$res['bus_facility'];

	$nationality = $res['nationality'];

	$regid = $res['religion_id'];

	


	

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>      

<div class="card">

<form action="" method="post" enctype="multipart/form-data">

	<div class="card-header">

		<strong>Update</strong> Student

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block" style="height:2100px;">

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Student Name <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="nstuname" value="<?php echo $res['student_name']; ?>" class="form-control" placeholder="Enter Student Name" required>

			<input type="hidden" name="sid" value="<?php echo $sid; ?>" >
			<input type="hidden" name="old_image" value="<?php echo $simg; ?>" >

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Registration Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" value="<?php echo $res['register_no']; ?>" name="regisnumber" id="txt_uname" class="form-control" placeholder="Enter Registration Number" readonly><span id="res1" ></span>

			</div>

			</div>

						

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Father's Name <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="nstufname" value="<?php echo $res['father_name']; ?>"  class="form-control" placeholder="Enter Father's Name" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Mother's Name <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="nstumname" value="<?php echo $res['mother_name']; ?>"  class="form-control" placeholder="Enter Mother's Name" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label" style="margin-top:10px">Select Gender <span style="color:red;font-weight:bold;">*</span></label><br>

			<input <?php if($res['gender']=="MALE"){echo "checked";}?> type="radio" name="gender" value="MALE" checked>&nbsp;MALE &nbsp;

			<input <?php if($res['gender']=="FEMALE"){echo "checked";}?> type="radio" name="gender" value="FEMALE">&nbsp;FEMALE

			</div>

			</div>

			

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label" style="margin-top:10px">Select Date Of Birth <span style="color:red;font-weight:bold;">*</span></label><br>

			<input type="date" value="<?php echo $res['dob']?>" name="ndob" class="form-control" required>

			</div>

			</div>

		

				

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Admission Date <span style="color:red;font-weight:bold;">*</span></label>

			<input type="date" value="<?php echo $res['admission_date']?>" name="nadmissiondate" class="form-control" readonly>

			</div>

			</div>

			

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Student Contact Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" id="stucontact" value="<?php echo $res['student_contact']; ?>" name="nstucontact" 

			class="form-control mobile" placeholder="Enter Student Contact" required><span class="mobile_error"></span>

			</div>

			</div>

			

			<div class="col-md-6">		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Select Class <span style="color:red;font-weight:bold;">*</span></label>

			<select class="form-control" name="stuclass" id="stuclass" onchange="subcat(this.value);chkfee(trim(<?php echo $sid;?>))" required>

			<option value="" selected disabled>---Select Class--</option>

			<?php

				$qcls = "SELECT * FROM class";

				$rcls = mysqli_query($con, $qcls);

				while( $rowcls = mysqli_fetch_array($rcls) ) {

				?>

				<option <?php if($class==$rowcls['class_id']){echo "selected";}?> value="<?php echo $rowcls['class_id']; ?>"><?php echo $rowcls['class_name']; ?>

				</option>

			<?php } ?>	

			</select>	

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Select Section <span style="color:red;font-weight:bold;">*</span></label>

			<select class="form-control" name="stusection" id="sub_cat" required>

			<option value="" selected disabled>---Select Section--</option>

			<?php

			$qsect = "SELECT * FROM section where class_id='$class'";

			$rqsect = mysqli_query($con, $qsect);

			while( $rowsect = mysqli_fetch_array($rqsect) ) {

			?>

			<option <?php if($section==$rowsect['section_id']){echo "selected";}?> value="<?php echo $rowsect['section_id']; ?>"><?php echo $rowsect['section_name']; ?>

			</option>

			<?php } ?>

			</select>

			</div>

			</div>

			

				<script>

					function subcat(str)

					{

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

				</script>

				

				<script>

					function chkfee(str)

					{

						$.ajax({

							url:'get_ajax_student_fee.php?stu_id='+str,

							type:'get', 

							success:function(data){

							if(!data=='')	

							{

								var dat = jQuery.parseJSON(data);

							alert('Cannot Edit Class');

							$('#stuclass').prop('selectedIndex',dat.clsid);

							$('#sub_cat').prop('selectedIndex',dat.secid);

							}

							}

						});

					}

				</script>

			<div class="col-md-6">	
			<div class="form-group">
			<label for="roll_no" class=" form-control-label">Roll No.<span style="color:red;font-weight:bold;">*</span></label>
			<input type="number" id="roll_no" name="roll_no" value="<?=$roll_no;?>" class="form-control " placeholder="Enter Roll Number" required><span class="roll_error"></span>
			</div>
			</div>

					

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Parents Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" id="parentcontact" name="nstuparentcontact" value="<?php echo $res['parent_no'];?>" class="form-control  mobile" placeholder="Enter Parent's Number"><span class="mobile_error"></span>

			</div>

			</div>
			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Student Address <span style="color:red;font-weight:bold;">*</span></label>

			<textarea class="form-control" name="stuaddress" required><?php echo $res['stuaddress'];?></textarea>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Present Address <span style="color:red;font-weight:bold;">*</span></label>

			<textarea class="form-control" name="present_address" required><?php echo $res['present_address'];?></textarea>

			</div>

			</div>

						

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Admission Type<span style="color:red;font-weight:bold;">*</span></label>

			<select class="form-control" name="unewadm" required>

			<?php

			$qadm = mysqli_query($con,"select * from admission_type");

			while($radm = mysqli_fetch_array($qadm))

			{

			?>	

			<option <?php if($admid==$radm['adm_type_id']){echo "selected";}?> value="<?php echo $radm['adm_type_id']; ?>"><?php echo $radm['adm_type_name']; ?>

			</option>

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

			<option <?php if($msgid==$rmsg['msg_type_id']){echo "selected";}?> value="<?php echo $rmsg['msg_type_id']; ?>"><?php echo $rmsg['msg_name']; ?>

			</option>

			<?php

			}

			?>

			</select>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Session Year <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" class="form-control" readonly value="<?php echo $acdyear;?>"/>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class="form-control-label">Nationality <span style="color:red;font-weight:bold;">*</span></label>

			<select class="form-control" name="nnationality">

			<option <?php if($nationality=="Indian"){echo "selected";}?> value="Indian">Indian</option>

			<option <?php if($nationality=="Others"){echo "selected";}?> value="Others">Others</option>

			</select>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Admin RTE</label>

			<select class="form-control" name="rte" required>

				<option <?php if($admrte=="No"){echo "selected";}?> value="No">No</option>

				<option <?php if($admrte=="Yes"){echo "selected";}?> value="Yes">Yes</option>

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

			<option <?php if($regid==$rrl['religion_id']){echo "selected";}?> value="<?php echo $rrl['religion_id']; ?>"><?php echo $rrl['religion_name']; ?>

			</option>

			<?php

			}

			?>

			</select>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Caste </label>

			<input type="text" name="caste" class="form-control" value="<?php echo $res['caste'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Social Category </label>

			<select class="form-control" name="category" required>

			<?php

			$qsc = mysqli_query($con,"select * from social_category");

			while($rsc = mysqli_fetch_array($qsc))

			{

			?>	

			<option <?php if($scid==$rsc['soc_cat_id']){echo "selected";}?> value="<?php echo $rsc['soc_cat_id']; ?>"><?php echo $rsc['soc_cat_name']; ?>

			</option>

			<?php

			}

			?>

			</select>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Blood Group </label>

			<input type="text" name="bldgrp" class="form-control" value="<?php echo $res['blood_grp'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Mother Tongue </label>

			<input type="text" name="lang" class="form-control" value="<?php echo $res['mother_tongue'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Aadhar Card </label>

			<input type="number" id="aadhar" name="aadhar" class="form-control aadhar" value="<?php echo $res['aadhar_card'];?>"><span class="aadhar_error"></span>

			</div>

			</div>

		

			<div class="col-md-3">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Student Image </label>

			<input type="file" name="file1" class="form-control" style="width:240px;">

			</div>

			</div>

			

			<div class="col-md-3">	

			<div class="form-group">

			<!-- <img src="images/student/<?php echo $regisno;?>/<?php echo $simg;?>" width='90px' height='90px' style="border-radius:50%;margin-top:20px;margin-left:40px;border:2px solid grey;"/> -->
			<img src="<?='images/student/'.str_replace('/','-',$regisno).'/'.$simg?>" width='90px' height='90px' style="border-radius:50%;margin-top:20px;margin-left:40px;border:2px solid grey;"/>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Place of Birth </label>

			<input type="text" name="birth_place" class="form-control" value="<?php echo $res['birth_place'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Village/Town/Taluk/District </label>

			<input type="text" name="village" class="form-control" value="<?php echo $res['village'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Father's Qualification </label>

			<input type="text" name="fqualification" class="form-control" value="<?php echo $res['fqualification'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Mother's Qualification </label>

			<input type="text" name="mqualification" class="form-control" value="<?php echo $res['mqualification'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Father's Occupation </label>

			<input type="text" name="foccupation" class="form-control" value="<?php echo $res['foccupation'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Mother's Occupation </label>

			<input type="text" name="moccupation" class="form-control" value="<?php echo $res['moccupation'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Father's Annual Income </label>

			<input type="text" name="fannual_income" class="form-control" value="<?php echo $res['fannual_income'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">No of Dependents </label>

			<input type="number" name="dependent" class="form-control" value="<?php echo $res['dependents'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Guardians Name & Address </label>

			<input type="text" name="guardians" class="form-control" value="<?php echo $res['guardians'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Sub Caste </label>

			<input type="text" name="subcaste" class="form-control" value="<?php echo $res['subcaste'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Any Other Language Spoken </label>

			<input type="text" name="other_language" class="form-control" value="<?php echo $res['other_language'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Previous School </label>

			<input type="text" name="previous_school" class="form-control" value="<?php echo $res['previous_school'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Father's Aadhar Card </label>

			<input type="number" id="f_aadhar" name="f_aadhar" class="form-control aadhar" value="<?php echo $res['father_aadhar'];?>"><span class="aadhar_error"></span>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Mother's Aadhar Card </label>

			<input type="number" id="m_aadhar" name="m_aadhar" class="form-control aadhar" value="<?php echo $res['mother_aadhar'];?>"><span class="aadhar_error"></span>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Student Bank A/c No. </label>

			<input type="number" name="bank_acc" class="form-control" value="<?php echo $res['student_bankacc'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">IFSC Code </label>

			<input type="text" name="ifsc" class="form-control" value="<?php echo $res['ifsc_code'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Branch </label>

			<input type="text" name="branch" class="form-control" value="<?php echo $res['branch'];?>">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Bus Facility </label>

			<select class="form-control" name="bus_facility">

				<option <?php if($bus=="No"){echo "selected";}?> value="No">No</option>

				<option <?php if($bus=="Yes"){echo "selected";}?> value="Yes">Yes</option>

			</select>

			</div>

			</div>
			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Password <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" id="password" name="npassword" value="<?php echo $res['password'];?>" class="form-control" placeholder="Enter Password" required><span id="wm2"></span>

			</div>

			</div>

		

	</div>

	<div class="card-footer">

		<button type="submit" name="update_student" id="update_stu" class="btn btn-secondary btn-sm">

			<i class="fa fa-edit"></i> Update Student

		</button>

		

		<a href="dashboard.php?option=view_students_details&sid=<?php echo $sid;?>" class="btn btn-info btn-sm">

		<i class='fa fa-arrow-left'> Back</i></a>

	</div>

	</form>

</div>



<!--

<script>

$("#stucontact").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || (k >= 48 && k <= 57)) { if ($(this).val().length == 10) { if (k == 8) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>



<script>

$("#parentcontact").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || (k >= 48 && k <= 57)) { if ($(this).val().length == 10) { if (k == 8) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>



<script>

$("#aadhar").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 12) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>



<script>

$("#f_aadhar").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 12) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>



<script>

$("#m_aadhar").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 12) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>



<script>			

	function cal() 													

	{

		var route=$("#root").val();

		var dataString={'rou_id':route};

				$.ajax({  

				 url:"view_ajax_duration_price.php",  

				 method:"POST",  

			   data:dataString, 

				 success:function(data)

				 {  

					   $('#res').val(data);

				 }  

			});

	}		

</script>

	

<script>			

	function contact() 													

	{

	var cno=$("#txt_uname1").val();

	var dataString={'cno':cno};

				$.ajax({  

				 url:"view_ajax_contact.php",  

				 method:"POST",  

			   data:dataString, 

				 success:function(data)

				 {  

					   $('#res2').html(data);

				 }  

			});

	}		

</script>	

-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
	// alert('test');
  var action = $("#update_stu").attr("name");
  // var action=$.trim($('button').prop("name");
	// var action=$('button').attr("name");
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("#update_stu").text("Sending, please wait...");  
	$("#update_stu").attr("disabled", true);

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
				window.location.href='dashboard.php?option=view_students';
				},3000);
			}
			else if(result.type=="ERROR"){
				toastr.error(result.message); 
				$("#update_stu").text("Update Student");  
	      $("#update_stu").attr("disabled", false);

			}else if(result.type=="ROLL_ERROR"){
				toastr.error(result.message);
				$("#update_stu").text("Update Student");  
				$('#roll_no').focus();
	            $("#update_stu").attr("disabled", false);

	      
		    }else if(result.type=="ALREADY"){
				toastr.error(result.message);
				$("#update_stu").text("Update Student");  
	            $("#update_stu").attr("disabled", false);
	      

			}


			// body...
		}
	})




});

});
</script>