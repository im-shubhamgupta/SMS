<?php
  $host="localhost";
  $Rgistration_No=trim($_REQUEST['registration_no']);
  if(!empty($Rgistration_No)){ 
      // $db = new mysqli("localhost", "abhigya_sch_db", "Sch_DB@#123$", "abhigya_schools");
      $db = new mysqli("localhost", "root", "", "abhigya_schools");
      $Query = $db->query("SELECT * FROM `school_details` WHERE `registration_no` = '".$Rgistration_No."' AND `status` = '1' ");
      if($Query->num_rows > 0){
        
        $Row = $Query->fetch_assoc();

         $dbname = trim($Row["db_name"]);
         $db_user = trim($Row["username"]);
         $db_password = trim($Row["password"]);
        $con=mysqli_connect($host,$db_user,$db_password,$dbname)or die(mysqli_connect_error());
        // echo "dynamic db connected";
      }else{
        $response["status"] = 0;
        $response["message"] = "DB Not Selected check Registration_no";
        $response["result"] = [];
        echo json_encode($response);  die;
        // die("DB Not Selected check Registration_no");   
      }
  }else{ 
      // $database="abhigya_mch_tekari_copy";
      // $user="abhigya_admin";
      // $pass="Admin@#123$";
      $database="psoft_school_beta";
      $user="root";
      $pass="";
      $con=new mysqli($host,$user,$pass,$database)or die(mysqli_connect_error());
      // $response["status"] = 0;
      // $response["message"] = "Please Enter  Registration_no";
      // $response["result"] = [];
      // echo json_encode($response);  die;
  }


// Firebase API Key
// define('FIREBASE_API_KEY', 'AAAAMDGQTqs:APA91bH0rm7cQiLS41q00fmFjbPM_mscd_f66s57tpB7f5F2VtyIPXgr5uiaar991jjSgzhX6FG4Fs4GelgPpVi4Xdo7BNbCOWF-pnSgl0n6uzCoIbmsrRFbKCX2UaRhXGalZPyL1aPS');

?>