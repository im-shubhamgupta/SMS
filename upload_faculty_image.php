<?php 

include('connection.php');

extract($_REQUEST);



if(isset($upload))

{	

	$error=array();

	$extension=array("jpeg","jpg","png","gif");

	foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) 

	{

		$file_name=$_FILES["files"]["name"][$key];

		

		if(file_exists("gallery/staffidcard/".$file_name))

		{	

			$stid = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);

			$q1 = mysqli_query($con,"select * from staff_idcard where staff_id='$stid'");

			$r1 = mysqli_fetch_array($q1);

			$id = $r1['id'];

			$oldpic = $r1['pic'];

			

			unlink("gallery/staffidcard/$oldpic");

			

			move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"gallery/staffidcard/".$file_name);

			

		}

		else

		{

			$file_tmp=$_FILES["files"]["tmp_name"][$key];

			$ext=pathinfo($file_name,PATHINFO_EXTENSION);



			if(in_array($ext,$extension))

			{

				$stid = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);

				

				$q1 = "insert into staff_idcard (staff_id,pic,create_date,modify_date) values ('$stid','$file_name',now(),now())";

				if(mysqli_query($con,$q1))

				{

				move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"gallery/staffidcard/".$file_name);

				}

			}

			else

			{

				array_push($error,"$file_name, ");

			}

		}

	}

	echo "<script>window.location='dashboard.php?option=upload_faculty_image'</script>";

}

?>



<div id="right-panel"  style="width:100%">

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Administration Panel</a>

  <a class="breadcrumb-item" href="#">ID Card</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_upload_student_image">View & Upload Faculty Image</a>

  <span class="breadcrumb-item active">Upload Image</span>

</nav>



        <div class="content mt-3">	

		 <div class="col-lg-6">

                    <div class="card"  style="width:900px;">

                      <div class="card-header">

                        <strong>Upload </strong> Image

                      </div>

					   <form method="post" enctype="multipart/form-data" class="form-horizontal" id="formElem">

                      <div class="card-body card-block">

                       

                        					  

						    <div class="row form-group">

                            <div class="col col-md-3">

							<label for="email-input" class=" form-control-label">Pls Upload Passport Size Image</label></div>

                            <div class="col-12 col-md-9">

							<input class="form-control" type="file" required name="files[]" multiple ></div>

							</div>

							

							

                      </div>

					  

					<?php

					if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

					{

					?>  

                      <div class="card-footer">

						<button type="submit" value="Upload" class="btn btn-info btn-sm" name="upload">

						<i class="fa fa-upload"></i> Upload

						</button>

	

						<a href="dashboard.php?option=view_upload_faculty_image" class="btn btn-info btn-sm"> 

						<i class='fa fa-arrow-left'> Back</i></a>

                      </div>

					<?php

					}

					?> 

					  

					   </form>

                    </div>

                  

                  </div>

	      </div>

