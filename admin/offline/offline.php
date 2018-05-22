<?php 
include'../../config.php';
include'../../file.php';
$prefix='../';$start=2;
session_admin($start);
$list='';
if(isset($_GET['class'])){
    $class=$_GET['class'];
    $sql=mysqli_query($con,"select * from user where class='$class' and status='y' ");
    while ($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
        $list.='
            <tr>
                <td class="text-center">'.$a['name'].'</td>
                <td>
                    <input type="hidden" name="user[]" value="'.$a['user_id'].'" />
                    <input type="text" name="score[]" class="form-control" required />
                </td>
            </tr>
        ';
    }
}


if(isset($_POST['save'])){
    $test_name=$_POST['test_name'];
    $date=$_POST['date'];
    $outoff=$_POST['outoff'];
    $class=$_GET['class'];
    mysqli_query($con,"insert into offline (test_name,class,date,outoff) values ('$test_name','$class','$date','$outoff') ");
    $s=mysqli_fetch_array(mysqli_query($con,"select test_id from offline  order by test_id DESC limit 1"),MYSQLI_ASSOC);
    $test_id=$s['test_id'];
    $user=$_POST['user'];
    $score=$_POST['score'];
    for($i=0;$i<sizeof($user);$i++){
        mysqli_query($con,"insert into offline_score (test_id,user_id,score) values ('$test_id','$user[$i]','$score[$i]') ");
    }
    $_SESSION['status']="offline_add";
    header('location:./');
}


?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
      
        <?php include_global($start);include_theme($start);include_countup($start);include_datepicker($start);include_datatable_base($start); ?>
        <Style>
         .mt-element-ribbon:hover{box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 1px 5px 0 rgba(0,0,0,0.12), 0 3px 1px -2px rgba(0,0,0,0.2);cursor: pointer}
        </Style>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid" style="overflow-x: hidden;">

        <?php include $prefix.'menu.php'; ?>
        <div class="clearfix"> </div>

        <div class="page-container">
            <?php include $prefix.'sidebar.php' ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption"><span class="caption-subject bold uppercase"> Add Offline Test</span></div>
                            <div class="actions bold"><?php echo $_GET['class'] ?><sup>th</sup> Standard</div>
                        </div>
                        <form method="post">
                        <div class="portlet-body">
                            <div class="row">
                                <div class="form-group  col-md-3">
                                    <label>Test Name</label>
                                    <input type="text" name="test_name" class="form-control" required/>
                                </div>
                                <div class="form-group  col-md-3">
                                    <label>Date</label>
                                    <input type="text" name="date" class="form-control datepicker" required />
                                </div>
                                <div class="form-group  col-md-3">
                                    <label>Outoff</label>
                                    <input type="text" name="outoff" class="form-control" required/>
                                </div>
                                <hr class="col-md-12" />
                                <div class="col-md-12">
                                    <table class="table" id="datatable">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Name</th>
                                                <th>Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $list ?>
                                        </tbody>
                                    </table>
                                </div>
                                <hr class="col-md-12" />
                                <div class="col-md-12">
                                    <input type="submit" name="save" class="btn btn-success" value="Save"  />
                                </div>
                            </div>
                        </div>
                      </form>
                    </div>
                </div>   
            </div>
        </div>         

</body>



<script>
$(document).ready(function(){
    $(".datepicker").datetimepicker({autoclose:true,format: 'yyyy-mm-dd'});
    $(".page-sidebar>ul>li").eq(5).addClass('start open active');
        $("#datatable").dataTable({
            aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
    iDisplayLength: -1,
           });
})
</script>

</html>