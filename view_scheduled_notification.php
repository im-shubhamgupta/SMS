<script type="text/javascript">
function delet(id)
	{
		if(confirm("Do You want to delete this Notification?"))
		{
			window.location.href='delete_scheduled_notification.php?x='+id;
		}
	}
	
</script>

<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#"> Student Panel</a>
  <a class="breadcrumb-item" href="#"> Notification</a>
  <span class="breadcrumb-item active"> View Scheduled Notification</span>
</nav>
<!-- breadcrumb -->
<div id="right-panel" class="right-panel">
        <div class="content mt-3" style="width:1020px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Notifications</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
											<th>Date & Time</th>
											<th>Category </th>
											<th>Class </th>
											<th>Section </th>
											<th>Message </th>
											<th>Submitted By </th>
											<th>Action </th>
											
                                        </tr>
                                    </thead>
                                    <tbody id="PTResults">
									<?php
									$sr=1;
									$q1=mysqli_query($con,"SELECT *
										FROM student_scheduled_notifications group by category,class_id,section_id,message,date order by st_notification_id");			
									
									while($res=mysqli_fetch_array($q1))
									{
										$id = $res['st_notification_id'];
										
										$category=$res['category'];
										if($category=="1")
										{
											$cat="Announcement";
										}
										else if($category=="2")
										{
											$cat="Homework";
										}
										else if($category=="3")
										{
											$cat="Message";
										}
										else if($category=="4")
										{
											$cat="Photo Gallery";
										}
										else if($category=="5")
										{
											$cat="Important Information";
										}
										else if($category=="6")
										{
											$cat="Study Material";
										}
										
										$clsid=$res['class_id'];
										$q2=mysqli_query($con,"select * from class where class_id='$clsid'");
										$res2=mysqli_fetch_array($q2);
										$clsname=$res2['class_name'];
										
										$secid=$res['section_id'];
										$q3=mysqli_query($con,"select * from section where section_id='$secid'");
										$res3=mysqli_fetch_array($q3);
										$secname=$res3['section_name'];
																	
										$dt=$res['date'];
										$newdate=date("d-m-Y",strtotime($dt));
									?>
									<tr>
										<td><?php echo $sr;?></td>
										<td><?php echo $newdate;?></td>
										<td><?php echo $cat;?></td>
										<td><?php echo $clsname;?></td>
										<td><?php echo $secname;?></td>
										<td><?php echo $res['message'];?></td>
										<td><?php echo $res['loginuser'];?></td>
										<td><a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="delet	('<?php echo $id;?>')">
										<i class="fa fa-trash"></i> Delete </a></td>	
									</tr>
									<?php $sr++; 
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
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>