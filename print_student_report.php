<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



$c=mysqli_query($con,"select * from class where class_id='$class'");

$rc=mysqli_fetch_array($c);

$cls=$rc['class_name'];

if($cls)

{

$clsn=$cls;

}

else

{

$clsn='Class All';

}



$s=mysqli_query($con,"select * from section where section_id='$section'");

$rs=mysqli_fetch_array($s);

$se=$rs['section_name'];

if($se)

{

$sec=$se;

}

else

{

$sec='All';

}





$sr=1;	

$cond = '';



	if($_REQUEST['class']!='') 

	{

		$cond.=" && sr.class_id='$_REQUEST[class]'";

	}

	if($_REQUEST['section']!='') 

	{

		$cond.=" && sr.section_id='$_REQUEST[section]'";

	}

	

// $query = mysqli_query($con,"SELECT * FROM students WHERE stu_status='0'  and session='".$_SESSION['session']."'  $cond");	

$query=mysqli_query($con,"select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session,sr.roll_no from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0'  && sr.session='".$_SESSION['session']."' $cond order by sr.roll_no asc  ");




?>



	<style>

	tr th{

		

		font-size:12px;

	}



	tr td{

		

		font-size:12px;

	}



	</style>

	

<script type="text/javascript">

$(document).ready(function(){

    $(".menu a").each(function(){

        if($(this).hasClass("disabled")){

            $(this).removeAttr("href");

        }

    });

});

</script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">



<div id="right-panel" class="right-panel">

   <form method="post" action="dashboard.php?option=student_report" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

								<h3 align="center">Student Report For Class <?php echo $clsn; ?> Section <?php echo $sec; ?> </h3>

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Register No</th>

											 <th>Student Name</th>

											 <th>Father Name</th>

											 <th>Class</th>

											 <th>Section</th>
											 <th>Roll no.</th>

											 <th>Gender</th>

											 <th>Parent Phone</th>

											 <th>Admin RTE</th>

											 <th>Religion</th>

											 <th>Caste</th>

											 <th>Social Category</th>

											 <th>Mother Tongue</th>

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

									$tstudent = mysqli_num_rows($query);
									if($tstudent > 0){

									while($res=mysqli_fetch_array($query))

									{

																	

									$id=$res['student_id'];

									$clid=$res['class_id'];

									$quec=mysqli_query($con,"select * from class where class_id='$clid'");

									$resc=mysqli_fetch_array($quec);

									

									$seid=$res['section_id'];

									$qse=mysqli_query($con,"select * from section where section_id='$seid'");

									$rsec=mysqli_fetch_array($qse);

									

									

									$admid = $res['adm_type_id'];

									$qadm = mysqli_query($con,"select * from admission_type where adm_type_id='$admid'");

									$radm=mysqli_fetch_array($qadm);

									$admname = $radm['adm_type_name'];

									

									$msgid=$res['msg_type_id'];

									$qmsg=mysqli_query($con,"select * from message_type where msg_type_id='$msgid'");

									$rmsg=mysqli_fetch_array($qmsg);

									$msgname = $rmsg['msg_name'];

									

									$regid = $res['religion_id'];

									$qrl=mysqli_query($con,"select * from religion where religion_id ='$regid'");

									$rrl=mysqli_fetch_array($qrl);

									$regname = $rrl['religion_name'];

									

									$scid = $res['soc_cat_id'];

									$qsc=mysqli_query($con,"select * from social_category where soc_cat_id='$scid'");

									$rsc=mysqli_fetch_array($qsc);

									$scat_name = $rsc['soc_cat_name'];				

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $res['register_no']; ?></td>

										<td><?php echo $res['student_name']; ?></td>

										<td><?php echo $res['father_name']; ?></td>

										<td><?php echo $resc['class_name'];?></td>

										<td><?php echo $rsec['section_name'];?></td>
										<td><?=($res['roll_no']) ? $res['roll_no'] : '0' ;?></td>

										<td><?php echo $res['gender']; ?></td>

										<td><?php echo $res['parent_no']; ?></td>

										<td><?php echo $res['admin_rte']; ?></td>

										<td><?php echo $regname; ?></td>

										<td><?php echo $res['caste']; ?></td>

										<td><?php echo $scat_name; ?></td>

										<td><?php echo $res['mother_tongue']; ?></td>

									</tr>

                                    <?php $sr++; }
                                     }

									

									?>

								</tbody>

                                </table>

                            </div>

                        </div>

								



						<div class="row">

							<div class="col-md-10">

							<?php

							

								

								

								echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'>The Total Students from $clsn, Section $sec is $tstudent Students. </h5>";

					

							?>	

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

		

		

		<button id="printbtn" class="btn btn-primary btn-md" onclick="window.print();" style="margin-top:20px;">print</button>

		

		

		<a href="dashboard.php?option=student_report" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:18px">Back</a>

		

		</div>

		

	</form>	

    </div><!-- /#right-panel -->



 