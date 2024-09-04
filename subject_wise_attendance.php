<?php
error_reporting(1);
extract($_REQUEST);

$atdate=(date("Y-m-d"));
$class = $_REQUEST['class'];
$section = $_REQUEST['section'];
$subject = $_REQUEST['subject'];
$qsub=mysqli_query($con,"select * from subject where subject_id='$subject'");
$rsub=mysqli_fetch_array($qsub);
$subname=$rsub['subject_name'];
	
if(isset($load))
{
	 $atdate = $_REQUEST['atdate']; 
	 $query="select * from students where class_id='$class' && section_id='$section' order by (student_id) DESC";
	 $search_result = filterTable($query);
	
}


if($save)
{
	$atdate = $_REQUEST['atdate'];
	$chgdt=date("d-m-Y",strtotime($atdate));
	$regno=$_REQUEST['regno'];
	$sid=$_REQUEST['sid'];
	$attendance=$_REQUEST['attend'];
	$reasons=$_REQUEST['reason'];
	
	$totaluser=sizeof($regno);
	
	for($i=0;$i<$totaluser;$i++)
	{
		$newreg=$regno[$i];
		$newsid=$sid[$i];
		$newattendance=$attendance[$i];
		$newreasons=$reasons[$i];
		
		$q1=mysqli_query($con,"insert into subjectwise_attendance  (register_no,student_id,class_id,section_id,subject_id,type_of_attend,reason,date) 
		values('$newreg','$newsid','$class','$section','$subject','$newattendance','$newreasons','$atdate')");
	}
	
	$query="select * from subjectwise_attendance where class_id='$class' && section_id='$section' && subject_id='$subject' &&
			date='$atdate' order by (student_att_id) DESC";
	
	echo "<script>window.location='dashboard.php?option=subject_wise_attendance'</script>";

}	
	
	
	// function to connect and execute the query
	function filterTable($query)
	{
		include('connection.php');
		$filter_Result = mysqli_query($con, $query);
		return $filter_Result;
	}	
	
	
if(isset($update))
{
	
	$regno=$_REQUEST['regno'];
	$sid=$_REQUEST['sid'];
	$attendance=$_REQUEST['attend'];
	$reasons=$_REQUEST['reason'];
	
	$totaluser=sizeof($regno);
	
	for($i=0;$i<$totaluser;$i++)
	{
		$newreg=$regno[$i];
		$newsid=$sid[$i];
		$qname=mysqli_query($con,"select * from students where student_id='$newsid'");
		$res=mysqli_fetch_array($qname);
		$newname=$res['student_name'];
		
		$newattendance=$attendance[$i];
		$newreasons=$reasons[$i];
		
	$q=mysqli_query($con,"select * from students where register_no='$newreg'");
	$r=mysqli_fetch_array($q);
	$mobile=$r['parent_no'];
	$fathername=$r['father_name'];
	$gender=$r['gender'];
	if($gender=="FEMALE")
	{
	 $gen="Daughter";	
	}
	else
	{
	 $gen="Son";	
	}	
	
	$date=date("d-m-Y",strtotime($atdate));
	
	$sset=mysqli_query($con,"select * from setting");
	$rsset=mysqli_fetch_array($sset);
	$sclname=$rsset['company_name'];
	
	if($newattendance=="2")
	{
		$message="Dear ".$fathername."%0aYour ".$gen." ".$newname." is Absent for the class ".$subname." on ".$chgdt.".%0aFrom,%0a".$sclname.".";
	}
	
	if($newattendance=="2")
	{
	//echo $newattendance;	

	$set=mysqli_query($con,"select * from sms_setting");
	$rset=mysqli_fetch_array($set);
	$senderid=$rset['sender_id'];
	$apiurl=$rset['api_url'];
	$apikey=$rset['api_key'];
	
	//Send sms to sender and reciever
	$senderId = "$senderid";
		$route = 4;
		$campaign = "OTP";
		$sms = array(
			'message' => "$message",
			'to' => array($mobile)
		);
		//Prepare you post parameters
		$postData = array(
			'sender' => $senderId,
			'campaign' => $campaign,
			'route' => $route,
			'sms' => array($sms)
		);
		$postDataJson = json_encode($postData);

		$url="$apiurl";

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "$url",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $postDataJson,
			CURLOPT_HTTPHEADER => array(
				"authkey:"."$apikey",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		
	}	
		
	}
	
	echo "<script>window.location='dashboard.php?option=subject_wise_attendance'</script>";

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	
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
   <span class="breadcrumb-item active">View Students Attendance</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=subject_wise_attendance" id="devel-generate-content-form" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						
                        <div class="row" style="margin-top:20px;">
								
								<div class="col-md-1" style="font-size:14px;">Date <?php echo $cdate; ?></div>
								<div class="col-md-2" style="margin-left:-30px;margin-top:-10px;">
								<input type="date" name="atdate" value="<?php echo $atdate; ?>" class="form-control" style="width:175px;" autofocus required>
								</div>
								
								<div class="col-md-1" style="font-size:14px;">Class</div>
								<div class="col-md-2" style="margin-left:-30px;margin-top:-10px">
								<select name="class" class="form-control" onchange="search_sec(this.value)" style="width:175px;" autofocus required>
								<option value="" selected="selected" disabled>Select Class</option>
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
							
								<div class="col-md-1" style="font-size:14px;margin-left:20px;">Section </div>
								<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">
								<select class="form-control" name="section" id="search_sect" style="width:175px;" 
								onchange="search_sub(this.value)" autofocus required>
								<option value="" selected="selected">All</option>
								<?php
								$qsec=mysqli_query($con,"select * from section where class_id='$class'");
								while($rsec=mysqli_fetch_array($qsec))
								{
								?>
								<option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>
								</option>
								<?php 
								}
								?>		
								</select>	
								</div>
							
							<script>
							function search_sub(str)
							{
							var xmlhttp= new XMLHttpRequest();	
							xmlhttp.open("get","search_ajax_subject_att.php?sec_id="+str,true);
							xmlhttp.send();
							xmlhttp.onreadystatechange=function()
							{
							if(xmlhttp.status==200  && xmlhttp.readyState==4)
							{
							document.getElementById("search_subj").innerHTML=xmlhttp.responseText;
							}
							} 
							}
							</script>
								
								<div class="col-md-1" style="font-size:14px;margin-left:20px;">Subject </div>
								<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">
								<select class="form-control" name="subject" id="search_subj" style="width:175px;" autofocus required>
								<option value="" selected="selected">Select Subject</option>
								<?php
								$qsub=mysqli_query($con,"select * from subject where subject_id	='$subject'");
								while($rsub=mysqli_fetch_array($qsub))
								{
								?>
								<option <?php if($subject==$rsub['subject_id']){echo "selected";}?> value="<?php echo $rsub['subject_id']; ?>"><?php echo $rsub['subject_name'];?>
								</option>
								<?php 
								}
								?>		
								</select>	
								</div>
						</div>
						<br>
						
								
						<div class="row" style="margin-top:20px;">
							<div class="col-md-2">
							<input type="submit" name="load" class="btn btn-primary btn-sm" style="margin-top:-10px;width:100px;margin-left:550px;" value="Load"><br><br>
							</div>
							<br>
							<br>
						</div>
						
			<script>	
			function test456(at_type,reg_no)
			{
				var tmp="demo345"+reg_no;
				if(at_type=="3")
				{			  
				  $("#"+tmp).css("display","block");
				 
				  $("#"+tmp).prop('required',true); 
				}
				else
				{
				$("#"+tmp).css("display","none");
				$("#"+tmp).prop('required',false);
				}
			}
			</script>	
			
						<!--table starts from here-->
						<div class="card">
                            <div class="card-body" style="width:1100px">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                             <th>Register No</th>
											 <th>Student Name</th>
											 <th>Attendance</th>
											 <th>Reason</th>
										</tr>
                                    </thead>
                                    <tbody>
									<?php 
									while($res1=mysqli_fetch_array($search_result))
									{									
									$regno=$res1['register_no'];
									$stuid=$res1['student_id'];
									$qname=mysqli_query($con,"select * from students where student_id='$stuid'");
									$res2=mysqli_fetch_array($qname);
									$stuname=$res2['student_name'];
									$attend=$res1['type_of_attend'];
									$reason=$res1['reason'];
														
									?>
									<tr>
								<td><?php echo $regno; ?></td>
								<input type="hidden" name="regno[]" value="<?php echo $regno;?>">
								<td><?php echo $stuname; ?></td>
								<input type="hidden" name="sid[]" value="<?php echo $stuid;?>">
								<td>
								<select name="attend[]" id="<?php echo $regno;?>"  class="form-control" 
								onchange="test456(this.value,this.id)" style="width:150px;">
								<?php
								$qu=mysqli_query($con,"select * from attendance_type");
								while($re=mysqli_fetch_array($qu))
								{
								?>
								<option <?php if($attend==$re['att_type_id']){echo "selected";}?> value="<?php echo $re['att_type_id']; ?>"><?php echo $re['att_type_name'];?></option>
								<?php
								}
								?>
								</select>
								</td>
								<td><input type="text" name="reason[]" id="demo345<?php echo $regno; ?>" value="<?php echo $reason;?>" 
								style="display:<?php if(!empty($reason)){echo 'block';} else {
								echo 'none';}?>" class="form-control"></td>									
									</tr>
									<?php
									}
									?>					
                                    </tbody>
                                </table>
                            </div>
                        </div><br><br>
		
				<!--		<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-2" style="font-size:14px;">Number of Presenties : </div>
							<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">
							<input type="text" name="present" id="present" class="form-control" style="margin-left:10px;" readonly>
							</div>
						</div><br><br>

						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-2" style="font-size:14px;">Number of Absenties : </div>
							<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">
							<input type="text" name="absent" id="absent" class="form-control" style="margin-left:10px;" readonly>
							</div>
						</div><br><br>
						
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-2" style="font-size:14px;">Number of Leaves : </div>
							<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">
							<input type="text" name="leave" id="leave" class="form-control" style="margin-left:10px;" readonly>
							</div>
						</div><br><br>
				-->
				
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		
		<div style="text-align:center">
		<input type="submit" name="save" value="Save" class="btn btn-primary btn-md"/>
		
		<input type="submit" name="update" value="Save & Send SMS" style="margin-left:50px;" class="btn btn-primary btn-md"/>
		
		<input type="reset" name="reset" value="Cancel" style="margin-left:50px;" class="btn btn-primary btn-md"/>		
		</div>
		
		
	</form>	
    </div><!-- /#right-panel -->
	

 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 