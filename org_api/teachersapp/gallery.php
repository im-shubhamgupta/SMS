<?php 
include('../connection.php');
//include('myfunction.php');

extract($_REQUEST);
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		
		$image = $_FILES['image']['name'];
								
	$q1 = mysqli_query($con,"select * from students where stu_status='0' and class_id='$classid' and section_id='$sectionid'");
	$row = mysqli_num_rows($q1);
	if($row)	
	{
		move_uploaded_file($_FILES['image']['tmp_name'],"../gallery/".$_FILES['image']['name']);
		
		while($r1 = mysqli_fetch_array($q1))
		{
			$studid=$r1['student_id'];
			$mobile=$r1['parent_no'];
			
		$q2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,photos,notice_datetime,date)
		values(4,'$studid','$classid','$sectionid','$mobile','$message','$image',now(),now())");
		}
		
		echo "inserted";
	}	
		//$path = "pic/$id.png";
		//$actualpath = "https://kiranajunction.in/API/v2/$path";
		//file_put_contents($path,base64_decode($image));
		
		//$sql = "INSERT INTO seller_product (image) VALUES ('$actualpath')";
		
		// $sql1=mysqli_query($con,"insert into sale_request(category_id,pro_id,pro_price,qantity,payment_mode,expiry_date,image,user_id,user_type) values('$category_id','$pro_id','$pro_price','$quantity','$payment_mode','$expiry_date','$actualpath','$user_id','$user_type')");
		
		// if(mysqli_query($con,$sql1))
		// {
			//file_put_contents($path,base64_decode($image));
			// echo "Successfully Uploaded";
		// }
		
		// mysqli_close($con);
	else
	{
		echo "Error";
	}	
	}

	
?>