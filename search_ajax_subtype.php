<?php 
extract($_REQUEST);
include('connection.php');

if($type=="Category")
{
?>
<option value="" selected disabled>Select Category</option>
<?php 
$sc=mysqli_query($con,"select * from social_category");
while($rsc=mysqli_fetch_array($sc))
{
?>
<option value="<?php echo $rsc['soc_cat_id']; ?>"><?php echo $rsc['soc_cat_name']; ?></option>
<?php 
}
}

else if($type=="Religion")
{
?>
<option value="" selected disabled>Select Religion</option>
<?php 
$rl=mysqli_query($con,"select * from religion");
while($rrl=mysqli_fetch_array($rl))
{
?>
<option value="<?php echo $rrl['religion_id']; ?>"><?php echo $rrl['religion_name']; ?></option>
<?php 
}
}

else if($type=="Gender")
{
?>
<option value="" selected disabled>Select Gender</option>
<option value="MALE">Male</option>
<option value="FEMALE">Female</option>
<?php 
}
?>