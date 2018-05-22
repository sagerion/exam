<?php
$practice_test='';$var='';$btn_text='';
$sqq=mysqli_query($con,"select * from settings ");
while ($v=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
    $practice_test=$v['practice_test'];
    if($practice_test=='y'){$practice_test='blue';$var='n';$btn_text='Active';}
    if($practice_test=='n'){$practice_test='red';$var='y';$btn_text='Inactive';}
}

if(isset($_POST['practice_test'])){
    $practice_test=$_POST['practice_test'];
    mysqli_query($con,"update settings set practice_test='$practice_test' ");
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    echo "<script>location.href=('".$actual_link."')</script>";
}

?>

<div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner ">
                <div class="page-logo">
                    <a href="index.html">
                        <img src="<?php echo $prefix ?>../assets/layouts/layout2/img/logo-default.png" alt="logo" class="logo-default" /> </a>
                    <div class="menu-toggler sidebar-toggler">
                    </div>
                </div>
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <div class="page-actions">
                    <form method="post">
                        <button name="practice_test" value="<?php echo $var ?>" class="btn btn-circle btn-outline <?php echo $practice_test ?>">
                            <i class="fa fa-circle"></i>&nbsp;
                            <span class="hidden-sm hidden-xs">Practice Test : <?php echo $btn_text ?></span>&nbsp;
                        </button>
                    </form>
                </div>
                <!-- END PAGE ACTIONS -->
                <!-- BEGIN PAGE TOP -->
                <div class="page-top">
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                   <i class="icon-user-follow" style="font-size:20px"></i>
                                    <span class="username username-hide-on-mobile">Admin </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                 
                                    <li>
                                        <a href="<?php echo $prefix ?>logout.php">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END PAGE TOP -->
            </div>
            <!-- END HEADER INNER -->
        </div>