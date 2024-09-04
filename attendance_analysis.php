<?php

//error_reporting(1);

include('connection.php');

extract($_REQUEST);



?> 



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Data Analysis</a>

  <a class="breadcrumb-item" href="#">Student Analysis</a>

  <span class="breadcrumb-item active">Attendance Analysis</span>

</nav>



	<form method="post" action="dashboard.php?option=attendance_analysis" enctype="multipart/form-data">

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                                 

							<div class="row" style="margin-top:20px;">

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-2" style="margin-left:80px;">Class</div>

								<div class="col-md-5" style="margin-left:70px;">

								<select name="class" class="form-control" onchange="search_sec(this.value); searchstudent(this.value);" autofocus required>

								<option value="" selected="selected" disabled >Select</option>

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

								<div class="col-md-6" style="margin-left:30px;">

								<select class="form-control" name="section" id="search_sect" onchange="searchstudent(this.value)" autofocus required>

								<option value="" selected disabled>Select</option>

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

								xmlhttp.open("get","search_ajax_section_report.php?cls_id="+str,true);

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

								function searchstudent(str)

								{

								var xmlhttp= new XMLHttpRequest();	

								xmlhttp.open("get","search_ajax_student_report.php?sec_id="+str,true);

								xmlhttp.send();

								xmlhttp.onreadystatechange=function()

								{

								if(xmlhttp.status==200  && xmlhttp.readyState==4)

								{

								document.getElementById("student").innerHTML=xmlhttp.responseText;

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

								<div class="col-md-4" style="margin-left:80px;">Select Student</div>

								<div class="col-md-5">

								

								<select class="form-control" name="student" id="student" autofocus required>

								<option value="" selected="selected" disabled>Select</option>

								<?php

								// $qstu=mysqli_query($con,"select * from students where class_id='$class' && section_id='$section'");
								$sql1="select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' and sr.class_id='$class' && sr.section_id='$section' and sr.session='".$_SESSION['session']."'";
								$qstu=mysqli_query($con,$sql1);

								while($rstu=mysqli_fetch_array($qstu))

								{

								?>

								<option <?php if($student==$rstu['student_id']){echo "selected";}?> value="<?php echo $rstu['student_id']; ?>"><?php echo $rstu['student_name'];?>

								</option>

								<?php 

								}

								?>							

								</select>	

							

								</div>

								</div>

								</div>

								

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-4">Select Month</div>

								<div class="col-md-6" style="margin-left:0px;">

								

								<select name="month[]" multiple class="form-control" autofocus required>

								<option value="" selected="selected" disabled>Select</option>

								<?php

								$qstu=mysqli_query($con,"select * from months");

								while($rstu=mysqli_fetch_array($qstu))

								{

								?>

								<option <?php if(in_array($month)==$rstu['month_id']){echo "selected";}?> value="<?php echo $rstu['month_id']; ?>"><?php echo $rstu['month_name'];?>

								</option>

								<?php 

								}

								?>		

								</select>

																

								</div>

								</div>

								</div>

									

							</div><br>

							<br>

							

							<div class="row">

								<div class="col-md-2" style="margin-left:280px">

								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Analysis"><br><br>

								</div>

								<div class="col-md-2">

								<input type="reset" class="btn btn-info btn-sm" value="Cancel"><br><br><br>

								</div>

							</div>

							

							<div class="card">

							<div class="card-body">

							<?php

							if(isset($search))

							{

								$monarr = $month;

								$tmonth = count($monarr);

								$dataPoints1 = array();							

								$dataPoints2 = array();							

								$dataPoints3 = array();							

								$monname = array();

								

									foreach($monarr as $k)

									{

									$qmon = mysqli_query($con,"select * from months where month_id='$k'");

									$rmon = mysqli_fetch_array($qmon);

									

									$monname[] = $rmon['short_name'];

									

									$qatt1 = mysqli_query($con,"select * from student_daily_attendance where month(date)='$k' && student_id='$student' && type_of_attend='1'");

									$qatt2 = mysqli_query($con,"select * from student_daily_attendance where month(date)='$k' && student_id='$student' && type_of_attend='2'");

									$qatt3 = mysqli_query($con,"select * from student_daily_attendance where month(date)='$k' && student_id='$student' && type_of_attend='3'");

									$present[]=mysqli_num_rows($qatt1);//present

									$absent[]=mysqli_num_rows($qatt2);//absent

									$leave[]=mysqli_num_rows($qatt3);//leave     

									}

									

									for($i=0;$i<$tmonth;$i++)

									{

										array_push($dataPoints1, array("label" => $monname[$i], "y" => $present[$i])); 

										array_push($dataPoints2, array("label" => $monname[$i], "y" => $absent[$i])); 

										array_push($dataPoints3, array("label" => $monname[$i], "y" => $leave[$i])); 

									} 

								

									

								?>

								<div id="chartContainer" style="height:300px; width:100%;">

								

								</div>

								<br>

							<?php

							}

							?>

							<br> 

							</div>

							</div>

							

							

							<div class="row">

							<div class="col-md-10">

							<?php

							if(isset($search))

							{

								$firstmon = reset($monarr);

								$lastmon = end($monarr);

								$present=0;

								$absent=0;

								$leave=0;

								$query = mysqli_query($con,"select * from student_daily_attendance where (student_id='$student') && (month(date) between '$firstmon' and '$lastmon')");

								$rowcount=mysqli_num_rows($query);

								if($rowcount>0)

								{

								while($r1 = mysqli_fetch_array($query))

								{

									$attend=$r1['type_of_attend'];

									 if($attend==1)

									 {

										 $present=$present+1; 

									 }

									 else if($attend==2)

									 {

										 $absent=$absent+1;

									 }

									 else if($attend==3)

									 {

										 $leave=$leave+1;

									 }

								}

									$present_per = round($present/$rowcount*100,2)."%";

									$absent_per = round($absent/$rowcount*100,2)."%";

									$leave_per = round($leave/$rowcount*100,2)."%";

								}

								else

								{	

									echo "<script>alert('Selected months attendance are not taken')</script>";

									

									$present_per = 0 ."%";

									$absent_per = 0 ."%";

									$leave_per = 0 ."%";

								}

								

																

								echo "<h6>Total Selected Month : $tmonth</h6>";

								echo "<h6>Total Attendance Percentage : $present_per</h6>";

								echo "<h6>Total Absent Percentage :  $absent_per</h6>";

								echo "<h6>Total Leave Percentage : $leave_per</h6>";

								

							}

							?>	

							</div>

							</div>

							

                    </div>

                    </div>

                </div>

            </div><!-- .animated -->

       

	</form>

</div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

<script> 

		window.onload = function () { 

		

			var chart = new CanvasJS.Chart("chartContainer", { 

				animationEnabled: true, 

				title:{ 

					text: "Attendance Analysis"

				},				

				/*axisY: { 

					title: "Purchased", 

					titleFontColor: "#4F81BC", 

					lineColor: "#4F81BC", 

					labelFontColor: "#4F81BC", 

					tickColor: "#4F81BC"

				}, 

				axisY2: { 

					title: "Sold", 

					titleFontColor: "#C0504E", 

					lineColor: "#C0504E", 

					labelFontColor: "#C0504E", 

					tickColor: "#C0504E"

				},*/	 

				toolTip: { 

					shared: true 

				}, 

				legend: { 

					cursor:"pointer", 

					itemclick: toggleDataSeries 

				}, 

				data: [{ 

					type: "column", 

					name: "Present", 

					legendText: "Present", 

					showInLegend: true, 

					dataPoints:<?php echo json_encode($dataPoints1, 

							JSON_NUMERIC_CHECK); ?>			

				}, 

				{ 

					type: "column",	 

					name: "Absent", 

					legendText: "Absent", 

					//axisYType: "secondary", 

					showInLegend: true, 

					dataPoints:<?php echo json_encode($dataPoints2, 

							JSON_NUMERIC_CHECK); ?> 

				}, 

				{ 

					type: "column",	 

					name: "Leave", 

					legendText: "Leave", 

					//axisYType: "secondary", 

					showInLegend: true, 

					dataPoints:<?php echo json_encode($dataPoints3, 

							JSON_NUMERIC_CHECK); ?> 

				}] 

			}); 

			chart.render(); 

			

			function toggleDataSeries(e) { 

				if (typeof(e.dataSeries.visible) === "undefined"

							|| e.dataSeries.visible) { 

					e.dataSeries.visible = false; 

				} 

				else { 

					e.dataSeries.visible = true; 

				} 

				chart.render(); 

			} 

		

		} 

	</script>

	



<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>