<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);


/*$x=1;
$email=$_SESSION['user_logged_in'];

$username=$res['username'];



if(isset($sms))

{
	// echo "<pre>";
	// print_r($_POST);

	
	$set=mysqli_query($con,"select * from sms_setting");

	$rset=mysqli_fetch_array($set);

	$senderid=$rset['sender_id'];

	$apiurl=$rset['api_url'];

	$apikey=$rset['api_key'];

	$category = $_REQUEST['category'];

	$dept = $_REQUEST['dept'];

	

	$composetext1 = $_REQUEST['composetext1'];

    //$composetext2 = $_REQUEST['composetext2'];

    

	//$heading1 = $_REQUEST['heading1'];

	

	if($category==1)

	{

		$compose = $composetext1;

		$messagetype = "staff_notification";

	}
	

	if($category=="1")

	{

	$que=mysqli_query($con,"select * from assign_department where dept_id='$dept'");

	}

	

	

	while($resz=mysqli_fetch_array($que))

	{		

		$stid=$resz['staff_id'];

		

		$q1 = mysqli_query($con,"select * from staff where st_id='$stid'");

		$r1 = mysqli_fetch_array($q1);
		// echo "<pre>";
		// print_r($r1);

		$msgtype=$r1['msg_type_id'];

		 $mobile=$r1['mobno'];

		

		if($check)

		{

			if($msgtype==1)

			{

				$q2=$con->query("insert into staff_notifications(category,dept_id,staff_id,selected_no,message,loginuser,notice_datetime,date) values('$category','$dept','$stid','$mobile','$compose','$username',now(),now())");

				

				//Send message via whatsapp

				$encod=urlencode($compose);

				 $msg = $encod;
				// die;

				sendwhatsappMessage($mobile, $msg, $messagetype);
			

				//Send message via whatsapp

			}

						

				//Send text message

				$msg = $compose;
				// echo "nsms"; 
				// die;
				sendtextMessage($mobile, $msg, $messagetype);
				

				//Send text message

		}

		else

		{

		if($msgtype==1)

		{

			$q2=mysqli_query($con,"insert into staff_notifications(category,dept_id,staff_id,selected_no,message,loginuser,notice_datetime,date)

			values('$category','$dept','$stid','$mobile','$compose','$username',now(),now())");

			

			//Send message via whatsapp

			$encod=urlencode($compose);

			 $msg = $encod;
			
			sendwhatsappMessage($mobile, $msg, $messagetype);
			


			//Send message via whatsapp

		}

		else if($msgtype==2)

		{

			//Send text message

			$msg = $compose;
			// die;
			// sendtextMessage($mobile, $msg, $messagetype);

			//Send text message

		}	

		}

	}

	

	echo "<script>window.location='dashboard.php?option=send_staff_notification'</script>";

}
*/


?>



<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  

<script src="multi.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script type="text/javascript" src="http://www.google.com/jsapi"></script>

	

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



<script type="text/javascript">

        // Load the Google Transliteration API

        google.load("elements", "1", {

          packages: "transliteration"

        });



        function language(str) {

			if(str=="kn")

			{

			var options = {

            sourceLanguage: 'en',

            destinationLanguage: ['kn'],

            shortcutKey: 'ctrl+m',

            transliterationEnabled: true

			}

			}

			else if(str=="te")

			{

			var options = {

            sourceLanguage: 'en',

            destinationLanguage: ['te'],

            shortcutKey: 'ctrl+m',

            transliterationEnabled: true

			}

			}

			else

			{

			var options = {

            sourceLanguage: 'en',

            destinationLanguage: ['en'],

            shortcutKey: 'ctrl+m',

            transliterationEnabled: true

			}	

			}

		

		  // Create an instance on TransliterationControl with the required options.

          var control = new google.elements.transliteration.TransliterationControl(options);



          // Enable transliteration in the textfields with the given ids.

         

		  var categ = $("#category").val();

		  if(categ==1)

		  {

			var ids = ["composetext1"];

            control.makeTransliteratable(ids);

		  }

	 



          // Show the transliteration control which can be used to toggle between English and Hindi and also choose other destination language.

          control.showControl('translControl');

        }



        google.setOnLoadCallback(onLoad);

      </script>



<!-- breadcrumb-->

<style>



input[type=checkbox] {

    zoom: 1.8;

	margin-top:5px;

}

</style>

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Communication Panel</a>

  <a class="breadcrumb-item" href="#"> Staff Communication</a>

  <span class="breadcrumb-item active"> Send Notification</span>

</nav>

<!-- breadcrumb -->

<form method="post" enctype="multipart/form-data"> 

<div class="row" style="margin-top:50px;margin-left:20px;">

	<div class="col-md-2">Category : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-40px;">

	<select style="width:165px;" name="category" id="category" onchange="test456()" 

	class="form-control" required>

	<option value="" selected="selected" disabled>Select Category</option>

	<option value="1">Message</option>						

	<!--<option value="3">Messages</option>						

	<option value="6">Study Materials</option>	-->

	</select>

	</div>

	

	<div class="col-md-2" style="margin-left:30px">Select Department : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px">

	<select style="width:180px;" name="dept" id="dept" onchange="totalstaff(this.value)" 

	class="form-control" required>

	<option value="" selected="selected" disabled>Select Department</option>

	<?php

	$qgrp = mysqli_query($con,"select * from department");

	while( $rgrp = mysqli_fetch_array($qgrp) ) {

	?>

	<option <?php if($group==$rgrp['dept_id']){echo "selected";}?> value="<?php echo $rgrp['dept_id']; ?>"><?php echo $rgrp['dept_name']; ?>

	</option>

	<?php } ?>							

	</select>

	</div>

	

	<div class="col-md-2" style="margin-left:30px;">Select Languaue : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px">

	<select style="width:150px;" class="form-control" onchange="language(this.value)" required>

	<option value="en">English</option>						

	<option value="kn">Kannada</option>						

	<option value="te">Telugu</option>						

	</select>

	</div>

</div>

<br><br>



	<script>

	function test456()

	{

		var p = document.getElementById("category").value

		if(p=="1")

		{

			document.getElementById("message").style="display:block";

			document.getElementById("composetext2").required=true;

		}

		

	}

	

		function totalstaff(str)

			{

			

				var xmlhttp= new XMLHttpRequest();

				xmlhttp.open("get","count_ajax_dept_staff.php?deptid="+str,true);

				xmlhttp.send();

				xmlhttp.onreadystatechange=function()

				{

				if(xmlhttp.status==200  && xmlhttp.readyState==4)

				{

				document.getElementById("staffcount").value=xmlhttp.responseText;

				

				}

				} 

				

			}

			

	</script>





<div class="row">



<!---- Message ---->

	<div class="col-md-12" id="message" style="display:none">

	<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;">

		<div class="col-md-2" style="margin-top:20px;">Message : </div>

		<div class="col-md-2" style="margin-left:-40px;">

		<textarea id="composetext1" name="composetext1" class="form-control" style="width:300px;height:200px;"></textarea>

		</div>	

	</div>

	</div>

<!---- Message ---->





</div>



<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;" id="stcount">	

	<div class="col-md-2">Characters : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-40px">

		<input type="text" name="charcount" class="form-control" id="charcount" style="width:150px;" readonly>		

	</div>

	<div class="col-md-2" style="margin-left:30px;">Staff Count : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-40px">

		<input type="text" name="staffcount" class="form-control" id="staffcount" style="width:150px;" readonly>		

	</div>

</div>



<hr style="height:2px solid grey">



<div>

<input type="checkbox" name="check" checked style="margin-left:150px;">Send SMS

<input type="submit" name="sms" value="Send" id="add" style="margin-left:40px;" class="btn btn-primary btn-sm"/>

<input type="reset" name="reset" value="Cancel" style="margin-left:40px;" class="btn btn-info btn-sm"/>

</div>

</form>



<script>

	$(function () {

		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 

		$('#composetext1').keyup(function () {

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

			

		});

	});

</script>



<script>

	$(function () {

		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 

		$('#composetext2').keyup(function () {

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

			

		});

	});

</script>



<script>

	$(function () {

		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 

		$('#composetext3').keyup(function () {

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

			

		});

	});

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script> 
 <script>$(document).ready(function(){	
 	toastr.options = {		
 		"closeButton": true, 
		"debug": false,"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-bottom-right",	
		"preventDuplicates": false,	

		"onclick": null,	
		"showDuration": "300",
		"hideDuration": "1000",	
		"timeOut": "6000",		
		"extendedTimeOut": "1000",
		"showEasing": "swing",	
		"hideEasing": "linear",	
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"	
		};					}); 


</script>
<script>
$('form').on('submit',function(e){

   	e.preventDefault();
   // var Toarr = [];
// 	$("#multiselect_to_1 > option").each(function(){
// 	   Toarr.push(this.value);
// 	   // console.log(this);
// 	});
    	if(confirm("Are you sure want to send SMS")){

    			 $('input[type="submit"]').attr('disabled',true);
 		    	 $('input[type="submit"]').val('Please wait...')
       
            var action ='send_staff_notification';     
            $(this).append('<input type="hidden" name="'+ action+'"/>');   
            // var formData =new FormData($('#devel-generate-content-form')[0]);
            var formData =new FormData(this);
            // formData.append("to_student_id", Toarr);
            	
				// 			for (i = 0; i < Toarr.length; i++) {
              	// formData.append("to_student_id["+i+"]", Toarr[i]);
			    //     } 

                   		 		
        $.ajax({              	
 		    type: "POST",    
 		    url : 'Controllers/CommunicationControllers.php', 
 		    data : formData,
 		    contentType: false,   
		    	cache: false,    
		    	processData:false, 
		    	success: function (res) {  
		    	var responce = JSON.parse(res);
		    	// console.log(response);	
 		    	    if(responce.status=='success') {  
 		    	    	 
 		    	    	toastr.success(responce.message);	
 		    	    	setInterval(function(){
 		    	    	
 		    	    	// window.location.reload();
 		    	    	window.location.href = "dashboard.php?option=send_staff_notification";			
 		    	    		},6000);
 		    	    }else{      
 		    	    	
 		    	    	toastr.error(responce.message);	
 		    	    }
 		    	     $('input[type="submit"]').attr('disabled',false);
 		    	     $('input[type="submit"]').val('Send Now'); 		
 		    	}					
 		});
 	}else{
 		return false;	
 	}       	 
 		

    });
    // });
</script> 

 

<script type="text/javascript">

jQuery(document).ready(function($) {

    $('.multiselect').multiselect();

});

</script>