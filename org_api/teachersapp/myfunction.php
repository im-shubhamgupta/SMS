<?php
include('../connection.php');
extract($_REQUEST);	

function login($mobile,$password)
{
	global $con;
	$query=mysqli_query($con,"select * from staff where mobno='$mobile' && password='$password'");
	
	if(mysqli_num_rows($query)>0)
	{
		$res = mysqli_fetch_assoc($query);
		@$temp = array();
	    $temp['id'] = $res['st_id']; 
	    $temp['staffname'] = $res['staff_name']; 
		echo json_encode($temp);
	}
	else
	{
		return "Invalid Details";
	}
}


function profile($id)
{
	global $con;
	$query=mysqli_query($con,"select * from staff where st_id='$id'");
	
	if(mysqli_num_rows($query)>0)
	{
		$res = mysqli_fetch_assoc($query);
		@$temp = array();
	    $temp['id'] = $res['st_id']; 
		$temp['staff_name'] = $res['staff_name']; 
		$temp['designation'] = $res['designation']; 
		$temp['mobno'] = $res['mobno'];
		$temp['address'] = $res['address'];
		$temp['image'] = $res['image'];
		echo json_encode($temp);
	}
	else
	{
		return "Invalid Id";
	}
}


function assignclass($id)
{
	global $con;
	$data = array();
	$query=mysqli_query($con,"select * from assign_clsteacher where st_id='$id'");
	
	if(mysqli_num_rows($query)>0)
	{
		while($res = mysqli_fetch_assoc($query))
		{
			$clsid = $res['class_id'];
			$q1 = mysqli_query($con,"select * from class where class_id='$clsid'");
			$r1 = mysqli_fetch_array($q1);
			$clsname = $r1['class_name'];
			$secid = $res['section_id'];
			$q2 = mysqli_query($con,"select * from section where section_id='$secid'");
			$r2 = mysqli_fetch_array($q2);
			$secname = $r2['section_name'];

		@$temp = array();
	    $temp['class_id'] = $clsid;
	    $temp['class_name'] = $clsname;
		$temp['section_id'] = $secid;
		$temp['section_name'] = $secname; 
		array_push($data, $temp);
		}
		echo json_encode($data);
	}
	else
	{
		return "No Class Assigned";
	}
}


function attendancetype()
{
	global $con;
	$data = array();
	$query=mysqli_query($con,"select * from attendance_type");
	
	if(mysqli_num_rows($query)>0)
	{
		while($res = mysqli_fetch_assoc($query))
		{
		@$temp = array();
	    $temp['att_type_id'] = $res['att_type_id'];
	    $temp['att_type_name'] = $res['att_type_name'];
	    $temp['short_name'] = $res['short_name'];
		array_push($data, $temp);
		}
		echo json_encode($data);
	}
	else
	{
		return "Invalid Details";
	}
}


function showattendance($classid,$sectionid,$atdate)
{
	global $con;
	$data = array();
	$query=mysqli_query($con,"select * from student_daily_attendance where class_id='$classid' && section_id='$sectionid' 
	 && date='$atdate'");
	$row = mysqli_num_rows($query);
	if(!$row)
	{

		$q1 = mysqli_query($con,"select * from students where class_id='$classid' && section_id='$sectionid' order by (student_id)");
		while($r1 = mysqli_fetch_assoc($q1))
		{
			
		@$temp = array();
		$temp['student_att_id'] = NULL;
	    $temp['register_no'] = $r1['register_no'];
	    $temp['student_id'] = $r1['student_id'];
	    $temp['student_name'] = $r1['student_name'];
		$temp['attendance_type_id'] = NULL;
	    $temp['attendance_type_name'] = NULL;
		array_push($data, $temp);
		}
		echo json_encode($data);
		
	}
	else
	{

		$q2 = mysqli_query($con,"select * from students where class_id='$classid' && section_id='$sectionid' order by (student_id)");
		while($r2 = mysqli_fetch_assoc($q2))
		{
			$stuid = $r2['student_id'];
			$status = mysqli_query($con,"select * from student_daily_attendance where student_id='$stuid' && date='$atdate'");
			$attres = mysqli_fetch_array($status);
			$student_att_id = $attres['student_att_id'];
			$attend_type_id = $attres['type_of_attend'];
			
			$q3 = mysqli_query($con,"select * from attendance_type where att_type_id='$attend_type_id'");
			$r3 = mysqli_fetch_array($q3);
			$attendname = $r3['att_type_name'];
			
		@$temp = array();
	    $temp['student_att_id'] = $student_att_id;
	    $temp['register_no'] = $r2['register_no'];
	    $temp['student_id'] = $stuid;
	    $temp['student_name'] = $r2['student_name'];
	    $temp['attendance_type_id'] = $attend_type_id;
	    $temp['attendance_type_name'] = $attendname;
		array_push($data, $temp);
		}
		echo json_encode($data);
		
	}
}


function homework($classid,$sectionid,$message)
{
	global $con;
	
	$q1 = mysqli_query($con,"select * from students where stu_status='0' and class_id='$classid' and section_id='$sectionid'");
	$row = mysqli_num_rows($q1);
	if($row)	
	{
		while($r1 = mysqli_fetch_array($q1))
		{
			$studid=$r1['student_id'];
			$mobile=$r1['parent_no'];
			
			$q2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,message,notice_datetime,date)
			values(2,'$studid','$classid','$sectionid',0,'$mobile','$message',now(),now())");
		}
		return "Message Sent.";
	}
	else
	{
		return "Invalid Class and Section Id.";
	}
	
}	


function studentattendance($status,$regno,$stuid,$classid,$sectionid,$attendanceid,$atdate,$stuattid)
{
	global $con;
	
	if($status==0)
	{
		$q = mysqli_query($con,"select * from student_daily_attendance where register_no='$regno' and 
		student_id='$stuid' and class_id='$classid' and section_id='$sectionid' and date='$atdate'");
		$r = mysqli_num_rows($q);
		if(!$r)
		{		
		$q1=mysqli_query($con,"insert into student_daily_attendance(register_no,student_id,class_id,section_id,type_of_attend,date) 
		values('$regno','$stuid','$classid','$sectionid','$attendanceid','$atdate')");
		}
		return "Inserted";
	}
	else
	{
		$q2=mysqli_query($con,"update student_daily_attendance set type_of_attend='$attendanceid' where student_att_id='$stuattid'");
		
		return "Updated";
	}
		
}	

/*
function gallery($classid,$sectionid,$message,$image)
{
	global $con;
	
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
	$image_no="1";//or Anything You Need
	$image = $_POST['image'];
	$path = "../gallery/".$image_no.".png";

	$status = file_put_contents($path,base64_decode($image));
	if($status){
	 echo "Successfully Uploaded";
	}else{
	 echo "Upload failed";
	}
	}
	else
	{
		return "Invalid Class and Section Id.";
	}
}
*/


function testname($classid,$sectionid)
{
	global $con;
	$data = array();
	$q1 = mysqli_query($con,"select distinct(test_name) from test where class_id='$classid' && section_id='$sectionid'");
	$row = mysqli_num_rows($q1);
	if($row)
	{
		while($r1= mysqli_fetch_array($q1))
		{
			@$temp = array();
			$temp['test_name'] = $r1['test_name'];
			array_push($data, $temp);
		}
			
			echo json_encode($data);
	}
	else
	{
		return "Invalid Class and Section Id.";
	}
}


function testsubject($classid,$sectionid,$testname)
{
	global $con;
	$data = array();
	$q1 = mysqli_query($con,"select * from test where class_id='$classid' && section_id='$sectionid' && test_name='$testname'");
	$row = mysqli_num_rows($q1);
	if($row)
	{
		while($r1= mysqli_fetch_array($q1))
		{
			$subjectid = $r1['subject_id'];
			$q2 = mysqli_query($con,"select * from subject where subject_id='$subjectid'");
			$r2 = mysqli_fetch_array($q2);
			$subjectname = $r2['subject_name'];
			
			@$temp = array();
			$temp['subject_id'] = $subjectid;
			$temp['subject_name'] = $subjectname;
			array_push($data, $temp);
		}
			
			echo json_encode($data);
	}
	else
	{
		return "Invalid Details.";
	}
}


function showstudents($classid,$sectionid,$testname,$subjectid)
{
	global $con;
	$data = array();
	$q1=mysqli_query($con,"select * from students where class_id='$classid' && section_id='$sectionid'");
	$row = mysqli_num_rows($q1);
	if($row)
	{

        while($r1 = mysqli_fetch_assoc($q1))
		{
		   $regno = $r1['register_no'];
		   $stuid = $r1['student_id'];
		   $stuname = $r1['student_name'];
		   
		   $q2 = mysqli_query($con,"select * from marks where class_id='$classid' && section_id='$sectionid' 
           && test_name='$testname' && subject_id='$subjectid' && student_id='$stuid'");
		   
	        $r2 = mysqli_fetch_array($q2);
	        $markid = $r2['mark_id'];
	        $marks = $r2['marks'];
	       
	        @$temp = array();
    	    $temp['register_no'] = $regno;
    	    $temp['student_id'] = $stuid;
    	    $temp['student_name'] = $stuname;
    	    $temp['markid'] = $markid;
    	    $temp['student_marks'] = $marks;
    		array_push($data, $temp);
		     
		}
		echo json_encode($data);
		
	}
	else
	{
	   return "No Students"; 
	}
}


function exammarks($classid,$sectionid,$testname,$subjectid,$studentid,$marks,$markid)
{
	global $con;
	$q1 = mysqli_query($con,"select * from marks where class_id='$classid' && section_id='$sectionid' 
	&& test_name='$testname' && subject_id='$subjectid' && student_id='$studentid'");
	
	$row = mysqli_num_rows($q1);
	if(!$row)
	{
	    $q2 = mysqli_query($con,"select * from test where class_id='$classid' && section_id='$sectionid' 
	    && test_name='$testname' && subject_id='$subjectid'");
	    $r2 = mysqli_fetch_array($q2);
	    $maxmarks = $r2['max_marks'];
	    
	   $querysave = mysqli_query($con,"insert into marks (class_id,section_id,test_name,subject_id,student_id,marks,max_mark,date) values 
	   ('$classid','$sectionid','$testname','$subjectid','$studentid','$marks','$maxmarks',now())");
	
	    echo "Inserted";
	}
	else
	{
	
		$querysave = mysqli_query($con,"update marks set marks='$marks' where mark_id='$markid'");
	
		echo "Marks Updated";
	}
	
}


function eventcalendar($classid,$sectionid,$creationdate,$fromdate,$todate,$eventfor,$nodays,$heading,$description)
{
	global $con;
	
	$q1 = mysqli_query($con,"select * from events where class_id='$classid' && section_id='$sectionid' && 
	creation_date='$creationdate' && from_date='$fromdate' && to_date='$todate' && event_for='$eventfor' 
	&& no_of_days='$nodays' && event_heading='$heading' && description='$description'");
	
	$row = mysqli_num_rows($q1);
	if($row)
	{
		echo "Already Exists";
	}
	else
	{
		$querysave = mysqli_query($con,"insert into events (class_id,section_id,creation_date,from_date,
		to_date,event_for,no_of_days,event_heading,description) 
		values ('$classid','$sectionid','$creationdate','$fromdate','$todate','$eventfor','$nodays',
		'$heading','$description')");
		
		echo "Event Saved";
	}	
}


?>