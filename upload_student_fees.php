<?php
error_reporting(1);
extract($_REQUEST);
include('connection.php');

if(isset($upload))
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
	echo "<h1>" . "File ". $_FILES['csvfile']['name'] ." uploaded successfully." . "</h1>";
 
	readfile($_FILES['csvfile']['tmp_name']);
}
          $handle = fopen($_FILES['csvfile']['tmp_name'], "r");
			
		  $headerLine = true;
			
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
{		
	$regno=$data[0];
	
	$q1 = mysqli_query($con,"select * from students where register_no='$regno'");
	$row = mysqli_num_rows($q1);
	if($row)
	{
		
		$r1=mysqli_fetch_array($q1);
		$studentid=$r1['student_id'];
		
		$qfee = mysqli_query($con,"select * from assign_fee_class where class_id='$class'");
		$rfee = mysqli_fetch_array($qfee);
		$feeids = $rfee['fee_header_id'];
		
		$arr = explode(',',$feeids);
		foreach($arr as $k)
		{
			$due = $due + $k;
		}
				
		$import=mysqli_query($con,"update student_wise_fees set fee_header_id='$feeheader', fee_amount='$feeamount' where student_id='$studentid'");		
		
	}
	else
	{
		echo "Invalid Register Number.";
	}
	
}
 
	echo "<script>window.location='dashboard.php?option=view_previous_fees'</script>";
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
  <span class="breadcrumb-item active">Download Student Fees</span>
</nav>


   <form method="post" action="dashboard.php?option=upload_student_fees" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">
							
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                              
								<div class="row" style="margin-top:20px;">
								<div class="col-md-2" style="margin-left:10px;">Class</div>
								<div class="col-md-2">
								<div class="sorting-left">
								<select name="class" class="form-control" onchange="search_sec(this.value)" autofocus required>
								<option value="" selected="selected" disabled >Select Class</option>
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
								
								<div class="col-md-2" style="margin-left:50px;">Section</div>
								<div class="col-md-2">
								<div class="sorting-left">
								<select class="form-control" name="section" id="search_sect" style="width:150px" autofocus required>
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
								<script>
								function search_sec(str)
								{
								var xmlhttp= new XMLHttpRequest();	
								xmlhttp.open("get","search_ajax_section_att.php?cls_id="+str,true);
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
								<br/>
								<br/>
 
								<div class="row">
								<div class="col-md-9">
									<div class="panel-body">
									<label>Upload Students Previous Fees</label>
									<input class="form-control" type="file" required name="csvfile">
								
									</div>
								</div>
								<div class="col-md-1">
								</div>
								</div>
								<br/><br/>
								
								<div class="row">
								<div class="col-md-1" style="margin-left:350px;">
								<input type="submit" name="upload" class="btn btn-primary btn-sm" value="Upload"><br><br>
								</div>
								</div>
								<br/>
								<br/>
								
                            </div>
							
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		<div style="text-align:center">
		
		
		
		</div>
		
	</form>	
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 