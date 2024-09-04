<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);

$class = $_REQUEST['class'];
$section = $_REQUEST['section'];
$fromdt = $_REQUEST['fromdt'];
$todt = $_REQUEST['todt'];

	$query="select distinct(a.student_id),b.student_name from student_daily_attendance a inner join students b on a.student_id=b.student_id where (a.class_id='$class' && a.section_id='$section') && (date between '$fromdt' and '$todt')";
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
   <form method="post" action="dashboard.php?option=classwise_daily_att_report" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						<div class="row">
						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">
						<h3 align='center'>Class Wise Daily Attendance Report</h3>
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
										$query4=mysqli_query($con,"select * from student_daily_attendance where student_id='$stuid' && date='$ndate'");
										
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
						
						echo "<p style='font-size:18px;line-height:30px;color:black;padding:10px;'>
						Attendance Taken : $rowcount Days<br/>
						</p>";
						
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
		
		
		<a href="dashboard.php?option=classwise_daily_att_report" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:18px">Back</a>
		</div>
		
	</form>	
    </div><!-- /#right-panel -->

 