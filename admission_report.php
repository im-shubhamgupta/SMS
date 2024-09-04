<?php

error_reporting(1);

extract($_REQUEST);

include('connection.php');



$sr=1;

if(isset($_POST['search'])){

	

	$cond = '';

	

	if($_POST['class']!=''){

		$cond.=" && sr.class_id='$_REQUEST[class]'";

		$cond2.=" && sr.class_id='$_REQUEST[class]'";

	}

	if($_POST['section']!=''){

		$cond.=" && sr.section_id='$_REQUEST[section]'";

		$cond2.=" && sr.section_id='$_REQUEST[section]'";

	}

	

	if($type=="Category"){

		$ntype="soc_cat_id";

	}elseif($type=="Religion"){

		$ntype="religion_id";

	}elseif($type=="Gender"){

		$ntype="gender";

	}
	if($_POST['type']!=''){

		$cond.=" && $ntype='$_REQUEST[stype]'";

	}


// $query3 = mysqli_query($con,"SELECT * FROM students WHERE stu_status='0' and session='".$_SESSION['session']."' ");
$query3=mysqli_query($con,"select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session,sr.roll_no from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0'  && sr.session='".$_SESSION['session']."' order by sr.roll_no asc  ");

	

// $query = mysqli_query($con,"SELECT * FROM students WHERE stu_status='0' and session='".$_SESSION['session']."' $cond");
$query=mysqli_query($con,"select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session,sr.roll_no from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0'  && sr.session='".$_SESSION['session']."' $cond order by sr.roll_no asc  ");



// $query2 =mysqli_query($con,"SELECT * FROM students WHERE stu_status='0' and session='".$_SESSION['session']."'  $cond2");
$query2=mysqli_query($con,"select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session,sr.roll_no from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0'  && sr.session='".$_SESSION['session']."' $cond2 order by sr.roll_no asc ");




}



?>

<style>



/* Media Query  */

@media only screen and (max-width: 600px)

{

	.col-md-3{

		width:400px;

		

	}

	

}



</style>





<div id="right-panel" class=" right-panel">

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Report Panel</a>

  <a class="breadcrumb-item" href="#">Student Report</a>

  <span class="breadcrumb-item active">Admission</span>

</nav>



	<form method="post" action="dashboard.php?option=admission_report" enctype="multipart/form-data">

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                                 

							<div class="row" style="margin-top:20px;">

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-2" style="margin-left:80px;">Class</div>

								<div class="col-md-5" style="margin-left:20px;">

								<select name="class" class="form-control" onchange="search_sec(this.value)">

								<option value="" selected="selected" disabled >All</option>

								<?php

								$scls =  mysqli_query($con,"select * from class");

								while( $rescls = mysqli_fetch_array($scls) ) {

								?>

								<option  <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

								</option>

								<?php } ?>							

								</select>

								</div>

								</div>

								</div>

								

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-3" style="margin-left:0px;">Section</div>

								<div class="col-md-6" style="margin-left:20px;">

								<select class="form-control" name="section" id="search_sect">

								<option value="" selected disabled>All</option>

								<?php

								$qsec=mysqli_query($con,"select * from section where class_id='$class'");

								while($rsec=mysqli_fetch_array($qsec))

								{

								$secname=$rsec['section_name'];

								?>

								<option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>

								</option>

								<?php 

								}

								?>	

								</select>

								<script>

								function search_sec(str)

								{

								var xmlhttp= new XMLHttpRequest();	

								xmlhttp.open("get","search_ajax_section_withall_report.php?cls_id="+str,true);

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

								</div>

								</div>

								</div>

							</div>

							

							<div class="row" style="margin-top:20px;">

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-2" style="margin-left:80px;">Type</div>

								<div class="col-md-5" style="margin-left:20px;">

								<select name="type" class="form-control" onchange="search_subtype(this.value)" autofocus >

								<option value="" selected="selected" disabled >All </option>

								<option <?php if($type=="Category"){echo "selected";}?> value="Category">Category</option>

								<option <?php if($type=="Religion"){echo "selected";}?> value="Religion">Religion</option>

								<option <?php if($type=="Gender"){echo "selected";}?> value="Gender">Gender</option>

								</select>

								</div>

								</div>

								</div>

								

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-3" style="margin-left:0px;">Sub Type</div>

								<div class="col-md-6" style="margin-left:20px;">

								<select class="form-control" name="stype" id="search_stype" autofocus >

								<option value="" selected disabled>All </option>

								<?php

								if($type=="Category")

								{

								$sc=mysqli_query($con,"select * from social_category");	

								while($rsc=mysqli_fetch_array($sc))

								{

								?>

								<option <?php if($stype==$rsc['soc_cat_id']){echo "selected";}?> value="<?php echo $rsc['soc_cat_id']; ?>"><?php echo $rsc['soc_cat_name'];?>

								</option>

								<?php 

								}

								}



								else if($type=="Religion")

								{

								$rl=mysqli_query($con,"select * from religion");	

								while($rrl=mysqli_fetch_array($rl))

								{

								?>

								<option <?php if($stype==$rrl['religion_id']){echo "selected";}?> value="<?php echo $rrl['religion_id']; ?>"><?php echo $rrl['religion_name'];?>

								</option>

								<?php 

								}

								}

								

								else if($type=="Gender")

								{

								?>

								<option <?php if($stype=="MALE"){echo "selected";}?> value="MALE">Male</option>

								<option <?php if($stype=="FEMALE"){echo "selected";}?> value="FEMALE">Female</option>

								<?php 

								}								

								?>	

								</select>

								<script>

								function search_subtype(str)

								{

								var xmlhttp= new XMLHttpRequest();	

								xmlhttp.open("get","search_ajax_subtype.php?type="+str,true);

								xmlhttp.send();

								xmlhttp.onreadystatechange=function()

								{

								if(xmlhttp.status==200  && xmlhttp.readyState==4)

								{

								document.getElementById("search_stype").innerHTML=xmlhttp.responseText;

								}

								} 

								}

								</script>

								</div>

								</div>

								</div>

									

							</div><br>

							<br>

							

							<div class="row">

								<div class="col-md-2" style="margin-left:280px">

								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>

								</div>

								<div class="col-md-2">

								<input type="reset" class="btn btn-info btn-sm" value="Cancel"><br><br>

								</div>

							</div>

							

							<div class="card">

							<?php

							if(isset($search))

							{

							?>

							<div id="chartContainer" style="height:400px; width:100%;margin-left:0px;">

							

							</div>

							<?php

							}

							?>

							<br>

							

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive" >

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Register No</th>

											 <th>Student Name</th>

											 <th>Father Name</th>

											 <th>Class</th>

											 <th>Section</th>
											 <th>Roll no </th>

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
									if(isset($query2)){

									$totalstudents = mysqli_num_rows($query2);

									$tstypestudent = mysqli_num_rows($query);

									$balstu = $totalstudents - $tstypestudent;
									if(mysqli_num_rows($query3)>0){

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
                                    }

									

									?>

									

									<?php

									if($type=="Category")

									{

										$q1 = mysqli_query($con,"select * from social_category where soc_cat_id='$stype'");

										$r1 = mysqli_fetch_array($q1);

										$stypename = $r1['soc_cat_name'];										

									}

									else if($type=="Religion")

									{

										$q2 = mysqli_query($con,"select * from religion where religion_id='$stype'");

										$r2 = mysqli_fetch_array($q2);

										$stypename = $r2['religion_name'];

									}

									else if($type=="Gender")

									{

										$stypename = $stype;

									}

									

									

								 	$dataPoints = array(

											array("label"=> "Others", "y"=> $balstu),

											array("label"=> $stypename, "y"=> $tstypestudent)

											

										);

									

									?>

                                    </tbody>

                                </table>

                            </div>

							

							<div>

							<a href="export_admissionreport_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>&type=<?php echo $type;?>&stype=<?php echo $stype;?>" 

							class="btn btn-success btn-sm" style="margin-left:380px;margin-right:20px"> <i class="fa fa-download"> </i> Download To Excel</a>

							

							<a href="print_admission_report.php?class=<?php echo $class;?>&section=<?php echo $section;?>&type=<?php echo $type;?>&stype=<?php echo $stype;?>" target="_blank"

							class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Print</a>							

							

							</div>

							<br> 

							</div>

							

							

							<div class="row">

							<div class="col-md-10">

							<?php

							if(isset($search))

							{

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

								

								echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'>

								The Total Students from $clsn, Section $sec for $type $stypename is $tstypestudent Students. </h5>";

					

							}

							?>	

							</div>

							</div>

							

                    </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		

	</form>

</div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 

<script>

window.onload = function () {

	

var chart = new CanvasJS.Chart("chartContainer", {

	animationEnabled: true,

	//exportEnabled: true,

	theme: "light2", // "light1", "light2", "dark1", "dark2"

	title:{

		text: "Admission Report"

	},

	data: [{

		type: "pie", //change type to bar, line, area, pie, etc

		//showInLegend: "true",

		legendText: "{label}",

		indexLabelFontSize: 16,

		indexLabel: "{label} - #percent%",

		//yValueFormatString: "฿#,##0", 

		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>

	}]

});

chart.render();

 

}

</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>