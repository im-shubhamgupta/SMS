<?php
include('connection.php');

	$q1 = mysqli_query($con,"select * from activity_history");
	while($r1 = mysqli_fetch_array($q1))
	{
		$id = $r1['activity_id'];
		
		$now = time();
		
		$hisdate = $r1['date'];
		$your_date = strtotime($hisdate);
		$datediff = $now - $your_date;

		$totaldays = round($datediff / (60 * 60 * 24));
		
		if($totaldays>30)
		{
			$qu1 = mysqli_query($con,"delete from activity_history where activity_id='$id'");
		}
	}

	
	$q2 = mysqli_query($con,"select * from student_notifications where category='4' || category='6'");
	while($r2 = mysqli_fetch_array($q2))
	{
		$id = $r2['st_notification_id'];
		$photos = $r2['photos'];
		$photoarr = explode(",",$photos);
		
		$now = time();
		$hisdate = $r2['date'];
		$your_date = strtotime($hisdate);
		$datediff = $now - $your_date;

		$totaldays = round($datediff / (60 * 60 * 24));
		
		if($totaldays>30)
		{
			foreach($photoarr as $k)
			{
				unlink("gallery/$k");
			}
			
			$qu2 = mysqli_query($con,"delete from student_notifications where st_notification_id='$id'");
		}
	}
	
?>

<form method="post">
<input type="submit" name="save"/>
</form>
