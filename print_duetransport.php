<?php

//error_reporting(1);

include('connection.php');

extract($_REQUEST);



	$class = $_REQUEST['class'];

	$section = $_REQUEST['section'];

	$range = $_REQUEST['range'];

    $r1 = $_REQUEST['r1'];

    $r2 = $_REQUEST['r2'];

	

	$class = $_REQUEST['class'];

	$c=mysqli_query($con,"select * from class where class_id='$class'");

	$rc=mysqli_fetch_array($c);

	$cls=$rc['class_name'];

	if($cls)

	{

		$clsn=$cls;

	}

	else

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

	

		

	// if($range==1)

	// {

	// 	if($class!="" and $section!="")

	// 	{		

	// 	$query="select * from student_route where class_id='$class' and section_id='$section' and due_amount > 0 and due_amount < '$r1'";

	// 	$search_result = filterTable($query);

	// 	}

				

	// 	else if($class!="" and $section=="")

	// 	{

	// 	$query="select * from student_route where class_id='$class' and due_amount > 0 and due_amount < '$r1'";					

	// 	$search_result = filterTable($query);

	// 	}

			

	// 	else if($class=="" and $section=="")

	// 	{

	// 	$query="select * from student_route where due_amount > 0 and due_amount < '$r1'";

	// 	$search_result = filterTable($query);

	// 	}

		

	// }

	

	// else if($range==2)

	// {

		

	// 	if($class!="" and $section!="")

	// 	{

	// 	$query="select * from student_route where class_id='$class' and section_id='$section' and due_amount > '$r1'";			

	// 	$search_result = filterTable($query);

	// 	}

				

	// 	else if($class!="" and $section=="")

	// 	{

	// 	$query="select * from student_route where class_id='$class' and due_amount > '$r1'";					

	// 	$search_result = filterTable($query);

	// 	}

			

	// 	else if($class=="" and $section=="")

	// 	{

	// 	$query="select * from student_route where due_amount > '$r1'";

	// 	$search_result = filterTable($query);

	// 	}

		

	// }

	

	// else if($range==3)

	// {

		

	// 	if($class!="" and $section!="")

	// 	{

	// 	$query="select * from student_route where class_id='$class' and section_id='$section' and due_amount between '$r1' and '$r2'";			

	// 	$search_result = filterTable($query);

	// 	}

				

	// 	else if($class!="" and $section=="")

	// 	{

	// 	$query="select * from student_route where class_id='$class' and due_amount between '$r1' and '$r2'";					

	// 	$search_result = filterTable($query);

	// 	}

			

	// 	else if($class=="" and $section=="")

	// 	{

	// 	$query="select * from student_route where due_amount between '$r1' and '$r2'";

	// 	$search_result = filterTable($query);

	// 	}

		

	// }
		if($class!="" and $section!=""){

		$query="select * from student_route where class_id='$class' and section_id='$section' ";			

	

		}	

		else if($class!="" and $section=="")

		{

		$query="select * from student_route where class_id='$class' ";					

 
		}

		else if($class=="" and $section=="")

		{

		$query="select * from student_route where 1 ";
 
		}

		

	
	if(!empty($range)){
		if($range==1){
			$query.=" and due_amount > 0 and due_amount < '$r1'";

		}elseif($range==2){
			$query.="  and due_amount > 0 and due_amount > '$r1' ";
		}elseif($range==3){
			$query.=" and due_amount between '$r1' and '$r2' ";

		}
	}

	// echo $query;
	$query.=" and session='".$_SESSION['session']."' ";

	$search_result = filterTable($query);

	

	

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

   <form method="post" action="dashboard.php?option=due_transport_report" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						<div class="row">

						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">

						<?php 

						

						$r=$range;

						if($r==1)

						{

								$show= "Less Than";

								echo "<h3 align='center'>Due Transport Report for    $clsn ,Section $sec &nbsp; $show Rs: $r1 </h3>" ;

								

						}

						else if($r==2)

						{

								$show= "Greater Than";

								echo "<h3 align='center'>Due Transport Report for    $clsn ,Section $sec &nbsp; $show Rs: $r1 </h3>" ;

						}

						else if($r==3)

						{

								$show= "Between";

								echo "<h3 align='center'>Due Transport Report for    $clsn ,Section $sec &nbsp; $show Rs: $r1 to $r2 </h3>" ;

						}

						else{

								echo "<h3 align='center'>Due Transport Report for   $clsn ,Section $sec </h3>" ;

						

						}

						

						

						?>

						</div>						

						</div><br>

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                              <th>Sr. No</th>

											 <th>Name</th>

											 <th>Reg No</th>

											 <th>Father Name</th>

											 <th>Parent Contact</th>

											 <th>Class</th>

											 <th>Section</th>

											 <th>Transport Fee</th>

											 <th>Previous Transport Fee</th>

											 <th>Total Fee</th>

											 <th>Total Discount</th>

											 <th>Total Paid</th>

											 <th>Total Due</th>

											 <th>Last Paid Date</th>

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

									$sr=1;
									if(mysqli_num_rows($search_result)>0){
									while($res=mysqli_fetch_array($search_result))

									{



										$stuid=$res['student_id'];

										// $q1 = mysqli_query($con,"select * from students where student_id='$stuid' and session='".$_SESSION['session']."'");
										$q1=mysqli_query($con,"select `student_id`,`register_no`,`student_name`,father_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$stuid' && stu_status='0'  && sr.session='".$_SESSION['session']."'");
										if(mysqli_num_rows($q1)>0){
										$r1 = mysqli_fetch_array($q1);

										$stuname=$r1['student_name'];

										$regno=$r1['register_no'];

										$fname=$r1['father_name'];

										$parentno=$r1['parent_no'];

										

										$cid=$res['class_id'];

										$qcls=mysqli_query($con,"select * from class where class_id='$cid'");

										$rcls=mysqli_fetch_array($qcls);

										

										$sectid=$res['section_id'];

										$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");

										$rsec=mysqli_fetch_array($qsec);

																		

										$due=$res['due_amount'];

										$transid=$res['trans_id'];

										$qtd = mysqli_query($con,"select * from transports where trans_id ='$transid'");

										$rtd = mysqli_fetch_array($qtd);

										$transamt = $rtd['price'];

										$totaldiscount = $res['discount'];

										

										$qp = mysqli_query($con,"select * from previous_transport_fees where student_id ='$stuid'  and session='".$_SESSION['session']."'");

										$rp = mysqli_fetch_array($qp);

										

										if(mysqli_num_rows($qp))

										{

											$prevamt = $rp['previous_transport_fees'];

										}

										else

										{

											$prevamt = 0;

										}

										

										$totalfee = $transamt + $prevamt;

										

										$qt = mysqli_query($con,"select * from student_transport_due_fees where student_id ='$stuid' and status!='2' and status!='4' and session='".$_SESSION['session']."' ");

										$transfeepaid = 0;

										$prevfeepaid = 0;

										while($rt = mysqli_fetch_array($qt))

										{

										$transfeepaid += $rt['trans_amount'];

										$prevfeepaid += $rt['previous_trans_amount'];

										$issdt=$rt['issue_date'];	

										}

										

										if($issdt){

											$chgedate = date('d-m-Y h:i:s',strtotime($issdt));	

										}

										else

										{

											$chgedate = " ";

										}

										

										$tfeepaid = $transfeepaid + $prevfeepaid;

																																													

																					

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $stuname; ?></td>

										<td><?php echo $regno; ?></td>

										<td><?php echo "Mr&nbsp;".$fname; ?></td>

										<td><?php echo $parentno; ?></td>

										<td><?php echo $rcls['class_name']; ?></td>

										<td><?php echo $rsec['section_name']; ?></td>

										<td><?php echo $transamt; ?></td>

										<td><?php echo $prevamt; ?></td>

										<td><?php echo $totalfee; ?></td>

										<td><?php echo $totaldiscount; ?></td>

										<td><?php echo $tfeepaid;?></td>								

										<td><?php echo $due;?></td>								

										<td><?php echo $chgedate;?></td>																

									</tr>

									

                                    <?php

									$sr++;	

									$tdue = $tdue + $due; 

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

						

						echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total Due Transport amount for the Selected   $clsn ,Section $sec &nbsp; is : Rs $tdue </h5>" ;

						

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

		

		

		<a href="dashboard.php?option=due_transport_report" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:18px">Back</a>

		</div>

		

	</form>	

    </div><!-- /#right-panel -->



 