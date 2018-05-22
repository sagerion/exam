<?php 
include'../../config.php';
include'../../file.php';
$prefix='../';$start=2;
session_check($start);
$id=$_SESSION['id'];
$setting=mysqli_fetch_array(mysqli_query($con,"select * from settings"),MYSQLI_ASSOC);
$v=mysqli_fetch_array(mysqli_query($con,"select class from user where user_id='$id'"),MYSQLI_ASSOC);
$class=$v['class'];

$subject_list='';
$sql=mysqli_query($con,"select * from subject where class='$class' ");
while ($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
    $subject_id=$a['subject_id'];

    $subject_list.='
                        <div class="col-md-4">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">'.$a['subject_name'].'</div>
                                </div>
                                <div class="portlet-body chapter-list" >
                                   <div class="panel-group accordion" >
                                        ';
    $sqq=mysqli_query($con,"select * from chapter where subject_id='$subject_id' ");
    while ($b=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
    $chapter_id=$b['chapter_id'];
    $link='';
    if($setting['practice_test']=='y'){
        $link='<span class="btn btn-primary btn-circle pull-right accord-action btn-xs" onclick="location.href=(`start/?id='.$b['chapter_id'].'`)">Start Test</span>';
    }
    else{
        $link='<span class="pull-right"><i class="fa fa-lock"></i></span>';
    }
     $subject_list.='
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <div class="accordion-toggle"><span class="chapter-name">'.$b['chapter_name'].'</span>
                        '.$link.'
                     </div>
                </h4>
            </div>
           
        </div>                             
    ';
    }
    $subject_list.='</div></div></div></div>';
}

mysqli_close($con);

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
      
        <?php include_global($start);include_theme($start); ?>
        <Style>
        .mt-element-ribbon:hover{box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 1px 5px 0 rgba(0,0,0,0.12), 0 3px 1px -2px rgba(0,0,0,0.2);cursor: pointer}
        </Style>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

        <?php include $prefix.'menu.php'; ?>
        <div class="clearfix"> </div>

        <div class="page-container">
            <?php include $prefix.'sidebar.php' ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="row">
                        <div class="col-md-12"><h3 class="page-title">Practice Test</h3></div>
                            <?php echo $subject_list ?>
                    </div>
                </div>
            </div>
        </div>         
    </body>
<script>
$(document).ready(function(){
    $(".page-sidebar>ul>li").eq(1).addClass('start open active');
})
</script>



</html>