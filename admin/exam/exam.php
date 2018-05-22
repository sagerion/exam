<?php
$list='';
$sql=mysqli_query($con,"select * from subject");
while ($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
    $subject_id=$a['subject_id'];
    
     $list.='<optgroup label="'.$a['subject_name'].' - '.$a['class'].'th Standard">';
    $sqq=mysqli_query($con,"select * from chapter where subject_id='$subject_id'");
    while ($b=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
        $chapter_id=$b['chapter_id'];
        $section='';
        $text='';
        
        $ssq=mysqli_query($con,"select question_id,type from question where chapter_id='$chapter_id'");
        while ($c=mysqli_fetch_array($ssq,MYSQLI_ASSOC)) {
            $question_id=$c['question_id'];
            $type=$c['type'];
            $ss=mysqli_num_rows(mysqli_query($con,"select question_id from ".$type." where question_id='$question_id' "));
            if($type=="tf"){$type="true/false";}
            $text.=$type.' : '.$ss.' | ';
        }
        $text=substr($text,0,(strlen($text)-2));
        $list.='<option value="'.$b['chapter_id'].'">'.$b['chapter_name'].' ( '.$text.') </option>';
    }
    $list.='</optgroup>';
    
}

if(isset($_POST['save'])){
    $name=$_POST['name'];
    $start=$_POST['start'];
    $end=$_POST['end'];
    $positive=$_POST['positive'];
    $negative=$_POST['negative'];
    $time_limit=$_POST['time_limit'];
    $class=$_POST['class'];
    $total=$_POST['total'];
    $level=$_POST['level'];

    mysqli_query($con,"insert into test (name,start,end,positive,negative,total_time,total,class,level) values ('$name','$start','$end','$positive','$negative','$time_limit','$total','$class','$level') ");

    $sq=mysqli_query($con,"select test_id from test order by test_id DESC limit 1");
    $a=mysqli_fetch_array($sq,MYSQLI_ASSOC);
    $test_id=$a['test_id'];
    $chapter_id=$_POST['chapter_id'];
    $type=$_POST['type'];
    $num=$_POST['num'];

    for($i=0;$i<sizeof($chapter_id);$i++){
        mysqli_query($con,"insert into test_prep (test_id,chapter_id,type,num) values ('$test_id','$chapter_id[$i]','$type[$i]','$num[$i]') ");
    }
    $_SESSION['status']="new_test";
    echo"<script>location.href=('../exam/')</script>";
}

?>

<form method="post">
<div class="add-test-panel">
<div class="title">Create Test</div>
<div class="body">
    <div class="row">
        <div class="col-md-3 form-group">
            <label class="control-label">Test Name</label>
            <input type="text" maxlength="100" name="name" class="form-control" autocomplete="off" required><br/>
            <label class="control-label">Correct Answer (Marks Per Question) </label>
            <input type="number" name="positive" class="form-control" required><br/>
            <label class="control-label">Class</label><br/>&nbsp;&nbsp;&nbsp;
            <input type="radio" name="class" value="9" checked /> 9<sup>th</sup> Standard&nbsp;&nbsp;&nbsp;
            <input type="radio" name="class" value="10"/> 10<sup>th</sup> Standard
        </div>
        <div class="col-md-3 form-group">
            <label class="control-label">Start Date</label>
            <input type="text" name="start" class="form-control" required><br/>
            <label class="control-label">Incorrect Answer (Marks Per Question)</label>
            <input type="number" name="negative" class="form-control" required><br/>
            <label class="control-label">Level/School Code</label>
            <select name="level" class="form-control" required>
                <option value="" selected disabled> -Select School -</option>
                <option value="0">All</option>
                <option value="1">Fatima High School</option>
                <option value="2">Vidya Bhavan</option>
                <option value="3">M.D.Bhatia</option>
                <option value="4">Holy Family</option>
                <option value="5">Gurukul</option>
                <option value="6">St.Anthony</option>
                <option value="7">Swami Vivekanand</option>
                <option value="8">SVDD</option>
                <option value="9">Others</option>
            </select>
            
        </div>
        <div class="col-md-3 form-group">
            <label class="control-label">End Date</label>
            <input type="text" name="end" class="form-control" required><br/>
            <label class="control-label">Total Test Time</label>
            <input type="text" name="time_limit" class="form-control" required><br/>
            <label class="control-label">Total Score</label>
            <input type="text" name="total" class="form-control" value="0" readonly required>
        </div>
        
    </div>
  
<h3 class="question-title">Questions</h3>
<div class="row">
    <div class="col-md-4"><label>Chapter</label></div>
    <div class="col-md-4"><label>Question Type</label></div>
    <div class="col-md-4"><label>No of Questions</label></div>
</div>
<div class="row" id="question-panel">
    

</div>
<br/>
<div class="btn-group btn-group-circle btn-group-solid">
    <button type="button" class="btn blue-madison add-row">Add Chapter</button>
    <button type="submit" name="save" class="btn green-meadow">Save</button>
    <button type="button" class="btn dark" id="close-panel">Close</button>
</div>

</div>
</div>
</form>
<script>
$(document).on("click",".add-row",function(){
    $("#question-panel").append(`
        <div class="row">
            <div class="col-md-4">
                <select class="select form-control" required data-show-subtext="true" name="chapter_id[]"><option></option><?php echo $list ?></select>
            </div>
            <div class="col-md-4">
                <select name="type[]" class="form-control" required>
                    <option value="" disabled selected>Select One</option>
                    <option value="mcq">MCQ</option>
                    <option value="tf">True/False</option>
                    <option value="fillup">Fillups</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" maxlength="10" name="num[]" required>
            </div>
            <div class="col-md-1">
                <a class="btn btn-circle btn-icon-only btn-outline red delete"><i class="icon-trash"></i></a>
            </div>
        </div> 
    `);
    $(".select").select2({
            allowClear: true,
            placeholder: "Select One",
            width: null
    });
     
})

</script>