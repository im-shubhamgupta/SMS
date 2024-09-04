<?php 
include('connection.php');
extract($_REQUEST);
if(isset($id))
{
	$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$id'");
	$r1 = mysqli_fetch_array($q1);
	$feehead = $r1['fee_header_name'];
	
	
	$query = mysqli_query($con,"select * from assign_fee_class");
	$c = 0;
	while($res = mysqli_fetch_array($query))
	{
		$rfstr=$res['fee_header_id'];
		$arr = explode(',',$rfstr);
		foreach($arr as $k)
		{
		if($k == $id)	
		{
			$c += 1; 
		}
		}
	}
	
	if($c>0)
	{
	echo $feehead;
	}
}


if(isset($del_id))
{
	if(mysqli_query($con,"delete from fee_header where fee_header_id='$del_id'"))
	{
		
		echo "deleted Successfully";

	}	 
}

?>