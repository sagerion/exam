<?php 
$prefix='../';$start=2;
include'../../config.php';
include'../../file.php';
session_admin($start);

$js='';
if(isset($_SESSION['status'])){
    $status=$_SESSION['status'];
    if($status=="add_subject"){
        $js='toastr.success("Subject Database Updated", "Subject Added");';
    }
}


$subject_list='';
$sql=mysqli_query($con,"select * from subject");
while ($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
    $subject_id=$a['subject_id'];

    $subject_list.='
                        <div class="col-md-4">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption"><span class="tag bg-dark">'.$a['class'].'</span>'.$a['subject_name'].'</div>
                                    <div class="actions">
                                            <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                                            <a class="btn btn-circle btn-icon-only btn-default tooltips add-chapter" href="javascript:;" data-original-title="Add Chapter" title="Add Chapter"><i class="fa fa-plus"></i> </a>
                                    </div>
                                    <div class="input-group" style="margin-bottom:10px;display: none">
                                        <div class="input-icon">
                                            <i class="fa fa-lock fa-book"></i>
                                            <input name="chapter_name" class="form-control" type="text" placeholder="Chapter" autocomplete="off"> 
                                            <input type="hidden" name="subject_id" value="'.$subject_id.'" />
                                        </div>
                                        <span class="input-group-btn">
                                            <button class="btn btn-success save-chapter" type="button"><i class="fa fa-check"></i> Save </button>
                                            <button class="btn btn-default close-chapter" type="button"><i class="fa fa-close"></i> Cancel</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="portlet-body chapter-list" >
                                   <div class="panel-group accordion" >
                                        ';
    $sqq=mysqli_query($con,"select * from chapter where subject_id='$subject_id' ");
    while ($b=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
    $chapter_id=$b['chapter_id'];
    
    
     $subject_list.='
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <div class="accordion-toggle"><span class="chapter-name">'.$b['chapter_name'].'</span>
                        
                        <i class="icon-trash pull-right accord-action tooltips delete-chapter"  data-toggle="confirmation" data-singleton="true" data-attr="'.$b['chapter_id'].'"  data-title="Delete Chapter?" ></i>
                     </div>
                </h4>
            </div>
           
        </div>                             
    ';
    }
    $subject_list.='</div></div></div></div>';
}



//add Subject
if(isset($_POST['add_subject'])){
    $subject=$_POST['subject'];
    $class=$_POST['class'];
    if($subject!='' || $subject !=null){
        mysqli_query($con,"insert into subject (subject_name,class) values ('$subject','$class') ");
        $_SESSION['status']='add_subject';
        header('location:../subject');
    }
}




?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <?php include_global($start);include_theme($start);include_toastr($start);include_popoverconfirm($start); ?>
<style>

.portlet.light{padding:12px 0px 0px}
.portlet.light>.portlet-title{padding-left: 10px;padding-right: 10px;margin-bottom: 0px}
.portlet.light .portlet-body{padding-top: 0px}
.panel-group{margin-bottom:0px;}
.panel-group .panel{border-radius: 0}
.panel-group .panel+.panel{margin-top: 0px}
.no-padding{padding-left: 0px}
.accord-action{color: #9a9a9a;padding-right: 7px;line-height: 18px;}
.accord-action:hover{cursor: pointer;color:#2F353B;}
.section-chapter:hover{background: #2F353B !important;color:#E1E5EC !important;cursor: pointer}
.tag{margin-left: -10px;padding: 5px;margin-right: 10px;border-radius: 0 50% 50% 0;font-size: 14px;color: #fff;}
</style>              
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

        <?php include $prefix.'menu.php'; ?>
        <div class="clearfix"> </div>

        <div class="page-container">
            <?php include $prefix.'sidebar.php' ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                	<h1 class="page-title">Subjects  <a href="#add-subject-modal" data-toggle="modal" class="btn btn-default btn-circle pull-right"><i class="icon-plus"></i>&nbsp;Add Subject</a></h1>
                    <div class="row">
                        <?php echo $subject_list ?>
                    </div>
                </div>
            </div>
        </div> 
<div class="modal fade bs-modal-sm" id="add-subject-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content"><form method="POST" action="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="icon-notebook"></i> Add Subject</h4>
            </div>
            <div class="modal-body"> 
                <div class="form-group">
                    <input type="text" name="subject" class="form-control" placeholder="Subject" autocomplete="off" maxlength="100" required />
                </div>
                <div class="form-group">
                    <select name="class" class="form-control" required>
                        <option value="" disabled selected>-Select Class-</option>
                        <option value="9">9th Standard</option>
                        <option value="10">10th Standard </option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" name="add_subject" class="btn green" value="Save Changes">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
        </form></div>
    </div>
</div> 

<div class="modal fade bs-modal" id="add-section-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content"><form id="add-section">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="icon-notebook"></i> Add Section - <span class="chapter-name"></span></h4>
            </div>
            <div class="modal-body"> 
                <div class="form-group">
                    <input type="text" name="section" class="form-control" placeholder="Section Name" autocomplete="off" maxlength="100" required />
                    <input type="hidden" name="chapter_id" />
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" name="add_section" class="btn green" value="Save Changes">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
        </form></div>
    </div>
</div> 

<div class="modal fade bs-modal" id="delete-section-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="icon-notebook"></i> Delete Section -  <span class="section-name"></span></h4>
            </div>
            <div class="modal-body"> 
                <input type="hidden" name="section_id" />
                <input type="submit" name="delete_section" class="btn green" value="Confirm">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
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