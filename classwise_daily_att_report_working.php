<?php

error_reporting(1);

extract($_REQUEST);

if(isset($search))

{	



	$query="select distinct(a.student_id),b.student_name from student_daily_attendance a inner join students b on a.student_id=b.student_id where (a.class_id='$class' && a.section_id='$section') && (date between '$fromdt' and '$todt') && session='".$_SESSION['session']."'";

	$search_result = filterTable($query);

	

}





// function to connect and execute the query

	function filterTable($query)

	{

		include('connection.php');

		$filter_Result = mysqli_query($con, $query);

		return $filter_Result;

	}	

	



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

<style>

.breadcrumb {

    display: -ms-flexbox;

    display: flex;

    -ms-flex-wrap: wrap;

    flex-wrap: wrap;

    padding: .75rem 1rem;

    margin-bottom: 1rem;

    list-style: none;

	margin-left:-18px;

	margin-top:-17px;

    background-color: #237791;

    border-radius: .25rem;

	font-size:19px;

}

.breadcrumb-item{

	color:#fff;

}

.breadcrumb-item .fa fa-home{

	color:#fff;

}

.breadcrumb-item.active {

    color: #eff7ff;

}

.breadcrumb-item+.breadcrumb-item::before {

    display: inline-block;

    padding-right: .5rem;

    color: #eff4f9;

    content: "/";

} 



</style>

<nav class="breadcrumb" style="width:1200px">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Attendance Report</a>

  <span class="breadcrumb-item active">Class Wise Daily Attendance Report</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=classwise_daily_att_report" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">



						<div class="row" style="margin-top:20px;">	

						

							<div class="col-md-2" style="font-size:14px;margin-left:20px;">Class</div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px">

							<select name="class" class="form-control" onchange="search_sec(this.value)" style="width:175px;" autofocus required>

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

							

							<div class="col-md-2" style="font-size:14px;margin-left:10px;margin-left:40px;">Section </div>

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

							<div class="col-md-2" style="font-size:14px;margin-left:20px;">From Date </div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px;">

							<input type="date" name="fromdt" class="form-control" style="width:175px;" value="<?php echo $fromdt; ?>" autofocus required>

							</div>

							

							<div class="col-md-2" style="font-size:14px;margin-left:40px;">To Date</div>

							<div class="col-md-2" style="margin-left:-100px;margin-top:-10px">

							<input type="date" name="todt" class="form-control" style="width:175px;" value="<?php echo $todt; ?>" autofocus required>

							</div>

													

							

							<div class="col-md-2">

							<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-80px;width:180px;margin-left:50px;" value="Load"><br><br>

							</div>

							

						</div><br>

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

										<th>Sl. No.</th>

										<th>Name</th>

										<?php

										if($search)

										{

											

											for($i=$fromdt; $i<=$todt; $i++)

											{

												$newdt[] = date("d-m-Y",strtotime($i));

											}

										foreach($newdt as $val)

										{

										?>

										<th><?php echo $val; ?></th>

										

										<?php

										}

										}

										?>

										<th>Attendance Percentage</th>

                                    </thead>

                                    <tbody>

									<?php

									$i=1;

									while($res1=mysqli_fetch_array($search_result))

									{

									 $stuid=$res1['student_id'];

									 $stuname=$res1['student_name'];

									 

									?>

									<tr>

									<td><?php echo $i; ?></td>

									<td><?php echo $stuname; ?></td>

									

									<?php

									$rowcount=0;

									$present=0;

									$absent=0;

									$leave=0;

									foreach($newdt as $k)

									{

										$ndate = date("Y-m-d",strtotime($k));

										$query4=mysqli_query($con,"select * from student_daily_attendance where student_id='$stuid' && date='$ndate' && session='".$_SESSION['session']."'");

										

										if(mysqli_num_rows($query4))

										{

										$rowcount=$rowcount+1;

										}								

										

										$res4 = mysqli_fetch_array($query4);

										$attend = $res4['type_of_attend'];

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

										 

										$queatt=mysqli_query($con,"select * from attendance_type where att_type_id='$attend'");

										$ratt=mysqli_fetch_array($queatt);

										$attname=$ratt['short_name'];

									?>

									

									<td><?php echo $attname; ?></td>

									<?php

									}

									$att_percentage = round(($present+$leave)/$rowcount*100,2)." %";

									

									?>

									

									<td><?php echo $att_percentage; ?></td>

									</tr>

									<?php

									$i++;

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

	

	echo "<p style='font-size:18px;line-height:30px;color:black;padding:10px;'>

			Attendance Taken : $rowcount Days<br/>

		  </p>";

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



			<a href="print_classwise_daily_att_report.php?class=<?php echo $class;?>&section=<?php echo $section;?>&fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>" style="margin-left:20px;" class="btn btn-primary">Print</a>

		

			<a href="export_classwise_daily_att_report_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>&fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>" style="margin-left:20px;" class="btn btn-success">Download To Excel</a>





		</div>

		

	</form>	

    </div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 