<?php 
include('../connection.php');
include('myfunction.php');

extract($_REQUEST);

if($_SERVER['REQUEST_METHOD']=='POST')
	{
	$body = file_get_contents('php://input');
	$object = json_decode($body);

	echo homework($object->classid,$object->sectionid,$object->subject,$object->stuid);

	}

?>