<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



	$class = $_REQUEST['class'];

	$c=mysqli_query($con,"select * from class where class_id='$class'");

	$rc=mysqli_fetch_array($c);

	$cls=$rc['class_name'];

	if($cls)

	{

		$clsn=$cls;

	}else

	{

		$clsn='Class All';

	}

	

    $section = $_REQUEST['section'];

    $s=mysqli_query($con,"select * from section where section_id='$section'");

	$rs=mysqli_fetch_array($s);

	$se=$rs['section_name'];

	if($se)

	{

		$sec=$se;

	}else

	{

		$sec='All';

	}

	

	if($class!="" and $section!="")

	{

	$query="select * from student_wise_fees where class_id='$class' and section_id='$section' and discount_amount>0 and session ='".$_SESSION['session']."' ";	

	

	$search_result = filterTable($query);

    }

	

	else if($class!="" and $section=="")

	{

	$query="select * from student_wise_fees where class_id='$class' and discount_amount>0 and session ='".$_SESSION['session']."' ";					

	$search_result = filterTable($query);

    }

	

	else if($class=="" and $section=="")

	{

	$query="select * from student_wise_fees where discount_amount>0 and session ='".$_SESSION['session']."' ";					

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

   <form method="post" action="dashboard.php?option=discountedfees_report" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

								<h3 align="center">Paid Students For The <?php echo $clsn; ?> for Section <?php echo $sec; ?> </h3>

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Name</th>

											 <th>Reg No</th>

											 <th>Father Name</th>

											 <th>Class</th>

											 <th>Section</th>

											 <th>Fee Discount</th>

											 <th>Reason</th>

									    </tr>

                                    </thead>

                                    <tbody>

									<?php 

									$sr=1;

									$gtotal = 0;

									while($res1=mysqli_fetch_array($search_result))

										{									

										

									$stuid=$res1['student_id'];

									

									// $que2=mysqli_query($con,"select * from students where student_id='$stuid' and stu_status='0'");
									$sql1="select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' and student_id='$stuid' and sr.session='".$_SESSION['session']."'";
									$que2=mysqli_query($con,$sql1);

									while($res2=mysqli_fetch_array($que2))

									{

									

									$cid=$res2['class_id'];

									$qcls=mysqli_query($con,"select * from class where class_id='$cid'");

									$rcls=mysqli_fetch_array($qcls);

									

									$sectid=$res2['section_id'];

									$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");

									$rsec=mysqli_fetch_array($qsec);

									

									$discount_amt=$res1['discount_amount'];

									$reason=$res1['reason'];

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $res2['student_name']; ?></td>

										<td><?php echo $res2['register_no']; ?></td>

										<td><?php echo "Mr&nbsp;".$res2['father_name']; ?></td>

										<td><?php echo $rcls['class_name']; ?></td>

										<td><?php echo $rsec['section_name']; ?></td>

										<td><?php echo $discount_amt;?></td>

										<td><?php echo $reason;?></td>	

									</tr>

									

                                    <?php

									$sr++;									

										}

										$gtotal = $gtotal + $discount_amt;

										}

									?>

									

                                    </tbody>

                                </table>

                            </div>

                        </div>

						

						<div class="row">

						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">

						<?php 

						

						echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total discounted amount from $clsn , $sec &nbsp;Section is : Rs $gtotal. </h5>";

						

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

		display: none;

				}

			}

		</style>

		

		

		<button id="printbtn" class="btn btn-primary btn-md" onclick="window.print();" style="margin-top:20px;">print</button>

		

		

		<a href="dashboard.php?option=discountedfees_report" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:18px">Back</a>

		

		</div>

		

	</form>	

    </div><!-- /#right-panel -->



 