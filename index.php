<?php

   $pathurl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".dirname($_SERVER['PHP_SELF']);

  $demo=0;
  // echo $path_link=dirname($_SERVER['SCRIPT_NAME']); 

    if($pathurl === 'https://abhigya.in/beta/sms' || $pathurl === 'http://localhost/beta/sms' ){
        $baseurl ='https://abhigya.in/beta/sms/';  
  
        $demo=1;   
    }else{ 
        $baseurl ='https://abhigya.in/';//live    
        $demo=0;
    }

   
?>
<!doctype html>
<html class="no-js" lang="en">
<!--<![endif]-->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Admin Dashboard</title>
    <meta name="description" content="It Automates All Operations, Reduces Costs And Equips Users With Powerful Reporting Tools. Education CRM software for the Administration of Schools, Colleges & Universities. Fully-Customizable System. Role specific access. Access on Any Device.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="iSoftCare Technology">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <!-- <link rel="shortcut icon" href="favicon.ico"> -->
    <!-- <link rel="shortcut icon" href="images/profile/<?//get_school_details()['company_image']?>"> -->


    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">

    <link rel="stylesheet" href="assets/css/style.css">
	
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<style>
body { 
  background-image: url('images/background.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
.login-form .btn {
    padding: 8px;
}
.error{
	color:red;
}
.success{
	color:green;
}
</style>
</head>

<body class="bg-dark">
    <div class="sufee-login d-flex align-content-center flex-wrap" style="margin-top:-30px;">
        <div class="container">
            <div class="login-content" style="height:500px">
                <div class="login-logo">
                    <a href="<?=$baseurl?>" style="color:white;font-size:30px;font-weight:bold">
                        Abhigya Institute Management Software (AIMS)
                    </a>
                </div>
                <div class="login-form" style="padding:50px;border-radius:40px;background-color: rgba(0, 0,0, 0.6);box-shadow:2px 2px 7px 2px gray;margin-top: 55px;">
				<div style="color:red;font-weight:bold;"><?php echo @$err; ?></div><br>
                    <form method="post" id="Registration-form" autocomplete="off">
						<div class="form-group">
                            <label>Registration No.</label>
                            <?php if($demo==1){ ?>
                                <input type="text" name="registration_no" class="form-control" placeholder="Enter Registration no." value="1234567891" autofocus required>

                          <?php }else{ ?>
                                <input type="text" name="registration_no" class="form-control"  placeholder="Enter Registration no." autofocus required>


                          <?php  } ?>
                            
                            <span id="error" class='error'></span>
                        </div>
                        <center><span id='success' class="success"></span></center><br>
						<button type="submit" name="save" id="registration_btn" class="btn btn-success btn-flat m-b-30 m-t-30">Submit</button>
                          
						<div class="checkbox">
							
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script> 
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- <script src="https://code.jquery.com/ui/1.9.2/jquery-ui.min.js"></script> 	  -->

 <script>
 	"use strict";
 	// alert(12);
 	$(document).ready(function(){	
 	// toastr.options = {		
 	// 	"closeButton": true, 
	// 	"debug": false,"newestOnTop": false,
	// 	"progressBar": true,
	// 	"positionClass": "toast-bottom-right",	
	// 	"preventDuplicates": false,	
	// 	"onclick": null,	
	// 	"showDuration": "300",
	// 	"hideDuration": "1000",	
	// 	"timeOut": "5000",		
	// 	"extendedTimeOut": "1000",
	// 	"showEasing": "swing",	
	// 	"hideEasing": "linear",	
	// 	"showMethod": "fadeIn",
	// 	"hideMethod": "fadeOut"	
	// 	};				


   $('#registration_btn').click(function(e){	
   		  	  	e.preventDefault();
   		  	
         // $("input[type='hidden']").removeAttr('name');

            var action ='school_registation_no';     
            $(this).append('<input type="hidden" name="'+ action+'"/>'); 

            var formData =new FormData($('#Registration-form')[0]);
            $('#registration_btn').attr('disabled',true);
            // $('#saveattendence').val('Please wait...');

            // var formData =$('#Attendance-form').serialize();		
            // console.log(formData);   
                  		 		
        $.ajax({              	
 		    type: "POST",    
            // url : 'AjaxSignin.php', 
 		    url : 'DynamicConfig.php', 
 		    data : formData, 
 		    contentType: false,   
		    	cache: false,    
		    	processData:false, 
		    	success: function (responce) {  
		    	var responce = JSON.parse(responce);	
 		    	    if(responce.type=='SUCCESS') {  
 		    	    	 $('#registration_btn').attr('disabled',false);
 		     		  	 $('#error').html(""); 
 		    	    	// toastr.success(responce.msg);	
 		    	    	setInterval(function(){
 		    	    	// $('#attendance').empty();	
 		    	    	$('#success').html("Successful");
 		    	    	window.location.href = "index_details.php";			
 		    	    		},1000);
 		    	    }else{      
 		    	    	$('#registration_btn').attr('disabled',false);
 		    	    	$('#error').html(responce.msg);
 		    	    	// toastr.error("Somethings is Wrong");			
 		    	    }
 		  	    }	
 		  	});
 	
 		  	return false;	 
 	    });
 	}); 

</script>

</body>

</html>
