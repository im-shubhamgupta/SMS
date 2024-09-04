<?php

error_reporting(1);

extract($_REQUEST);



?>



	<style>

	tr th{

		

		font-size:11px;

	}



	tr td{

		

		font-size:11px;

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

<div id="right-panel" class="right-panel">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Attendance Report</a>

  <span class="breadcrumb-item active">Yearly Report</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=yearly_report" enctype="multipart/form-data">      

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">



						<div class="row" style="margin-top:20px;">	

						

							<div class="col-md-2" style="font-size:14px;margin-left:20px">Class</div>

							<div class="col-md-2" style="margin-left:-100px;margin-top:-10px">

							<select name="class" class="form-control" onchange="searchstudent(this.value);search_sec(this.value)" style="width:175px;" autofocus required>

							<option value="" selected="selected" disabled>Select Class</option>

							<?php

							$scls = "select * from class";

							$rcls = mysqli_query($con, $scls);

							while( $rescls = mysqli_fetch_array($rcls) ) {

							?>

							<option <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

							</option>

							<?php } ?>							

							</select>

							</div>

							

							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Section </div>

							<div class="col-md-2" style="margin-left:-100px;margin-top:-10px">

							<select class="form-control" name="section" id="search_sect" onchange="searchstudent(this.value)"   style="width:175px;" autofocus required>

							<option value="" selected="selected" disabled>Select Section</option>

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

							</div>

							

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

													

						</div><br>

						

												

                        <div class="row" style="margin-top:20px;">

								

							

							<div class="col-md-2" style="font-size:14px;margin-left:20px">Student</div>

							<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">

							<select class="form-control" name="student" id="student" style="width:175px;margin-left:-50px;" autofocus required>

							<option value="" selected="selected" disabled>Select Student</option>

							<?php
							 $ysql="select `student_id`,`student_name` from students as s join student_records as sr on s.student_id=sr.stu_id where sr.class_id='$class' && sr.section_id='$section' && sr.session='".$_SESSION['session']."'";					
							$qstu=mysqli_query($con,$ysql);

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



							<div class="col-md-2">

							<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;width:120px;margin-left:80px;" value="Load"><br><br>

							</div>

							

						</div><br>

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

										<th>Month</th>

										<th>Present</th>

										<th>Percentage</th>

                                    </thead>

                                    

									<tbody>

									<tr>

									<?php 

									if(isset($search))

									{

										// $q1 = mysqli_query($con,"select * from academic_year");

										// $r1 = mysqli_fetch_array($q1);

										// $year = $r1['acd_year_start'];
										$year=getSessionByid($_SESSION['session'])['only_year'];
											


										$yr = "april".$year;

										$start = strtotime($yr);

										for ($i = 0; $i <= 11; $i++) 

										{

										$time = strtotime(sprintf('+%d months', $i), $start);

										$label = date('F Y', $time);

										$month = date('m', $time);

										$year = date('Y', $time);

									

										$qatt = mysqli_query($con,"select * from student_daily_attendance where student_id='$student' && month(date)='$month' && year(date)='$year'");

																		

										$totalrow = mysqli_num_rows($qatt);

										$present=0;

										$absent=0;

										$leave=0;

										$monthlypercent=0;

										while($res = mysqli_fetch_array($qatt))

										{

											$attendance = $res['type_of_attend'];

											if($attendance==1)

											{

												$present = $present+1;

											}

											else if($attendance==2)

											{

												$absent = $absent+1;

											}

											else if($attendance==3)

											{

												$leave = $leave+1;

											}

										

										}

										

										$totalpresent = $present+$leave;
										if($totalrow > 0){
										    $monthlypercent = round($totalpresent/$totalrow*100,2)." %";
									    }

									?>

									<td><?php echo $label; ?></td>

									<td><?php echo $totalpresent."/".$totalrow; ?></td>

									<td><?php echo $monthlypercent; ?></td>

									

									</tr>

									<?php

									$totalpresentyear = $totalpresentyear+$totalpresent;

									$totalrowyear = $totalrowyear+$totalrow;

									if($totalrowyear > 0){

									    $totalpercentageyear = round($totalpresentyear/$totalrowyear*100,2)." %";
								    }
										}	

									

									}

																			

									?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

					

	<div class="row">

	<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">

	<?php 

	if(isset($search))

	{	

	echo "<p style='font-size:18px;color:black;padding:10px;'> Total Percentage : $totalpercentageyear</p>";

	}

	?>

	</div>						

	</div><br>

						

						

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		<div style="text-align:center">

		<style>

			

		@media print{

		#printbtn{

		display: block;

				}

			}

		</style>

		

			<a href="export_yearly_att_report_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>&student=<?php echo $student;?>" style="margin-left:20px;" class="btn btn-success">

			<i class="fa fa-download"></i> Download To Excel</a>

		

		</div>

		

	</form>	

    </div><!-- /#right-panel -->

 <?php //include('bootstrap_datatable_javascript_library.php'); ?>

 

 