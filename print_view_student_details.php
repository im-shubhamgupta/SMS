<?php

error_reporting(1);

// include('connection.php');
include('myfunction.php');

extract($_REQUEST);

// $sql="select * from students where student_id='$sid'";
$sql = "SELECT `student_id`, `register_no`, `student_name`, `father_name`, `mother_name`,'student_contact', `gender`, `dob`, `admission_date`, `sr`.`class_id` ,`sr`.`section_id`, `sr`.`roll_no`, `due`,  `parent_no`,  `stuaddress`,  `academic_year`, `admin_rte`, `religion_id`, `caste`, `msg_type_id`,`soc_cat_id`, `blood_grp`, `mother_tongue`, `aadhar_card`, `stu_image`, `birth_place`, `village`, `fqualification`, `mqualification`, `foccupation`, `moccupation`, `fannual_income`, `dependents`, `guardians`, `nationality`, `subcaste`, `other_language`, `present_address`, `previous_school`, `father_aadhar`, `mother_aadhar`, `student_bankacc`, `ifsc_code`, `branch`, `bus_facility`, `stu_status`, `android_status`, `firebase_reg_id`, `create_date`, `modify_date`, `sr`.`session` FROM `students` as `s`  join `student_records` as `sr` on `s`.`student_id`=`sr`.`stu_id` where stu_status='0'  AND `sr`.`session`= '".$_SESSION['session']."' AND `sr`.`stu_id`='$sid' AND student_id='$sid'  ";
$que=mysqli_query($con,$sql);

$Stu=mysqli_fetch_assoc($que);
// echo "<pre>";
// print_r($res);
// echo "</pre>";


?>


	

<!-- <script type="text/javascript">

$(document).ready(function(){

    $(".menu a").each(function(){

        if($(this).hasClass("disabled")){

            $(this).removeAttr("href");

        }

    });

});

</script> -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">



	<style>
	.table{
		border:1px solid black;
		border-bottom-color: black !important;
		margin-bottom:0px;
	}	
	.table>thead>tr>th {
    vertical-align: bottom;
    border-bottom: 1px solid black; 
/*    #ddd;*/
}
	.card-body .student_table{
		border:1px solid black;
/*		border-top: 1px solid black ; */
	}
	/*.company_name {
		vertical-align: top !important;
	
	}*/
	.company_name h2{
	
		font-size: 35px;
	}
	.affiliation{
		    text-align: right;
		    padding-right: 55px;
		    float: right;
	}
	/*.student_table>tr>th{
		width:40px;
	}*/
/*	tr th{

		

		font-size:12px;

	}



	tr td{

		

		font-size:12px;

	}
*/


	</style>


<div id="right-panel" class="right-panel">

   <!-- <form method="post" action="dashboard.php?option=student_report" enctype="multipart/form-data">       -->

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="container">
                <div class="row">

                    <div class="col-md-12">

						

						<!--table starts from here-->

						<div class="card" >

                            <div class="card-header" >
                            

								<!-- <h3 align="center"><u>Student Details</u> </h3>  -->
								<div class="row">
									<div class="col-md-11">
								      <u><h2 align="center"></h2></u>
								    </div>
								    <div class="col-md-1">
								      <button id="printbtn" class="btn btn-primary btn-md" onclick="window.print();" style="margin-top:20px;">print</button>
								    </div>
							    </div>

                                <table class="table"  > 
                                	 <!-- id="bootstrap-data-table-export" -->
                                	<thead style="border:1px solid black;">
                                	

                                    <tr>
                                		<th><center><img src="<?=get_school_details()['company_image_path'] ?>" style='width:80px; height:80px; ' /></center></th>
                                		<th colspan='3'>
                                		<div class="row" class="company_name" >	
	                                		<div class="col-12"> 
	                                			<span class="text-center"><small>Registration Number : <?=get_school_details()['registration_number'] ?></small></span>
	                                		<!-- </div>	
	                                		<div class="col-sm-5" style="text-align: right;" > --> 
	                                			<span class="affiliation" ><small >Affiliation No. / UDISE Code : <?=get_school_details()['affiliation_number'] ?></small></span>
	                                		</div>	
                                	    </div>
                                			<b><center><h2><?=get_school_details()['company_name']?></h2></center></b></th>
                                	 </tr>
                                	 <tr>
                                	 	<th></th> 
                                	 	<th></th> 
                                		<th>Address :
                                		<?=get_school_details()['company_address'] ?></th>
                                		<th>Contact No. : 
                                		<?=get_school_details()['company_number'] ?></th>
                                	 </tr>
                                	</thead>
                                </table>	
                            </div>     
                            <div class="card-body">    
                                <table class="table table-striped student_table  ">	 
                                	<tr>
                                		<th colspan="4"><center><u>Student Details</u></center></th>
                                	</tr>
<!-- table-bordered -->
                      <?php      echo  "<tr>
	                                         <th>Student Name : </th>
											 <td>".$Stu['student_name']."</td>
											 <th rowspan='2'>Student Image. :</th>
											 <td  rowspan='2'><img src=".getStudent_byStudent_id($Stu['student_id'])['stu_image_path']." width='90px' height='90px' style='border-radius:50%' />
											 </td>
										</tr>
										<tr>
                                             <th>Registration No. :</th>
											 <td>".$Stu['register_no']."</td>
											
										</tr>




										<tr>
                                             <th>Father Name :</th>
											 <td>".$Stu['father_name']."</td>
											 <th>Mother Name :</th>
											 <td>".$Stu['mother_name']."</td>
										</tr>
										<tr>
                                             <th>Class : </th>
											 <td>".get_class_byid($Stu['class_id'])['class_name']."</td>
											 <th>Section :</th>
											 <td>".get_section_byid($Stu['section_id'])['section_name']."</td>
										</tr>
										<tr>
											 <th>Roll No. :</th>
											 <td>".htmlentities(($Stu['roll_no']) ? $Stu['roll_no'] : 'NA' )."</td>
											 <th>Caste :</th>
											 <td>".htmlentities(($Stu['caste']) ? $Stu['caste'] : 'NA' )."</td>
										</tr>
										
										<tr>
                                             <th>Religion : </th>
											 <td>".get_religion_byid($Stu['religion_id'])['religion_name']."</td>
											 <th>Social Category :</th>
											 <td>".get_social_category_byid($Stu['soc_cat_id'])['soc_cat_name']."</td>
										</tr>
										<tr>
                                             <th>Mother Tongue :</th>
											 <td>".htmlentities(($Stu['mother_tongue']) ? $Stu['mother_tongue'] : 'NA' )."</td>
											 <th>D.o.b :</th>
											 <td>".date('d-m-Y',strtotime($Stu['dob']))."</td>
										</tr>
										<tr>
                                             <th>Admission Date :</th>
											 <td>".date('d-m-Y',strtotime($Stu['admission_date']))."</td>
											 <th>Session Year :</th>
											 <td>".getSessionByid($Stu['session'])['year']."</td>
											 
										</tr>
										<tr>
                                             <th>Student Contact no:</th>
											 <td>".$Stu['student_contact']."</td>
											 <th>Parent No. :</th>
											 <td>".$Stu['parent_no']."</td>
										</tr>
										
										<tr>
										      <th>Gender :</th>
											 <td>".$Stu['gender']."</td>
											 <th>Nationality :</th>
											 <td>".htmlentities(($Stu['nationality']) ? $Stu['nationality'] : 'NA' )."</td>
										</tr>
										<tr>
                                             <th>Blood Group:</th>
											 <td>".htmlentities(($Stu['blood_grp']) ? $Stu['blood_grp'] : 'NA' )."</td>
											 <th>Aadhar no. :</th>
											 <td>".htmlentities(($Stu['aadhar_card']) ? $Stu['aadhar_card'] : 'NA' )."</td>
										</tr>
										<tr>
                                             <th>Place of Birth :</th>
											 <td>".htmlentities(($Stu['birth_place']) ? $Stu['birth_place'] : 'NA' )."</td>
											 <th>Village/Town/Taluk/District :</th>
											 <td>".htmlentities(($Stu['village']) ? $Stu['village'] : 'NA' )."</td>
										</tr>
										
										
										<tr>
                                             <th>Father's Qualification :</th>
											 <td>".htmlentities(($Stu['fqualification']) ? $Stu['fqualification'] : 'NA' )."</td>
											 <th>Mother's Qualification :</th>
											 <td>".htmlentities(($Stu['mqualification']) ? $Stu['mqualification'] : 'NA' )."</td>
										</tr>
										<tr>
                                             <th>Father's Occupation :</th>
											 <td>".htmlentities(($Stu['foccupation']) ? $Stu['foccupation'] : 'NA' )."</td>
											 <th>Mother's Occupation :</th>
											 <td>".htmlentities(($Stu['moccupation']) ? $Stu['moccupation'] : 'NA' )."</td>
										</tr>
										<tr>
                                             <th>Father's Annual Income :</th>
											 <td>".$Stu['fannual_income']."</td>
											 <th>No. of Dependents :</th>
											 <td>".$Stu['dependents']."</td>
										</tr>
										<tr>
                                             <th>Guardians Name :</th>
											 <td>".htmlentities(($Stu['guardians']) ? $Stu['guardians'] : 'NA' )."</td>
											 <th>Sub Caste :</th>
											 <td>".htmlentities(($Stu['subcaste']) ? $Stu['subcaste'] : 'NA' )."</td>
										</tr>
										<tr>
                                             <th>Other Language  :</th>
											 <td>".htmlentities(($Stu['other_language']) ? $Stu['other_language'] : 'NA' )."</td>
											 <th>Previous School :</th>
											 <td>".htmlentities(($Stu['previous_school']) ? $Stu['previous_school'] : 'NA' )."</td>
										</tr>
										<tr>
                                             <th>Father's Aadhar Card :</th>
											 <td>".htmlentities(($Stu['father_aadhar']) ? $Stu['father_aadhar'] : 'NA' )."</td>
											 <th>Mother's Aadhar Card :</th>
											 <td>".htmlentities(($Stu['mother_aadhar']) ? $Stu['mother_aadhar'] : 'NA' )."</td>
										</tr>
										<tr>
                                             <th>Student Bank A/c No. :</th>
											 <td>".htmlentities(($Stu['student_bankacc']) ? $Stu['student_bankacc'] : 'NA' )."</td>
											 <th>IFSC Code :</th>
											 <td>".htmlentities(($Stu['ifsc_code']) ? $Stu['ifsc_code'] : "NA")."</td>
										</tr>
										<tr>
                                             <th>Branch :</th>
											 <td>".htmlentities(($Stu['branch']) ? $Stu['branch'] : "NA") ."</td>
											 <th>Bus Facility :</th>
											 <td>".$Stu['bus_facility']."</td>
										</tr>
										<tr>
                                             <th>Message Type:</th>
											 <td colspan='3'>".get_message_type_byid($Stu['msg_type_id'])['msg_name']."</td>
											
										</tr>
										<tr>
                                             <th>Student Address:</th>
											 <td colspan='3'>".$Stu['stuaddress']."</td>
										</tr>
										<tr>
											 <th>Present Address :</th>
											 <td colspan='3'>".$Stu['present_address']."</td>
										</tr>



										";
										?>

                                  

                                </table>

                            </div>

                        </div>

								



						<div class="row">

							<div class="col-md-10">

							<?php

							

								

								

								// echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'>The Total Students from $clsn, Section $sec is $tstudent Students. </h5>";

					

							?>	

							</div>

							</div>

										

                    </div>

                </div>
               </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		<div style="text-align:center">

		<style>

			

		@media print{

		#printbtn{

		display: none;

				}

			}

		</style>

		

		

		<button id="printbtn" class="btn btn-primary btn-md fa fa-print" onclick="window.print();" style="margin-top:20px;">print</button>

		

		

		<a href="dashboard.php?option=view_students" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:18px">Back</a>

		

		</div>

		

	<!-- </form>	 -->

    </div><!-- /#right-panel -->



 