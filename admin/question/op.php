<?php
include'../../config.php';
include'../../file.php';
$start=2;
session_admin($start);

if(isset($_POST['action'])){
$action=$_POST['action'];

if($action=="delete"){
	$type=$_POST['type'];
	$id=$_POST['id'];

	if($type=="mcq"){
		mysqli_query($con,"delete from mcq where mcq_id='$id' ");
	}
	if($type=="tf"){
		mysqli_query($con,"delete from tf where tf_id='$id' ");
	}
	if($type=="fillup"){
		mysqli_query($con,"delete from fillup where fillup_id='$id' ");
	}
}

}

?>