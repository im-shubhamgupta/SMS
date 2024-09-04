<?php 
include('connection.php');
$eid=$_GET['x'];

mysqli_query($con,"delete from book_type where book_type_id='$eid'");
header('location:dashboard.php?option=view_book_type');

?>