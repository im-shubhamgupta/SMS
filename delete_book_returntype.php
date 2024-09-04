<?php 
include('connection.php');
$eid=$_GET['x'];

mysqli_query($con,"delete from book_return_type where book_return_type_id ='$eid'");
header('location:dashboard.php?option=view_book_return_type');

?>