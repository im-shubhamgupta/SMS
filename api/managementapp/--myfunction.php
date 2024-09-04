<?php
include('../../connection.php');
include('../dbcontroller.php');  
// extract($_REQUEST);	

function login($email,$password)
{
	global $con;
	$data=array();
	$query = mysqli_query($con,"select * from users where email='$email' && pass='$password'");
	$row = mysqli_num_rows($query);
	if($row){

		$res = mysqli_fetch_assoc($query);
		@$temp = array();
	    $temp['user_id'] = $res['user_id']; 
	    $temp['username'] = $res['username']; 
	    $temp['roles'] = $res['roles']; 
	    $temp['phone'] = $res['phone']; 
	    $temp['email'] = $res['email']; 
	    $temp['profile_image'] = ($res['profile_image']) ? ($res['profile_image']) : "no_image.png" ; 
	    array_push($data,$temp);

		return $data;

	}else{
		return "";
	}
}


function profile($user_id){

	global $con;
	$data=array();
	$query = mysqli_query($con,"select * from users where user_id='$user_id'");
	$row = mysqli_num_rows($query);
	if($row)
	{		
		$res = mysqli_fetch_array($query);
		@$temp = array();
		$temp['user_id'] = $res['user_id']; 
	    $temp['username'] = $res['username']; 
	    $temp['roles'] = $res['roles']; 
	    $temp['phone'] = $res['phone']; 
	    $temp['email'] = $res['email']; 
	    $temp['profile_image'] = ($res['profile_image']) ? ($res['profile_image']) : "no_image.png" ; 
		array_push($data,$temp);

		return $data;
	}
	else
	{
		return "";
	}
}

 function ClassNameById($class_id){
	 global $con;
	 $ClassQuery= $con->query("SELECT * FROM class WHERE class_id='$class_id'");
	 if($ClassQuery->num_rows>0){
		$ClassRow=  $ClassQuery->fetch_assoc();
		$class_name=$ClassRow['class_name'];
		return $class_name;
		 
	 }else{
		return '';
		  
		 
	 } 
 }
 
  function SectionNameById($section){
	 global $con;
	 $sectionQuery= $con->query("SELECT * FROM section WHERE section_id='$section'");
	 if($sectionQuery->num_rows>0){
		$SectionRow=  $sectionQuery->fetch_assoc();
		$section_name=$SectionRow['section_name'];
		return $section_name;
		 
	 }else{
		return '';
		  
		 
	 } 
 }

 function studentdetail($sessionid,$class_id){
	 global $con;
	$data = array();
	$q1=mysqli_query($con,"select * from students where stu_status='0' AND  class_id= '$class_id' AND session='$sessionid'");
	$row=mysqli_num_rows($q1);
	if($row)
	{	
		@$temp = array();
		while($r2 = mysqli_fetch_array($q1))
		{
			
			$temp['student_id'] = $r2['student_id'];
			$temp['register_no'] = $r2['register_no'];
			$temp['student_name'] = $r2['student_name'];
			$temp['father_name'] = $r2['father_name'];
			$temp['mother_name'] = $r2['mother_name'];
			$temp['gender'] = $r2['gender'];
			$temp['dob'] = $r2['dob'];
			$temp['class'] = ClassNameById($r2['class_id']);
			$temp['section']  = SectionNameById($r2['section_id']);

			array_push($data, $temp);
			}
		
		
			return $data;
	}
	else
	{
		return "";
	}
	 
	 
	 
 }


function studentcount($sessionid)
{
	global $con;
	$data = array();
	$q1=mysqli_query($con,"select * from students where stu_status='0' AND session='$sessionid'");
	$row=mysqli_num_rows($q1);
	if($row)
	{	
		@$temp = array();
		$temp['total_students'] = $row; 
		array_push($data, $temp);
		
		$q2 = mysqli_query($con,"select * from class");
		while($r2 = mysqli_fetch_array($q2))
		{
			
			$classid = $r2['class_id'];
			$classname = $r2['class_name'];

			$q3 = mysqli_query($con,"select * from students where class_id='$classid'");
			$row3 = mysqli_num_rows($q3);
			if($row3)
			{
			@$temp = array();
			$temp['class_id'] = $classid;
			$temp['class_name'] = $classname;
			$temp['no_of_students'] = $row3;
			array_push($data, $temp);
			}
		}
		
			return $data;
	}
	else
	{
		return "";
	}
}


function Student_detailsById($student_id){
	global $con;
  $Query= $con->query("select * from students where stu_status='0' AND  student_id= '$student_id'");
  if($Query->num_rows>0){
	$StudentData=  $Query->fetch_assoc();
   
     $data['student_name']= $StudentData['student_name'];
	  
	return $data;  
  }else{
	  
	 return ''; 
  }
	
	
}


function financedetail($sessionid)
{
	global $con;
	$data = array();
	$q1 = mysqli_query($con,"select * from student_wise_fees");
	$row = mysqli_num_rows($q1);
	if($row)
	{
		
		$discamount = 0;
		$totalfee_tocollect = 0;
		while($res1 = mysqli_fetch_array($q1))
		{
			$discamount = $discamount + $res1['discount_amount'];
			
			$stramt = $res1['fee_amount'];
			$arramt = explode(',',$stramt);
			foreach($arramt as $k)
			{
				$totalfee_tocollect = $totalfee_tocollect + $k;
			}		
		}

		
		$que3 = mysqli_query($con,"select * from previous_fees");
		$totalpre_fee = 0;
		while($res3 = mysqli_fetch_array($que3))
		{
			$prevamt = $res3['previous_fees'];
			$totalpre_fee = $totalpre_fee + $prevamt;
		}
		
		$temp['header_name']= "Total Finance";
		$temp['amount']= $totalfee_tocollect+$discamount+$totalpre_fee; 
		array_push($data, $temp);

		$temp['header_name']= "Total Amount to Collect";
		$temp['amount']= $totalfee_tocollect+$totalpre_fee; 
		array_push($data, $temp);
		
		$que3=mysqli_query($con,"select * from student_due_fees");
		$tpaidamt = 0;
		$tpaidamt1 = 0;
		while($rque3=mysqli_fetch_array($que3))
		{
			$recdamt=$rque3['received_amount'];
			$tranamt=$rque3['transport_amount'];
			$arr = explode(',',$recdamt);
			
			foreach($arr as $k)
			{
			 $tpaidamt1 = $tpaidamt1 + floatval($k) ;
			}
			
			$tpaidamt = $tpaidamt1;
		}
			@$temp = array();
			$temp['header_name']= "Total Paid Amount";
			$temp['amount']= $tpaidamt; 
			array_push($data, $temp);
		
		
		$q1 = mysqli_query($con,"select * from student_wise_fees");
		$dueamt = 0;
		while($r1 = mysqli_fetch_array($q1))
		{
			$dueamt = $dueamt + $r1['due_amount'];
		}
			@$temp = array();
			$temp['header_name']= "Total Due Amount";
			$temp['amount']= $dueamt; 
			array_push($data, $temp);
		
		
		@$temp = array();
		$temp['header_name']= "Total Discount Amount";
		$temp['amount']= $discamount;
		array_push($data, $temp);
		
		return $data;
	}
	else
	{
		return "";
	}
}


function expensename($sessionid)
{
	global $con;
	$data = array();
	
	$q1=mysqli_query($con,"select * from expense_type where sessionid='".$sessionid."'");
	$row=mysqli_num_rows($q1);
	if($row)
	{
			$temp['expense_id'] = '0';
			$temp['expense_name'] = "All";
			array_push($data, $temp);
		
		while($r1 = mysqli_fetch_array($q1))
		{
			$expid = $r1['expense_type_id'];
			$expname = $r1['expense_type_name'];

			$temp['expense_id'] = $expid;
			$temp['expense_name'] = $expname;
			array_push($data, $temp);
			}
			
		    return $data;
	}
	else
	{
		return "";
	}
}


function expensedetail($fromdt,$todt,$expid,$sessionid){

	global $con;
	$data = array();

	if(!empty($fromdt) && !empty($todt)){
		$chgfrdt = date("Y-m-d", strtotime($fromdt));
	    $chgtodt = date("Y-m-d", strtotime($todt));

	    $datesql=" and  date between '$chgfrdt' AND '$chgtodt' ";


	}else{
		$datesql='';
	}
	$tot = 0;
	$query = mysqli_query($con,"select * from expense where session='".$sessionid."'");
	while($res = mysqli_fetch_array($query))
	{
		$tot += $res['amount'];
		
	}
	
		$temp['total_expense'] = $tot;
		array_push($data, $temp);
	
	
	if($expid=="0"){  // 0 means all expense show
		
		
		$q1 = mysqli_query($con,"select * from expense_type");
		while($r1 = mysqli_fetch_array($q1))
		{
			$expenseid = $r1['expense_type_id'];
			$expensename = $r1['expense_type_name'];

			 $sql="select * from expense where expense_type_id='$expenseid' $datesql ";
			$q2 = mysqli_query($con,$sql);
			$row1 = mysqli_num_rows($q2);
			if($row1)
			{
				// echo "from to";
				$amount = 0;
				while($r2 = mysqli_fetch_array($q2))
				{
					$amount = $amount + $r2['amount'];
				}
			
			@$temp = array();
			$temp['expense_name'] = $expensename ? ($expensename) : "NA" ;
			$temp['expense_amount'] = $amount ? ($amount) : "NA" ;
			array_push($data, $temp);
						
			}
			
		}
			return $data;
		
	}else{
		$q2 = mysqli_query($con,"select * from expense where expense_type_id='$expid' $datesql ");
		// if(mysqli_num_rows($q2) > 0){
			$tamount=0;
			$q3 = mysqli_query($con,"select * from expense_type where expense_type_id='$expid'");
			$r3 = mysqli_fetch_array($q3);
				
			$expname = $r3['expense_type_name'];
			while($r2 = mysqli_fetch_array($q2))
			{
				
				$tamount+=$r2['amount'];
			}
				
			@$temp = array();
			$temp['expense_name'] = ($expname) ? ($expname) : "NA" ;
			$temp['expense_amount'] = ($tamount) ? ($tamount) : "NA";
			array_push($data, $temp);
				
			// echo json_encode($data);
			return $data;
		// }else{
		// 	return '';
		// }	
		  
	}
}


function staffdetail($sessionid,$staff_id)
{
	global $con;
	$data = array();
	if(!empty($staff_id)){
	  $staffQuery= " AND st_id='$staff_id'";
	}else{
		$staffQuery='';
	}
	
	$q1 = mysqli_query($con,"select * from staff where session='$sessionid' $staffQuery  ");
	$row1 = mysqli_num_rows($q1);
	if($row1)
	{
	@$temp = array();
	while($r1 = mysqli_fetch_array($q1))
	{
	
		$temp['id'] = $r1['st_id']; 
		$temp['staff_name'] = $r1['staff_name']; 
		$temp['staff_id'] = $r1['staff_id']; 
		$temp['gender'] = $r1['gender']; 
		$temp['mobno'] = $r1['mobno']; 
		$temp['address'] = $r1['address'];
        $temp['qualification'] = $r1['qualification'];
        $temp['teaching_type'] = $r1['teaching_type'];	
		$temp['skills'] = $r1['skills'];
		$temp['joining_date'] = $r1['joining_date'];
		$temp['designation'] = $r1['designation'];
        		
		
		
		array_push($data, $temp);
	
	}
	 return $data;
	}
	else
	{
		return "";
	}
	
}


function department()
{
	global $con;
	$data = array();
	$q1 = mysqli_query($con,"select * from department");
	
	if(mysqli_num_rows($q1)>0)
	{
		while($res = mysqli_fetch_assoc($q1))
		{
		@$temp = array();
	    $temp['department id'] = $res['dept_id'];
	    $temp['departmanet name'] = $res['dept_name'];
		array_push($data, $temp);
		}
		return $data;
	}
	else
	{
		return "";
	}

}


function staffcommunication($deptid,$message,$login_userid)
{
	global $con;
	date_default_timezone_set("Asia/Kolkata");
	$username=profile($login_userid)['0']['username'];

	$q1 = mysqli_query($con,"select * from assign_department where dept_id='$deptid'");
	$row = mysqli_num_rows($q1);
	if($row)	
	{
		while($r1 = mysqli_fetch_array($q1))
		{
			$staffid=$r1['staff_id'];
			$qu = mysqli_query($con,"select * from staff where st_id='$staffid'");
			$ru = mysqli_fetch_array($qu);
			$mobile=$ru['mobno'];
			$msgtype=$ru['msg_type_id'];
					
			if($msgtype==1)
			{
			    $q2=mysqli_query($con,"insert into staff_notifications(category,dept_id,staff_id,selected_no,message,msg_type,loginuser,notice_datetime,date)
			values(1,'$deptid','$staffid','$mobile','$message','1','$username',now(),now())");
			}
			else if($msgtype==2)
			{
				$q3=mysqli_query($con,"insert into staff_notifications(category,dept_id,staff_id,selected_no,message,msg_type,loginuser,notice_datetime,date)
			     values(1,'$deptid','$staffid','$mobile','$message','2','$username',now(),now())");
				// $set=mysqli_query($con,"select * from sms_setting");
				// $rset=mysqli_fetch_array($set);
				// $senderid=$rset['sender_id'];
				// $apiurl=$rset['api_url'];
				// $apikey=$rset['api_key'];
	
				// //Send sms to sender and reciever
				// $senderId = "$senderid";
				// $route = 4;
				// $campaign = "OTP";
				// $sms = array(
				// 	'message' => $message,
				// 	'to' => array($mobile)
				// );
				// //Prepare you post parameters
				// $postData = array(
				// 	'sender' => $senderId,
				// 	'campaign' => $campaign,
				// 	'route' => $route,
				// 	'sms' => array($sms)
				// );
				// $postDataJson = json_encode($postData);

				// $url="$apiurl";

				// $curl = curl_init();
				// curl_setopt_array($curl, array(
				// 	CURLOPT_URL => "$url",
				// 	CURLOPT_RETURNTRANSFER => true,
				// 	CURLOPT_CUSTOMREQUEST => "POST",
				// 	CURLOPT_POSTFIELDS => $postDataJson,
				// 	CURLOPT_HTTPHEADER => array(
				// 		"authkey:"."$apikey",
				// 		"content-type: application/json"
				// 	),
				// ));
				// $response = curl_exec($curl);
				// $err = curl_error($curl);
				// curl_close($curl);
				
			}
			
		}
		if($q2 || $q3){
		    // return "Message Sent.";
		    return "success";
		}else{
			return "error";
		}
		
	}else{
		return "";
	}
	
}


function classname()
{
	global $con;
	$data = array();
	$query=mysqli_query($con,"select * from class");
	
	if(mysqli_num_rows($query)>0)
	{
			while($res = mysqli_fetch_array($query)){
			@$temp = array();
			$temp['class_id'] = $res['class_id'];;
			$temp['class_name'] = $res['class_name'];
			array_push($data, $temp);
			}
			
	    return $data;
	}
	else
	{
		return "";
	}
}


function sectionname($classid){
	global $con;
	$data = array();
	$query=mysqli_query($con,"select * from section where class_id='$classid'");
	
	if(mysqli_num_rows($query)>0)
	{
			while($res = mysqli_fetch_array($query))
			{
				$secid = $res['section_id'];
				$secname = $res['section_name'];
				
				@$temp = array();
				$temp['section_id'] = $secid;
				$temp['section_name'] = $secname;
				array_push($data, $temp);
			}
			
		   return $data;
	}
	else
	{
		return "";
	}
}


function message($heading,$msgtype,$classid,$sectionid,$message,$login_userid)
{
	global $con;
	date_default_timezone_set("Asia/Kolkata");

	$username=profile($login_userid)['0']['username'];
	
	$cond = '';
	
	if($classid!=''){
		$cond.=" && class_id=$classid";
	}else{
		$classid='0';
	}
	if($sectionid!=''){
		$cond.=" && section_id=$sectionid";
	}else{
		$sectionid='0';
	}
	
	$q1 = mysqli_query($con,"select * from students where stu_status='0' && msg_type_id='1' $cond");
	$row = mysqli_num_rows($q1);
	if($row)	
	{
		while($r1 = mysqli_fetch_array($q1))
		{
			$studid=$r1['student_id'];
			$mobile=$r1['parent_no'];
			
			
			$q2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,subject,
			selected_no,heading,message,loginuser,notice_datetime,date)
			values('$msgtype','$studid','$classid','$sectionid',0,'$mobile','$heading','$message','$username',now(),now())");
		}
		if($q2){

		   // $q3="INSERT INTO `staff_message`(`heading`,`class_id`, `section_id`, `message`, `date`,`category`,`status`,`loginuser`) VALUES ('$heading','$classid','$sectionid','$message',now(),'$msgtype','0','$username')";

		   // $qu=mysqli_query($con,$q3);
		 
			return "success";
		}else{
			return "error";
		}
		
	}
	else
	{
		return "";
	}
	
}	


function changepassword($id,$currentpassword,$newpassword)
{
	global $con;
	
	$data = array();
	
	$que = mysqli_query($con,"select * from users where user_id='$id' && pass='$currentpassword'");
	$row = mysqli_num_rows($que);		
	if($row)
	{	
		$que1 = mysqli_query($con,"update users set pass='$newpassword' where user_id='$id'");

		$temp['Response'] = "Updated";

		array_push($data,$temp);
		return $data;
	}
	else
	{
		// $temp['Response'] = "Invalid Details";
		// echo json_encode($temp);
		return "";
	}
}


function getClasswiseAttendance($class_id,$section_id,$session_id,$date){
	
	global $con;
	$data=array();
	$sql="select * from student_daily_attendance where class_id='$class_id' && section_id='$section_id'   AND  date='$date'";
   
	
	$AtQuery=$con->query($sql);
	if($AtQuery->num_rows>0){
	 while($AtData= $AtQuery->fetch_assoc()){
		 
		$temp=array();
		if($AtData['type_of_attend']=='1'){
		  $Type="Present";		
		}
		if($AtData['type_of_attend']=='2'){
		  $Type="Absent";		
		}
		if($AtData['type_of_attend']=='3'){
		  $Type="Leave";	
			
		}
        
        $temp['register_no']= $AtData['register_no'];
		$temp['student_name']= Student_detailsById($AtData['student_id'])['student_name'];
		$temp['type_of_attend']= $Type;
		$temp['reason']= $AtData['reason']; 
        $temp['date']= $AtData['date'];		
		
		array_push($data,$temp);
		 
	 }
	
	return $data;
	}else{
	return $data;	
		
	}
}

 function getClasswiseExam($class_id,$section_id,$session_id){
   global $con;
   $data=array();
   $sql="select * from test where class_id='$class_id' && section_id='$section_id'  and session='".$session_id."'";
  
   $Query= $con->query($sql);
   if($Query->num_rows>0){
	while($TestData= $Query->fetch_assoc()){
     $temp=array();
    $subid = $TestData['subject_id'];
    $qsub = mysqli_query($con,"select subject_name from subject where subject_id='$subid'");
	$rsub = mysqli_fetch_array($qsub);
	$subname = $rsub['subject_name'];
	
    $temp['examname']=$TestData['test_name'];
	$temp['test_id']=$TestData['test_id'];
	$temp['subname']=$subname;
	$temp['exam_date']=$TestData['test_date'];
	$temp['starttime']=$TestData['starttime'];
	$temp['endtime']=$TestData['endtime'];
	
	array_push($data,$temp);
	
	}
  return $data;
   }else{
	return 	$data;  
	   
   }
 }

 function getDriverList($session_id,$driver_id){
	 $data=array();
	 global	$con;
	 if(!empty($driver_id)){
		$IdSQL=" AND  id='".$driver_id."'"; 
	 }else{
		$IdSQL=''; 
	 }
	 $Query=$con->query("select * from driver where session='".$session_id."' $IdSQL ORDER BY `modify_date` DESC ");
	 if($Query->num_rows>0){
	 while($res= $Query->fetch_assoc()){
		$temp=array();
		$temp['name']= $res['name'];
		$temp['father_name'] = $res['father_name'];
		$temp['gender'] = $res['gender'];
		$temp['mobile'] = $res['mobile'];
		 $temp['address']= $res['address'];
		 $temp['city']= $res['city'];
		 $temp['designation'] =$res['designation'];
		 $temp['dlno'] =$res['dlno'];
		 $temp['experience'] =$res['experience'];
		 $temp['experience'] =$res['experience'];
		 array_push($data,$temp);
		
	 }
	 return $data;
	 }else{
		 return $data; 
		 
	 }

 }

function view_driver($session_id){
global $con;
$data=array();
if(!empty($session_id)){
		$IdSQL=" AND  session='".$session_id."'"; 
	 }else{
		$IdSQL=''; 
	 }
    $sql="select * from driver where status='0' $IdSQL";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				$temp['name']=$res['name'];
				$temp['father_name']=$res['father_name'];
				$temp['gender']=$res['gender'];
				$temp['mobile']=$res['mobile'];
				$temp['alternate_no']=$res['alternate_no'];
				$temp['address']=$res['address'];
				$temp['city']=$res['city'];
				$temp['designation']=$res['designation'];
				$temp['experience']=$res['experience'];
				$temp['dlno']=$res['dlno'];
				$temp['aadhar_no']=$res['aadhar_no'];
				$temp['previous_exp ']=$res['previous_exp'];
				$temp['description ']=$res['description'];
				$temp['date ']=date("d-m-Y H:i:s ", strtotime($res['date']));
				array_push($data,$temp);
			}
				return $data;
		}else{
			return $data;
		}	
}

function view_vehicle($session_id){
global $con;
$data=array();
if(!empty($session_id)){
		$IdSQL=" AND  session='".$session_id."'"; 
	 }else{
		$IdSQL=''; 
	 }
    $sql="select * from `vehicle` where  status='0' $IdSQL";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				$temp['vehicle_name']=$res['vehicle_name'];
				$temp['vehicle_type']=$res['vehicle_type'];
				$temp['vehicle_number']=$res['vehicle_number'];
				$temp['chassis_no']=$res['chassis_no'];
				$temp['purchased_year']=$res['purchased_year'];
				$temp['vehicle_status']=$res['vehicle_status'];
				$temp['about_vehicle']=$res['about_vehicle'];
				$temp['prev_exp']=$res['prev_exp'];
				$temp['description']=$res['description'];
				$temp['create_date']=date("d-m-Y H:i:s ", strtotime($res['create_date']));
				
				array_push($data,$temp);
			}
				return $data;
		}else{
			return $data;
		}	
}

function view_transports(){
global $con;
$data=array();

    $sql="select * from `transports` where status='1' ";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				$temp['route_name']=$res['route_name'];
				$temp['price']=$res['price'];
				$temp['create_date']=date("d-m-Y H:i:s ", strtotime($res['create_date']));
				
				array_push($data,$temp);
			}
				return $data;
		}else{
			return $data;
		}	
}

function fee_mode(){
	global $con;
	$data=array();
	$query=mysqli_query($con,"select * from fee_mode WHERE 1 ");
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_array($query)){
			$temp=array();
			$temp['fee_mode_id']=$res['fee_mode_id'];
			$temp['fee_mode_name']=$res['fee_mode_name'];
			array_push($data,$temp);
	  }
	 return $data;
	}else{
			return $data;
	}	 
}

function view_route_to_student($class_id,$section_id,$session_id){
global $con;
$IdSQL='';
$data=array();
	if(!empty($class_id)){
		$IdSQL.=" AND  class_id='".$class_id."'"; 
	}
	if(!empty($section_id)){
		$IdSQL.=" AND  section_id='".$section_id."'"; 
	}
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}

  $sql="select * from student_route WHERE 1 $IdSQL";
  $query=mysqli_query($con,$sql);
  if(mysqli_num_rows($query)>0){
	 while($res=mysqli_fetch_array($query)){
	 		$temp=array();
			$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'];
			$temp['class_name']=get_class_byid($res['class_id'])['class_name'];
			$temp['section_name']=get_section_byid($res['section_id'])['section_name'];
			$temp['route_name']=get_transports_byid($res['trans_id'])['route_name'];
			$temp['price']=get_transports_byid($res['trans_id'])['price'];;
			$temp['due_amount']=$res['due_amount'];
			$temp['fee_mode_name']=get_fee_mode_byid($res['fee_mode_id'])['fee_mode_name'];
			$temp['reason']=($res['reason']) ?? "NA";
			$temp['create_date']=date("d-m-Y H:i:s ", strtotime($res['create_date']));
			array_push($data,$temp);
   }
  		return $data;
		}else{
			return $data;
		}
}

function view_assign_driver_route(){
	global $con;
$data=array();
  // if(!empty($session_id)){	// 	$IdSQL=" AND  session='".$session_id."'"; 
    $sql="select * from assign_driver_route where status='0' ";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				$temp['name']=get_driver_byid($res['driver_id'])['name'];
				$temp['vehicle_name']=get_vehicle_byid($res['vehicle_id'])['vehicle_name'];
				$temp['vehicle_number']=get_vehicle_byid($res['vehicle_id'])['vehicle_number'];
				$temp['route_id']=get_transports_byid($res['route_id'])['route_name'];
				$temp['description']=$res['description'];
				$temp['date']=date("d-m-Y H:i:s ", strtotime($res['date']));
				array_push($data,$temp);
			}
				return $data;
		}else{
			return $data;
		}	
}

function view_transport_expense($session_id){
	global $con;
$data=array();
  if(!empty($session_id)){
   	$IdSQL=" AND  session='".$session_id."'"; 
  }else{
  	$IdSQL="";
  } 	
  $total_expense=0;
   $sql="select  `amount`from transport_expense where status='0' $IdSQL  ";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$total_expense+=$res['amount'];
		  }
		  	$temp['total_expense']=$total_expense;
		    array_push($data,$temp);
		}
   $sql="select  `trans_expense_type_id`, `trans_expense_details`, `amount`, `proofs`, `point_of_contact`, `expensed_datetime`  from transport_expense where status='0' $IdSQL  ";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				$temp['trans_expense_type_name']=get_transport_expense_type_byid($res['trans_expense_type_id'])['trans_expense_type_name'];
				$temp['trans_expense_details']=$res['trans_expense_details'];
				$temp['expense_amount']=$res['amount'];
				$temp['proofs']=($res['proofs']) ? "../../images/transport/".$res['proofs'] : "NA" ;
				$temp['point_of_contact']=$res['point_of_contact'];
				$temp['expensed_datetime']=date("d-m-Y H:i:s ", strtotime($res['expensed_datetime']));
				// $temp['create_date']=date("d-m-Y H:i:s ", strtotime($res['create_date']));
				array_push($data,$temp);
			
			}
				return $data;
		}else{
			return $data;
		}	
}


function view_expense($session_id,$fromdt,$todt){
global $con;
$IdSQL='';
$data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	if(!empty($from_date) && !empty($to_date)){
		$IdSQL.=" AND  between $from_date and $to_date"; 
	}
	  $sql="select * from expense where status='0' $IdSQL ";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				$temp['expense_type_name']=get_expense_type_byid($res['expense_type_id'])['expense_type_name'];
				$temp['expense_details']=$res['expense_details'];
				$temp['amount']=$res['amount'];
				$temp['proofs']=$res['proofs'];
				$temp['point_of_contact']=$res['point_of_contact'];
				$temp['expensed_datetime']=date("d-m-Y H:i:s ", strtotime($res['expensed_datetime']));;
				$temp['create_date']=date("d-m-Y H:i:s ", strtotime($res['date']));
				array_push($data,$temp);
			}
				return $data;
		}else{
			return $data;
		}	
}

function fees_paid_students($session_id,$class_id,$section_id){
global $con;
$IdSQL='';
$data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	if(!empty($class_id)){
		$IdSQL.=" AND  class_id='".$class_id."'"; 
	}
	 if(!empty($section_id)){
		$IdSQL.=" AND  section_id='".$section_id."'"; 
	}
	//find total fee
	$qtf = mysqli_query($con,"select * from assign_fee_class where 1 $IdSQL  ");
					$rtf = mysqli_fetch_array($qtf);
					$totalfee = $rtf['total_amount'] + $previousfee - $totaldiscount;
	//end find total fee				
	 $sql = "SELECT * FROM `student_wise_fees` WHERE 1 $IdSQL ";
	$query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				 $sql2 = "SELECT `student_id` FROM `students` WHERE `student_id`='".$res['student_id']."' and `session`='$session_id' ";
				$query2=mysqli_query($con,$sql2);
			  if(mysqli_num_rows($query2)>0){

						$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'];
						$temp['register_no']=getStudent_byStudent_id($res['student_id'])['register_no'];
						
						$temp['class_name']=get_class_byid($res['class_id'])['class_name'];
						$temp['section_name']=get_section_byid($res['section_id'])['section_name'] ?? 'NA';
		        $temp['total_fee']=$totalfee;

		        //find total paid amount
		        $q4 = mysqli_query($con,"select * from student_due_fees where student_id='".$res['student_id']."' && (status='0' || status='1') && session='$session_id' ");
								$pamt = 0;
								$totalpaidamt = 0;
								while($r4 = mysqli_fetch_array($q4))
								{
									$recdamt = $r4['received_amount'];
									$prevamt = $r4['previous_amount'];
									$ramtarr = explode(',',$recdamt);
									foreach($ramtarr as $a1){
										$pamt = $pamt+ $a1;      //show error use intval()
									}
									$totalpaidamt = $pamt + $prevamt;
								}
						$temp['total_paid']=$totalpaidamt;
		        //end total paid amount
						$temp['total_due']=getStudent_byStudent_id($res['student_id'])['due'];
						array_push($data,$temp);
			  }
			}//while
				return $data;
		}else{
			return $data;
		}	
}

function transport_fees_paid_students($session_id,$class_id,$section_id){
	global $con;
$IdSQL='';
$data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	if(!empty($class_id)){
		$IdSQL.=" AND  class_id='".$class_id."'"; 
	}
	if(!empty($section_id)){
		$IdSQL.=" AND  section_id='".$section_id."'"; 
	}

	$sql = "SELECT * FROM `student_route` WHERE 1 $IdSQL ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'];
				$temp['register_no']=getStudent_byStudent_id($res['student_id'])['register_no'];
				$temp['class_name']=get_class_byid($res['class_id'])['class_name'];
				$temp['section_name']=get_section_byid($res['section_id'])['section_name'] ?? 'NA';
				$temp['route_name']=get_transports_byid($res['trans_id'])['route_name'];

				$price=get_transports_byid($res['trans_id'])['price'];
				// $temp['due_amount']=$res['due_amount'];

				//get previous transport fees due
			  $sql5="select * from previous_transport_fees where student_id='".$res['student_id']."' and session='$session_id' ";
				$q5 = mysqli_query($con,$sql5);
				if(mysqli_num_rows($q5)){
				   $r5 = mysqli_fetch_array($q5);
					 $pretransfee = $r5['previous_transport_fees'];
				}else{
						$pretransfee = 0;
				}
				$total_amount = $price + $pretransfee - $res['discount'];    //total given amount with previous amt & discount
				//get current transport fees due & payment
				$qfee2 = mysqli_query($con,"select * from student_transport_due_fees where 1 && (status='0' || status='1')  and student_id='".$res['student_id']."' and session='$session_id' ");

					$tramt = 0;
					$ptramt = 0;
					$total_amt_paid = 0;

					while($rfee2 = mysqli_fetch_array($qfee2)){

						$rectransamt = $rfee2['trans_amount'];
						$tramt = $tramt + $rectransamt;
						$prevtransamt = $rfee2['previous_trans_amount'];
						$ptramt = $ptramt + $prevtransamt;
					}	
					$total_amt_paid += $tramt + $ptramt;  //till total amount paid
				  $duefee = $price + $pretransfee - $res['discount'] - $total_amt_paid;  //remainig dues 

				  $temp['total_amount']=$total_amount;
				  $temp['total_amt_paid']=$total_amt_paid;
				  $temp['total_due']=$duefee;
				  array_push($data,$temp);

		}//while	
		return $data;
	}else{
		return $data;
	}	

}
function view_test($session_id,$class_id,$section_id){
	global $con;
$IdSQL='';
$data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	if(!empty($class_id)){
		$IdSQL.=" AND  class_id='".$class_id."'"; 
	}
	if(!empty($section_id)){
		$IdSQL.=" AND  section_id='".$section_id."'"; 
	}

	$sql = "SELECT `test_id`,`parent_test_id`,`test_name` FROM `test` WHERE 1 $IdSQL  Group by `test_name` ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$temp['test_id']=$res['test_id'];
				$temp['parent_test_id']=$res['parent_test_id'];
				$temp['test_name']=$res['test_name'];
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;
	}		
}

function view_test_details($session_id,$class_id,$section_id,$test_id){
	global $con;
$IdSQL='';
$data=array();
	if(!empty($section_id)){
		$IdSQL.=" AND  section_id='".$section_id."'"; 
	}
	if(!empty($test_id)){
		$test_name=get_test_byid($test_id)['test_name'] ?? '';
		if(!empty($test_name)){
			// $Gsql=" Group by '".$test_name."' ";
			$IdSQL.=" AND  test_name LIKE '".$test_name."'"; 
		}	
	}  
	 
	 $sql = "SELECT * FROM `test` WHERE `class_id`='".$class_id."' and  session='".$session_id."'  $IdSQL  ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				// print_r($res);
				$temp['test_name']=$res['test_name'];
				$temp['test_date']=$res['test_date'];
				$temp['starttime']=$res['starttime'];
				$temp['endtime']=$res['endtime'];
				$temp['subject_name']=get_subject_byid($res['subject_id'])['subject_name'];
				$temp['min_marks']=$res['min_marks'];
				$temp['max_marks']=$res['max_marks'];
				$temp['room_no']=$res['room_no'];
				$temp['create_date']=date("d-m-Y H:i:s ", strtotime($res['create_date']));
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;
	}		
}

function view_feedback($session_id){
	global $con;
$IdSQL='';
$data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	
	$sql = "SELECT * FROM `feedback` WHERE 1  $IdSQL  ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				// print_r($res);
				$temp['title']=$res['title'];
				$temp['description']=($res['description'])  ? $res['description'] : "NA";
				$temp['raised_for']=$res['raised_for'];
				$temp['class_name']=get_class_byid($res['class_id'])['class_name'];
				$temp['section_name']=get_section_byid($res['section_id'])['section_name'];
				$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'] ?? '';
				$temp['request_name']=get_request_type_byid($res['request_id'])['request_name'] ?? '';
				$temp['response']=($res['response']) ? $res['response'] : "NA";
				$temp['submission_date']=date("d-m-Y ", strtotime($res['submission_date']));
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;
	}		
}
function view_remedy($session_id){
	global $con;
$IdSQL='';
$data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	
	$sql = "SELECT * FROM `remedy` WHERE 1  $IdSQL  ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				// print_r($res);
				$temp['rid']=$res['rid'];
				$temp['class_name']=get_class_byid($res['class_id'])['class_name'];
				$temp['section_name']=get_section_byid($res['section_id'])['section_name'];
				$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'] ?? '';
				$temp['staff_name']=get_staff_byid($res['staff_id'])['staff_name'] ?? '';
				$temp['observations']=$res['observations'];
				$temp['observations_proof']="../../gallery/remedy/".$res['observations_proof'];
				$temp['observations']=$res['remedies_taken'];
				$temp['approved_by']=($res['approved_by']) ? $res['approved_by'] : "NA";
				$temp['start_date']=date("d-m-Y ", strtotime($res['start_date']));
				$temp['end_date']=date("d-m-Y ", strtotime($res['end_date']));
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;
	}		
}
function view_allocate_budget($session_id){
	global $con;
$IdSQL='';
$data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	$sql = "select * from allocate_budget where 1  $IdSQL  ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$header_id=$res['budget_header_id'];
				$q1 = mysqli_query($con,"select * from budget_header where budget_header_id='$header_id'");
				$r1 = mysqli_fetch_array($q1);
				$temp['budget_header_name']=$r1['budget_header_name'];
				$temp['allocate_amount']=$res['allocate_amount'];	
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;  
	}		
}
function view_allocate_budget_expense($session_id){
	global $con;
$IdSQL='';
$data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	$sql = "select * from allocate_budget_expense where 1  $IdSQL  ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$expense_id=$res['expense_id'];
				$temp['budget_header_name']=get_budget_header_byid($res['budget_header_id'])['budget_header_name'] ?? '';
				$temp['allocated_amount']=$res['allocated_amount'];	
				$temp['available_amount']=$res['available_amount'];	
				$temp['expensed_amount']=$res['expensed_amount'];	
				$temp['description']=$res['description'];	
				if(!empty($res['attachment'])){
					$temp['attachment']="../../gallery/budgetexp/".$res['attachment'];	
				}else{
					$temp['attachment']="../../gallery/no_image.png";	
				}
				$temp['amount_remaining']=$res['amount_remaining'];
				$temp['expense_date']=date("d-m-Y ", strtotime($res['expense_date']));	
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;  
	}		
}

function view_stock_vendor(){
	global $con;
$IdSQL='';
$data=array();
  // if(!empty($session_id)){ 		$IdSQL.=" AND  session='".$session_id."'"; 	}
	$sql = "select * from stock_vendor where 1 ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$temp['stock_vendor_id']=$res['stock_vendor_id'] ;
				$temp['stock_vendor_name']=$res['stock_vendor_name'];	
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;  
	}		
}
function view_purchase_order($session_id){
	global $con;
	$data=array();
	$IdSQL='';
  $data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}	
  $sql = "select * from purchase_order where 1 $IdSQL  order by modify_date desc";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$temp['poid']=$res['poid'] ;
				$temp['stock_vendor_name']=get_stock_type_byid($res['stock_type_id'])['stock_type_name'] ?? '';
				$temp['purchase_date']=$res['purchase_date'] ;
				$temp['quantity']=$res['quantity'] ;
				$temp['amt_per_item']=$res['amt_per_item'] ;
				$temp['disc_per_item']=$res['disc_per_item'] ;
				$temp['description']=$res['description'] ;
				$temp['total_amount']=$res['amount'];
				$temp['stock_vendor_name']=get_stock_vendor_byid($res['stock_vendor_id'])['stock_vendor_name'] ?? ''; 
				$temp['image']=($res['image']) ? "../../gallery/purchaseorder/".$res['image']  :  "../../gallery/purchaseorder/no_image.png";
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;  
	}		
}

function view_stock_avilable(){
	global $con;
	$data=array();
	$IdSQL='';
  $data=array();
  // if(!empty($session_id)){ 	$IdSQL.=" AND  session='".$session_id."'"; 	}	
  $sql = "select * from purchase_order where 1 $IdSQL  order by modify_date desc";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
			  $id=$res['pur_ord_id'];
			  $stockid=$res['stock_type_id'];
			  $quantity = $res['quantity'];
				$temp=array();
				$temp['poid']=$res['poid'] ;
				$temp['stock_vendor_name']=get_stock_type_byid($res['stock_type_id'])['stock_type_name'] ?? '';
				$temp['purchase_date']=$res['purchase_date'];
				$temp['total_quantity']=$res['quantity'];

				//find total issued quantity
				$q3 = mysqli_query($con,"select `quantity` from issue_order where pur_ord_id='$id'");
				$tissue_qty = 0;
				$issdet = "";
				while($r3 = mysqli_fetch_assoc($q3)){
					$tissue_qty += $r3['quantity'];
				}
				//find total dead stock
				$q5 = mysqli_query($con,"select * from dead_stock where pur_ord_id='$id'");
				$tdead_qty = 0;
				while($r5 = mysqli_fetch_array($q5)){
					$tdead_qty += $r5['dead_stock_qty'];
				}
				// $qret6 = mysqli_query($con,"select * from return_stock where pur_ord_id='$id'");
				// $return_qty = 0;
				// while($r6 = mysqli_fetch_array($qret6)){
				// 	$return_qty += $r6['return_qty'];
				// }
				$tbal_qty = $quantity - $tissue_qty - $tdead_qty;
				$temp['avilable_qty']=$tbal_qty;
				$temp['issue_qty']=$tissue_qty;
				// $temp['return_qty']=$return_qty;
				$temp['dead_qty']=$tdead_qty ;
				$temp['total_amount']=$res['amount'];
				$temp['stock_vendor_name']=get_stock_vendor_byid($res['stock_vendor_id'])['stock_vendor_name'] ?? ''; 
				$temp['image']=($res['image']) ? "../../gallery/purchaseorder/".$res['image']  :  "../../gallery/purchaseorder/no_image.png";
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;  
	}		
}
function view_books(){
	global $con;
	$data=array();
	$sql = "select * from books where 1 order by modify_date desc";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
			  $temp['book_id']=$res['book_id'];
			  $temp['book_name']=$res['book_name'];
			  $temp['book_isbn']=$res['book_isbn'];
			  $temp['author']= $res['author'];
			  $temp['quantity']= $res['quantity'];
			  $temp['price']=  $res['price'];
			  $temp['publisher_name']= get_publisher_byid($res['publisher_id'])['publisher_name'];
			  $temp['book_type_name']= get_book_type_byid($res['book_type_id'])['book_type_name'];
			  $temp['vendor_name']= get_vendor_byid($res['vendor_id'])['vendor_name'];
			  $temp['branch_name']=  get_branch_byid($res['branch_id'])['branch_name'];
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;  
	}	
}
function library_fees_report($session_id,$class_id,$section_id){
	global $con;
	$data=array();
	$IdSQL='';
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	if(!empty($class_id)){
		$IdSQL.=" AND  class_id='".$class_id."'"; 
	}
	if(!empty($section_id)){
		$IdSQL.=" AND  section_id='".$section_id."'"; 
	}
	$sql = "SELECT * FROM `issue_bookto_students` WHERE 1 and return_status='0' $IdSQL";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
			$temp=array();
			$id=$res['issue_id'];
			$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'] ?? '';
			$temp['class_name']=get_class_byid($res['class_id'])['class_name'];
			$temp['section_name']=get_section_byid($res['section_id'])['section_name']?? '';

			$retdt = $res['return_date'];
			$curdate = date("Y-m-d");
			$date1=date_create($curdate);
			$date2=date_create($retdt);
			$diff=date_diff($date2,$date1);
			$tdays = $diff->format("%R%a days");
			$rettypeid=$res['return_type_id'];

			$q3=mysqli_query($con,"select * from book_return_type where book_return_type_id ='$rettypeid'");
			$r3=mysqli_fetch_array($q3);
			$amt=$r3['book_fine_per_day'];
			if($tdays > 0){
				$tpenalty = $tdays * $amt;
			}else{
				$tpenalty = 0;
			}
			$q4 = mysqli_query($con,"select * from library_payment where issue_id='$id'");
			$tpaid = 0;
			while($r4 = mysqli_fetch_array($q4)){
				$tpaid += $r4['paid_amount']; 
			}
			$tdue = $tpenalty - $tpaid;
			$temp['total_penalty']=$tpenalty;
			$temp['total_paid']=$tpaid;
			$temp['total_due']=$tdue;
			array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;  
	}	
}
function view_branch(){
	global $con;
	$data=array();
	$sql = "select * from branch where 1 order by branch_name";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
			  $temp['branch_id']=$res['branch_id'];
			  $temp['branch_name']=$res['branch_name'];
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;  
	}	
}
function issue_book_to_students($branch_id,$book_id){
	global $con;
  $IdSQL='';
  $data=array();
  if(!empty($branch_id)){
		$IdSQL.=" AND  branch_id='".$branch_id."'"; 
	}
	if(!empty($book_id)){
		$IdSQL.=" AND  book_id='".$book_id."'"; 
	}

	$sql = "SELECT *	 FROM `issue_bookto_students` WHERE 1 $IdSQL  ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'] ?? '';
				$temp['register_no']=getStudent_byStudent_id($res['student_id'])['register_no'] ?? '';
			  $temp['class_name']=get_class_byid($res['class_id'])['class_name'];
			  $temp['section_name']=get_section_byid($res['section_id'])['section_name']?? '';
			  $temp['issue_date']=date("d-m-Y ", strtotime($res['issue_date']));
			  $temp['return_date']=date("d-m-Y ", strtotime($res['return_date']));
			  if(!empty($res['returned_date'])){
			  		$temp['returned_date']=date("d-m-Y ", strtotime($res['returned_date']));
			  }else{
			  	$temp['returned_date']="NA";
			  }
			  
			  $temp['mobile']=$res['mobile'];

				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;
	}		
}
function issue_book_to_faculty($branch_id,$book_id){
	global $con;
  $IdSQL='';
  $data=array();
  if(!empty($branch_id)){
		$IdSQL.=" AND  branch_id='".$branch_id."'"; 
	}
	if(!empty($book_id)){
		$IdSQL.=" AND  book_id='".$book_id."'"; 
	}

	$sql = "SELECT *	 FROM `issue_bookto_faculty` WHERE 1 $IdSQL  ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$temp['staff_name']=get_staff_byid($res['st_id'])['staff_name'];
				$temp['staff_id']=get_staff_byid($res['st_id'])['staff_id'];
				
			  $temp['issue_date']=date("d-m-Y ", strtotime($res['issue_date']));
			  $temp['return_date']=date("d-m-Y ", strtotime($res['return_date']));
			  if(!empty($res['returned_date'])){
			  		$temp['returned_date']=date("d-m-Y ", strtotime($res['returned_date']));
			  }else{
			  	$temp['returned_date']="NA";
			  }
			  
			

				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;
	}		
}
function view_online_admission($class_id,$session_id){
	global $con;
  $IdSQL='';
  $data=array();
  if(!empty($class_id)){
		$IdSQL.=" AND  grade='".$class_id."'"; 
	}
	if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	$sql = "SELECT *	 FROM `admission` WHERE 1 $IdSQL  ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				// print_r($res);
				$temp['reference_no']=$res['reference_no'];
				$temp['name']=$res['name'];
				$temp['fathername']=$res['fathername'];
				$temp['gender']=$res['gender'];
				$temp['dob']=date("d-m-Y ", strtotime($res['dob']));
				$temp['admission_class']= get_class_byid($res['grade'])['class_name'];
				$temp['phone']=$res['phone'];
				// $temp['qualification']=$res['qualification'];
				$temp['city']=$res['city'];
				$temp['pincode']=$res['pincode'];
				$temp['address']=$res['address'];
				$temp['caste']=$res['caste'];
				$temp['apply_date']=date("d-m-Y ", strtotime($res['apply_date']));
				if($res['status']=='1'){
					$temp['status']='Requested';
				}elseif($res['status']=='2'){
					$temp['status']='Accept';
				}elseif($res['status']=='3'){
					$temp['status']='Decline';
				}	
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;
	}		
}

?>