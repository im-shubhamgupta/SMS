<?php 

if(isset($_REQUEST['registration_no'])){
	 $registration_no= $_REQUEST['registration_no'];     
    }else{
	  $registration_no='';  
    }
    
include('myfunction.php');
	echo classes();
	
?>