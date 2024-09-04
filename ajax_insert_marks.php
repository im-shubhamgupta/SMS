<?php
include('connection.php');
extract($_REQUEST);

//$stuidarr = json_decode($_POST['studid']);
$marksarr = json_decode($_POST['marks']);

for ($i = 0; $i < count($marksarr); $i++) {
$que = mysqli_query($con,"insert into marks (marks) values ('$marksarr[$i]')");

}
Print "Data added Successfully !";



?>