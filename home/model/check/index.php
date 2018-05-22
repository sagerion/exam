<?php
include'../../../config.php';
include'../../../file.php';
$prefix='../../';$start=3;
session_check($start);
$user_id=$_SESSION['id'];

include'../../../checker_question.php';
mysqli_close($con);
?>

<!DOCTYPE html>

<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
      
        <?php include_global($start);include_theme($start); ?>
		<link rel="stylesheet" href="main.css" type="text/css" />        
</head>
<body style="overflow-x:hidden">
<div id="doc">
<img src="../../../assets/pages/img/back.png" style="margin:0 auto;opacity:0.2;width:300px;z-index: -1;position: fixed;top:30vh;left:40vw">
<div class="title bg-dark font-white text-center">
    <span class="logo-line" style="color:#fff;float:left">MKS Tutorials</span>
	<span class="score">Score: <?php echo $score.' / '.$total ?></span>
</div>      
<div class="row">
<div class="col-md-10 col-xs-12 col-md-offset-1">
<?php echo $out ?>
</div>
</div>   
</div>
<div class="floating-buttons">
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
<script>

$(document).on("click","#print",function(){
	window.print();
})
</script>


</html>