<?php
include'config.php';
include'file.php';
$js='';

if(isset($_POST['reset'])){
    $email=$_POST['email'];

    $sql=mysqli_query($con,"select * from user where email='$email' ");
    if(mysqli_num_rows($sql)==1){
    	$a=mysqli_fetch_array($sql,MYSQLI_ASSOC);
        $code=md5($email);
		date_default_timezone_set('Asia/Kolkata');

		require_once('./mail/class.phpmailer.php');
		//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
		
		$mail             = new PHPMailer();
		$postdata = http_build_query(
		    array(
		        'code' => $code,
		        'name' => $a['name']
		    )
		);
		
		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/x-www-form-urlencoded',
		        'content' => $postdata
		    )
		);

		$context  = stream_context_create($opts);
		$body             = file_get_contents('http://mkstutorials.com/login/mail/forgot.php', false, $context);
		//$body             = preg_replace("[\]",'',$body);
		
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = "mail.mkstutorials.com"; // SMTP server
		//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
		                                           // 1 = errors and messages
		                                           // 2 = messages only
		$mail->SMTPSecure = "ssl";
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Host       = "mail.mkstutorials.com"; // sets the SMTP server
		$mail->Port       = 465;                    // set the SMTP port for the GMAIL server
		$mail->Username   = "info@mkstutorials.com"; // SMTP account username
		$mail->Password   = "mks@2583";        // SMTP account password
		
		$mail->SetFrom('info@mkstutorials.com', 'MKS Tutorails');
		
		$mail->AddReplyTo("info@mkstutorials.com","MKS Tutorails");
		
		$mail->Subject    = "Reset Password Request.";
		
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		
		$mail->MsgHTML($body);
		
		$address = $a['email'];
		$mail->AddAddress($address, $a['name']);
		
		//$mail->AddAttachment("images/phpmailer.gif");      // attachment
		//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
		$mail->Send();
		
        //$header = "From:info@mkstutorials.com \r\n";
        //$header .= "MIME-Version: 1.0\r\n";
        //$header .= "Content-type: text/html\r\n";
        //$msg = "Someone requested a new password for your MKS Tutorials site.\r\n login at <a href='http://mkstutorials.com/reset.php?id=".$code."' target='_blank'>Reset Password</a>.\r\n\r\n If you did not  request a new password the ignore this email.";
        //$to=$email;$subject="Reset Password Request.";
        //mail($to,$subject,$msg,$header);
        mysqli_query($con,"update user set password_reset='y' where email='$email' ");
        $js='
            $(".message").show();
            $("form").hide();
        ';
    }
}
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>MKS Tutorials | Forgot Password</title>
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
                        <h1>Forgot Password</h1><br/><br/>
                        <div class="message">
                            Email Sent.<br/><br/>
                            <a class="btn btn-default blue circle" href="./">Back to login</a>
                        </div>
                        <form action="" class="login-form" method="post">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span>Enter registered email address. </span>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Email" name="email" required/> </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 text-left">
                                    <input type="submit" class="btn btn-circle green" name="reset" value="Reset Password"/>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <a href="./" class="btn btn-default circle dark" >Back to Login</a>
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