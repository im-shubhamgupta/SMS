<?php 
include('connection.php');
$eid=$_GET['x'];

mysqli_query($con,"delete from books where book_id='$eid'");
header('location:dashboard.php?option=view_books');

?>