<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);

	$class = $_REQUEST['class'];
	$section = $_REQUEST['section'];
	$range = $_REQUEST['range'];
    $r1 = $_REQUEST['r1'];
    $r2 = $_REQUEST['r2'];
	$nextpay = $_REQUEST['nextpay'];
	
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
	
	
	if($range==1)
	{
		
		if($class!="" and $section!="" and $nextpay!="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where class_id='$class' and section_id='$section' and month(b.month)='$nextpay' and a.due < '$r1'";
		$search_result = filterTable($query);
		}
		
		else if($class!="" and $section!="" and $nextpay=="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where class_id='$class' and section_id='$section' and a.due < '$r1'";					
		$search_result = filterTable($query);
		}
		
		else if($class!="" and $section=="" and $nextpay=="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where class_id='$class' and a.due < '$r1'";					
		$search_result = filterTable($query);
		}
		
		else if($class!="" and $section=="" and $nextpay!="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where class_id='$class' and a.due < '$r1' and month(b.month)='$nextpay'";					
		$search_result = filterTable($query);
		}
		
		else if($class=="" and $section=="" and $nextpay!="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where a.due < '$r1' and month(b.month)='$nextpay'";
		$search_result = filterTable($query);
		}
		
		else if($class=="" and $section=="" and $nextpay=="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where a.due < '$r1'";
		$search_result = filterTable($query);
		}
		
	}
	
	else if($range==2) 
	{
	
		if($class!="" and $section!="" and $nextpay!="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where class_id='$class' and section_id='$section' and month(b.month)='$nextpay' and a.due > '$r1'";
		$search_result = filterTable($query);
		}
		
		else if($class!="" and $section!="" and $nextpay=="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where class_id='$class' and section_id='$section' and a.due > '$r1'";					
		$search_result = filterTable($query);
		}
		
		else if($class!="" and $section=="" and $nextpay=="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where class_id='$class' and a.due > '$r1'";					
		$search_result = filterTable($query);
		}
		
		else if($class!="" and $section=="" and $nextpay!="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where class_id='$class' and a.due > '$r1' and month(b.month)='$nextpay'";					
		$search_result = filterTable($query);
		}
		
		else if($class=="" and $section=="" and $nextpay!="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where a.due > '$r1' and month(b.month)='$nextpay'";
		$search_result = filterTable($query);
		}
		
		else if($class=="" and $section=="" and $nextpay=="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where a.due > '$r1'";
		$search_result = filterTable($query);
		}
	}
	
	else if($range==3) 
	{
		
		if($class!="" and $section!="" and $nextpay!="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where class_id='$class' and section_id='$section' and month(b.month)='$nextpay' and a.due between '$r1' and '$r2'";
		$search_result = filterTable($query);
		}
		
		else if($class!="" and $section!="" and $nextpay=="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where class_id='$class' and section_id='$section' and a.due between '$r1' and '$r2'";					
		$search_result = filterTable($query);
		}
		
		else if($class!="" and $section=="" and $nextpay!="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where class_id='$class' and month(b.month)='$nextpay' and a.due between '$r1' and '$r2'";					
		$search_result = filterTable($query);
		}
		
		else if($class!="" and $section=="" and $nextpay=="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where class_id='$class' and a.due between '$r1' and '$r2'";					
		$search_result = filterTable($query);
		}
		
		else if($class=="" and $section=="" and $nextpay!="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where  a.due between '$r1' and '$r2' and month(b.month)='$nextpay'";
		$search_result = filterTable($query);
		}
		
		else if($class=="" and $section=="" and $nextpay=="")
		{
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.class_id, a.section_id, a.due,
				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.month
				from students a
				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount
				where a.due between '$r1' and '$r2'";
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
   <form method="post" action="dashboard.php?option=duestudents_report" enctype="multipart/form-data">      
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
								echo "<h3 align='center'>Due Students Report for    $clsn ,Section $sec &nbsp; $show Rs: $r1 </h3>" ;
								
						}
						else if($r==2)
						{
								$show= "Greater Than";
								echo "<h3 align='center'>Due Students Report for    $clsn ,Section $sec &nbsp; $show Rs: $r1 </h3>" ;
						}
						else if($r==3)
						{
								$show= "Between";
								echo "<h3 align='center'>Due Students Report for    $clsn ,Section $sec &nbsp; $show Rs: $r1 to $r2 </h3>" ;
						}
						else{
								echo "<h3 align='center'>Due Students Report for    $clsn ,Section $sec </h3>" ;
						
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
											 <th>Class</th>
											 <th>Section</th>
											 <th>Total Paid</th>
											 <th>Total Due</th>
											 <th>Last Paid Date</th>
											 <th>Next Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									while($res=mysqli_fetch_array($search_result))
									{
										$stuid=$res['student_id'];
										$stuname=$res['student_name'];
										$regno=$res['register_no'];
										$fname=$res['father_name'];
										$due=$res['due'];
										$npay=$res['month'];
										if($npay)
										{
											$mont = date("m", strtotime($npay));
										
											$months=mysqli_query($con,"select * from months where month_id='$mont'");
											$rmonths=mysqli_fetch_array($months);
											$rmon=$rmonths['month_name'];
										}
										else
										{
											$rmon = "";
										}
										
										$cid=$res['class_id'];
										$que1=mysqli_query($con,"select * from class where class_id='$cid'");
										$res1=mysqli_fetch_array($que1);
										
										$sectid=$res['section_id'];
										$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");
										$rsec=mysqli_fetch_array($qsec);
																				
										$qbill=mysqli_query($con,"select * from student_due_fees where student_id='$stuid'");
										$rowbill=mysqli_num_rows($qbill);
											
											if($rowbill)
											{	
												$tpaidamt1 = 0;
												$trans = 0;
												while($b=mysqli_fetch_array($qbill))	
												{	
												$recdamt=$b['received_amount'];
												$tranamt=$b['transport_amount'];
												$arr = explode(',',$recdamt);
												
												foreach($arr as $k)
												{
												 $tpaidamt1 = $tpaidamt1 + $k;
												}
												
												$trans = $trans + $tranamt;
												$tpaidamt = $tpaidamt1 + $trans;
												$issdt=$res['issue_date'];
												$chgdate = date('d-m-y h:i:s',strtotime($issdt));
												}
																					
											}
											else
											{
												$tpaidamt = 0;
												$trans = 0;
												$chgdate="";
											}
									
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $stuname; ?></td>
										<td><?php echo $regno; ?></td>
										<td><?php echo "Mr&nbsp;".$fname; ?></td>
										<td><?php echo $res1['class_name']; ?></td>
										<td><?php echo $rsec['section_name']; ?></td>
										<td><?php echo $tpaidamt;?></td>								
										<td><?php echo $due;?></td>								
										<td><?php echo $chgdate;?></td>							
										<td><?php echo $rmon;?></td>										
									</tr>
									
                                    <?php
									$sr++;	
									$tdue =$tdue + $due; 
									}
									?>
									
                                    </tbody>
                                </table>
                            </div>
                        </div>
						
						
							
						<div class="row">
						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">
						<?php 
						
						echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total Due amount for the Selected   $clsn ,Section $sec &nbsp; is : Rs $tdue </h5>" ;
						
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
		
		
		<a href="dashboard.php?option=duestudents_report" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:18px">Back</a>
		</div>
		
	</form>	
    </div><!-- /#right-panel -->

 