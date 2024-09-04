<?php

//error_reporting(1);

include('connection.php');

extract($_REQUEST);
// echo "<pre>";
// print_r($_REQUEST);
// echo "</pre>";


?> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Data Analysis</a>

  <a class="breadcrumb-item" href="#">Student Analysis</a>

  <span class="breadcrumb-item active">Exam Analysis</span>

</nav>



	<form method="post" action="dashboard.php?option=exam_analysis" enctype="multipart/form-data">

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                                 

							<div class="row" style="margin-top:20px;">

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-2" style="margin-left:80px;">Class</div>

								<div class="col-md-5" style="margin-left:70px;">

								<select name="class" id="class" class="form-control" onchange="searchstudent(this.value);search_sec(this.value)" autofocus required>

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

								<select class="form-control" name="section" id="search_sect" onchange="searchstudent(this.value); searchtest(this.value)" autofocus required>

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

								

								function searchtest(str)

								{

								var clsid = $('#class').val();

								var xmlhttp= new XMLHttpRequest();	

								xmlhttp.open("get","search_ajax_test.php?sec_id="+str+"&cls_id="+clsid,true);

								xmlhttp.send();

								xmlhttp.onreadystatechange=function()

								{

								if(xmlhttp.status==200  && xmlhttp.readyState==4)

								{

								document.getElementById("search_test").innerHTML=xmlhttp.responseText;

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

								<div class="col-md-4">Select Exam</div>

								<div class="col-md-6" style="margin-left:0px;">

								

								<select name="test[]" id="search_test" multiple class="form-control" autofocus required>

								<option value="" selected="selected" disabled>Select</option>

								<?php

								$qtest=mysqli_query($con,"select distinct(test_name) from test where class_id='$class' && section_id='$section'");

								while($rtest=mysqli_fetch_array($qtest))

								{

								?>

								<option <?php if($test==$rtest['test_name']){echo "selected";}?> value="<?php echo $rtest['test_name']; ?>"><?php echo $rtest['test_name'];?>

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

								$testarr = $test;

								$ttest = count($test);

																	

								$q1 = mysqli_query($con,"select * from subject where class_id='$class'");

								while($r1 = mysqli_fetch_array($q1))

								{ 

								$subarr[] = $r1['subject_id'];

								$subnamearr[] = $r1['subject_name'];

								}

								

									$l=0;

									foreach($subarr as $k)

									{

										$terimalSequence=1;

										foreach($testarr as $terminal)

										{

											if(!count(${'marks'.$terimalSequence}))

											{

											    ${'marks'.$terimalSequence}=array();

											}

											$queryMarks=mysqli_query($con,"select * from marks where test_name='$terminal' && student_id='$student' && subject_id='$k'");

											$rmark1 = mysqli_fetch_array($queryMarks);

											array_push(${'marks'.$terimalSequence}, array("label" => $subnamearr[$l], "y" => $rmark1['marks']));

											

											$terimalSequence++;

										}

									

									$l++;

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

												

								echo "<h6>Total Selected Tests : $ttest</h6>";



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

					text: "Exam Analysis"

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

				data: [

					<?php

				    $terimalSequence=1;

				    foreach($testarr as $terminal)

					{

					?>

				    { 

					type: "column", 

					name: "<?=$terminal?>", 

					legendText: "<?=$terminal?>", 

					showInLegend: true, 

					dataPoints:<?php echo json_encode(${'marks'.$terimalSequence}, 

							JSON_NUMERIC_CHECK); ?>			

					},

					<?php

					$terimalSequence++;

					

					}

					?>

				] 

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