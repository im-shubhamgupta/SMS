<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



?>





<div id="right-panel" class="right-panel">

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

  <span class="breadcrumb-item active">View App Installed</span>

</nav>



	<form method="post" action="dashboard.php?option=view_students" enctype="multipart/form-data">

		

        <div class="content mt-3" >

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-10">

                        <div class="card">

                            <div class="card-header">

                               <strong class="card-title">View Installed App Detail</strong>

                            </div>

                            <div class="card-body">

                                <!-- <table id="bootstrap-data-table-export" class="table table-striped table-bordered"> -->
                                <table id="table-grid" class="table table-striped table-bordered " >	

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Register No</th>

											 <th>Student Name</th>

											 <th>Father Name</th>

											 <th>Mother Name</th>

											 <th>Class</th>

											 <th>Section</th>
											 <th>Session year</th>

											 <th>Student Phone</th>

											 <th>Parent Phone</th>

                                             <th>Message Type</th>
                                             <th>App Installed On</th>

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from installed_app order by date desc");

									while($res=mysqli_fetch_array($query))

									{

									$stuid=$res['student_id'];

									

									$q1 = mysqli_query($con,"select student_id,register_no,student_name,father_name,mother_name,student_contact,parent_no,msg_type_id,sr.class_id,sr.section_id,sr.roll_no,sr.session from students as s join student_records as sr on s.student_id=sr.stu_id  where s.student_id='$stuid'");

									$r1 = mysqli_fetch_array($q1);

									

									$clid=$r1['class_id'];

									$quec=mysqli_query($con,"select * from class where class_id='$clid'");

									$rcl=mysqli_fetch_array($quec);

									

									$seid=$r1['section_id'];

									$qse=mysqli_query($con,"select * from section where section_id='$seid'");

									$rsec=mysqli_fetch_array($qse);

									

									$msgid=$r1['msg_type_id'];

									$qmid = mysqli_query($con,"select * from message_type where msg_type_id='$msgid'");

									$rqmid = mysqli_fetch_array($qmid);

									$msgname = $rqmid['msg_name'];

									

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $r1['register_no']; ?></td>

										<td><?php echo $r1['student_name']; ?></td>

										<td><?php echo $r1['father_name']; ?></td>

										<td><?php echo $r1['mother_name']; ?></td>

										<td><?php echo $rcl['class_name'];?></td>

										<td><?php echo $rsec['section_name'];?></td>
										
										<td><?=getSessionByid($r1['session'])['year'];?></td>

										<td><?php echo $r1['student_contact']; ?></td>

										<td><?php echo $r1['parent_no']; ?></td>

										<td><?php echo $msgname;?></td>
										<td><?=date('d-m-Y H:i:s',strtotime($res['date']))?></td>

									

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

 <?php// include('bootstrap_datatable_javascript_library.php'); ?>
  <?php include('datatable_links.php'); ?>
 
	<!-- ------------------ -->
	<script>
	 $(document).ready(function(){
 			
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 50, 100,-1], [10, 50, 100, 'All'] ],	
                    // 'order':[7,'ASC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'print'
                    ],
					// "processing": true,
					// "serverSide": true,
                    "scrollX": true,
					
			});
		
				});

 </script> 