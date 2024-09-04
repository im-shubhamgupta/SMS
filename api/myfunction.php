<?php
include('dbcontroller.php');


function login($mobile,$password,$user_type, $session,$TokenId,$api_url,$registration_no){  

    

  global $con;
  @$temp = array();
   $Remarks = 'Login has been successfully';
  
  if($user_type==1){
    $query = mysqli_query($con,"select * from users where (username='$mobile' || email='$mobile' || phone='$mobile') && pass='$password'");
	$row = mysqli_num_rows($query);
	if($row){
		$res = mysqli_fetch_assoc($query);
		@$temp = array();
	    $temp['user_id'] = $res['user_id']; 
	    $temp['username'] = $res['username']; 
	    $temp['roles'] = $res['roles']; 
	    $temp['phone'] = $res['phone']; 
	    $temp['email'] = $res['email']; 
	    $temp['user_type'] = $user_type;
	    $temp['session'] = $session;
		$temp['session_year'] =  getSessionByid($session)['year'];
	    $temp['registration_no'] = $registration_no;
	    $temp['api_url'] = $api_url.'api/managementapp/'; 
	    

		
		$temp['profile_image'] = !empty($res['profile_image']) ? Call_Baseurl()."/sms/images/admin/".$res['profile_image'] : Call_Baseurl()."/sms/images/no_image.png" ;
		
		   
	    $temp['token_id'] =  ($TokenId!='') ? $TokenId : '' ;

	    $usql="UPDATE `users` SET `token_id` = '".$TokenId."' WHERE `user_id` = '".$res['user_id']."'";
        $UQuery = $con->query($usql);
	}
      
  }elseif($user_type==2){
//    echo "select * from staff where mobno='$mobile' && password='$password'"; 
   $query=$con->query("select * from staff where mobno='$mobile' && password='$password'");
   if($query->num_rows>0){
  
     $res = $query->fetch_assoc();
     // $Teacherid = $res['st_id']; 

	 $temp['id'] = $res['st_id']; 

	 $temp['staffname'] = $res['staff_name'];

	 $temp['user_type'] = $user_type;
	 $temp['session'] = $session;
	  $temp['registration_no'] = $registration_no;

	 $temp['api_url'] = $api_url.'api/teachersapp/'; 
	 $temp['token_id'] =  ($TokenId!='') ? $TokenId : '' ;
	// $query=$con->query("update staff SET session='$session'  where  st_id='$Teacherid'");

	 // Update Token for Firebase Notification
	   $usql="UPDATE `staff` SET `token_id` = '".$TokenId."' , `modify_date`=now() WHERE `st_id` = '".$temp['id']."'";
     $UQuery = $con->query($usql);
      $Title="Login Successfully!";
    push_notification_android($TokenId,$Title, $Remarks);


   }

   }elseif($user_type==3){
   	$ssql="select `student_id`,register_no,student_name,stu_image,father_name,student_contact,`parent_no`,gender,dob,stuaddress,`msg_type_id`,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where parent_no='$mobile'  && password='$password' && s.stu_status='0' && sr.session='$session' ";

      
    $que1 = mysqli_query($con,$ssql);

    if($que1->num_rows>0){  
       
     $res = mysqli_fetch_array($que1);

     $temp['student_name'] = $res['student_name'];
	 $temp['father_name'] = $res['father_name'];
	 $temp['parent_no'] = $res['parent_no'];
	 $temp['gender'] = $res['gender'];
	 $temp['dob'] = $res['dob'];
	 $temp['stuaddress'] = $res['stuaddress'];
	 $temp['academic_year']=getSessionByid($res['session'])['year'];
	 $temp['class']= GetClass($res['class_id']);
	 $temp['section']= Getsection($res['section_id']);
	 $temp['user_type'] = $user_type;
	 $temp['session'] = $session;
	 $temp['registration_no'] = $registration_no;
	$temp['api_url'] = $api_url.'api/parentapp/';
	$temp['token_id'] = ($TokenId!='') ? $TokenId : '' ; 
	$temp['installed_app'] = check_installed_app_bymob($res['parent_no']); 

	// $usql="UPDATE `students` SET `token_id` = '".$TokenId."' WHERE `student_id` = '".$res['student_id']."'";
	$usql="UPDATE `students` SET `token_id` = '".$TokenId."',modify_date=now() WHERE `parent_no` ='".$res['parent_no']."'";
    $UQuery = $con->query($usql);
    $Title="Login Successfully!";
    push_notification_android($TokenId,$Title, $Remarks);
	 
       
    }
   }
   return $temp;
} 


function forgetpassword($usertype,$username)

{

	global $con;

	

	if($usertype=="parent")

	{

		$que1 = mysqli_query($con,"select * from students where parent_no='$username'");

		$row1 = mysqli_num_rows($que1);	

		

		if($row1)

		{	

			$res = mysqli_fetch_array($que1);

			$password = $res['password'];

			$mobile = $res['parent_no'];

			

			$msg = "Your password is ".$password.".";

			

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

				'message' => $msg,

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

			

			

			$temp['password'] = $password;

			echo json_encode($temp);

			return "Password is sent to registered number.";

		}

		

	}

	else if($usertype=="teacher")

	{

		$que2 = mysqli_query($con,"select * from staff where mobno='$username'");

		$row2 = mysqli_num_rows($que2);	

		

		if($row2)

		{	

			$res = mysqli_fetch_array($que2);

			$password = $res['password'];

			$mobile = $res['mobno'];

			

			$msg = "Your password is ".$password.".";

			

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

				'message' => $msg,

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

			

			

			$temp['password'] = $password;

			echo json_encode($temp);

			return "Password is sent to registered number.";

		}

	}

	else if($usertype=="admin")

	{

		$que3 = mysqli_query($con,"select * from users where email='$username'");

		$row3 = mysqli_num_rows($que3);	

		

		if($row3)

		{	

			$res = mysqli_fetch_array($que3);

			$password = $res['pass'];

			$mobile = $res['phone'];

			

			$msg = "Your password is ".$password.".";

			

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

				'message' => $msg,

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

			

			

			$temp['password'] = $password;

			echo json_encode($temp);

			return "Password is sent to registered number.";

		}

	}	

	

	else

	{

		return "Invalid Username";

	}

}
function session(){
	global $con;
	$data=array();
	$sessionQuery= $con->query("SELECT * FROM session WHERE 1");
	if($sessionQuery->num_rows>0){
		while($res=$sessionQuery->fetch_assoc()){
			$temp=array();
			$temp['session_id']=$res['id'];
			$temp['session']=$res['year'];
			array_push($data,$temp);
		}
		return $data;
	}else{
		return $data;
	}	
}
?>