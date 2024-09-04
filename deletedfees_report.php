<?php

error_reporting(1);

extract($_REQUEST);



if(isset($_POST['search']))

{

	

    $class = $_POST['class'];

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

	

    $section = $_POST['section'];

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

	$query="select * from student_due_fees where class_id='$class' and section_id='$section' and status=4 and session ='".$_SESSION['session']."'";	

	

	$search_result = filterTable($query);

    }

	

	else if($class!="" and $section=="")

	{

	$query="select * from student_due_fees where class_id='$class' and status=4 and session ='".$_SESSION['session']."'";					

	$search_result = filterTable($query);

    }

	

	else if($class=="" and $section=="")

	{

	$query="select * from student_due_fees where status=4 and session ='".$_SESSION['session']."'";					

	$search_result = filterTable($query);

    }

		

}





// function to connect and execute the query

function filterTable($query)

{

	include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}



?>



<div id="right-panel" class="right-panel">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Report Panel</a>

  <a class="breadcrumb-item" href="#">Fee Report</a>

  <span class="breadcrumb-item active">Deleted Fees Report</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=deletedfees_report" enctype="multipart/form-data">      

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						

						<div class="row" style="margin-top:20px;">	

						

							<div class="col-md-2" style="margin-left:20px;">Class</div>

							<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">

							

							<select name="class" class="form-control" onchange="search_sec(this.value)" style="width:175px;" autofocus>

							<option value="" selected="selected">All</option>

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

							

							<div class="col-md-1"></div>

											

							<div class="col-md-2" style="font-size:14px;">Section </div>

							<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">

							<select class="form-control" name="section" id="search_sect" style="width:175px;">

							<option value="" selected="selected">All</option>

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

							

							<div class="col-md-2">

							<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;width:120px;margin-left:50px;" value="Submit"><br><br>

							</div>

							

						</div><br/>

						

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

                                             <th>Receipt No</th>

											 <th>Name</th>

											 <th>Father Name</th>

											 <th>Class</th>

											 <th>Section</th>

											 <th>Amount</th>

											 <th>Deleted Date</th>

											 <th>Reason</th>

											 <th>Action</th>

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

									if(isset($search))

									{

									$sr=1;

									$gtotal = 0;

									while($res1=mysqli_fetch_array($search_result))

										{									

										

									$logid=$res1['student_due_fee_id'];

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

									

									$totalamt=$res1['total_amount'];

									$act_dt = $res1['action_date'];

									$nactdt = date("d-m-Y",strtotime($act_dt));

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $logid; ?></td>

										<td><?php echo $res2['student_name']; ?></td>

										<td><?php echo "Mr&nbsp;".$res2['father_name']; ?></td>

										<td><?php echo $rcls['class_name']; ?></td>

										<td><?php echo $rsec['section_name']; ?></td>

										<td><?php echo $totalamt;?></td>	

										<td><?php echo $nactdt;?></td>	

										<td><?php echo $res1['reason'];?></td>	

										<td><?php echo "<a href='reprint_deleted_receipt.php?id=$logid' class='btn btn-outline-success btn-sm' title='Print Deleted Receipt'>Print</a>";?></td>

									</tr>

									

                                    <?php

									$sr++;									

										}

										$gtotal = $gtotal + $totalamt;

										}

									}

									?>

									

                                    </tbody>

                                </table>

                            </div>

                        </div>

						

						<div class="row">

						<div class="col-md-10">

						<?php 

						if(isset($search))

						{

						echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total deleted amount from $clsn , $sec &nbsp;Section is : Rs $gtotal. </h5>";

						}

						?>

						</div>						

						</div><br>

						

						

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		<!--

		<div style="text-align:center">

		<style>

			

		@media print{

		#printbtn{

		display: block;

				}

			}

		</style>

		

		<a href="print_discountedfee.php?class=<?php echo $class;?>&section=<?php echo $section;?>" class="btn btn-primary btn-sm" style="margin-left:20px;"><i class="fa fa-print"></i> Print</a>

		

		<a href="export_discountedfee_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>" class="btn btn-success btn-sm" style="margin-left:20px;"><i class="fa fa-download"></i> Download To Excel</a>

		

		<a href="dashboard.php?option=discountedfees_report" class="btn btn-info btn-sm" style="margin-left:20px;"><i class='fa fa-arrow-left'> </i> Back</a>

			

		</div>-->

		

	</form>	

    </div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 