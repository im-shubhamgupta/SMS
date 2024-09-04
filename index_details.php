<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	// session_start();
	include_once('connection.php');
	include_once('myfunction.php');
	
	extract($_REQUEST);
		
		echo "<pre>";
		print_r($_REQUEST);
		echo "</pre>";	

	if(isset($save)){

	
		$username = mysqli_real_escape_string($con, $_REQUEST['username']); 
		$password = mysqli_real_escape_string($con, $_REQUEST['password']); 
		//$npass=md5($password);
		$loginuser = mysqli_real_escape_string($con, $_REQUEST['user']); 
		
		$session=$_REQUEST['session'];
		
		if($username=="" and $password=="")
		{
		$err="<span style='color:red'>Pls fill all details.</span>";	
		}
		else
		{
			// echo "select * from users where username='$username' and pass='$password' and roles='$loginuser' and status='1' ";
			
			$query=mysqli_query($con,"select * from users where username='$username' and pass='$password' and roles='$loginuser' and status='1' ");




			 $row=mysqli_num_rows($query);

			// die('stopp1');
			if($row)
			{
				$res=mysqli_fetch_array($query); 
						
				$_SESSION['user_logged_in']=$res['email'];
				
				$_SESSION['user_roles']=$res['roles'];
				
				$_SESSION['session']=$session;
				
				
				echo "<script>window.location='dashboard.php'</script>";

			// die('stopp123');
			}

			else
			{
				$err="<span style='color:red'>Invalid Login Details.</span>";
			}
		}
	
	}
?>
<?php
if(!empty($_SESSION['registration_no'])){
	
	include_once('DynamicConfig.php');
	$regis_no=$_SESSION['registration_no'];
	$c_name=get_school_details()['company_name'];
	// $c_name=get_school_by_register_no($regis_no)['name'] ?? '';
	
		$c_logo=get_school_details()['company_image_path'];
		// $c_logo="https://abhigya.in/schools/Image/".get_school_by_register_no($regis_no)['image'] ?? '';
	// }
	

}



?>
<!doctype html>
<html class="no-js" lang="en">
<!--<![endif]-->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$c_name?> | Admin Dashboard</title>
    <meta name="description" content="It Automates All Operations, Reduces Costs And Equips Users With Powerful Reporting Tools. Education CRM software for the Administration of Schools, Colleges & Universities. Fully-Customizable System. Role specific access. Access on Any Device.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="iSoftCare Technology">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <!-- <link rel="shortcut icon" href="favicon.ico"> -->
    <!-- <link rel="shortcut icon" href="images/profile///get_school_details()['company_image']?? ''"> -->
    <link rel="shortcut icon" href="<?=$c_logo?>">


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
</style>
</head>

<body class="bg-dark">
    <div class="sufee-login d-flex align-content-center flex-wrap" style="margin-top:-30px;">
        <div class="container">
            <div class="login-content" style="height:500px;">
                <div class="login-logo">
					<center><img src="<?=$c_logo?>" title="<?=$c_name?>"  style="margin-top:5px; width:40px; height:40px;"></center>
                    <a href="<?=$baseurl?>" style="color:white;font-size:30px;font-weight:bold">
                       <!-- [ Institute Management Software ] -->
					   <?=$c_name?>
                    </a>
                </div>
                <div class="login-form" style="padding:20px 50px 50px 50px;border-radius:40px;background-color: rgba(0, 0,0, 0.6);box-shadow:2px 2px 7px 2px gray;">
				<div style="color:red;font-weight:bold;"><?php echo @$err; ?></div><br>
                    <form method="post">
						<div class="form-group">
                            <label>User Name</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" autofocus required>
                        </div>
                            
						<div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" autofocus required>
                        </div>
						
						<div class="form-group">
                            <label>User Type</label>
                            <select class="form-select" name="user" autofocus required>
							<option value="Admin">Admin</option>
							<option value="Superadmin">Technical</option>
							<option value="Account">Account</option>
							<option value="Stock">Stock</option>
							<option value="Library">Library</option>
							<option value="Systemuser">System User</option>
							<option value="Transport">Transport</option>
							</select>
                        </div>
						
						<div class="form-group">
							<label>Academic Year</label>
							<select class="form-select" name="session" autofocus required>
							<option value="" selected="selected" disabled>Academic Year</option>
							<?php 
							  $query=mysqli_query($con,"SELECT id,year from session");
							  $numrow=mysqli_num_rows($query);
							  if($numrow>0){
														 
							  while($ResSession=mysqli_fetch_assoc($query)){
						      echo '<option value="'.$ResSession["id"].'">'.$ResSession["year"].'</option>';
							
							  }
							  }
							 ?> 
							
							</select>
                        </div><br>		
                        
						<button type="submit" name="save" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                          
						<div class="checkbox">
							<!--<label>
							<input type="checkbox"> Remember Me
							</label>-->
							
							<label class="pull-right">
							<a href="forget_password.php">Forget Password?</a>
							</label>
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


</body>

</html>
