<?php

if(isset($_GET['id'])){
	$chapter_id=$_GET['id'];
	$s=mysqli_fetch_array(mysqli_query($con,"select * from chapter where chapter_id='$chapter_id'"),MYSQLI_ASSOC);
	$total=10;
	$time=10;
	$num=rand(1,5);$total=$total-$num;
	$f=mysqli_fetch_array(mysqli_query($con,"select question_id from question where chapter_id='$chapter_id' and type='mcq' "));
	$question_id=$f['question_id'];
	$sqq=mysqli_query($con,"select * from mcq where question_id='$question_id' ORDER BY RAND() LIMIT ".$num." ");
	while ($b=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
		$check_question.="answer[".$noi."]='".$b['answer']."';";
		$noi++;
		$out.='
			<div class="row question portlet light">
			            <div class="col-md-12 question-text" data-attr="q"><span class="pull-left bold">Q'.$noi.'</span>'.$b['question'].'</div>
			            <div class="col-md-12 text-center option-row ">
			                <div class="col-md-3 question-option" data-attr="a">'.$b['a'].'</div>
			                <div class="col-md-3 question-option" data-attr="b">'.$b['b'].'</div>
			            </div>
			            <div class="col-md-12 text-center option-row ">
			                <div class="col-md-3 question-option" data-attr="c">'.$b['c'].'</div>
			                <div class="col-md-3 question-option" data-attr="d">'.$b['d'].'</div> 
			            </div>
			             	<input type="hidden" name="id[]" value="'.$b['mcq_id'].'" />
			             	<input type="hidden" name="type[]" value="mcq" />
			                <input type="hidden" name="answer[]" />
			</div>
			';
			
	}
	$num=rand(1,5);$total=$total-$num;
	$f=mysqli_fetch_array(mysqli_query($con,"select question_id from question where chapter_id='$chapter_id' and type='tf' "));
	$question_id=$f['question_id'];
	$sqq=mysqli_query($con,"select * from tf where question_id='$question_id' ORDER BY RAND() LIMIT ".$num." ");
	while ($b=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
			$check_question.="answer[".$noi."]='".$b['answer']."';";
			$noi++;
			$out.='
					<div class="row question portlet light">
			            <div class="col-md-12 question-text" data-attr="q"><span class="pull-left bold">Q'.$noi.'</span>'.$b['question'].'</div>
			            <div class="col-md-12 text-center option-row ">
			                <div class="col-md-3 question-option" data-attr="t">True</div>
			                <div class="col-md-3 question-option" data-attr="f">False</div>
			            </div>
			             	<input type="hidden" name="id[]" value="'.$b['tf_id'].'" />
			             	<input type="hidden" name="type[]" value="tf" />
			                <input type="hidden" name="answer[]" />
			        </div>
			';
	}
	$num=$total;
	$f=mysqli_fetch_array(mysqli_query($con,"select question_id from question where chapter_id='$chapter_id' and type='fillup' "));
	$question_id=$f['question_id'];
	$sqq=mysqli_query($con,"select * from fillup where question_id='$question_id' and qorder='n' ORDER BY RAND() LIMIT ".$num." ");
	while ($b=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
				$check_question.="answer[".$noi."]='".$b['answer']."';";
				$check_question.="question[".$noi."]='".$b['question']."';";
				$noi++;
				$question=$b['question'];

				$question=preg_replace("/<u+\>(.*?)<\/u>/i"," <u></u> ", $question); 
				$out.='
						<div class="row question portlet light">
				            <div class="col-md-12 question-text" data-attr="q"><span class="pull-left bold">Q'.$noi.'</span>'.$question.'</div>
				             	<input type="hidden" name="id[]" value="'.$b['fillup_id'].'" />
				             	<input type="hidden" name="type[]" value="fillup" />
				                <input type="hidden" name="answer[]" />
				        </div>
				';
			}
		

	

	
}


?>