<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);

$class = $_REQUEST['class'];
$section = $_REQUEST['section'];
$subject = $_REQUEST['subject'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];

	$query="select distinct(a.student_id),a.register_no,b.student_name from subjectwise_attendance a inner join students b on a.student_id=b.student_id where a.class_id='$class' && a.section_id='$section' && a.subject_id='$subject' && 
	month(date)='$month' && year(date)='$year'";
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
   <form method="post" action="dashboard.php?option=subjectwise_att_report" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						<div class="row">
						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">
						<h3 align='center'>Subject Wise Attendance Report</h3>
						</div>						
						</div><br>
						
						<!--table starts from here-->
						<div class="card">
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                         <th>Sl. No.</th>
										<th>Register No</th>
										<th>Name</th>
										<?php
										if($month)
										{
										$start_date = "01-".$month."-".$year;
										$start_time = strtotime($start_date);

										$end_time = strtotime("+1 month", $start_time);

										for($i=$start_time; $i<$end_time; $i+=86400)
										{
										   $list[] = date('d-m-Y', $i);
										}

										//print_r($list);
										foreach($list as $k)
										{
										?>
										<th><?php echo $k;?></th>
										<?php
										}
										}
										?>	
										<th>Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$i=1;
									while($res1=mysqli_fetch_array($search_result))
									{
									 $student=$res1['student_id'];
									?>
									<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $res1['register_no']; ?></td>
									<td><?php echo $res1['student_name']; ?></td>
								
									<?php
									$rowcount=0;
									$trow=0;
									foreach($list as $k)
									{
									$trow=$trow+1;	
									$ndate=date("Y-m-d",strtotime($k));
									$query4=mysqli_query($con,"select * from subjectwise_attendance where student_id='$student' && subject_id='$subject' && date='$ndate'");
									
									if(mysqli_num_rows($query4))
									{
									$rowcount=$rowcount+1;
									}
									
									$trow=cal_days_in_month(CAL_GREGORIAN,$month,$year);
									
									$res4=mysqli_fetch_array($query4);									
									$attend=$res4['type_of_attend'];
									$queatt=mysqli_query($con,"select * from attendance_type where att_type_id='$attend'");
									$ratt=mysqli_fetch_array($queatt);
									$attname=$ratt['short_name'];
									?>
									<td><?php echo $attname; ?></td>
									<?php
									}
									$percent = round($rowcount/$trow*100,2);
									?>
									<td><?php echo $percent." %"; ?></td>
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
						
						echo "<p style='font-size:18px;color:black;padding:10px;boder-radius:10px;'> Attendance Taken : $rowcount Days  </p>" ;
						
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

 