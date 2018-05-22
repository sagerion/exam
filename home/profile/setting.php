<?php 
include'../../config.php';
include'../../file.php';
$prefix='../';$start=2;
session_check($start);
$user_id=$_SESSION['id'];
$out='';$js='';

$sql=(mysqli_query($con,"select test_id,score,date from test_score where user_id='$user_id' "));
$test=mysqli_num_rows($sql);
$f=mysqli_fetch_array(mysqli_query($con,"select * from user where user_id='$user_id' "));

if(isset($_POST['update'])){
    $old=$_POST['old'];
    $new=$_POST['new'];
    $old=md5($old);
	$new=md5($new);

    $sql=mysqli_query($con,"select user_id from user where user_id='$user_id' and pswd='$old' ");
    $count=mysqli_num_rows($sql);
    if($count==1){
    	$a=mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$user_id=$a['user_id'];
    	mysqli_query($con,"update user set pswd='$new' where user_id='$user_id'");
        $js='toastr.success("Password Changed Successfully.","Password Changed!")';
    }
    else{
        $js='toastr.error("Password incorrect for username.","Invalid Password!")';
    }
}


mysqli_close($con);
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
      
        <?php include_global($start);include_theme($start);include_countup($start);include_toastr($start); ?>
        <link href="../../assets/pages/css/profile.min.css" rel="stylesheet" type="text/css">
    <style>
        .profile-userpic{font-size: 100px;text-align: center}
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
                            <div class="profile-sidebar">
                                <!-- PORTLET MAIN -->
                                <div class="portlet light profile-sidebar-portlet ">
                                    <!-- SIDEBAR USERPIC -->
                                    <div class="profile-userpic">
                                        <i class="icon-user"></i> 
                                    </div>
                                    <!-- END SIDEBAR USERPIC -->
                                    <!-- SIDEBAR USER TITLE -->
                                    <div class="profile-usertitle">
                                        <div class="profile-usertitle-name text-capitalize"><?php echo $f['name'] ?> </div>
                                        <div class="profile-usertitle-job"> <?php echo $f['class'] ?><sup>th</sup> Standard </div>
                                    </div>
                                    <div class="profile-usermenu">
                                        <ul class="nav">
                                            <li>
                                                <a href="index.php">
                                                    <i class="icon-home"></i> Overview </a>
                                            </li>
                                            <li class="active">
                                                <a href="#!">
                                                    <i class="icon-settings"></i> Account Settings </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- END MENU -->
                                </div>
                                <!-- END PORTLET MAIN -->
                                <!-- PORTLET MAIN -->
                                <div class="row">
                                    <div class="col-md-12">
                                    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                                        <div class="visual">
                                            <i class="fa fa-bar-chart-o"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="<?php echo $test ?>"><?php echo $test ?></span></div>
                                            <div class="desc"> Test Taken </div>
                                        </div>
                                    </a>
                                    </div>
                                </div>
                                <!-- END PORTLET MAIN -->
                            </div>

                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">Change Password</div>
                                            </div>
                                            <div class="portlet-body row">
                                                <form method="post" >
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Old Password</label>
                                                        <input type="password" name="old" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">New Password</label>
                                                        <input type="password" name="new" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="submit" name="update" class="btn btn-success" value="Update">
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    $(".page-sidebar>ul>li").eq(3).addClass('start open active');
    <?php echo $js ?>
})
</script>



</html>