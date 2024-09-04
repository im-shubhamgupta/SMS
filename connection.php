<?php
	if(isset($_GET['debugTest']) && $_GET['debugTest'] == 1){
	    ini_set('display_errors', 1);
	    ini_set('display_startup_errors', 1);
	    error_reporting(E_ALL);
	}

	if(!isset($_SESSION)){
		session_start();
	}
    
	error_reporting(1);
	$host="localhost";
	// echo "<pre>";
	// 	print_r($_REQUEST);
	// 	print_r($_SESSION);
	// 	echo "</pre>";
	
	// $user="abhigya_sch_db";
	// $pass="Sch_DB@#123$"; 
	// $user="root";
	// $pass=""; 
// $pass="AIms@#123$"; 	
// print_r($_SESSION);
	
	$regdb="psoft_school_admin";

	// $maindb=new mysqli($host,$user,$pass,$regdb);

	
	if(isset($_SESSION['db_name']) && !empty($_SESSION['db_name'])){
		// echo "<pre>";	print_r($_SESSION);	echo "</pre>";
		$database=$_SESSION['db_name'];
	    $user=$_SESSION['username'];
	    $pass=$_SESSION['password'];
	
		$con=mysqli_connect($host,$user,$pass,$database)or die(mysqli_connect_error());
	}else{
		echo "<script>window.location='index.php'</script>";die('connection error');
	}	

	// if($con){
	// 	echo "<br>connected";
	// }else{
	// 	echo "<br>not connected";
	// }

		
	$baseurl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".dirname($_SERVER['PHP_SELF']);

	date_default_timezone_set("Asia/Kolkata");
	?>