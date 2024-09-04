<?php 
include('../connection.php');
include('myfunction.php');

extract($_REQUEST);

if($_SERVER['REQUEST_METHOD']=='POST')
	{
$body = file_get_contents('php://input');
$object = json_decode($body);

	echo exammarks($object->classid,$object->sectionid,$object->testname,$object->subjectid,$object->studentid,$object->marks,$object->markid);
	}
?>