<?php
error_reporting(1);
extract($_REQUEST);
include('connection.php');


if(isset($_POST['search']))
{
	
	$cond = '';
	
	if($_POST['class']!='') 
	{
		$cond.="class_id='$_REQUEST[class]'";
	}
	if($_POST['section']!='') 
	{
		$cond.=" && section_id='$_REQUEST[section]'";
	}
	if($_POST['faculty']!='') 
	{
		$cond.=" && staff_id='$_REQUEST[faculty]'";
	}
	if($_POST['subject']!='') 
	{
		$cond.=" && subject_id='$_REQUEST[subject]'";
	}

	$cond.=" && session='".$_SESSION['session']."' ";

	$sql="select * from assign_syllabus_staff where 1 and $cond";
	$query = mysqli_query($con,$sql);
									
}

?>
<style>

/* Media Query  */
@media only screen and (max-width: 600px)
{
	.col-md-3{
		width:400px;
		
	}
	
}

</style>


<div id="right-panel" class=" right-panel">
<nav class="breadcrumb" style="width:1000px;">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Staff Panel</a>
  <a class="breadcrumb-item" href="#">Syllabus Management</a>  
  <span class="breadcrumb-item active">View Syllabus Allocation Chart</span>
</nav>

	<form method="post" action="dashboard.php?option=view_syllabus_allocation_chart" enctype="multipart/form-data">
        <div class="content mt-3" style="width:1000px;">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                          	
							<div class="row" style="margin-top:20px;">
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-2" style="margin-left:80px;">Class</div>
								<div class="col-md-5" style="margin-left:20px;">
								<select name="class" id="class" class="form-control" onchange="search_sec(this.value)">
								<option value="" selected="selected" disabled >Select Class</option>
								<?php
								$scls =  mysqli_query($con,"select * from class");
								while( $rescls = mysqli_fetch_array($scls) ) {
								?>
								<option  <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>
								</option>
								<?php } ?>							
								</select>
								</div>
								</div>
								</div>
								
								<script>
								function search_sec(str)
								{
								// document.getElementById("search_subj").innerHTML="";	
								var xmlhttp= new XMLHttpRequest();	
								xmlhttp.open("get","search_ajax_section_withoutall.php?cls_id="+str,true);
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

								<div class="col-md-5">
								<div class="row">
								<div class="col-md-3">Section</div>
								<div class="col-md-6" style="margin-left:20px;">
								<select class="form-control" name="section" id="search_sect">
								<option value="" selected disabled>Select Section</option>
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
								</div>
								</div>
							</div>
							
		
							<div class="row" style="margin-top:20px;">
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-2" style="margin-left:80px;">Staff</div>
								<div class="col-md-5" style="margin-left:20px;">
								<select name="faculty" class="form-control" onchange="search_subject(this.value)" autofocus required>
								<option value="" selected="selected" disabled >Select Staff</option>
								<?php
								$squ = "select * from staff where status='1'";
								$rsqu = mysqli_query($con, $squ);
								while( $resst = mysqli_fetch_array($rsqu) ) {
								?>
								<option <?php if($faculty==$resst['st_id']){echo "selected";}?> value="<?php echo $resst['st_id']; ?>"><?php echo $resst['staff_name']; ?>
								</option>
								<?php } ?>	
								</select>
								</div>
								</div>
								</div>

								<script>
								function search_subject(str)
								{
								var xmlhttp= new XMLHttpRequest();
								var clid = document.getElementById("class").value;
								var secid = document.getElementById("search_sect").value;
								xmlhttp.open("get","search_ajax_assigned_subject_staff.php?secid="+secid+"&clid="+clid+"&stid="+str,true);
								xmlhttp.send();
								xmlhttp.onreadystatechange=function()
								{
								if(xmlhttp.status==200  && xmlhttp.readyState==4)
								{
								document.getElementById("search_subj").innerHTML=xmlhttp.responseText;
								}
								} 
								}
								</script>
								
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-3">Subject</div>
								<div class="col-md-6" style="margin-left:20px;">
								<select name="subject" class="form-control" name="subject" id="search_subj" autofocus required>
								<option value="" selected="selected" disabled >Select Subject</option>
								<?php
								$qsub =  mysqli_query($con,"select * from subject");
								while( $rsub = mysqli_fetch_array($qsub) ) {
								?>
								<option  <?php if($subject==$rsub['subject_id']){echo "selected";}?> value="<?php echo $rsub['subject_id']; ?>"><?php echo $rsub['subject_name']; ?>
								</option>
								<?php } ?>	
								</select>
								</div>
								</div>
								</div>
									
							</div><br>
							<br>
							
							<div class="row">
								<div class="col-md-2" style="margin-left:280px">
								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>
								</div>
								<div class="col-md-2">
								<input type="reset" class="btn btn-info btn-sm" value="Cancel"><br><br>
								</div>
							</div>
							
			
							<div class="card">
							<?php
							if(isset($search))
							{
							?>
							<div id="chartContainer" style="height:400px; width:100%;margin-left:0px;">
							
							</div>
							<?php
							}
							?>
							<br>
							<div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Staff</th>
											 <th>Class</th>
											 <th>Section</th>
											 <th>Subject</th>
											 <th>Chapter</th>
											 <th>From</th>
											 <th>To</th>
											 <th>Days</th>
											 <th>Description</th>
											 <th>Status</th>
											 <th>Completion Date</th>
											 <th>Updated Date</th>
											 <th>Updated By</th>
											 <th>Comments</th>
										</tr>
                                    </thead>
                                    <tbody>
									
									<?php 
									// $totalrow = 
									if(isset($query)){
									// if(mysqli_num_rows($query)>0){
									$sr=1;
									while($res=mysqli_fetch_array($query))
									{									
									$staffid=$res['staff_id'];
									$qst=mysqli_query($con,"select * from staff where st_id='$staffid'");
									$rst=mysqli_fetch_array($qst);
									$stname=$rst['staff_name'];
									
									$clid=$res['class_id'];
									$qcls=mysqli_query($con,"select * from class where class_id='$clid'");
									$rcls=mysqli_fetch_array($qcls);
									$clsname=$rcls['class_name'];
									
									$secid=$res['section_id'];
									$qsec=mysqli_query($con,"select * from section where section_id='$secid'");
									$rsec=mysqli_fetch_array($qsec);
									$secname=$rsec['section_name'];
									
									$subid=$res['subject_id'];
									$qsub=mysqli_query($con,"select * from subject where subject_id='$subid'");
									$rsub=mysqli_fetch_array($qsub);
									$subname=$rsub['subject_name'];
									
									$frmdt = $res['from_dt'];
									$nfrmdt = date("d-m-Y",strtotime($frmdt));
	
									$todt = $res['to_dt'];
									$ntodt = date("d-m-Y",strtotime($todt));
									
									$sta = $res['status'];
									if($sta==1)
									{
										$st = "Done";
									}
									else if($sta==2)
									{
										$st = "In Progress";
									}
									else if($sta==3)
									{
										$st = "Not Started";
									}
									
									$comp_dt = $res['completion_date'];
									if(!empty($comp_dt)){
										$ncomp_dt = date("d-m-Y",strtotime($comp_dt));
									}else{
										$ncomp_dt = '';
									}
									
									
									$updt_dt = $res['updated_dt'];
									if(!empty($updt_dt)){
										$nupdt_dt = date("d-m-Y",strtotime($updt_dt));
									}else{
										$nupdt_dt ='';	
									}
									
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $stname; ?></td>
										<td><?php echo $clsname; ?></td>
										<td><?php echo $secname; ?></td>
										<td><?php echo $subname;?></td>										
										<td><?php echo $res['chapter'];?></td>										
										<td><?php echo $nfrmdt;?></td>										
										<td><?php echo $ntodt;?></td>										
										<td><?php echo $res['days'];?></td>										
										<td><?php echo $res['description'];?></td>										
										<td><?php echo $st;?></td>										
										<td><?php echo $ncomp_dt;?></td>										
										<td><?php echo $nupdt_dt;?></td>										
										<td><?php echo $res['updated_by'];?></td>										
										<td><?php echo $res['comments'];?></td>	
									</tr>
                                    <?php 
									$sr++;
									}}

									if(isset($_POST['search'])){
	
									 $sql2="select * from assign_syllabus_staff where 1 and $cond && status=1 ";
									$q1 = mysqli_query($con,$sql2);
									$r1 = mysqli_num_rows($q1);
									
									$q2 = mysqli_query($con,"select * from assign_syllabus_staff where  1 and $cond && status=2 ");
									$r2 = mysqli_num_rows($q2);
									
									$q3 = mysqli_query($con,"select * from assign_syllabus_staff where 1 and $cond && status=3 ");
									$r3 = mysqli_num_rows($q3);
									
								 	$dataPoints = array(
											array("label"=> "Done", "y"=> $r1),
											array("label"=> "In Progress", "y"=> $r2),
											array("label"=> "Not Started", "y"=> $r3)
											
										);
								    }
									
									?>
                                    </tbody>
                                </table>
                            </div>
					
                            </div>
																					
                    </div>
                </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		
		
	</form>
</div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 
<script>
window.onload = function () {
	
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	//exportEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Allocated Syllabus"
	},
	data: [{
		type: "pie", //change type to bar, line, area, pie, etc
		//showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - #percent%",
		//yValueFormatString: "฿#,##0", 
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>