<?php 
//error_reporting(1);
include('connection.php');
extract($_REQUEST);

if (isset($_POST['upload'])) 
{
$csvfile = $_FILES['csvfile']['name'];
$ext = pathinfo($csvfile, PATHINFO_EXTENSION);
$base_name = pathinfo($csvfile, PATHINFO_BASENAME);

if(!$_FILES['csvfile']['name'] == "")   
{ 
if($ext == "csv")
{
 
 if(file_exists($base_name))
{
      echo "file already exist" . $base_name;
                                                  
}
 
    else
{
	    
if (is_uploaded_file($_FILES['csvfile']['tmp_name'])) 
 
	{
	
	//echo "<h1>" . "File ". $_FILES['csvfile']['name'] ." uploaded successfully." . "</h1>";
 
	readfile($_FILES['csvfile']['tmp_name']);
		}
		
          $handle = fopen($_FILES['csvfile']['tmp_name'], "r");
 
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
{
	
	$clsname=$data[8];
	$qcls=mysqli_query($con,"select * from class where class_name='$clsname'");
	$rcls=mysqli_fetch_array($qcls);
	$clsid=$rcls['class_id'];
	
	$secname=$data[9];
	$qsec=mysqli_query($con,"select * from section where section_name='$secname' and class_id='$clsid'");
	$rsec=mysqli_fetch_array($qsec);
	$secid=$rsec['section_id'];
	
	$traname=$data[13];
	$qtra=mysqli_query($con,"select * from transports where route_name='$traname'");
	$rtra=mysqli_fetch_array($qtra);
	$tranid=$rtra['trans_id'];
	
$import="INSERT INTO students(register_no,student_name,father_name,mother_name,gender,dob,admission_date,student_contact,class_id,section_id,tutionfee_disc,tutionfeedisc_reason,transport_availed,trans_id,transfee_disc,transfeedisc_reason,parent_no,stuaddress,academic_year,stu_status)

VALUES('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$clsid','$secid','$data[10]','$data[11]','$data[12]','$tranid','$data[14]','$data[15]','$data[16]','$data[17]','$data[18]','$data[19]')";
 
 $run=mysqli_query($con,$import); 
  
}
 if($run)
 {
	 echo "<script>window.location='dashboard.php?option=view_students'</script>";
	 
 }
 else
 {
	 echo "<script>alert('There is some duplicate entry in Register No.')</script>";
	 echo "<script>window.location='dashboard.php?option=upload_students'</script>";
 }
  
}
 
}
 
else
{
 
 echo " Check Extension. your extension is ." . $ext;
		   
 }
 
}  
 
else
{
 echo "Please Upload File";
}
}
?>

<div id="right-panel"  style="width:100%">
         
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><a href="csv/upload_students.csv" class="btn btn-primary">Download Format</a><br /><br /></strong>
                            </div>
                            <div class="card-body">
                                <form method="post" enctype="multipart/form-data">
<div class="row">
	<div class="col-md-12">
		<div class="panel-group">
			<div class="panel panel-default">
				
			<?php echo @$err; ?>	


		<div class="row">
			<div class="col-md-12">
				<div class="panel-body">
				<label>Upload Students</label>
<input class="form-control" type="file" required name="csvfile">
			
				</div>
			</div>
		</div><br>
			
					
			<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-1"><input type="submit" value="Upload" class="btn btn-primary" name="upload"/> </div><br /><br /><br />
			</div>
			

		</div> <!-- End of section 1 row-->
			
			</div>
		</div>
	</div>
</div>				
	</section>
				
</form>		
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
    </div><!-- /#right-panel -->
