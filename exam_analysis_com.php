<?php
//error_reporting(1);
include('connection.php');
extract($_REQUEST);

?> 

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Data Analysis</a>
  <a class="breadcrumb-item" href="#">Student Analysis</a>
  <span class="breadcrumb-item active">Exam Analysis</span>
</nav>

	<form method="post" action="dashboard.php?option=exam_analysis_org1" enctype="multipart/form-data">
        <div class="content mt-3" style="width:1000px;">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                                 
							<div class="row" style="margin-top:20px;">
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-2" style="margin-left:80px;">Class</div>
								<div class="col-md-5" style="margin-left:70px;">
								<select name="class" class="form-control" onchange="search_sec(this.value)" autofocus required>
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
								$qstu=mysqli_query($con,"select * from students where class_id='$class' && section_id='$section'");
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
								
								<select name="test[]" multiple class="form-control" autofocus required>
								<option value="" selected="selected" disabled>Select</option>
								<?php
								$qtest=mysqli_query($con,"select * from test");
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
								$dataPoints1 = array();
								$dataPoints2 = array();							
									
								$q1 = mysqli_query($con,"select * from subject where class_id='$class'");
								while($r1 = mysqli_fetch_array($q1))
								{ 
								$subarr[] = $r1['subject_id'];
								$subnamearr[] = $r1['subject_name'];
								}
									foreach($subarr as $k)
									{
										$mark1 = mysqli_query($con,"select * from marks where test_name='Ist Internal Test' && student_id='$student' && subject_id='$k'");
										$rmark1 = mysqli_fetch_array($mark1);
										$onemarks[] = $rmark1['marks'];
										
										$mark2 = mysqli_query($con,"select * from marks where test_name='2nd Internal Test' && student_id='$student' && subject_id='$k'");
										$rmark2 = mysqli_fetch_array($mark2);
										$twomarks[] = $rmark2['marks'];
									}
									
										$tsub = count($subarr);
										for($i=0;$i<$tsub;$i++)
										{
											array_push($dataPoints1, array("label" => $subnamearr[$i], "y" => $onemarks[$i])); 
											array_push($dataPoints2, array("label" => $subnamearr[$i], "y" => $twomarks[$i])); 
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
				data: [{ 
					type: "column", 
					name: "First Internal Test", 
					legendText: "First Internal Test", 
					showInLegend: true, 
					dataPoints:<?php echo json_encode($dataPoints1, 
							JSON_NUMERIC_CHECK); ?>			
				},
				{ 
					type: "column", 
					name: "Second Internal Test", 
					legendText: "Second Internal Test", 
					showInLegend: true, 
					dataPoints:<?php echo json_encode($dataPoints2, 
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