<?php
error_reporting(1);
extract($_REQUEST);

if(isset($_POST['search']))
{
    $class = $_POST['class'];
	$cl1 = mysqli_query($con,"select * from class where class_id='$class'");
	$r1 = mysqli_fetch_array($cl1);
	$cname = $r1['class_name'];
	
    $section = $_POST['section'];
	$se1 = mysqli_query($con,"select * from section where section_id='$section'");
	$s1 = mysqli_fetch_array($se1);
	$sname = $s1['section_name'];
	
	if($class!="" and $section!="")
	{
    // search in all table columns

		$query = "SELECT * FROM `student_wise_fees` WHERE `class_id`='$class' and section_id='$section'";
		$search_result = filterTable($query);
    }
	else if($class!="" and $section=="")
	{
		$query = "SELECT * FROM `student_wise_fees` WHERE `class_id`='$class'";
		$search_result = filterTable($query);
	}	
	
}

if(isset($_GET['search']))
{
    $class = $_GET['class'];
	$cl1 = mysqli_query($con,"select * from class where class_id='$class'");
	$r1 = mysqli_fetch_array($cl1);
	$cname = $r1['class_name'];
	
    $section = $_GET['section'];
	$se1 = mysqli_query($con,"select * from section where section_id='$section'");
	$s1 = mysqli_fetch_array($se1);
	$sname = $s1['section_name'];
	
	if($class!="" and $section!="")
	{
    // search in all table columns

		$query = "SELECT * FROM `student_wise_fees` WHERE `class_id`='$class' and section_id='$section'";
		$search_result = filterTable($query);
    }
	else if($class!="" and $section=="")
	{
		$query = "SELECT * FROM `student_wise_fees` WHERE `class_id`='$class'";
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

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Accounts Panel</a>
  <a class="breadcrumb-item" href="#">Fees</a>
  <span class="breadcrumb-item active">View Assign Fees Student</span>
</nav>


<?php
if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
{
?>		
<div class="breadcrumbs" style="width:1020px">
	<div class="col-sm-4" style="padding:10px;">  
	<a href="dashboard.php?option=assign_fees_to_students&smid=<?php echo '31';?>" class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> Assign Fees to Students</a>
	</div>
</div>
<?php
}
?>

   <form method="post" action="dashboard.php?option=view_assign_fees_students" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1050px">
            <div class="animated fadeIn">
                <div class="row">
							
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                              
								<div class="row" style="margin-top:20px;">
								<div class="col-md-1" style="margin-left:10px;">Class</div>
								<div class="col-md-2">
								<div class="sorting-left">
								<select name="class" class="form-control" onchange="search_sec(this.value); divchange(this.value)" autofocus required>
								<option selected="selected" disabled >Select Class</option>
								<?php
								$scls = "select * from class";
								$rcls = mysqli_query($con, $scls);
								while( $rescls = mysqli_fetch_array($rcls) ) {
								?>
								<option  <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>
								</option>
								<?php } ?>							
								</select>
								</div>
								</div>
								
								<div class="col-md-1" style="margin-left:50px;">Section</div>
								<div class="col-md-2">
								<div class="sorting-left">
								<select class="form-control" name="section" id="search_sect">
								<option value="" selected disabled>All</option>
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
								xmlhttp.open("get","search_ajax_section.php?cls_id="+str,true);
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
								</div>
								
								<div class="col-md-1" style="margin-left:50px;">
								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>
								</div>
							    </div>
 
                            </div>
							
							<div class="card-body" id="test">
							<?php
							// if(isset($search))
							// {
								// if($sname)
								// {
									// $sename = $sname;
								// }
								// else
								// {
									// $sename = "All";
								// }
								
								// echo "<span style='font-weight:bold;font-size:18px;'>Class ".$cname." and Section ".$sename." is selected for Edit</span>";
							// }
							?>			
							</div>
							
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Name</th>
											 <th>Reg No</th>
											 <th>Father Name</th>
											 <th>Class</th>
											 <th>Section</th>
											 <?php 
											 $qf = mysqli_query($con,"select * from assign_fee_class where class_id='$class'");
											 $rf = mysqli_fetch_array($qf);
											 $fid = $rf['fee_header_id'];
											 $arr = explode(',',$fid);
											 foreach($arr as $k)
											 {
									
											 $qf1 = mysqli_query($con,"select * from fee_header where fee_header_id='$k'");
											 $rf1 = mysqli_fetch_array($qf1);
																							 
											 ?>
											 <th><?php echo $rf1['fee_header_name']; ?></th>
											 <?php
											 }
											 ?>
											 <th>Transport Fees</th>
											 <th>Total Paid Amount</th>
											 <th>Total Due</th>
											 <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									
									if(isset($search))
									{
										$sr=1;
										while($res=mysqli_fetch_array($search_result))
									{
									$stuid=$res['student_id'];
																		
									$q1 = mysqli_query($con,"select * from students where student_id='$stuid'");
									$r1 = mysqli_fetch_array($q1);
									$stuname=$r1['student_name'];
									$regno=$r1['register_no'];
									$fathername=$r1['father_name'];
									$clsid=$r1['class_id'];
									$q2 = mysqli_query($con,"select * from class where class_id='$clsid'");
									$r2 = mysqli_fetch_array($q2);
									$classname = $r2['class_name'];
									$secid=$r1['section_id'];
									$q3 = mysqli_query($con,"select * from section where section_id='$secid'");
									$r3 = mysqli_fetch_array($q3);
									$secname = $r3['section_name'];
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $stuname; ?></td>
										<td><?php echo $regno; ?></td>
										<td><?php echo "Mr&nbsp;".$fathername; ?></td>
										<td><?php echo $classname; ?></td>
										<td><?php echo $secname; ?></td>
										
										<?php 
										//$q2 = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid'");
										//$r2 = mysqli_fetch_array($q2);
										$fhid = $res['fee_header_id'];
										$fheadarr = explode(',',$fhid);
										
										$fhamt = $res['fee_amount'];
										$famtarr = explode(',',$fhamt);
										
										foreach($arr as $k)
										{
										  if(in_array($k,$fheadarr))
										   {
											  $pos = array_search($k,$fheadarr);
											  $val = $famtarr[$pos];
										?>	
										<td><?php echo $val; ?></td>										
										<?php
											
										   }
										}
										?>
									
										<?php
										$q3 = mysqli_query($con,"select * from student_route where student_id='$stuid'");
										$r3 = mysqli_fetch_array($q3);
										$transfee = $r3['price'];
										if(isset($transfee))
										{
											$transamt = $transfee;
										}
										else
										{
											$transamt = 0;
										}
										?>
										<td><?php echo $transamt; ?></td>
										
										<?php
										$q4 = mysqli_query($con,"select * from student_due_fees where student_id='$stuid' && status='0' || status='3'");
										$row = mysqli_num_rows($q4);
										$transamt = 0 ;
										$pamt = 0;
										$totalpaidamt = 0;
										while($r4 = mysqli_fetch_array($q4))
										{
											$recdamt = $r4['received_amount'];
											$ramtarr = explode(',',$recdamt);
											foreach($ramtarr as $a1)
											{
												$pamt = $pamt+$a1;
											}
											
											$transamt = $transamt + $r4['transport_amount'];
											
											$totalpaidamt = $pamt + $transamt;
										
										}
										
										$q5 = mysqli_query($con,"select * from students where student_id='$stuid'");
										$r5 = mysqli_fetch_array($q5);
										$due = $r5['due'];
										
										?>
										<td><?php echo $totalpaidamt; ?></td>
										
										<td><?php echo $due; ?></td>
										
										<?php 
										if($row)
										{
										?>
										<td>
										<input onclick="return confirm('Does not able to Edit the Fees Details. Contact Administration');" type="submit" name="edit" value="Edit" style='width:80px;' class="btn btn-outline-success btn-sm"/>
										</td>
										<?php
										}
										else
										{
										?>
										<td>
										<?php
										echo "<a href='dashboard.php?option=edit_assign_fees_students&stuid=$stuid&cl1=$class&se1=$section&smid=32' class='btn btn-outline-success btn-sm' style='width:80px;' title='Edit'>Edit</a>";
										?></td>
										<?php
										}
										?>
										
									</tr>
                                    <?php
									$sr++; 
									}
									
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
		<!--
		<input type="submit" name="sms" value="Send SMS" id="add" class="btn btn-primary btn-md"/>
		
		<a href="export_excel.php" class="btn btn-success" style="margin-left:20px;">Download To Excel</a> -->
		
		<!--<a href="dashboard.php?option=view_bill" class="btn btn-danger btn-md" style="margin-left:20px;">Cancel</a>-->
		
		</div>
		
	</form>	
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 