<?php
include'../../../config.php';
include'../../../file.php';
$prefix='../../';$start=3;


//include'../../../checker_question.php';
$s='';
if(isset($_POST['test_id'])){
	$_SESSION['posted']='y';
    $test_id=$_POST['test_id'];
	$user_id=$_POST['user_id'];
    $score=$_POST['score'];
	$total=$_POST['total'];
	$a=mysqli_fetch_array(mysqli_query($con,"select name,email from user where user_id='$user_id'"),MYSQLI_ASSOC);
    $s=mysqli_fetch_array(mysqli_query($con,"select name from test where test_id='$test_id'"),MYSQLI_ASSOC);
    $xyz=mysqli_fetch_array(mysqli_query($con,"select score,mail from test_score where test_id='$test_id' and user_id='$user_id' "),MYSQLI_ASSOC);
    $last_score=$xyz['score'];
    if($last_score<$score){
    mysqli_query($con,"update test_score set score='$score' where test_id='$test_id' and user_id='$user_id' ");
	$mail=$xyz['mail'];
	if($mail=='n'){
		$test_name=$s['name'];
		$user_name=$a['name'];
		//$body=file_get_contents('http://mkstutorials.com/login/mail/score.html');
		//$body=eregi_replace("[\]",'',$body);
		//$body=str_replace('%name%',$user_name,$body);
		//$body=str_replace('%test_name%',$test_name,$body);
		//$body=str_replace('%score%',$score,$body);
		//$body=str_replace('%total_marks%',$total,$body);
		date_default_timezone_set('Asia/Kolkata');

		require_once('../../../mail/class.phpmailer.php');
		//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
		
		$mail = new PHPMailer();
		
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = "mail.mkstutorials.com"; // SMTP server
		//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
		                                           // 1 = errors and messages
		//$mail->SMTPSecure = "ssl";                                           // 2 = messages only
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Host       = "mail.mkstutorials.com"; // sets the SMTP server
		$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
		$mail->Username   = "info@mkstutorials.com"; // SMTP account username
		$mail->Password   = "mks@2583";        // SMTP account password
		
		$mail->SetFrom('info@mkstutorials.com','MKS Tutorials');
		
		$mail->AddReplyTo("info@mkstutorials.com",'MKS Tutorials');
		
		$mail->Subject="Test Score.";
		
		$mail->AltBody="To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		
		$mail->isHTML(true);  
		$mail->Body='<p style="color:#333">Dear '.$user_name.',<br>Your Test Score for '.$test_name.' - '.$score.' / '.$total.'.<br><br><a href="http://mkstutorials.com/login" style="text-decoration:none;padding:10px;background:#2196F3;color:#fff;font-size:14px;margin:10px;border-radius:5px">Visit MKSTutorials</a><br><br><br>Regards,<br>MKS Tutorials.</p>';
		//$mail->Body='<p style="color:#333">Dear '.$user_name.',<br>Someone requested a new password for your MKS Tutorials site. If you did not request a new password the ignore this email.<br><br><a href="http://mkstutorials.com/login/reset.php?id='.$code.'" style="padding:10px;background:#2196F3;color:#fff;font-size:14px;margin:10px;border-radius:5px">Reset Password</a><br><br><br>Regards,<br>MKS Tutorials.</p>';
		
		//$mail->MsgHTML($body);
		
		$address = $a['email'];
		//$address='max.james2583@gmail.com';
		$mail->AddAddress($address, $a['name']);
		
		$mail->Send();
		mysqli_query($con,"update test_score set mail='y' where test_id='$test_id' and user_id='$user_id' ");
}}
}
mysqli_close($con);
?>

