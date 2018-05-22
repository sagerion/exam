<?php 
include'../../../config.php';
include'../../../file.php';
$prefix='../../';$start=3;
session_admin($start);
$js='';
$a='';
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql=mysqli_query($con,"select * from test where test_id='$id' ");
    $a=mysqli_fetch_array($sql,MYSQLI_ASSOC);
}

if(isset($_POST['update'])){
    $test_id=$_POST['test_id'];
    $start=$_POST['start'];
    $end=$_POST['end'];
    mysqli_query($con,"update test set start='$start',end='$end' where test_id='$test_id' ");
    header('location:../');
}

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
      
    <?php include_global($start);include_theme($start);include_datepicker($start);include_select2($start);include_toastr($start);include_blockui($start);include_countdown($start); ?>
    <link rel="stylesheet" type="text/css" href="main.css" />
<style>
.portlet-body .test{-webkit-transition:0.3s;-moz-transition:0.3s;transition:0.3s;}
.portlet-body .test:hover{background:#eee;cursor: pointer}
.tag{margin-left: -20px;color:#fff;font-size: 14px;padding:5px;padding-top: 7px;padding-bottom: 7px;border-radius: 0 50% 50% 0}
.info-window{position: fixed;z-index: 9997;width:40vw;height:100%;top:0;left:0;background:#fff;box-shadow: 0 3px 9px rgba(0,0,0,.5);border-radius: 0;-webkit-transition:0.3s;-moz-transition:0.3s;transition:0.3s;-webkit-transform:translateX(-100%);-moz-transform:translateX(-100%);transform:translateX(-100%);}


.overlay{background:rgba(47,53,59,0.5);position: fixed;top:0;left:0;z-index: 9996;width:100%;height:100%;display:none;}
</style>       
</head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

    <?php include $prefix.'menu.php'; ?>
    <div class="clearfix"> </div>

    <div class="page-container">
        <?php include $prefix.'sidebar.php' ?>
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <form method="post">
                        <h2 class="title">Extend Date</h2>
                        <h3>Test Name: <span class="bold"><?php echo $a['name'] ?></span></h3>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label class="control-label">Start Date</label>
                                    <input type="hidden" name="test_id" value="<?php echo $a['test_id'] ?>" />
                                    <input type="text" name="start" class="form-control" value="<?php echo $a['start'] ?>" required>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="control-label">End Date</label>
                                    <input type="text" name="end" class="form-control" value="<?php echo $a['end'] ?>" required>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary" name="update" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
$(document).ready(function(){
    $("input[name=start],input[name=end]").datetimepicker({autoclose:true});
    
    <?php echo $js ?>
   

})



</script>
</body>




</html>