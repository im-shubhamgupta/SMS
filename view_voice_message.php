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
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#"> Notification Panel</a>
  <span class="breadcrumb-item active"> View Voice Messages   
</span>
</nav>
<!-- breadcrumb -->
<div id="right-panel" class="right-panel">
        <div class="content mt-3" style="width:1020px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Voice Messages</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
											<th>Date & Time</th>
											<th>Msg For</th>
											<th>Class </th>
											<th>Section </th>
											<th>Message </th>
											<th>Submitted By </th>
										<!--	<th>Action </th>
											-->
                                        </tr>
                                    </thead>
                                    <tbody id="PTResults">
									<?php
									$sr=1;
									$q1=mysqli_query($con,"SELECT * FROM voice_message group by msgfor,class_id,section_id,
									message,date order by voice_msg_id");			
									
									while($res=mysqli_fetch_array($q1))
									{
										$id = $res['voice_msg_id'];
										
										$msgfor = $res['msgfor'];
										
										$clsid=$res['class_id'];
										$q2=mysqli_query($con,"select * from class where class_id='$clsid'");
										$res2=mysqli_fetch_array($q2);
										$clsname=$res2['class_name'];
										
										$secid=$res['section_id'];
										$q3=mysqli_query($con,"select * from section where section_id='$secid'");
										$res3=mysqli_fetch_array($q3);
										$secname=$res3['section_name'];
																	
										$dt=$res['date'];
										$newdate=date("d-m-Y h:i A",strtotime($dt));
										
										$loguser = $res['loginuser'];
										$logid = $res['login_id'];
										if($loguser =="users")
										{
											$q = mysqli_query($con,"select * from users where user_id ='$logid'");
											$r = mysqli_fetch_array($q);
											$loginname = $r['roles'];
										}
										else if($loguser =="staff")
										{
											$q = mysqli_query($con,"select * from staff where st_id ='$logid'");
											$r = mysqli_fetch_array($q);
											$loginname = $r['staff_name'];
										}
										
										$audio = $res['message'];
									?>
									<tr>
										<td><?php echo $sr;?></td>
										<td><?php echo $newdate;?></td>
										<td><?php echo $msgfor;?></td>
										<td><?php echo $clsname;?></td>
										<td><?php echo $secname;?></td>
										<td><audio controls><source src="gallery/audio/<?php echo $audio;?>"></audio></td>
										<td><?php echo $loginname;?></td>
									<!--	<td><a title="Deleted" class="btn btn-outline-danger btn-sm" onclick="delet	('<?php echo $id;?>')">Delete </a></td>	
									-->
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