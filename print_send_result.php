<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



$class = $_REQUEST['class'];

$qc = mysqli_query($con,"select * from class where class_id='$class'");

$rc = mysqli_fetch_array($qc);

$clsname = $rc['class_name'];



$section = $_REQUEST['section'];

$qs = mysqli_query($con,"select * from section where section_id='$section'");

$rs = mysqli_fetch_array($qs);

$secname = $rs['section_name'];



//$test = $_REQUEST['test'];

		

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

   <form method="post" action="dashboard.php?option=send_result" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

								<h3 align="center">Result For Class <?php echo $clsname; ?> Section <?php echo $secname; ?> </h3>

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                             <th>Sl No.</th>

											 <th>Student Name</th>

											 <th>Parent Name</th>

											 <th>Register No</th>

											<?php

											$que = mysqli_query($con,"select * from test where class_id='$class' && section_id='$section' && test_name='$test'  && session='".$_SESSION['session']."'");

											 while($rque = mysqli_fetch_array($que))

											 {

												 $subid = $rque['subject_id'];

												 $subidarr[] = $rque['subject_id'];

												 $sque = mysqli_query($con,"select * from subject where subject_id='$subid'");

												 $rque = mysqli_fetch_array($sque);

											 ?>

											 <th><?php echo $rque['subject_name'];?></th>

											 <?php 

											 }

											 ?>

											 <th>Grade</th>

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

							// $que2 = mysqli_query($con,"select * from students where class_id='$class' && section_id='$section'  && session='".$_SESSION['session']."'");
							$que2 = mysqli_query($con,"select `student_id`,`register_no`,`student_name`,`father_name`,`parent_no`,`msg_type_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class' && sr.section_id='$section' && s.stu_status='0' && sr.session='".$_SESSION['session']."' ");

							$i=1;								

							while($res2=mysqli_fetch_array($que2))

							{									

							$stuid = $res2['student_id'];

							$stuname = $res2['student_name'];					

							$fathername = $res2['father_name'];					

							$regno = $res2['register_no'];					

							?>

							<tr>

							<td><?php echo $i; ?></td>

							<td><?php echo $stuname; ?></td>

							<input type="hidden" name="studid[]" value="<?php echo $stuid;?>">

							<td><?php echo $fathername;?></td>	

							<td><?php echo $regno;?></td>	

							<?php 

							$total = 0;

							$totalmarks = 0;

							$percent = 0;

							foreach($subidarr as $v)

							{

							$que3 = mysqli_query($con,"select * from marks where class_id='$class' && section_id='$section' && test_name='$test' && subject_id='$v' && student_id='$stuid'  && session='".$_SESSION['session']."' ");

							$res3 = mysqli_fetch_array($que3);

							$stumarks = $res3['marks'];

							if($stumarks)

							{

								$marks = $stumarks;

							}

							else

							{

								$marks = 0;

							}

							$tmarks = $res3['max_mark'];

							?>

							<td><?php echo $marks;?></td>

							<?php

							$total = $total+$marks;

							$totalmarks = $totalmarks+$tmarks;

							$percent = round($total/$totalmarks*100,2);

							

							$que4 = mysqli_query($con,"select * from grade where (condition1 <='$percent' && condition2 >='$percent')");

							

							$row = mysqli_num_rows($que4);

							if($row)

							{

								$res4 = mysqli_fetch_array($que4);

								$gr = $res4['grade_name'];

							}

							

							}

							?>

							<td><?php echo $gr;?></td>	

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

		display: none;

				}

			}

		</style>

		

		

		<button id="printbtn" class="btn btn-primary btn-md" onclick="window.print();" style="margin-top:20px;">print</button>

		

		

		<a href="dashboard.php?option=send_result" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:18px">Back</a>

		

		</div>

		

	</form>	

    </div><!-- /#right-panel -->



 