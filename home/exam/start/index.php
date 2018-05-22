<?php 
include'../../../config.php';
include'../../../file.php';
$prefix='../../';$start=3;
date_default_timezone_set('Asia/Kolkata');
session_check($start);
$check_question='';
$current_time=strtotime(date("Y-m-d H:i:s"));
$user_id=$_SESSION['id'];$s='';$out='';$time='';$noi=0;$attempt='';
$sq=mysqli_fetch_array(mysqli_query($con,"select class from user where user_id='$user_id' "),MYSQLI_ASSOC);
$user_class=$sq['class'];$user_level=$sq['level'];
$check_question.="<script>var answer=new Array();var question=new Array();";
if(isset($_GET['id'])){
	if($_SESSION['posted']=='y'){header('location:../');}
	$_SESSION['posted']='n';
	$test_id=$_GET['id'];
	$sqq=mysqli_query($con,"select test_id from test where class='$user_class' and (level='$user_level' or level='0') and test_id='$test_id'");
	if(mysqli_num_rows($sqq)==0){header('location:../');}
	$s=mysqli_fetch_array(mysqli_query($con,"select * from test where test_id='$test_id'"),MYSQLI_ASSOC);
	$time=date("i",strtotime($s['total_time']));
	$check_question.='var positive='.$s['positive'].';';
	$check_question.='var negative='.$s['negative'].';';
	$check_question.='var total='.$s['total'].';';
	$check_question.='var test_id='.$test_id.';';
	$check_question.='var uni_id='.$user_id.';';
	$start_date=strtotime($s['start']);$end_date=strtotime($s['end']);
	if($current_time<$start_date){$_SESSION['status']="upcoming_test";header('location:../');}
	else if($current_time>$end_date){$_SESSION['status']="end_test";header('location:../');}
	else{
	$sql=mysqli_query($con,"select * from test_prep where test_id='$test_id'");
	while ($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
		$type=$a['type'];$num=$a['num'];$chapter_id=$a['chapter_id'];
		$b=mysqli_fetch_array(mysqli_query($con,"select question_id from question where chapter_id='$chapter_id' and type='$type'"));
		$question_id=$b['question_id'];
		if($type=="mcq"){
			$sqq=mysqli_query($con,"select * from mcq where question_id='$question_id' ORDER BY RAND() LIMIT ".$num." ");
			while ($b=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
			$check_question.="answer[".$noi."]='".$b['answer']."';";
			$noi++;
			$out.='
					<div class="row question portlet light">
			            <div class="col-md-12 question-text" data-attr="q"><span class="pull-left bold">Q'.$noi.'</span>'.$b['question'].'</div>
			            <div class="col-md-12 text-center option-row ">
			                <div class="col-md-3 question-option" data-attr="a">'.$b['a'].'</div>
			                <div class="col-md-3 question-option" data-attr="b">'.$b['b'].'</div>
			            </div>
			            <div class="col-md-12 text-center option-row ">
			                <div class="col-md-3 question-option" data-attr="c">'.$b['c'].'</div>
			                <div class="col-md-3 question-option" data-attr="d">'.$b['d'].'</div> 
			            </div>
			             	<input type="hidden" name="id[]" value="'.$b['mcq_id'].'" />
			             	<input type="hidden" name="type[]" value="mcq" />
			                <input type="hidden" name="answer[]" />
			        </div>
			';
			}
		}
		if($type=="tf"){
			$sqq=mysqli_query($con,"select * from tf where question_id='$question_id' ORDER BY RAND() LIMIT ".$num." ");
			while ($b=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
			$check_question.="answer[".$noi."]='".$b['answer']."';";
			$noi++;
			$out.='
					<div class="row question portlet light">
			            <div class="col-md-12 question-text" data-attr="q"><span class="pull-left bold">Q'.$noi.'</span>'.$b['question'].'</div>
			            <div class="col-md-12 text-center option-row ">
			                <div class="col-md-3 question-option" data-attr="t">True</div>
			                <div class="col-md-3 question-option" data-attr="f">False</div>
			            </div>
			             	<input type="hidden" name="id[]" value="'.$b['tf_id'].'" />
			             	<input type="hidden" name="type[]" value="tf" />
			                <input type="hidden" name="answer[]" />
			        </div>
			';
			}
		}
		if($type=="fillup"){
			$sqq=mysqli_query($con,"select * from fillup where question_id='$question_id' and qorder='n' ORDER BY RAND() LIMIT ".$num." ");
			while ($b=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
				$check_question.="answer[".$noi."]='".$b['answer']."';";
				$check_question.="question[".$noi."]='".$b['question']."';";
				$noi++;
				$question=$b['question'];
				$question=preg_replace("/<u+\>(.*?)<\/u>/i"," <u></u> ", $question); 
				$out.='
						<div class="row question portlet light">
				            <div class="col-md-12 question-text" data-attr="q"><span class="pull-left bold">Q'.$noi.'</span>'.$question.'</div>
				             	<input type="hidden" name="id[]" value="'.$b['fillup_id'].'" />
				             	<input type="hidden" name="type[]" value="fillup" />
				                <input type="hidden" name="answer[]" />
				        </div>
				';
			}
		}}

		$sql=mysqli_query($con,"select attempt from test_score where test_id='$test_id' and user_id='$user_id' ");
		if(mysqli_num_rows($sql)==1){
			$a=mysqli_fetch_array($sql,MYSQLI_ASSOC);
			$attempt=$a['attempt'];$attempt++;

			if($attempt>3){$_SESSION['status']='attempt_complete';header('location:../');}
			else{
				mysqli_query($con,"update test_score set attempt='$attempt',mail='n' where user_id='$user_id' and test_id='$test_id' ");
			}
			
		}
		else{
			$attempt=1;
			$current_date=date("Y-m-d H:i:s");
			mysqli_query($con,"insert into test_score (attempt,user_id,test_id,class,date) values ('1','$user_id','$test_id','$user_class','$current_date') ");
		}
	}
	$check_question.="</script>";
}

mysqli_close($con);
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
<body>
<div id="doc">
<img src="../../../assets/pages/img/back.png" style="margin:0 auto;opacity:0.2;width:300px;z-index: -1;position: fixed;top:30vh;left:40vw">
<div class="title bg-dark font-white text-center">
	<span class="pull-left"><?php echo $s['name'] ?> <small style="font-weight: 100;margin-left: 10px">Attempt: <?php echo $attempt ?> / 3</small></span>
	<span class="timer"></span>
	<input type="hidden" value="<?php echo ($_GET['id']); ?>" name="test_id" />
	<a href="#confirm_submit" data-toggle="modal" class="btn btn-circle btn-success pull-right" id="confirm_button">Submit</a>
</div>      
<div class="row">
<div class="col-md-10 col-md-offset-1">
<?php echo $out ?>
</div>
</div>            
</div>

<div class="circle-loader">
  <div class="checkmark draw"></div>
</div>
<div class="overlay"></div>

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
<Script>var countdown = <?php echo $time ?> * 60 * 1000;</Script>
<?php echo $check_question ?>
<script src="main.js"></script>



</html>