<?php
include('connection.php');
?>
<table border>
<thead>
<tr bgcolor="skyblue">
<th>Monday</th>
<th>Tuesday</th>
<th>Wednesday</th>
<th>Thursday</th>
<th>Friday</th>
<th>Saturday</th>
<th>Sunday</th>
</tr>
</thead> 

<tbody>

<tr>
<?php 
$q1 = mysqli_query($con,"select * from weeks order by week_id asc limit 1");
$r1 = mysqli_fetch_array($q1);

$firstdate = $r1['date'];
$dw = date('N', strtotime($firstdate));

$startdt = new DateTime($r1['date']);
$currentdt   = date("Y-m-d");
$end   = new DateTime($currentdt);

for($d=1;$d<$dw;$d++)
{
echo "<td style=\"font-family:arial;\" align=center valign=middle>**
</td>";
}

for($i=$startdt; $i<=$end; $i->modify('+1 day'))
{		
	$ndt = $i->format("Y-m-d");
	
if(date('N', strtotime($i)) == 1) {echo "<tr>";}
$fontColor="#000000";

$q2 = mysqli_query($con,"select * from weeks where date='$ndt'");
$row = mysqli_num_rows($q2);
if($row)
{
	$r2 = mysqli_fetch_array($q2);
	$number = $r2['number'];
	
$fontColor="grey"; 
echo "<td style=\"font-family:arial;color:#333333\" align=center valign=middle> <span style=\"color:$fontColor\">$number</span></td>";
}
else
{
echo "<td style=\"font-family:arial;color:#333333\" align=center valign=middle> <span style=\"color:$fontColor\"></span>**</td>";
}
	

if (date('N', strtotime($ndt)) == 7) { echo "</tr>"; }

}
?>
</tr>

</tbody>

</table>