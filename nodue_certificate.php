<?php

error_reporting(1);

extract($_REQUEST);

include('connection.php');



$sr=1;

if(isset($_POST['search']))

{

	$cond = '';

	

	if($_POST['class']!='') 

	{

		$cond.=" && class_id='$_REQUEST[class]'";

	}

	if($_POST['section']!='') 

	{

		$cond.=" && section_id='$_REQUEST[section]'";

	}

	if($_POST['student']!='') 

	{

		$cond.=" && student_id='$_REQUEST[student]'";

	}

 $sql="SELECT * FROM `issue_bookto_students` WHERE `return_status`='0' $cond";	

$query =mysqli_query($con,$sql);



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



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Library Management</a>

  <span class="breadcrumb-item active">No Due Certificate</span>

</nav>





   <form method="post" action="dashboard.php?option=nodue_certificate" enctype="multipart/form-data" target="_blank">      

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">

							

                    <div class="col-md-12">

                         

							<div class="row" style="margin-top:20px;">

								<div class="col-md-2" style="margin-left:20px">Class</div>

								<div class="col-md-2">

								<div class="sorting-left">

								<select name="class" class="form-control" style="width:180px" onchange="searchstudent(this.value);search_sec(this.value)" autofocus required>

								<option value="" selected="selected" disabled>Select Class</option>

								<?php

								$scls = "select * from class";

								$rcls = mysqli_query($con, $scls);

								while( $rescls = mysqli_fetch_array($rcls) ) {

								?>

								<option  <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

								</option>

								<?php } ?>							

								</select>

								</div>

								</div>

								

								<div class="col-md-2" style="margin-left:50px;">Section</div>

								<div class="col-md-2">

								<div class="sorting-left">

								<select class="form-control" name="section" id="section" style="margin-left:-50px;width:180px" onchange="searchstudent(this.value);" 

								autofocus required>

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

								xmlhttp.open("get","search_ajax_section_att.php?cls_id="+str,true);

								xmlhttp.send();

								xmlhttp.onreadystatechange=function()

								{

								if(xmlhttp.status==200  && xmlhttp.readyState==4)

								{

								document.getElementById("section").innerHTML=xmlhttp.responseText;

								}

								} 

								}

								

								

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

							</div><br/>

							

							<div class="row" style="margin-top:20px;">

								<div class="col-md-2" style="margin-left:20px;">Student Name</div>

								<div class="col-md-2">

								<div class="sorting-left">

								<select name="student" id="student" style="width:180px" class="form-control" autofocus required>

								<option value="" selected="selected">Select Student</option>

								<?php

								// $qstu = mysqli_query($con,"select * from students where class_id='$class' && section_id='$section' and session='".$_SESSION['session']."'");
								$sql1="select `student_id`,student_name,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  sr.class_id='$class' && sr.section_id='$section' and sr.session='".$_SESSION['session']."' ";
								$qstu=mysqli_query($con,$sql1);

								while($rstu = mysqli_fetch_array($qstu)) {

								?>

								<option  <?php if($student==$rstu['student_id']){echo "selected";}?> value="<?php echo $rstu['student_id']; ?>"><?php echo $rstu['student_name']; ?>

								</option>

								<?php } ?>							

								</select>

								</div>

								</div>

								

								<div class="col-md-2" style="margin-left:80px">

								<div class="sorting-left">

								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>

								</div>

								</div>

							</div><br/>

					

						<div class="card">

							<div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Name</th>

											 <th>Class</th>

											 <th>Section</th>

											 <th>Penalty</th>

											 						 

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

									$sr=1;

									if(isset($query))

									{

										while($res=mysqli_fetch_array($query))

									{
										// echo "<pre>";
										// print_r($_POST);
										// echo "</pre>";

									$id=$res['issue_id'];

									$stuid=$res['student_id'];

									$q1 = mysqli_query($con,"select * from students where student_id='$stuid' and session='".$_SESSION['session']."'");

									$r1 = mysqli_fetch_array($q1);

									$stuname=$r1['student_name'];

									

									$clsid=$res['class_id'];

									$q2 = mysqli_query($con,"select * from class where class_id='$clsid'");

									$r2 = mysqli_fetch_array($q2);

									$classname = $r2['class_name'];

									

									$secid=$res['section_id'];

									$q3 = mysqli_query($con,"select * from section where section_id='$secid'");

									$r3 = mysqli_fetch_array($q3);

									$secname = $r3['section_name'];									

									

									$retdt = $res['return_date'];

									$curdate = date("Y-m-d");

									$date1=date_create($curdate);

									$date2=date_create($retdt);

									$diff=date_diff($date2,$date1);

									$tdays = $diff->format("%R%a days");

																			

									$rettypeid=$res['return_type_id'];

									$q3=mysqli_query($con,"select * from book_return_type where book_return_type_id ='$rettypeid'");

									$r3=mysqli_fetch_array($q3);

									$amt=$r3['book_fine_per_day'];

									

									if($tdays > 0)

									{

										$tpenalty = $tdays * $amt;

									}

									else

									{

										$tpenalty = 0;

									}

									

									$q4 = mysqli_query($con,"select * from library_payment where issue_id='$id'");

									$tpaid = 0;

									while($r4 = mysqli_fetch_array($q4))

									{

										$tpaid += $r4['paid_amount']; 

									}

									$tdue = $tpenalty - $tpaid;

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $stuname; ?></td>

										<td><?php echo $classname; ?></td>

										<td><?php echo $secname; ?></td>

										<td><?php echo $tdue; ?></td>

									</tr>

                                    <?php

									$sr++;

										}

									 } 

									

									?>

									

                                    </tbody>

                                </table>

                            </div>

                        </div>

						

						<div>

						

						<input type="submit" name="certificate" value="Generate Certificate" class="btn btn-warning btn-md" style="margin-left:320px">

						

						</div>

						<br> 

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		<?php

		if(isset($certificate))

		{

			$student = $_REQUEST['student'];

			echo "<script>window.location='print_nodue_certificate.php?class=$class&section=$section&student=$student'</script>";

			

		}

		?>

		

	</form>	

    </div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 <script>

 $(document).ready(function()

 {

	$("#selectall").click(function(){

		if(this.checked)

		{

			$('.checkboxall').each(function(){

				$(".checkboxall").prop('checked', true);				

			})

		}

		else

		{

			$('.checkboxall').each(function(){

				$(".checkboxall").prop('checked', false);

			})

		}

		

	});

 }); 

 </script>