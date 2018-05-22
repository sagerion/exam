<?php
include'../../config.php';
include'../../file.php';
$start=2;
session_admin($start);
if(isset($_POST['data'])){
	$data=$_POST['data'];
	$type=$_POST['type'];

	 $header = "From:info@mkstutorials.com \r\n";
     $header .= "MIME-Version: 1.0\r\n";
     $header .= "Content-type: text/html\r\n";
	if($type=="accept"){
		mysqli_query($con,"update user set status='y' where user_id='$data' ");
		$s=mysqli_fetch_array(mysqli_query($con,"select * from user where user_id='$data' "),MYSQLI_ASSOC);
		date_default_timezone_set('Asia/Kolkata');

		require_once('../../mail/class.phpmailer.php');
		//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
		
		$mail             = new PHPMailer();
		$postdata = http_build_query(
		    array(
		        'name' => $s['name']
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
		$body             = file_get_contents('http://mkstutorials.com/login/mail/activate.php', false, $context);
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
		
		$mail->Subject    = "Account Activation Complete.";
		
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		
		$mail->MsgHTML($body);
		
		$address = $s['email'];
		$mail->AddAddress($address, $s['name']);
		
		//$mail->AddAttachment("images/phpmailer.gif");      // attachment
		//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
		$mail->Send();
		
		//$msg = "Your Account has been successfully activated.\r\n Visit <a href='http://mkstutorials.com/login/' target='_blank'>mkstutorials.com</a> to login.";
		//$to=$s['email'];$subject="Account Setup Complete.";
		//mail($to,$subject,$msg,$header);
	}
	if($type=="accept_demo"){
		mysqli_query($con,"update user set status='dy' where user_id='$data' ");	
	}
	if($type=="promote_demo"){
		mysqli_query($con,"update user set status='y' where user_id='$data' ");
	}
	if($type=="decline"){
		mysqli_query($con,"delete from user where user_id='$data' ");
		mysqli_query($con,"delete from offline_score where user_id='$data' ");
		mysqli_query($con,"delete from test_score where user_id='$data' ");
	}
	if($type=="ban"){
		mysqli_query($con,"update user set status='b' where user_id='$data' ");
	}
	if($type=="reset"){
		$pswd="123456";
		$pswd=md5($pswd);
		mysqli_query($con,"update user set pswd='$pswd' where user_id='$data' ");
	}
	if($type=="fees"){
		$sql=mysqli_query($con,"select * from user where user_id='$data'");
		$s=mysqli_fetch_array($sql,MYSQLI_ASSOC);$out='';
		$sq=mysqli_query($con,"select * from fees where user_id='$data'");
		while ($a=mysqli_fetch_array($sq,MYSQLI_ASSOC)) {
			$out.='
				<tr>
					<td>'.date("d/m/Y",strtotime($a['date'])).'</td>
					<td>'.$a['amt'].'</td>
					<td><a href="./?action=delete&id='.$a['fees_id'].'">Delete</a></td>
				</tr>
			';
		}
		$d=array("total"=>$s['amount'],"paid"=>$s['paid'],"trans"=>$out,"name"=>$s['name'],"class"=>$s['class'],"level"=>$s['level']);
		echo json_encode($d);
	}	
}

?>