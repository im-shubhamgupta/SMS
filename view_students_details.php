<?php

extract($_REQUEST);

$sid=$_REQUEST['sid'];

$que=mysqli_query($con,"select * from students where student_id='$sid'");

$res=mysqli_fetch_array($que);

$id=$res['student_id'];

// $cid=$res['class_id'];
$cid=get_student_records_by_stuid($sid)['class_id']??'';


// $secid=$res['section_id'];
$secid=get_student_records_by_stuid($sid)['section_id']?? '';
$admission_no=str_pad($res['admission_no'], 4 , "0", STR_PAD_LEFT);

$date=$res['dob'];

$chgdate=date("d-M-Y", strtotime($date));

$date1=$res['admission_date'];

$chgdate1=date("d-M-Y", strtotime($date1));

$msgid=$res['msg_type_id'];

$admid = $res['adm_type_id'];

$regid = $res['religion_id'];

$scid = $res['soc_cat_id'];

?>

<script type="text/javascript">

$(document).ready(function(){

    $(".menu a").each(function(){

        if($(this).hasClass("disabled")){

            $(this).removeAttr("href");

        }

    });

});

</script>



<script type="text/javascript">

	function delet(id)

	{

		if(confirm("Do You want to delete this Student???"))

		{

			window.location.href='delete_student.php?x='+id;

		}

	}

</script>
<div class="row">
	<div class="col-md-10">
      <h2 align="center">Student Details</h2>
    </div>
    <div class="col-md-2">
      <a align="center" href="print_view_student_details.php?sid=<?=$_GET['sid']?>" target="_blank" class="btn btn-primary btn-md fa fa-print" style="margin-top:0px;">  Print</a>
    </div>
</div>    
<hr>

<table class="table table-striped">

        <tbody>

		    <?php if(!empty($res['admission_no'])){?>
            <tr>

				<th>Admission Number</th>

				<td><?php echo $admission_no ?></td>

			</tr>
			<?php } ?>
			<tr>

			<th>Register Number</th>

			<td><?php echo $res['register_no'] ?></td>

			</tr>	
			

			<tr>

			<th>Student Name</th>

			<td><?php echo $res['student_name'] ?></td>

			</tr>

			

			<tr>

			<th>Father Name</th>

			<td><?php echo $res['father_name'] ?></td>

			</tr>

			

			<tr>

			<th>Mother Name</th>

			<td><?php echo $res['mother_name'] ?></td>

			</tr>

			

			<tr>

			<th>Parents Number</th>

			<td><?php echo $res['parent_no'] ?></td>

			</tr>

			

			<tr>

			<th>Password</th>

			<td><?php echo $res['password'] ?></td>

			</tr>

			

			<tr>

			<th>Student Address</th>

			<td><?php echo $res['stuaddress'] ?></td>

			</tr>

			

			<tr>

			<th>Date Of Birth</th>

			<td><?php echo $chgdate; ?></td>

			</tr>

			

			<tr>

			<th>Gender</th>

			<td><?php echo $res['gender'] ?></td>

			</tr>

			

			<tr>

			<th>Admission Date</th>

			<td><?php echo $chgdate1; ?></td>

			</tr>

			

			<tr>

			<th>Session Year</th>

			<!-- <td><?php
			// echo $res['academic_year'];?></td> -->
			<td><?=getSessionByid(get_student_records_by_stuid($sid)['session'])['year']?></td>

			</tr>

						

			<?php

			$que3=mysqli_query($con,"select * from class where class_id='$cid'");

			$res3=mysqli_fetch_array($que3);

			?>

			<tr>

			<th>Class Name</th>

			<td><?php echo $res3['class_name']; ?></td>

			</tr>

			

			<?php

			$que4=mysqli_query($con,"select * from section where section_id='$secid'");

			$res4=mysqli_fetch_array($que4);

			?>

			<tr>

			<th>Section Name</th>

			<td><?php echo $res4['section_name']; ?></td>

			</tr>
			<tr>

			<th>Roll No.</th>

			<td><?php echo get_student_records_by_stuid($sid)['roll_no']?? '0'; ?></td>

			</tr>

						

			<tr>

			<th>Student Contact</th>

			<td><?php echo $res['student_contact']; ?></td>

			</tr>

			

			<?php

			$que5=mysqli_query($con,"select * from admission_type where adm_type_id='$admid'");

			$res5=mysqli_fetch_array($que5);

			?>

			<tr>

			<th>Admission Type</th>

			<td><?php echo $res5['adm_type_name'];?></td>

			</tr>

			

			<?php

			$que6=mysqli_query($con,"select * from message_type where msg_type_id='$msgid'");

			$res6=mysqli_fetch_array($que6);

			?>

			<tr>

			<th>Message Type</th>

			<td><?php echo $res6['msg_name']; ?></td>

			</tr>

			

			<tr>

			<th>Admin RTE</th>

			<td><?php echo $res['admin_rte']; ?></td>

			</tr>



			<?php

			$qrl=mysqli_query($con,"select * from religion where religion_id ='$regid'");

			$rrl=mysqli_fetch_array($qrl);

			?>

			<tr>

			<th>Religion</th>

			<td><?php echo $rrl['religion_name']; ?></td>

			</tr>

			

			<tr>

			<th>Caste</th>

			<td><?php echo $res['caste']; ?></td>

			</tr>

			

			<?php

			$qsc=mysqli_query($con,"select * from social_category where soc_cat_id='$scid'");

			$rsc=mysqli_fetch_array($qsc);

			?>

			<tr>

			<th>Social Category</th>

			<td><?php echo $rsc['soc_cat_name']; ?></td>

			</tr>

			

			<tr>

			<th>Blood Group</th>

			<td><?php echo $res['blood_grp']; ?></td>

			</tr>

			

			<tr>

			<th>Mother Tongue</th>

			<td><?php echo $res['mother_tongue']; ?></td>

			</tr>

			

			<tr>

			<th>Aahdar Card</th>

			<td><?php echo $res['aadhar_card']; ?></td>

			</tr>

			

			<tr>

			<th>Profile Image</th>

			<td>
			<?php	$regisnumber_img=str_replace('/','-',$res['register_no']); ?>

			<a href="images/student/<?php echo $regisnumber_img ?>/<?php echo $res['stu_image']; ?>"><img src="images/student/<?php echo $regisnumber_img ?>/<?php echo $res['stu_image']; ?>" width='90px' height='90px' style="border-radius:50%"/></td>

			</tr>

			

			<tr>

			<th>Birth Place</th>

			<td><?php echo $res['birth_place']; ?></td>

			</tr>

			

			<tr>

			<th>Village</th>

			<td><?php echo $res['village']; ?></td>

			</tr>

			

			<tr>

			<th>Father's Qualification</th>

			<td><?php echo $res['fqualification']; ?></td>

			</tr>

			

			<tr>

			<th>Mother's Qualification</th>

			<td><?php echo $res['mqualification']; ?></td>

			</tr>

			

			<tr>

			<th>Father's Occupation</th>

			<td><?php echo $res['foccupation']; ?></td>

			</tr>

			

			<tr>

			<th>Mother's Occupation</th>

			<td><?php echo $res['moccupation']; ?></td>

			</tr>

			

			<tr>

			<th>Father Annual Income</th>

			<td><?php echo $res['fannual_income']; ?></td>

			</tr>

			

			<tr>

			<th>No. of Dependents</th>

			<td><?php echo $res['dependents']; ?></td>

			</tr>

			

			<tr>

			<th>Guardians Detail</th>

			<td><?php echo $res['guardians']; ?></td>

			</tr>

			

			<tr>

			<th>Nationality</th>

			<td><?php echo $res['nationality']; ?></td>

			</tr>

			

			<tr>

			<th>Sub Caste</th>

			<td><?php echo $res['subcaste']; ?></td>

			</tr>

			

			<tr>

			<th>Other Language Spoken</th>

			<td><?php echo $res['other_language']; ?></td>

			</tr>

			

			<tr>

			<th>present_address</th>

			<td><?php echo $res['present_address']; ?></td>

			</tr>

			

			<tr>

			<th>Previous School</th>

			<td><?php echo $res['previous_school']; ?></td>

			</tr>

			

			<tr>

			<th>Father Aadhar Card</th>

			<td><?php echo $res['father_aadhar']; ?></td>

			</tr>

			

			<tr>

			<th>Mother Aadhar Card</th>

			<td><?php echo $res['mother_aadhar']; ?></td>

			</tr>

			

			<tr>

			<th>Student Bank A/c</th>

			<td><?php echo $res['student_bankacc']; ?></td>

			</tr>

			

			<tr>

			<th>IFSC Code</th>

			<td><?php echo $res['ifsc_code']; ?></td>

			</tr>

			

			<tr>

			<th>Branch</th>

			<td><?php echo $res['branch']; ?></td>

			</tr>

			

			<tr>

			<th>Bus Facility</th>

			<td><?php echo $res['bus_facility']; ?></td>

			</tr>

						

			<tr>

			<th>Action</th>

			<td>

			

		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

			

			echo "<a href='dashboard.php?option=update_students&usid=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";

			?>

	

			<?php

			$qbill=mysqli_query($con,"select * from student_due_fees where student_id='$sid'");

			$rbill=mysqli_num_rows($qbill);

			if($rbill)

			{

				echo "<a href='#' style='color:#666;border-color:#666;' class='btn btn-outline-success btn-sm disabled' 

				class='btn btn-danger btn-sm text-white'> <i class='fa fa-trash'></i> Delete</a>";

			}

			else

			{?>

				<a href="#" class='btn btn-danger btn-sm text-white' onclick="delet('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete </a>

			<?php

			}

			

		}


		?>

		<a href="print_view_student_details.php?sid=<?=$_GET['sid']?>" target="_blank" class="btn btn-primary btn-sm fa fa-print" style="margin-top:0px;">  Print</a>

		

			<a href="dashboard.php?option=view_students" class="btn btn-info btn-sm" style="margin-left:20px;">

			<i class='fa fa-arrow-left'> Back</i></a>

			

			</td>

			</tr>

			

			

				

        </tbody>

    </table>