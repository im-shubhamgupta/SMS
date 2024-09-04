<?php 
include('../connection.php');
include('myfunction.php');

extract($_REQUEST);

if($_SERVER['REQUEST_METHOD']=='POST')
	{
$body = file_get_contents('php://input');
$object = json_decode($body);

	echo studentattendance($object->status,$object->regno,$object->stuid,$object->classid,$object->sectionid,$object->attendanceid,$object->atdate,$object->stuattid);
	}
?>