<?php
include('../connection.php');
include('myfunction.php');

extract($_REQUEST);

if($_SERVER['REQUEST_METHOD']=='POST')
{
	$body = file_get_contents('php://input');
	$object = json_decode($body);
	
	echo leaverequest($object->dateofsubmission, $object->classid, $object->sectionid, $object->studentid,
	$object->fromdate, $object->todate, $object->leavetypeid, $object->noofdays, $object->reason, 
	$object->note);
}

?>