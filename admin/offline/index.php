<?php 
include'../../config.php';
include'../../file.php';
$prefix='../';$start=2;
session_admin($start);
$js='';
if(isset($_SESSION['status'])){
    $status=$_SESSION['status'];
    if($status=="offline_add"){
        $js='toastr.success("Offline Test Database Updated", "Offline Test Added.");';
    }
    if($status=="delete_offline"){
        $js='toastr.success("Offline Test Database Updated", "Delete Offline Test.");'; 
    }
    unset($_SESSION['status']);
}

if(isset($_GET['id'])){
    $id=$_GET['id'];
    mysqli_query($con,"delete from offline_score  where test_id='$id'");
    mysqli_query($con,"delete from offline where test_id='$id'");
    $_SESSION['status']="delete_offline";
    header('location:./');
}

$out='';
$sql=mysqli_query($con,"select * from offline order by date DESC ");
while ($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
    $text='green-sharp';
    $out.='
     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 test" data-attr="'.$a['test_id'].'" style="border-bottom:1px solid #eee;padding-bottom:40px">
                <div class="display">
                    <div class="number">
                        <h3 class="font-'.$text.'">
                            <span class="tag bg-'.$text.'">'.$a['class'].'<sup>th</sup> </span>
                            <span style="text-transform:capitalize">'.$a['test_name'].'</span>
                        </h3>
                        <small style="font-size:12px;padding-left:20px">'.date("d/m/Y",strtotime($a['date'])).'</small>
                    </div>
                </div>
                <div class="col-md-12" style="margin-bottom:10px">
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default btn-success" onclick="location.href=(`list.php?id='.$a['test_id'].'`)"><i class="icon-eye" ></i> View</button>
			<button type="button" class="btn btn-default btn-primary" onclick="location.href=(`edit.php?id='.$a['test_id'].'`)"><i class="icon-note" ></i> Edit</button>
                        <button type="button" class="btn btn-default dark" onclick="location.href=(`./?id='.$a['test_id'].'`)"><i class="icon-trash"></i> Delete</button>
                    </div>    
                </div>
            </div>
        </div>
    ';
}

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
      
        <?php include_global($start);include_theme($start);include_countup($start);include_toastr($start) ?>
        <Style>
         .mt-element-ribbon:hover{box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 1px 5px 0 rgba(0,0,0,0.12), 0 3px 1px -2px rgba(0,0,0,0.2);cursor: pointer}
         .tag{margin-left: -20px;color:#fff;font-size: 14px;padding:5px;padding-top: 7px;padding-bottom: 7px;border-radius: 0 50% 50% 0}
         .test{-webkit-transition:0.3s;-moz-transition:0.3s;transition:0.3s;}
         .test:hover{cursor: pointer;box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 1px 5px 0 rgba(0,0,0,0.12), 0 3px 1px -2px rgba(0,0,0,0.2)}
        </Style>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

        <?php include $prefix.'menu.php'; ?>
        <div class="clearfix"> </div>

        <div class="page-container">
            <?php include $prefix.'sidebar.php' ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <h1 class="page-title">Offline Test 
                    <a class="btn btn-default btn-circle pull-right" data-toggle="modal" href="#class" style="margin-left:10px"><i class="icon-pie-chart"></i>&nbsp;Overall Report</a>
                     <a class="btn btn-default btn-circle pull-right create-test" data-toggle="modal" href="#small"><i class="icon-plus"></i>&nbsp;Add Test</a></h1>
                    <Div class="row">
                        <?php echo $out ?>
                    </Div>
                </div>   
            </div>
        </div>         
    


<div class="modal fade bs-modal-sm" id="small" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <form method="GET" action="offline.php">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Offline Test</h4>
            </div>
            <div class="modal-body">
                <input type="radio" name="class" value="10" /> 10<sup>th</sup> Standard<br/>
                <input type="radio" name="class" value="9" /> 9<sup>th</sup> Standard<br/>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn green">Save changes</button>
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
        </form>
        </div>
    </div>                                           
</div>
<div class="modal fade bs-modal-sm" id="class" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <form method="GET" action="overall.php">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title">Overall Online Test Report</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="radio" name="class" value="10"> 10<sup>th</sup> Standard<br/>
                                                        <input type="radio" name="class" value="9"> 9<sup>th</sup> Standard
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" class="btn btn-success" value="Check" />
                                                    </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>

</body>



<script>
toastr.options = {
  "closeButton": true,
  "debug": false,
  "positionClass": "toast-bottom-right",
  "onclick": null,
  "showDuration": "1000",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};
$(document).ready(function(){
    $(".page-sidebar>ul>li").eq(5).addClass('start open active');
    <?php echo $js ?>
})
</script>

</html>
