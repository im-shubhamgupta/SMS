<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);
if(isset($sms))
{
	$set=mysqli_query($con,"select * from sms_setting");
	$rset=mysqli_fetch_array($set);
	$senderid=$rset['sender_id'];
	$apiurl=$rset['api_url'];
	$apikey=$rset['api_key'];
	
	$number=$_REQUEST['number'];
    $class = $_REQUEST['class'];
    $section = $_REQUEST['section'];
    $composetext = $_REQUEST['composetext'];
	
	if($class=="" and $section=="")
	{
	$que=mysqli_query($con,"select * from students where stu_status='0'");
	}
	else if($class!="" and $section=="")
	{
	$que=mysqli_query($con,"select * from students where stu_status='0' and class_id='$class'");
	}
	else if($class!="" and $section!="")
	{
	$que=mysqli_query($con,"select * from students where stu_status='0' and class_id='$class' and section_id='$section'");
	}
	
	while($resz=mysqli_fetch_array($que))
	{	
	if($number=="student")
	{
	$mobile=$resz['student_contact'];
	}
	else
	{
	$mobile=$resz['parent_no'];
	}
		
	//Send sms to sender and reciever
	$senderId = "$senderid";
		$route = 4;
		$campaign = "OTP";
		$sms = array(
			'message' => $composetext,
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
	//Send sms to sender and reciever
	//print_r(explode(",",$response));
	
	$q1=mysqli_query($con,"insert into notifications(selected_no,content,date)values('$mobile','$composetext',now())");
	}
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  


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
  <span class="breadcrumb-item active"> Send Notification   
</span>
</nav>
<!-- breadcrumb -->
<div id="right-panel" class="right-panel">

   <form method="post">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row" style="margin-top:20px;">
								
								<div class="col-md-2" style="font-size:14px;">Select Class</div>
								<div class="col-md-2" style="margin-top:-8px;">
								<select style="width:150px;position:absolute;margin-left:-18px" name="class" id="class" class="form-control" onchange="search_sec(this.value)">
								<option value="" selected="selected">All</option>
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
								
								<div class="col-md-1" style="font-size:14px;margin-left:100px;">Section </div>
								<div class="col-md-2" style="margin-top:-8px;">
								<select class="form-control" style="width:150px" name="section" id="search_sect">
								<option value="" selected="selected" disabled>All</option>
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
								xmlhttp.open("get","search_ajax_section.php?cls_id="+str,true);
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
								
								
								<div class="col-md-3" style="font-size:14px;margin-left:20px">Select Number</div>
								<div class="col-md-3" style="margin-left:120px;margin-top:-10px">
								<select name="number" class="form-control" style="width:150px;position:absolute;margin-left:630px;margin-top:-30px;	"  onchange="search_count()">
								<option selected="selected"  disabled>Select Number</option>
								<option <?php if($number=="student"){echo "selected";}?> value="student">Student</option>
								<option <?php if($number=="parent"){echo "selected";}?> value="parent">Parent</option>					
								</select>
								</div>
							
						</div><br>
						<style>
						
						</style>
						<div class="row" style="margin-top:20px;">
								<div class="col-md-3" style="font-size:14px;">Compose Text</div>
								<div class="col-md-2" style="font-size:14px;"></div>
								<textarea id="composetext" name="composetext" class="form-control" style="width:250px;height:100px;margin-left:140px;position:absolute"></textarea>
								<div class="col-md-4" style="font-size:14px;margin-left:26px;">SMS Type </div>
								<div class="col-md-2" style="margin-top:-8px;margin-left:-200px;">
								<select name="class" class="form-control" style="width:150px;margin-top:8px;margin-left:-28px">
								<option value="" selected="selected" disabled>Select Type</option>
								<option value="english">English</option>
								<option value="others">Others</option>					
								</select>
								</div>
						</div>
						<br>
						<br><br>
						<hr style="height:2px solid grey">
						
						<div class="row" style="margin-top:90px;">
								
								<div class="col-md-2" style="font-size:14px;">Char Count</div>
								<div class="col-md-2" style="margin-top:-8px;">
									<input type="text" name="charcount" class="form-control" id="charcount" style="margin-left:-25px;" readonly>		
								
								</div>
								
								<div class="col-md-2" style="font-size:14px;">SMS Count</div>
								<div class="col-md-2" style="margin-top:-8px;">
									<input type="text" name="smscount" class="form-control" id="smscount" style="margin-left:-50px;" readonly>		
								</div>
								
								<div class="col-md-2" style="font-size:14px;">Total Numbers</div>
								<div class="col-md-2" style="margin-top:-8px;">
									<input type="text" name="totalnum" class="form-control" id="deliverych" value="<?php echo $sr;?>" style="margin-left:-30px;" readonly>		
								</div>
								<script>			
					function search_count() 													
					{
					var classid=$("#class").val();
					var secid=$("#search_sect").val();			
					//alert (rec_zone);
					
					var dataString={'cid':classid,'secid':secid};
								$.ajax({  
								 url:"search_total_number.php",  
								 method:"POST",  
							   data:dataString, 
								 success:function(data)
								 {  
									   $('#deliverych').val(data);
								 }  
							});
					}		
					</script>	
						</div><br><br>
						
						
					</div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		<div style="text-align:center">
		<input type="submit" name="sms" value="Send SMS" id="add" class="btn btn-primary btn-md"/>
		<input type="reset" name="reset" value="Cancel" class="btn btn-primary btn-md"/>
		</div>
	</form>	
    </div><!-- /#right-panel -->
	
<script>
	$(function () {
		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 
		$('#composetext').keyup(function () {
			var tsms=1;
			//.val() will give the text from the textbox and .length will give the number of characters
			var txtlen = $(this).val().length;
			
			if(txtlen>=160)
			{
				var tsms=tsms+1;
			}
			
			//alert('Hi');
			//the below lines will display the results 
			$('#charcount').val(txtlen);
			$('#smscount').val(tsms);
			
		});
	});
</script>
	
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 