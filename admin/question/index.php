<?php 
$prefix='../';$start=2;
include'../../config.php';
include'../../file.php';
session_admin($start);

$code='';$list='';$js='';
include'preload.php';

if(isset($_SESSION['status'])){
    $status=$_SESSION['status'];
    if($status=="new_question"){
        $js='toastr.success("Question Database Updated", "New Questions Added.");';
    }
    unset($_SESSION['status']);
}



if(isset($_POST['save'])){
    $chapter=$_POST['chapter'];
    $type=$_POST['type'];
    $ty=$type;if($ty=="name"){$ty="fillup";}
    $sql=mysqli_query($con,"select question_id from question where chapter_id='$chapter' and type='$ty' ");
    $count=mysqli_num_rows($sql);
    if($count==0){
        mysqli_query($con,"insert into question (chapter_id,type) values ('$chapter','$ty')");
    }

    $s=mysqli_fetch_array(mysqli_query($con,"select question_id from question where chapter_id='$chapter' and type='$ty'"),MYSQLI_ASSOC);
    $question_id=$s['question_id'];

    if($type!='' && $chapter!=''){
        if($type=="mcq"){
            $a=$_POST['a'];$b=$_POST['b'];$c=$_POST['c'];$d=$_POST['d'];$q=$_POST['q'];
            $answer=$_POST['answer'];
            for($i=0;$i<sizeof($a);$i++){
                $optiona=mysqli_real_escape_string($con,$a[$i]);$optionb=mysqli_real_escape_string($con,$b[$i]);
                $optionc=mysqli_real_escape_string($con,$c[$i]);$optiond=mysqli_real_escape_string($con,$d[$i]);
                $question=mysqli_real_escape_string($con,$q[$i]);
                mysqli_query($con,"insert into mcq (question,a,b,c,d,answer,question_id) values ('$question','$optiona','$optionb','$optionc','$optiond','$answer[$i]','$question_id')");
            }
        }

        if($type=="tf"){
            $q=$_POST['q'];
            $answer=$_POST['answer'];
            for($i=0;$i<sizeof($q);$i++){
               $question=mysqli_real_escape_string($con,$q[$i]);
                mysqli_query($con,"insert into tf (question,answer,question_id) values ('$question','$answer[$i]','$question_id')");
            } 
        }
        if($type=="fillup"){
            $q=$_POST['q'];$ans=$_POST['answer'];
            for($i=0;$i<sizeof($q);$i++){
                $question=mysqli_real_escape_string($con,$q[$i]);
                $answer=mysqli_real_escape_string($con,$ans[$i]);
                $answer=strtolower($answer);$answer=preg_replace("/\s|&nbsp;/",'',$answer);
                $answer=str_replace("-","",$answer);
                mysqli_query($con,"insert into fillup (question,question_id,answer) values ('$question','$question_id','$answer')");
            }

        }
        if($type=="name"){
            $q=$_POST['q'];$ans=$_POST['answer'];
            for($i=0;$i<sizeof($q);$i++){
                $question=mysqli_real_escape_string($con,$q[$i]);
                $answer=mysqli_real_escape_string($con,$ans[$i]);
                $answer=strtolower($answer);$answer=preg_replace("/\s|&nbsp;/",'',$answer);
				$answer=str_replace("<p>","",$answer);
                $answer=str_replace("</p>","",$answer);
                $answer=str_replace("<br>","",$answer);
                $answer=str_replace("<br/>","",$answer);
                $answer=str_replace("-","",$answer);
                mysqli_query($con,"insert into fillup (question,question_id,answer,qorder) values ('$question','$question_id','$answer','y')");
            }

        }
        $_SESSION['status']="new_question";
        echo"<script>location.href=('../question/')</script>";
    }
    
}

                           
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <?php include_global($start);include_theme($start);include_select2($start);include_summernote($start);include_toastr($start); ?>
    <link rel="stylesheet" type="text/css" href="main.css">       
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

        <?php include $prefix.'menu.php'; ?>
        <div class="clearfix"> </div>

        <div class="page-container">
            <?php include $prefix.'sidebar.php' ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <?php echo $code ?>
                </div>
            </div>


        </div>         

<form method="post">
<div class="add-question-panel" id="popup-window" >

<div class="title">Add Questions</div>
<div class="body" >
    <!--<div class="right-panel-toggle">Questions</div>
    <div class="right-panel-body">Questions</div>-->
    <div class="row">
        <div class="col-md-4 form-group">
            <label class="control-label">Select Section</label>
            <select name="chapter" class="form-control" required>
                <option></option>
                <?php echo $list ?>
            </select>
        </div>
        <div class="col-md-8">
            <label>Question Type</label>
             <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input type="radio" name="type" value="mcq"> MCQ
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="type" value="tf"> True/False
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="type" value="fillup"> Fillups
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="type" value="name"> Name the Following
                    <span></span>
                </label>
            </div>
        </div>
    </div>
    <div class="question-body">
          
    </div>
</div>
<div class="footer">
    <button type="button" class="btn btn-success btn-circle dark btn-outline add-new">Add Question</button>
    <span class="badge badge-info" id="count-question"><span>0</span> Questions</span>
    <button type="button" class="btn btn-success btn-circle dark btn-outline close-question pull-right" style="margin-right:10px">Close</button>
    <input type="submit" class="btn btn-success btn-circle pull-right" value="Save" name="save" style="margin-right:10px" />

</div>

</div>
</form>

<div class="modal fade" id="editor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <textarea name="editor" class="summernote"></textarea>
        </div>
        <div class="modal-footer">
            <span class="pull-left"><input type="checkbox" name="correct" id="correct"> Correct Answer</span>
            <button type="button" id="ok" class="btn btn-default dark">Close</button>
        </div>
    </div>
  </div>
</div>


</body>

<script src="main.js"></script>
<script>
$(document).ready(function(){
    <?php echo $js ?>
})
</script>

</html>
