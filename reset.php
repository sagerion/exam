<?php
include'config.php';
include'file.php';
$js='';

if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql=mysqli_query($con,"select * from user where md5(email)='$id' and password_reset='y' ");
    if(mysqli_num_rows($sql)==0){
        header('location:./');
    }
}

if(isset($_POST['change'])){
    $email=$_POST['email'];
    $pswd=$_POST['pswd'];$pswd=md5($pswd);
    $sq=mysqli_query($con,"select * from user where md5(email)='$email' and password_reset='y' ");
    if(mysqli_num_rows($sq)==1){
        $a=mysqli_fetch_array($sq,MYSQLI_ASSOC);
        $user_id=$a['user_id'];
        mysqli_query($con,"update user set pswd='$pswd',password_reset='n' where user_id='$user_id' ");
        $js='
            $(".message").show();
            $("form,.login-content>h1").hide();
        ';
    }
}

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>MKS Tutorials | Reset Password</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <?php include_global(0);include_login(0);include_sweetalert(0); ?>
    <style>
    .link{font-size: 14px;text-decoration: underline;color:#333;}
    .link:hover{color:#3598DC;}
    .message{font-size:20px;text-align: center;display: none}
    </style>
    </head>
    <body class="login">
        <!-- BEGIN : LOGIN PAGE 5-1 -->
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 bs-reset mt-login-5-bsfix">
                    <div class="login-bg" style="background-image:url(assets/pages/img/login/bg1.jpg)">
                        <img class="login-logo" src=" assets/pages/img/login/logo.png" /> </div>
                </div>
                <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
                    <div class="login-content">
                        <h1>Confirm New Password</h1><br/><br/>
                        <div class="message">
                            Change Password Successful.<br/><br/>
                            <a class="btn btn-default blue circle" href="./">Back to login</a>
                        </div>
                        <form action="" class="login-form" method="post">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span>Enter password. </span>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <input type="hidden" name="email" value="<?php echo $_GET['id'] ?>" />
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="New password" name="pswd" required/> </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 text-left">
                                    <input type="submit" class="btn btn-circle green" name="change" value="Change Password"/>
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
    <?php echo $js ?>
})
</script>
</html>