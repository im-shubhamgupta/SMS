<?php
error_reporting(1);
extract($_REQUEST);

if(isset($_POST['search']))
{
	$fromdt1 = $_POST['fromdt'];
	$chg_fdate = date("d-m-Y", strtotime($fromdt1));
	
    $todt1 = $_POST['todt'];
	$chg_tdate = date("d-m-Y", strtotime($todt1));
	
    $class = $_POST['class'];
	if($class)
	{
		$nclass=$class;
	}else
	{
		$nclass=0;
	}
	
    $section = $_POST['section'];
    if($section)
	{
		$nsection=$section;
	}else
	{
		$nsection=0;
	}
		
	if($class=="" and $section=="")
	{
	$query="select * from events where from_date>='$fromdt1' AND to_date<='$todt1'";		
	$search_result = filterTable($query);
    }
	else if($class!="" and $section!="")
	{
	$query="select * from events where class_id='$nclass' AND section_id='$nsection' AND from_date>='$fromdt1' AND to_date<='$todt1'";		
	$search_result = filterTable($query);	
	}
	else if($class!="" and $section=="")
	{
	$query="select * from events where class_id='$nclass' AND from_date>='$fromdt1' AND to_date<='$todt1'";		
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

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Student Panel</a>
  <a class="breadcrumb-item" href="#">Event Calendar</a>
  <span class="breadcrumb-item active"> View Event Calendar</span>
</nav>

	<form method="post" action="dashboard.php?option=view_event_calendar" enctype="multipart/form-data">
		
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
					
						<div class="row" style="margin-top:20px;">
								
								<div class="col-md-2" style="font-size:14px;margin-left:50px;">From Date</div>
								<div class="col-md-2" style="margin-left:-50px;margin-top:-10px;">
								<input type="date" name="fromdt" class="form-control" style="width:175px;" value="<?php echo $fromdt; ?>" autofocus required>
								</div>
								<div class="col-md-2" style="font-size:14px;margin-left:60px;">To Date</div>
								<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">
								<input type="date" name="todt" class="form-control" style="width:175px;" value="<?php echo $todt; ?>" autofocus required>
								</div>
							
						</div><br>	

						<div class="row" style="margin-top:20px;">
								
								<div class="col-md-2" style="font-size:14px;margin-left:50px;">Event For</div>
								<div class="col-md-2" style="margin-left:-50px;margin-top:-10px;">
								<select class="form-control" name="eventfor" id="eventfor" onchange="showcls()" style="width:175px;" autofocus required>
								<option value="" selected="selected" disabled>Select Event for</option>
								<?php
								$ql=mysqli_query($con,"select * from event_type");
								while($rl=mysqli_fetch_array($ql))
								{
								?>
								<option <?php if($eventfor==$rl['event_id']){echo "selected";}?> value="<?php echo $rl['event_id']; ?>"><?php echo $rl['event_name'];?>
								</option>
								<?php 
								}
								?>							
								</select>
								</div>
								
								<div class="col-md-4">
								</div>
								<div class="col-md-2">
								<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;width:140px;margin-left:50px;" value="Load"><br><br>
								</div>	
						</div><br>	
					
					<script>
					function showcls()
					{
						var p = document.getElementById("eventfor").value;
						if(p==2)
						{
							document.getElementById("test").style="display:none";
						}
						else
						{
							document.getElementById("test").style="display:block";
							document.getElementById("classid").required=true;
							document.getElementById("sectionid").required=true;
						}
						
					}	
					</script>
	
						<div class="row">	
						<div class="col-md-12">
						<div class="row" id="test">
							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Class</div>
							<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">
							<select name="class" class="form-control" onchange="search_sec(this.value)" style="width:175px;">
							<option selected="selected" disabled value="">Select Class</option>
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
							
							<div class="col-md-2" style="font-size:14px;margin-left:60px;">Section </div>
							<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">
							<select class="form-control" name="section" id="search_sect" style="width:175px;">
							<option selected="selected" disabled value="" value="">Select Section</option>
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
							xmlhttp.open("get","search_ajax_staff_section.php?cls_id="+str,true);
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
						</div>	
						</div><br><br>
										
					
                        <div class="card">
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Event Name</th>
											 <th>Event For</th>
											 <th>Event Description</th>
											 <th>From Date</th>
											 <th>To Date</th>
											 <th>Class</th>
											 <th>Section</th>
											 <th colspan="2" class="text-center">Action</th>
										</tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									while($res=mysqli_fetch_array($search_result))
									{
									$id=$res['event_id'];
									
									$eventname=$res['event_heading'];
									
									$efor=$res['event_for'];
									$qevent=mysqli_query($con,"select * from event_type where event_id='$efor'");
									$revent=mysqli_fetch_array($qevent);
									$eventfor=$revent['event_name']; 
									
									$description=$res['description'];
									
									$clid=$res['class_id'];
									$quec=mysqli_query($con,"select * from class where class_id='$clid'");
									$resc=mysqli_fetch_array($quec);
									$cname=$resc['class_name']; 
									if($cname)
									{
										$classname = $cname;
									}else
									{
										$classname = "ALL";
									}
									
									$seid=$res['section_id'];
									$qse=mysqli_query($con,"select * from section where section_id='$seid'");
									$rsec=mysqli_fetch_array($qse);
									$sname=$rsec['section_name'];
									if($sname)
									{
										$sectionname = $sname;
									}else
									{
										$sectionname = "ALL";
									}
									
									$fdate=$res['from_date'];
									$nfdate = date("d-m-Y",strtotime($fdate));
									
									$totdate=$res['to_date'];
									$ntotdate = date("d-m-Y",strtotime($totdate));
																			
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $eventname; ?></td>
										<td><?php echo $eventfor; ?></td>
										<td><?php echo $description; ?></td>
										<td><?php echo $nfdate;?></td>
										<td><?php echo $ntotdate;?></td>
										<td><?php echo $classname;?></td>
										<td><?php echo $sectionname;?></td>
										<td><?php echo "<a href='dashboard.php?option=edit_event_calendar&id=$id' class='btn btn-secondary btn-sm'><i class='fa fa-edit'></i> Edit</a>"?></td>
										<td><a onclick="return confirm('Do you want to Delete.')" href="dashboard.php?option=delete_event&id=<?php echo $id;?>" class="btn btn-danger btn-sm text-white"> <i class="fa fa-trash"></i> Delete</a>
										</td>
									</tr>
                                    <?php $sr++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		
	</form>
</div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>