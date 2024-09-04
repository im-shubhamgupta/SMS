<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);

date_default_timezone_set("Asia/Kolkata");

$curdate = date("Y-m-d");



if(isset($search)){
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";  



	$curdate = $_REQUEST['curdate'];

	

	$cond = '';

	

	if($_POST['class']!='')

	{

		$cond.=" && sdt.class_id='$_REQUEST[class]'";
		$cond.=" && sr.class_id='$_REQUEST[class]'";

	}

	if($_POST['section']!='')

	{

		$cond.=" && sdt.section_id='$_REQUEST[section]'";
		$cond.=" && sr.section_id='$_REQUEST[section]'";

	}	

	// echo $cond;
	 $sql="select sdt.student_id,sdt.class_id,sdt.section_id,sr.roll_no from student_daily_attendance as sdt join student_records as sr  ON `sdt`.`student_id`= `sr`.`stu_id`  where sdt.date='$curdate' && sdt.type_of_attend='2' $cond and sr.session='".$_SESSION['session']."' ";

	 $sql.=" order by roll_no asc ";

	$query=mysqli_query($con,$sql);



}else{
   	// $sql="select * from student_daily_attendance where date='$curdate' && type_of_attend='2'";
   	 $sql="select sdt.student_id,sdt.class_id,sdt.section_id,sr.roll_no from student_daily_attendance as sdt join student_records as sr  ON `sdt`.`student_id`= `sr`.`stu_id`  where sdt.date='$curdate' && sdt.type_of_attend='2' ";
	 $sql.=" and sr.session='".$_SESSION['session']."' order by roll_no asc ";
   	 

$query=mysqli_query($con,$sql);

}
	
?>



	<style>




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



<nav class="breadcrumb" style="width:1000px">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Attendence Panel</a>

  <a class="breadcrumb-item" href="#"> Student Attendance</a>

  <span class="breadcrumb-item active">Today Absentee List</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=today_absentee_list" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">



						<div class="row" style="margin-top:20px;">	

						

							<div class="col-md-2" style="font-size:14px;margin-left:20px;">Class</div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px">

							<select name="class" class="form-select" onchange="search_sec(this.value)" style="width:180px;">

							<option value="">All</option>

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

							

							<div class="col-md-2" style="margin-left:80px;">Section </div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px">

							<select class="form-select" name="section" id="search_sect" onchange="searchstudent(this.value)"  style="width:175px;">

							<option value="" selected="selected" >All</option>

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

							<div class="col-md-2" style="font-size:14px;margin-left:20px;">Date </div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px;">

							<input type="date" name="curdate" class="form-control" style="width:180px;" 

							value="<?php echo $curdate; ?>" autofocus required>

							</div>

							

							

							<div class="col-md-2" style="margin-left:125px;margin-top:-10px">

							<input type="submit" name="search" class="btn btn-primary btn-sm" style="width:120px;margin-left:40px;" value="Load"><br><br>

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

										<th>Class</th>

										<th>Section</th>
										<th>Roll no.</th>

										<th>Father Name</th>

										<th>Father Contact</th>

                                    </thead>

                                    <tbody>

									<?php

									$i=1;

									while($res=mysqli_fetch_array($query))

									{

									 $stuid=$res['student_id'];

									 

									 $q1 = mysqli_query($con,"select `student_name`,`father_name`,`parent_no` from students where student_id='$stuid'");

									 $r1 = mysqli_fetch_array($q1);

									 $stuname = $r1['student_name'];

									 $fathername = $r1['father_name'];

									 $fathermob = $r1['parent_no'];

									 

									 $clsid=$res['class_id'];

									 $q2 = mysqli_query($con,"select * from class where class_id='$clsid'");

									 $r2 = mysqli_fetch_array($q2);

									 $clsname = $r2['class_name'];

									 

									 $secid=$res['section_id'];

									 $q3 = mysqli_query($con,"select * from section where section_id='$secid'");

									 $r3 = mysqli_fetch_array($q3);

									 $secname = $r3['section_name'];

									 

									?>

									<tr>

									<td><?php echo $i; ?></td>

									<td><?php echo $stuname; ?></td>

									<td><?php echo $clsname; ?></td>

									<td><?php echo $secname; ?></td>
									<td><?=($res['roll_no']) ? $res['roll_no'] : '0' ;?></td>

									<td><?php echo $fathername; ?></td>

									<td><?php echo $fathermob; ?></td>

									</tr>

									<?php

									$i++;

									}									

									?>		

                                    </tbody>

                                </table>

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

		display: block;

				}

			}

		</style>



			<a href="export_today_absentee_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>&curdate=<?php echo $curdate;?>" style="margin-left:20px;" class="btn btn-success btn-sm">

			<i class="fa fa-download"></i> Download To Excel</a>



		</div>

		

	</form>	

    </div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 