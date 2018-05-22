<?php 

$prefix='../';$start=2;
include'../../config.php';
include'../../file.php';
session_admin($start);

if(isset($_POST['action'])){
	$action=$_POST['action'];

	if($action=="add_chapter"){
		$subject_id=$_POST['subject_id'];
		$chapter=$_POST['chapter'];
		if($chapter!='' || $chapter!=null){
			mysqli_query($con,"insert into chapter (chapter_name,subject_id) values ('$chapter','$subject_id')");
			$ss=mysqli_fetch_array(mysqli_query($con,"select chapter_id from chapter where subject_id='$subject_id' order by chapter_id DESC limit 1"),MYSQLI_ASSOC);
			echo $ss['chapter_id'];
		}
	}

	if($action=="add_section"){
		$section=$_POST['section'];
		$chapter_id=$_POST['chapter'];
		$f=mysqli_fetch_array(mysqli_query($con,"select subject_id from chapter where chapter_id='$chapter_id'"),MYSQLI_ASSOC);
		$subject_id=$f['subject_id'];
		mysqli_query($con,"insert into section (subject_id,chapter_id,section_name) values ('$subject_id','$chapter_id','$section')");
		$ss=mysqli_fetch_array(mysqli_query($con,"select section_id from section where chapter_id='$chapter_id' order by section_id DESC limit 1"),MYSQLI_ASSOC);
		echo $ss['section_id'];
	}

	if($action=="delete_chapter"){
		$chapter_id=$_POST['chapter_id'];
		mysqli_query($con,"delete from section where chapter_id='$chapter_id'");
		mysqli_query($con,"delete from chapter where chapter_id='$chapter_id'");
		echo "success";
	}
	if($action=="delete_section"){
		$section=$_POST['section'];
		mysqli_query($con,"delete from section where section_id='$section'");
		echo "success";
		
	}
}



?>