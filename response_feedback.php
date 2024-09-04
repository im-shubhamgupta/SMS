<?php

error_reporting(1);

extract($_REQUEST);

$email=$_SESSION['user_logged_in'];

$username=$res['username'];

?>





<div id="right-panel" class="right-panel">



<script>

function response(x)

{

	var textarea = $("#txt"+x).val();

	var user = $("#user").val();

	

	if(textarea=="")

	{

		$("#err"+x).html("Please Enter Response");

	}

	else

	{

		var datastring={"feedid":x,"message":textarea,"user":user};

		$.ajax({

			url:'insert_feedresponse.php',

			type:'post',

			data:datastring,

			success:function(str)

			{

				if(str=='Response not Saved')

				{

					alert(str);

				}

				window.location.reload(true);

			}

		});

	}

	

}

</script>





<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Administration Panel</a>

  <a class="breadcrumb-item" href="#"> Feedback Management</a>

  <span class="breadcrumb-item active"> Response Feedback</span>

</nav>

		

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                               <strong class="card-title">View Leave Request</strong>					   

                            </div>

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

                                             <th>Name</th>

											 <th>Class</th>

											 <th>Section</th>

											 <th>Request Type</th>

											 <th>Raised For</th>

											 <th>Teacher Name</th>

											 <th>Title</th>

											 <th>Description</th>

											 <th>Action</th>

										</tr>

                                    </thead>

                                    <tbody>

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from feedback where status='0'");

									while($res=mysqli_fetch_array($query)){

									$feedbackid=$res['feedback_id'];

									

									$stuid=$res['student_id'];

									$qstu=mysqli_query($con,"select * from students where student_id='$stuid'");

									$rstu=mysqli_fetch_array($qstu);

									

									$clid=$res['class_id'];

									$quec=mysqli_query($con,"select * from class where class_id='$clid'");

									$resc=mysqli_fetch_array($quec);

									

									$seid=$res['section_id'];

									$qse=mysqli_query($con,"select * from section where section_id='$seid'");

									$rsec=mysqli_fetch_array($qse);

									

									$requestid=$res['request_id'];

									$qre=mysqli_query($con,"select * from request_type where request_id='$requestid'");

									$rre=mysqli_fetch_array($qre);

									

									$stid=$res['staff_id'];

									$qst=mysqli_query($con,"select * from staff where st_id='$stid'");

									$rst=mysqli_fetch_array($qst);

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $rstu['student_name']; ?></td>

										<td><?php echo $resc['class_name'];?></td>

										<td><?php echo $rsec['section_name'];?></td>

										<td><?php echo $rre['request_name'];?></td>

										<td><?php echo $res['raised_for'];?></td>

										<td><?php echo $rst['staff_name'];?></td>

										<td><?php echo $res['title'];?></td>

										<td><?php echo $res['description'];?></td>

										<input type="hidden" name="user" id="user" value="<?php echo $username;?>">										

										<td>

<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#reply<?php echo $feedbackid;?>">

  Response

</button>

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

	

</div><!-- /#right-panel -->



<!-- Modal Starts Here -->

<?php

$query=mysqli_query($con,"select * from feedback where status='0'");

while($res=mysqli_fetch_array($query))

{

$feedbackid=$res['feedback_id'];

?>



<div class="modal fade" id="reply<?php echo $feedbackid;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Response</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

      

		<form method="post">

		<div class="form-group">

		<textarea id="txt<?php echo $feedbackid;?>" class="form-control" rows="5"></textarea>

		</div>

		<span id="err<?php echo $feedbackid;?>" style="color:red;"></span>

		<button type="button" class="btn btn-primary btn-sm" onclick="response(this.value)" value="<?php echo $feedbackid;?>">Ok</button>

		<button type="button" class="btn btn-info btn-sm" data-dismiss="modal">Cancel</button>

        

		</form>

	  </div>

    </div>

  </div>

</div>



<?php

}

?>

<!-- Modal Ends Here-->



 <?php include('bootstrap_datatable_javascript_library.php'); ?>