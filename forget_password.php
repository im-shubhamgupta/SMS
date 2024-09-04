<!doctype html>
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Institute Fees Management | Admin Dashboard</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">


    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">

    <link rel="stylesheet" href="assets/css/style.css">

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


    <div class="sufee-login d-flex align-content-center flex-wrap" style="margin-top:120px;">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.php" style="color:black;font-size:30px;font-weight:bold">
                       [ Forget Password ]
                    </a>
                </div><br>
                <div class="login-form" style="padding:80px;border-radius:20px">
			
                    <form method="post" action="mail.php">
                        <div class="form-group">
                            <label style="color:black;font-weight:bold">Enter Your Email Id</label>
                            <input type="text" name="email" class="form-control" placeholder="Enter Email" required>
                        </div>
						
						<div style="color:green;font-weight:bold"><?php echo @$err; ?></div><br>
                         <br>
            
			<input type="submit" name="save" class="btn btn-primary btn-flat m-b-30 m-t-30" value="Continue"/>
                             
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
