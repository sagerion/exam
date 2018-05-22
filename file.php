<?php
date_default_timezone_set('Asia/Kolkata');
function include_global($order){
	$pre='';
	for($i=0;$i<$order;$i++){$pre.='../';}
	echo '
	<link href="'.$pre.'assets/style/font.css" rel="stylesheet" type="text/css" />
    <link href="'.$pre.'assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="'.$pre.'assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="'.$pre.'assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="'.$pre.'assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <link href="'.$pre.'assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="'.$pre.'assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />

    <script src="'.$pre.'assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="'.$pre.'assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="'.$pre.'assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="'.$pre.'assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="'.$pre.'assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="'.$pre.'assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script src="'.$pre.'assets/global/scripts/app.min.js" type="text/javascript"></script>
	';
}
function include_theme($order){
    $pre='';
    for($i=0;$i<$order;$i++){$pre.='../';}
    echo '
        <link href="'.$pre.'assets/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="'.$pre.'assets/layouts/layout2/css/themes/blue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="'.$pre.'assets/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css" />
        <script src="'.$pre.'assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
        <script src="'.$pre.'assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="'.$pre.'assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
    ';
}




function include_login($order){	
	$pre='';
	for($i=0;$i<$order;$i++){$pre.='../';}	
	
	echo'
		<link href="'.$pre.'assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
		<script src="'.$pre.'assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="'.$pre.'assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="'.$pre.'assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="'.$pre.'assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
		<script src="'.$pre.'assets/pages/scripts/login-5.min.js" type="text/javascript"></script>
	';
}

function include_toastr($order){
    $pre='';
    for($i=0;$i<$order;$i++){$pre.='../';}
    echo'
        <link href="'.$pre.'assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css">
        <script src="'.$pre.'assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    ';
}
function include_popoverconfirm($order){
    $pre='';
    for($i=0;$i<$order;$i++){$pre.='../';}
    echo'
       <script src="'.$pre.'assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script> 
    ';
}

function include_select2($order){
    $pre='';
    for($i=0;$i<$order;$i++){$pre.='../';}
    echo '
        <link href="'.$pre.'assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="'.$pre.'assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <script src="'.$pre.'assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    ';
}


function include_summernote($order){
    $pre='';
    for($i=0;$i<$order;$i++){$pre.='../';}
    echo '
        <link href="'.$pre.'assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
        <script src="'.$pre.'assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
    ';
}
function include_datepicker($order){
    $pre='';
    for($i=0;$i<$order;$i++){$pre.='../';}
    echo '
        <link href="'.$pre.'assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="'.$pre.'assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <script src="'.$pre.'assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="'.$pre.'assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    ';
}

function include_sweetalert($order){
    $pre='';
    for($i=0;$i<$order;$i++){$pre.='../';}
    echo '
        <link href="'.$pre.'assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
         <script src="'.$pre.'assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
    ';
}

function include_blockui($order){
    $pre='';
    for($i=0;$i<$order;$i++){$pre.='../';}
    echo '
         <script src="'.$pre.'assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    ';
}


function include_datatable_base($order){
    $pre='';
    for($i=0;$i<$order;$i++){$pre.='../';}
    echo '
        <link href="'.$pre.'assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="'.$pre.'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
         <script src="'.$pre.'assets/global/scripts/datatable.js" type="text/javascript"></script>
         <script src="'.$pre.'assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
         <script src="'.$pre.'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
         <script src="'.$pre.'assets/global/plugins/moment.min.js" type="text/javascript"></script>
         <script src="'.$pre.'assets/global/plugins/datatables/plugins/bootstrap/datetime-moment.js" type="text/javascript"></script>
    ';
}

function include_countdown($order){
   $pre='';
   for($i=0;$i<$order;$i++){$pre.='../';} 
    echo '
         <script src="'.$pre.'assets/global/plugins/countdown/jquery.countdown.js" type="text/javascript"></script>
    ';
}

function include_countup($order){
   $pre='';
   for($i=0;$i<$order;$i++){$pre.='../';} 
    echo '
        <script src="'.$pre.'assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
         <script src="'.$pre.'assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
    ';

}


function include_echarts($order){
   $pre='';
   for($i=0;$i<$order;$i++){$pre.='../';} 
    echo '
        <script src="'.$pre.'assets/global/plugins/echarts/echarts-all.js" type="text/javascript"></script>
    ';

}

$base_url='http://localhost/exam/';
function session_check($order){
	error_reporting(0);
    $base_url='http://localhost/exam/';
    $pre='';
    for($i=0;$i<$order;$i++){$pre.='../';}
    include $pre.'config.php';
    session_start();
    if((isset($_SESSION['email'])) && (isset($_SESSION['id']))){
    $email=$_SESSION['email'];
    $user_id=$_SESSION['id'];
    $sql=mysqli_query($con,"select user_id from user where email='$email' and user_id='$user_id' and status='y'");
    $count=mysqli_num_rows($sql);
    if($count==0){
        session_unset();
        session_destroy();
        echo "<script>location.href=('".$base_url."')</script>";
    }}
    else{
        session_unset();
        session_destroy();
        echo "<script>location.href=('".$base_url."')</script>";
    }

}


function session_admin($order){
    $base_url='http://localhost/exam/';
    $pre='';
    for($i=0;$i<$order;$i++){$pre.='../';}
    include $pre.'config.php';
    session_start();
    if((isset($_SESSION['user'])) && (isset($_SESSION['pswd']))){
    $user=$_SESSION['user'];
    $pswd=$_SESSION['pswd'];
    if($user=="admin" && $pswd=="admin"){}
    else{
        session_unset();
        session_destroy();
        echo "<script>location.href=('".$base_url."')</script>";
    }}
    else{
        session_unset();
        session_destroy();
        echo "<script>location.href=('".$base_url."')</script>";
    }

}

function session_demo($order){
    $base_url='http://localhost/exam/';
    $pre='';
    for($i=0;$i<$order;$i++){$pre.='../';}
    include $pre.'config.php';
    session_start();
    if((isset($_SESSION['email'])) && (isset($_SESSION['id']))){
    $email=$_SESSION['email'];
    $user_id=$_SESSION['id'];
    $sql=mysqli_query($con,"select user_id from user where email='$email' and user_id='$user_id' and status='dy'");
    $count=mysqli_num_rows($sql);
    if($count==0){
        session_unset();
        session_destroy();
        echo "<script>location.href=('".$base_url."')</script>";
    }}
    else{
        session_unset();
        session_destroy();
        echo "<script>location.href=('".$base_url."')</script>";
    }

}













?>