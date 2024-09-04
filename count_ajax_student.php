<?php 

error_reporting(1);

extract($_REQUEST);

include('connection.php');

//echo "this is category".$cat;

//echo "class id".$clid;

//echo "section id".$secid;

if(isset($cat))

{

	if($cat=="1")

	{

	// $que=mysqli_query($con,"select * from students where stu_status='0' and session='".$_SESSION['session']."'");
	$que=mysqli_query($con,"select `student_id`,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' and sr.session='".$_SESSION['session']."'  ");



	echo mysqli_num_rows($que);

	}else if($cat=="2" || $cat=="3"){

		$que1=mysqli_query($con,"select `student_id`,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' && sr.class_id='$clid' && sr.section_id='$secid' and sr.session='".$_SESSION['session']."'  ");

	echo mysqli_num_rows($que1);

	}

	else if($cat=="4")

	{		

		if(!empty($clid) && empty($secid))

		{	

		
		$que2=mysqli_query($con,"select `student_id`,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' && sr.class_id='$clid' and sr.session='".$_SESSION['session']."'  ");

		echo mysqli_num_rows($que2);

		}

		else if(!empty($clid) && !empty($secid))

		{	

		
		$que3=mysqli_query($con,"select `student_id`,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' && sr.class_id='$clid'  && sr.section_id='$secid' and sr.session='".$_SESSION['session']."'  ");

		echo mysqli_num_rows($que3);

		}

		else

		{

		$que4=mysqli_query($con,"select `student_id`,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' and sr.session='".$_SESSION['session']."'  ");

		echo mysqli_num_rows($que4);

		}

	}

	else if($cat=="6")

	{

		if(!empty($clid) && empty($secid))

		{

		 $sql1="select `student_id`,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' && sr.class_id='$clid' and sr.session='".$_SESSION['session']."'  ";
		$que5=mysqli_query($con,$sql1);

		echo mysqli_num_rows($que5);

		}

		else

		{	
			 $sql2="select `student_id`,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' && sr.class_id='$clid' && sr.section_id='$secid' and sr.session='".$_SESSION['session']."'  ";
		
		$que6=mysqli_query($con,$sql2);


		echo mysqli_num_rows($que6);

		}

	}

	else if($cat=="5")

	{

		// $que7=mysqli_query($con,"select * from students where stu_status='0' && class_id='$clid' && section_id='$secid' and session='".$_SESSION['session']."'");
		if(empty($clid)){
			$que7=mysqli_query($con,"select `student_id`,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0'  and sr.session='".$_SESSION['session']."'  ");
		}else{
			$que7=mysqli_query($con,"select `student_id`,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' && sr.class_id='$clid' && sr.section_id='$secid' and sr.session='".$_SESSION['session']."'  ");
		}
		


		echo mysqli_num_rows($que7);

	}

	

	

}





?>