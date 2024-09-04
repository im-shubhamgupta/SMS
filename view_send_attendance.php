<?php
error_reporting(1);
extract($_REQUEST);

$atdate =(date("Y-m-d"));
	
if(isset($load))
{
	$atdate =$_REQUEST['atdate']; 	 
	$query="select distinct(a.student_id),b.student_name from subjectwise_attendance a  inner join students b on a.student_id=b.student_id  where a.class_id='$class' && a.section_id='$section' && a.date='$atdate' order by (student_id) asc";
	$search_result = filterTable($query);
	
}


if(isset($sendsms))
{
	$regno=$_REQUEST['regno'];
	$name=$_REQUEST['sname'];
	$attendance=$_REQUEST['attend'];
	
	$reason=$_REQUEST['reason'];

	$totaluser=sizeof($regno);
	
	for($i=0;$i<$totaluser;$i++)
	{
		$newreg=$regno[$i];
		$newname=$name[$i];
		$newattendance=$attendance[$i];
		$newreason=$reason[$i];
		
		$q1=mysqli_query($con,"insert into student_daily_attendance  (register_no,student_name,class_id,section_id,type_of_attend,reason,date) 
		values('$newreg','$newname','$class','$section','$newattendance','$newreason','$atdate')");
	
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
		$message="Dear ".$fathername." your ".$gen." ".$newname." is Absent on ".$date.".%0aRegards,%0a".$sclname.",";
	}
	else if($newattendance=="3")
	{
		$message="Dear ".$fathername." your ".$gen." ".$newname." is Leave on ".$date.", the Reason for leave is '".$newreason."'.%0aRegards,%0a".$sclname.",";
	}
	
	if($newattendance=="2" || $newattendance=="3")
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
	
	$query="select * from student_daily_attendance where class_id='$class' && section_id='$section' && date='$atdate' order by (student_att_id) DESC";
	$search_result = filterTable($query);
		
	//echo "<script>window.location='dashboard.php?option=stu_daily_attendance'</script>";	
	
}	
	
	// function to connect and execute the query
	function filterTable($query)
	{
		include('connection.php');
		$filter_Result = mysqli_query($con, $query);
		return $filter_Result;
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
   <form method="post" action="dashboard.php?option=view_send_attendance" id="devel-generate-content-form" enctype="multipart/form-data"> 
		
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						
                        <div class="row" style="margin-top:20px;">
								
								<div class="col-md-1"></div>
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
								
								<div class="col-md-1" style="font-size:14px;">Date </div>
								<div class="col-md-2" style="margin-left:-30px;margin-top:-10px;">
								<input type="date" name="atdate" value="<?php echo $atdate; ?>" class="form-control" style="width:175px;" autofocus required>
								</div>
								
						</div>
						
						<br>		
						<div class="row" style="margin-top:20px;">
							<div class="col-md-2">
							<input type="submit" name="load" class="btn btn-primary btn-sm" style="margin-top:-10px;width:100px;margin-left:550px;" value="Load"><br><br>
							</div>	
						</div><br>
						
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
										<th>Student Name</th>
										<?php
										$quesub=mysqli_query($con,"select * from subject where class_id='$class'");
										while($res=mysqli_fetch_array($quesub))
										{			
											//$subj=$res['subject_name'];
											$subid[]=$res['subject_id'];
										?>
										
										<th><?php echo $res['subject_name'];?></th>
										<input type="hidden" name="subjid[]" value="<?php echo $subid;?>">
										<?php
										}
										//print_r($subid);
										?>										
										</tr>
                                    </thead>
                                    <tbody>
									<?php
									$i=0;
									while($res1=mysqli_fetch_array($search_result))
									{
									 $stuid=$res1['student_id'];
									 $stud_name=$res1['student_name'];
									?>
									<tr>
									<td><?php echo $stud_name; ?></td>
									<input type="hidden" name="sid[]" value="<?php echo $stuid;?>">
									<?php
									foreach($subid as $v)
									{
									   
									$query4=mysqli_query($con,"select * from subjectwise_attendance where student_id='$stuid' && subject_id='$v' && date='$atdate'");
									$r2=mysqli_fetch_array($query4);
									$attend=$r2['type_of_attend'];
									$queatt=mysqli_query($con,"select * from attendance_type where att_type_id='$attend'");
									$ratt=mysqli_fetch_array($queatt);
									$attname=$ratt['short_name'];
									?>
									
									<td>
									<?php echo $attname; ?></td>
									<input type="hidden" name="stuatt[]" value="<?php echo $attend;?>">
									<?php
									}
									?>
																								
									</tr>
									<?php
									}
									
									?>					
                                    </tbody>
                                </table>
                            </div>
                        </div><br><br>
		
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		
		<div style="text-align:center">
		<input type="submit" name="sendsms" value="Send SMS" class="btn btn-primary btn-md"/>
		
		<input type="reset" name="reset" value="Cancel" style="margin-left:50px;" class="btn btn-primary btn-md"/>		
		</div>
		
		
	</form>	
    </div><!-- /#right-panel -->
	

 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 