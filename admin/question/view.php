<?php 
$prefix='../';$start=2;
include'../../config.php';
include'../../file.php';
session_admin($start);
$js='';
if(isset($_SESSION['status'])){
    $status=$_SESSION['status'];
    if($status=="update_question"){
        $js='toastr.info("Question Database Updated", "Question Updated.");';
    }
    unset($_SESSION['status']);
}


$code='';$list='';$out='';
$append='';$js_append='';
$noi=0;
$chapter_id=$_GET['id'];
$type_check=$_GET['type'];
$type=$_GET['type'];
if($type=="tf"){$type="True/False";}
$f=mysqli_fetch_array(mysqli_query($con,"select subject_id,chapter_name from chapter where chapter_id='$chapter_id'"),MYSQLI_ASSOC);
$subject_id=$f['subject_id'];
$g=mysqli_fetch_array(mysqli_query($con,"select subject_name from subject where subject_id='$subject_id'"));
$subject_name=$g['subject_name'];

$s=mysqli_fetch_array(mysqli_query($con,"select question_id from question where chapter_id='$chapter_id' and type='$type_check' "));  
$question_id=$s['question_id'];
if($type=="mcq"){
    $append='
            <div class="row portlet light">
                <div class="col-md-12 question-text" data-attr="q">Question</div><textarea wrap="hard" name="q" class="hide q">Question</textarea>
                <div class="row text-center option-row ">
                    <div class="col-md-2 question-option" data-attr="a">Option</div><textarea name="a" class="hide a">Option</textarea>
                    <div class="col-md-2 question-option" data-attr="b">Option</div><textarea name="b" class="hide b">Option</textarea>
                    <div class="col-md-2 question-option" data-attr="c">Option</div><textarea name="c" class="hide c">Option</textarea>
                    <div class="col-md-2 question-option" data-attr="d">Option</div><textarea name="d" class="hide d">Option</textarea>
                    <input type="hidden" name="answer" />
                </div>
            </div>
    ';
    $js_append='
        $(".active-edit").removeClass("active-edit");
        $(this).parent().parent().addClass("active-edit");
        var data=$(".active-edit input[name=question-text-view]").val();
        var optiona=$(".active-edit div[data-attr=a]").html();
        var optionb=$(".active-edit div[data-attr=b]").html();
        var optionc=$(".active-edit div[data-attr=c]").html();
        var optiond=$(".active-edit div[data-attr=d]").html();
        var answer=$(".active-edit .right").attr("data-attr");
        var question_id=$(".active-edit").attr("data-attr");

        $("#modal .question-text,#modal textarea[name=q]").html(data);
        $("#modal div[data-attr=a],#modal textarea[name=a]").html(optiona);
        $("#modal div[data-attr=b],#modal textarea[name=b]").html(optionb);
        $("#modal div[data-attr=c],#modal textarea[name=c]").html(optionc);
        $("#modal div[data-attr=d],#modal textarea[name=d]").html(optiond);
        $("#modal input[name=answer]").val(answer);
        $("#modal input[name=question_id]").val(question_id);
        $("#modal div[data-attr="+answer+"]").addClass("right");
    ';
    $sqq=mysqli_query($con,"select * from mcq where question_id='$question_id' ");
    while ($a=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
        $answer=$a['answer'];
        $ansa='';$ansb='';$ansc='';$ansd='';
        if($answer=="a"){$ansa="right";}
        if($answer=="b"){$ansb="right";}
        if($answer=="c"){$ansc="right";}
        if($answer=="d"){$ansd="right";}
        $noi++;
        $out.='
                <div class="col-md-10 col-md-offset-1 question portlet light" data-attr="'.$a['mcq_id'].'">
                    <div class="col-md-12 question-text-view" data-attr="q"><span class="pull-left bold">Q'.$noi.'</span>'.$a['question'].'</div>
                    <input type="hidden" name="question-text-view" value="'.$a['question'].'" />
                    <div class="col-md-2 question-option-view text-center '.$ansa.'" data-attr="a">'.$a['a'].'</div>
                    <div class="col-md-2 question-option-view text-center '.$ansb.'" data-attr="b">'.$a['b'].'</div>
                    <div class="col-md-2 question-option-view text-center '.$ansc.'" data-attr="c">'.$a['c'].'</div>
                    <div class="col-md-2 question-option-view text-center '.$ansd.'" data-attr="d">'.$a['d'].'</div> 
                    <div class="col-md-1 pull-right " >
                        <a href="#modal" data-toggle="modal" class="btn btn-circle btn-default btn-icon-only dark tooltips edit" data-title="Edit" data-attr="'.$a['mcq_id'].'" data-type="mcq">
                            <i class="icon-pencil"></i>
                        </a>
                        <span class="btn btn-circle btn-default btn-icon-only dark tooltips delete" data-title="Delete" data-attr="'.$a['mcq_id'].'" data-type="mcq">
                            <i class="icon-trash"></i>
                        </span>
                    </div>
                </div>
            ';
    }
}

if($type=="fillup"){
    $append.='
        <div class="row portlet light">
                <div class="col-md-11 question-text-fillup" data-attr="fillup">Fillups</div><textarea wrap="hard" name="q" class="hide q">Fillups</textarea>
                <input type="hidden" name="answer" />
            </div>
    ';
    $js_append='
        $(".active-edit").removeClass("active-edit");
        $(this).parent().parent().addClass("active-edit");
        var q=$(".active-edit input[name=question-text-fillup-view]").val();
        var ans=$(".active-edit input[name=answer-view]").val();
        var question_id=$(".active-edit").attr("data-attr");

        $("#modal .question-text-fillup,#modal textarea[name=q]").html(q);
        $("#modal input[name=answer]").val(ans);
        $("#modal input[name=question_id]").val(question_id);
    ';
    $sqq=mysqli_query($con,"select * from fillup where question_id='$question_id' ");
    while ($a=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {$back='';
        $noi++;$order=$a['qorder'];if($order=="y"){$back='style="background:rgba(0,188,212,0.2)"';}
        $out.='
                <div class="col-md-10 col-md-offset-1 question portlet light" data-attr="'.$a['fillup_id'].'">
                    <div class="col-md-11 question-text-fillup-view" '.$back.' data-attr="fillup"><span class="pull-left bold">Q'.$noi.'</span>'.$a['question'].'</div>
                    <input type="hidden" name="question-text-fillup-view" value="'.$a['question'].'" />
                    <input type="hidden" name="answer-view" value="'.$a['answer'].'" />
                    <div class="col-md-1 pull-right " >
                        <a href="#modal" data-toggle="modal" class="btn btn-circle btn-default btn-icon-only dark tooltips edit" data-title="Edit" data-attr="'.$a['fillup_id'].'" data-type="fillup">
                            <i class="icon-pencil"></i>
                        </a>
                        <span class="btn btn-circle btn-default btn-icon-only dark tooltips delete" data-title="Delete" data-attr="'.$a['fillup_id'].'" data-type="fillup">
                            <i class="icon-trash"></i>
                        </span>
                    </div>

                </div>
            ';
    }
}
if($type=="True/False"){
    $append='<div class="row question portlet light">
                <div class="col-md-12 question-text" data-attr="q">Question</div><textarea wrap="hard" name="q" class="hide q">Question</textarea>
                <div class="row text-center option-row ">
                    <div class="col-md-2 tf-option" data-attr="t">True</div>
                    <div class="col-md-2 tf-option" data-attr="f">False</div>
                    <input type="hidden" name="answer" />
                </div>
            </div>';
    $js_append='
        $(".active-edit").removeClass("active-edit");
        $(this).parent().parent().parent().addClass("active-edit");
        var data=$(".active-edit input[name=question-text-view]").val();
        var answer=$(".active-edit .right").attr("data-attr");
        var question_id=$(".active-edit").attr("data-attr");
        $("#modal .question-text,#modal textarea[name=q]").html(data);
        $("#modal input[name=answer]").val(answer);
        $("#modal input[name=question_id]").val(question_id);
        $("#modal div[data-attr="+answer+"]").addClass("right");
    ';
    $sqq=mysqli_query($con,"select * from tf where question_id='$question_id' ");
    while ($a=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
        $answer=$a['answer'];$anst='';$ansf='';
        if($answer=="t"){$anst="right";}
        if($answer=="f"){$ansf="right";}
        $noi++;
        $out.='
                <div class="col-md-10 col-md-offset-1 question portlet light" data-attr="'.$a['tf_id'].'">
                     <div class="col-md-12 question-text-view" data-attr="q"><span class="pull-left bold">Q'.$noi.'</span>'.$a['question'].'</div>
                     <input type="hidden" name="question-text-view" value="'.$a['question'].'" />
                    <div class="row text-center option-row ">
                        <div class="col-md-2 tf-option-view '.$anst.'" data-attr="t">True</div>
                        <div class="col-md-2 tf-option-view '.$ansf.'" data-attr="f">False</div>
                        <div class="col-md-1 pull-right" >
                            <a href="#modal" data-toggle="modal" class="btn btn-circle btn-default btn-icon-only dark tooltips edit" data-title="Edit" data-attr="'.$a['tf_id'].'" data-type="tf">
                                <i class="icon-pencil"></i>
                            </a>
                            <span class="btn btn-circle btn-default btn-icon-only dark tooltips delete" data-title="Delete" data-attr="'.$a['tf_id'].'" data-type="tf">
                                <i class="icon-trash"></i>
                            </span>
                        </div>
                        
                    </div>
                </div>
            ';
    }
}


if(isset($_POST['save'])){
    $chapter_id=$_GET['id'];
    $type=$_POST['type'];
    $question_id=$_POST['question_id'];
    if($type!=''){
        if($type=="mcq"){
            $a=$_POST['a'];$b=$_POST['b'];$c=$_POST['c'];$d=$_POST['d'];$q=$_POST['q'];
            $answer=$_POST['answer'];
            $optiona=mysqli_real_escape_string($con,$a);$optionb=mysqli_real_escape_string($con,$b);
            $optionc=mysqli_real_escape_string($con,$c);$optiond=mysqli_real_escape_string($con,$d);
            $question=mysqli_real_escape_string($con,$q);
            mysqli_query($con,"update mcq set question='$question',a='$optiona',b='$optionb',c='$optionc',d='$optiond' where mcq_id='$question_id' ");
        }

        if($type=="tf"){
            $q=$_POST['q'];
            $answer=$_POST['answer'];
            $question=mysqli_real_escape_string($con,$q);
            mysqli_query($con,"update tf set question='$question',answer='$answer' where tf_id='$question_id' ");
        }
        if($type=="fillup"){
            $q=$_POST['q'];$ans=$_POST['answer'];
                $question=mysqli_real_escape_string($con,$q);
                $answer=mysqli_real_escape_string($con,$ans);
                $answer=strtolower($answer);$answer=preg_replace("/\s|&nbsp;/",'',$answer);
                $answer=str_replace("<p>","",$answer);
                $answer=str_replace("</p>","",$answer);
                $answer=str_replace("<br>","",$answer);
                $answer=str_replace("<br/>","",$answer);
                mysqli_query($con,"update fillup set question='$question',answer='$ans' where fillup_id='$question_id' ");

        }
        $_SESSION['status']="update_question";
        echo"<script>location.href=('./view.php?id=".$chapter_id."&type=".$type."')</script>";
    }
}
                         
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <?php include_global($start);include_theme($start);include_toastr($start);include_summernote($start); ?>
    <link rel="stylesheet" type="text/css" href="main.css">       
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

        <?php include $prefix.'menu.php'; ?>
        <div class="clearfix"> </div>

        <div class="page-container">
            <?php include $prefix.'sidebar.php' ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                <h3  style="text-align: center;margin-top:0px;text-align: center"><span class="bold"><?php echo $subject_name ?></span>  - <small><?php echo $f['chapter_name'] ?> &nbsp;<span class="text-uppercase" style="letter-spacing: 1.3px;font-weight:600;color:#8e9093">[<?php echo $type ?>]</span></small></h3>
                <div  class="row">
                    <?php echo $out ?>
                </div>
                </div>
            </div>


        </div>         


<div class="modal fade" id="modal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Question</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="type" value="<?php echo $_GET['type']; ?>" />
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                <input type="hidden" name="question_id" value="" />
                <?php echo $append ?>
            </div>
            <div class="modal-footer">
                <input type="submit" name="save" value="Save Changes" class="btn green" />
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
        </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <textarea name="editor" class="summernote"></textarea>
        </div>
        <div class="modal-footer">
            <span class="pull-left"><input type="checkbox" name="correct" id="correct"> Correct Answer</span>
            <button type="button" id="ok" class="btn btn-default dark">Submit</button>
        </div>
    </div>
  </div>
</div>
</body>
<script src="view.js"></script>
<script>

$(document).ready(function(){
    <?php echo $js ?>
})

$(document).on("click",".edit",function(){
    <?php echo $js_append ?>
})

</script>

</html>
