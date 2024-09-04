<?php 
include('connection.php');
extract($_REQUEST);

if(isset($upload))
{

	$qcls = mysqli_query($con,"select * from class where class_id='$class'");
	$rcls = mysqli_fetch_array($qcls);
	$clsid = $rcls['class_id'];
	$clsname = $rcls['class_name'];

	$qsec = mysqli_query($con,"select * from section where section_id='$section'");
	$rsec = mysqli_fetch_array($qsec);
	$secid = $rsec['section_id'];
	$secname = $rsec['section_name'];

	if(!file_exists("gallery/idcard/".$clsname))
	{
		mkdir("gallery/idcard/$clsname");
		mkdir("gallery/idcard/$clsname/$secname");
	}

	
	$error=array();
	$extension=array("jpeg","jpg","png","gif");
	foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) 
	{
		$file_name=$_FILES["files"]["name"][$key];
		
		if(file_exists("gallery/idcard/".$clsname."/".$secname."/".$file_name))
		{	
			$regno = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);
			$q1 = mysqli_query($con,"select * from idcard where regno='$regno'");
			$r1 = mysqli_fetch_array($q1);
			$id = $r1['id'];
			$oldpic = $r1['pic'];
			
			unlink("gallery/idcard/$clsname/$secname/$oldpic");
			
			move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"gallery/idcard/".$clsname."/".$secname."/".$file_name);
			
		}
		else
		{
			$file_tmp=$_FILES["files"]["tmp_name"][$key];
			$ext=pathinfo($file_name,PATHINFO_EXTENSION);

			if(in_array($ext,$extension))
			{
				$regno = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);
				
				$q1 = "insert into idcard (class_id,section_id,regno,pic,create_date,modify_date,session) values ('$clsid','$secid','$regno','$file_name',now(),now(),'".$_SESSION['session']."')";
				if(mysqli_query($con,$q1))
				{
				move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"gallery/idcard/".$clsname."/".$secname."/".$file_name);
				}
			}
			else
			{
				array_push($error,"$file_name, ");
			}
		}
	}
	echo "<script>window.location='dashboard.php?option=upload_image'</script>";
}
?>

<div id="right-panel"  style="width:100%">
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Administration Panel</a>
  <a class="breadcrumb-item" href="#">ID Card</a>
  <a class="breadcrumb-item" href="dashboard.php?option=view_upload_student_image">View Upload Image</a>
  <span class="breadcrumb-item active">Upload Image</span>
</nav>

        <div class="content mt-3">	
		 <div class="col-lg-6">
                    <div class="card"  style="width:900px;">
                      <div class="card-header">
                        <strong>Upload </strong> Image
                      </div>
                      <div class="card-body card-block">
                        <form method="post" enctype="multipart/form-data" class="form-horizontal" id="formElem">
                         
                          
						    <div class="row form-group">
                            <div class="col col-md-3">
							<label for="email-input" class=" form-control-label">Select Class</label></div>
                            <div class="col-12 col-md-9">
							<select name="class" class="form-control" onchange="search_sec(this.value)">
							<option selected="selected" disabled>Select Class</option>
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
                         
							<div class="row form-group">
                            <div class="col col-md-3">
							<label for="email-input" class=" form-control-label">Select Section</label></div>
                            <div class="col-12 col-md-9">
							<select class="form-control" name="section" id="search_sect">
							<option value="" >Select Section</option>
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
	
						<a href="dashboard.php?option=view_upload_student_image" class="btn btn-info btn-sm"> 
						<i class='fa fa-arrow-left'> Back</i></a>
                      </div>
					<?php
					}
					?> 
					  
					  
                    </div>
                   </form>
                  </div>
	      </div>
