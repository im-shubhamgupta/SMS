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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	
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
  <a class="breadcrumb-item" href="#">Student Panel</a>
  <a class="breadcrumb-item" href="#">Exam & Result</a>
  <span class="breadcrumb-item active">View Report</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=view_report" id="devel-generate-content-form" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						<div class="row" style="margin-top:20px;">	
						
							<div class="col-md-2" style="margin-left:20px;">Class</div>
							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px">
							<select name="class" id="class" class="form-control" onchange="search_sec(this.value)" style="width:195px;" autofocus required>
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
							
							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Section </div>
							<div class="col-md-2" style="margin-left:-110px;margin-top:-10px">
							<select class="form-control" name="section" id="search_sect" onchange="searchtest(this.value)"   style="width:195px;" autofocus required>
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
							</div>
							<script>
							function searchtest(str)
							{
							var clsid = $('#class').val();
							//alert(clsid);
							var xmlhttp= new XMLHttpRequest();	
							xmlhttp.open("get","search_ajax_test.php?sec_id="+str+"&cls_id="+clsid,true);
							xmlhttp.send();
							xmlhttp.onreadystatechange=function()
							{
							if(xmlhttp.status==200  && xmlhttp.readyState==4)
							{
							document.getElementById("search_test").innerHTML=xmlhttp.responseText;
							}
							} 
							}
							</script>	
						</div><br><br>
                     
						<div class="row" style="margin-top:20px;">
							<div class="col-md-2" style="margin-left:20px;">Test Name </div>
							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px;">
							<select class="form-control" name="test" id="search_test" onchange="searchsub(this.value)"
							style="width:195px;" autofocus required>				
							<option value="" selected="selected" disabled>Select Test</option>
							<?php
							$quet = mysqli_query($con,"select distinct(test_name) from test where class_id='$class' && section_id='$section'");
							while( $rtest= mysqli_fetch_array($quet) ) {
							?>
							<option <?php if($test==$rtest['test_name']){echo "selected";}?> value="<?php echo $rtest['test_name']; ?>"><?php echo $rtest['test_name']; ?>
							</option>
							<?php } ?>	
							</select>
							</div>							
							<script>
							function searchsub(str)
							{
							var clsid = $('#class').val();
							var secid = $('#search_sect').val();
							//alert(secid);
							var xmlhttp = new XMLHttpRequest();
							xmlhttp.open("get","search_ajax_testsub.php?clsid="+clsid+"&secid="+secid+"&testname="+str,true);
							xmlhttp.send();
							xmlhttp.onreadystatechange=function()
							{
							if(xmlhttp.status==200 && xmlhttp.readyState==4)
							{
							document.getElementById("search_sub").innerHTML=xmlhttp.responseText;	
							}									
							}
							}
							</script>

							<div class="col-md-2">
							<input type="submit" name="load" class="btn btn-primary btn-sm" style="margin-top:-10px;width:120px;margin-left:142px;" value="Load"><br><br>
							</div>
						</div><br>
								
						<!--table starts from here-->
						
						<?php
						if(isset($load))
						{
							$q1 = mysqli_query($con,"select * from subject where class_id='$class'");
							$subjectrow = mysqli_num_rows($q1);
							
							$q2 = mysqli_query($con,"select distinct(subject_id) from marks where class_id='$class' && section_id='$section' && test_name='$test'");
							$marksrow=mysqli_num_rows($q2);
												
						?>	
						<div class="card">
						<div class="card-body" style="width:1100px">
						<h6>MARKS REPORT</h6><br>
					    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
							<thead>
								<tr>
									 <th>Sl No.</th>
									 <th>Student Name</th>
									 <?php
									 $que = mysqli_query($con,"select distinct(subject_id) from marks where class_id='$class' && section_id='$section' && test_name='$test'");
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
									 <th>Total</th>
									 <th>Percent</th>
									 <th>Grade</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							$que2 = mysqli_query($con,"select distinct(student_id) from marks where class_id='$class' && section_id='$section' && test_name='$test'");
							$i=1;							
							while($res2=mysqli_fetch_array($que2))
							{									
							$stuid = $res2['student_id'];
							$que3 = mysqli_query($con,"select * from students where student_id='$stuid'");
							$res3 = mysqli_fetch_array($que3);
							$stuname = $res3['student_name'];					
							?>
							<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $stuname; ?></td>
							<input type="hidden" name="studid[]" value="<?php echo $stuid;?>">
							
							<?php 
							$total = 0;
							$totalmarks = 0;
							$percent = 1;
							foreach($subidarr as $v)
							{
							$que3 = mysqli_query($con,"select * from marks where class_id='$class' && section_id='$section' && test_name='$test' && subject_id='$v' && student_id='$stuid'");
							$res3 = mysqli_fetch_array($que3);
							$marks = $res3['marks'];
							$tmarks = $res3['max_mark'];
							?>
							<td><?php echo $marks;?></td>
							<?php
							$total = $total+$marks;
							$totalmarks = $totalmarks+$tmarks;
							$percent = round($total/$totalmarks*100,2);
							
							$que4 = mysqli_query($con,"select * from grade where condition1 <='$percent' && condition2 >='$percent'");
							
							$row = mysqli_num_rows($que4);
							if($row)
							{
								$res4 = mysqli_fetch_array($que4);
								$gr = $res4['grade_name'];
							}
							
							}
							?>
							<td><?php echo $total." / ".$totalmarks;?></td>	
							<td><?php echo $percent." %";?></td>	
							<td><?php echo $gr;?></td>	
							</tr>
							<?php
							$i++;
							}
							?>					
						 	</tbody>
						 </table>
						 </div>	
						 </div><br><br>
						 		
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
				 
						<?php
						}
						?>								
                         
	</form>	
    </div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 