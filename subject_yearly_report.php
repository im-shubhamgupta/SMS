<?php
error_reporting(1);
extract($_REQUEST);

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
  <span class="breadcrumb-item active">Subject Wise Yearly Attendance Report</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=subject_yearly_report" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1200px">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">

						<div class="row" style="margin-top:20px;">	
						
							<div class="col-md-2" style="font-size:14px;margin-left:20px">Class</div>
							<div class="col-md-2" style="margin-left:-100px;margin-top:-10px">
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
							
							<div class="col-md-2" style="font-size:14px;margin-left:20px;">Section </div>
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
								
							
							<div class="col-md-2" style="font-size:14px;margin-left:20px">Student Name </div>
							<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">
							<select class="form-control" name="student" id="student" style="width:175px;margin-left:-50px;" autofocus required>
							<option value="" selected="selected" disabled>Select Student</option>
							<?php
							$qstu=mysqli_query($con,"select * from students where class_id='$class' && section_id='$section'");
							while($rstu=mysqli_fetch_array($qstu))
							{
							?>
							<option <?php if($student==$rstu['student_id']){echo "selected";}?> value="<?php echo $rstu['student_id']; ?>"><?php echo $rstu['student_name'];?>
							</option>
							<?php 
							}
							?>							
							</select>	
							</div>	

							<div class="col-md-2" style="font-size:14px;margin-left:-20px;">Year </div>
							<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">
							<select class="form-control" name="year" style="width:175px;margin-left:-60px;" autofocus required>
							<option value="" selected="selected" disabled>Select Year</option>
							<?php
							$qyear=mysqli_query($con,"select * from year");
							while($ryear=mysqli_fetch_array($qyear))
							{
							?>
							<option <?php if($year==$ryear['year_name']){echo "selected";}?> value="<?php echo $ryear['year_name'];?>"><?php echo $ryear['year_name'];?>
							</option>
							<?php 
							}
							?>							
							</select>
							</div>
							
							
							<div class="col-md-2">
							<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-80px;width:180px;margin-left:10px;" value="Load"><br><br>
							</div>
							
						</div><br>
						
						<!--table starts from here-->
						<div class="card">
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
										<th>Month</th>
										<?php
										$q1 = mysqli_query($con,"select * from subject where class_id='$class'");
										while($r1 = mysqli_fetch_array($q1))
										{
											$subid = $r1['subject_id'];
											$subname = $r1['subject_name'];
										?>
										<th><?php echo $subname;?></th>
										<?php
										}
										?>
										<th>Percentage</th>
                                    </thead>
                                    
									<tbody>
									<tr>
									<?php 
									if(isset($search))
									{
										$yr = "april".$year;
										$start = strtotime($yr);
										for ($i = 0; $i <= 11; $i++) 
										{
										$time = strtotime(sprintf('+%d months', $i), $start);
										$label = date('F Y', $time);
										$month = date('m', $time);
										$year = date('Y', $time);
									
									$qatt = mysqli_query($con,"select * from subjectwise_attendance where student_id='$student' && subject_id='' && month(date)='$month' && year(date)='$year'");
																		
										$totalrow = mysqli_num_rows($qatt);
										$present=0;
										$absent=0;
										$leave=0;
										$monthlypercent=0;
										while($res = mysqli_fetch_array($qatt))
										{
											$attendance = $res['type_of_attend'];
											if($attendance==1)
											{
												$present = $present+1;
											}
											else if($attendance==2)
											{
												$absent = $absent+1;
											}
											else if($attendance==3)
											{
												$leave = $leave+1;
											}
										
										}
										
										$totalpresent = $present+$leave;
										$monthlypercent = round($totalpresent/$totalrow*100,2)." %";
									?>
									<td><?php echo $label; ?></td>
									<td><?php echo $totalpresent."/".$totalrow; ?></td>
									<td><?php echo $monthlypercent; ?></td>
									
									</tr>
									<?php
									$totalpresentyear = $totalpresentyear+$totalpresent;
									$totalrowyear = $totalrowyear+$totalrow;
									$totalpercentageyear = round($totalpresentyear/$totalrowyear*100,2)." %";
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
	if(isset($search))
	{	
	echo "<p style='font-size:18px;color:black;padding:10px;'> Total Percentage : $totalpercentageyear</p>";
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
		</div>
		
	</form>	
    </div><!-- /#right-panel -->
 <?php //include('bootstrap_datatable_javascript_library.php'); ?>
 
 