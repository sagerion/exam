<?php 
include'../../../config.php';
include'../../../file.php';
$prefix='../../';$start=3;
session_demo($start);
$current_time=strtotime(date("Y-m-d H:i:s"));
$user_id=$_SESSION['id'];$s='';$out='';$time='';$noi=0;$attempt='';
$sq=mysqli_fetch_array(mysqli_query($con,"select class from user where user_id='$user_id' "),MYSQLI_ASSOC);
$user_class=$sq['class'];
$check_question='';
$check_question.="<script>var answer=new Array();var question=new Array();var positive=1;var negative=0;var total=10;";
include'../../../start_question.php';
$check_question.='</script>';

if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql=mysqli_query($con,"select subject_id from chapter where chapter_id='$id' ");
    $a=mysqli_fetch_array($sql,MYSQLI_ASSOC);
    $subject_id=$a['subject_id'];
    $sql=mysqli_query($con,"select chapter_id from chapter where subject_id='$subject_id' order by chapter_id ASC  limit 1000 offset 2 ");

    while ($c=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
        $chapter_id=$c['chapter_id'];
        if($chapter_id==$id){header('location:../');}
    }
    
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
      
        <?php include_global($start);include_theme($start);include_summernote($start); ?>
		<link rel="stylesheet" href="main.css" type="text/css" />        
</head>
<body style="overflow-x: hidden;">
<form action="" method="post" id="exam">
<div class="title bg-dark font-white text-center">
	<span class="pull-left"><?php echo $s['chapter_name'] ?></span>
	<span class="timer"></span>
	<a href="#confirm_submit" data-toggle="modal" class="btn btn-circle btn-success pull-right" id="confirm_button">Submit</a>
</div>      
<div class="row">
<div class="col-md-10 col-md-offset-1">
<?php echo $out ?>
</div>
</div>            
</form>
<div class="modal fade" id="confirm_submit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:20vh">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <h3 class="text-center bold">Submit Test ?</h3>
        </div>
        <div class="modal-footer">
            <button type="button" name="check" class="btn btn-default green pull-left">Submit</button>
            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<div class="modal fade" id="editor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <textarea name="editor" class="summernote"></textarea>
        </div>
        <div class="modal-footer">
            <button type="button" id="ok" class="btn btn-default dark">Submit</button>
        </div>
    </div>
  </div>
</div>
<div class="floating-buttons" style="display: none">
    <a href="javascript:;" id="print" class="btn btn-success">
        <i class="fa fa-print"></i>
        <div> Print </div>
    </a>
    <a href="../../" id="" class="btn btn-default dark" style="margin-left:-6px">
        <i class="fa fa-home"></i>
        <div> Home </div>
    </a>
    <a href="#modal" data-toggle="modal" class="btn btn-default blue" style="margin-left:-6px">
        <i class="fa fa-info"></i>
        <div>Know More </div>
    </a>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  style="top: 10vh;">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Know More</h4>
        </div>
        <div class="modal-body">
            <a class="btn btn-circle" style="background:rgba(3, 169, 244,0.7)">&nbsp;</a> Selected answer <b>Right</b><br/>
            <a class="btn btn-circle" style="background:rgba(231, 80, 90,0.7)">&nbsp;</a> Selected answer <b>Wrong</b><br/>
            <a class="btn btn-circle" style="background:rgba(38, 194, 129,0.7)">&nbsp;</a> <b>Correct</b> Answer
        </div>
        <div class="modal-footer">
            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
</body>
<Script>var countdown =<?php echo $time ?> * 60 * 1000;</Script>
<?php echo $check_question ?>
<script src="main.js"></script>



</html>