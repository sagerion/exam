<?php
$sql=mysqli_query($con,"select * from subject");
while ($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
    $subject_id=$a['subject_id'];
    $code.='
        <div class="portlet light subject-panel">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4 subject-title">
                            '.$a['subject_name'].'<span class="tag bg-dark pull-left">'.$a['class'].'</span><br/><br/>
                            <div class="btn btn-default btn-circle btn-outline dark add-question">Add Question</div>
                        </div>
                        <div class="col-md-8 chapter-list">
                        <div class="panel-group accordion">
    ';
     $list.='<optgroup label="'.$a['subject_name'].' - '.$a['class'].' Standard">';
    $sqq=mysqli_query($con,"select * from chapter where subject_id='$subject_id'");
    while ($b=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
        $chapter_id=$b['chapter_id'];
        $section='';
        $text='';$btn='';
        
        $ssq=mysqli_query($con,"select question_id,type from question where chapter_id='$chapter_id'");
        while ($c=mysqli_fetch_array($ssq,MYSQLI_ASSOC)) {
            $question_id=$c['question_id'];
            $type=$c['type'];$qt=$c['type'];
            $ss=mysqli_num_rows(mysqli_query($con,"select question_id from ".$type." where question_id='$question_id' "));
            if($type=="tf"){$type="true/false";}
            $text=$type.' : '.$ss.' ';
            $btn.='<div class="col-md-4  btn btn-success bg-white bg-font-white default btn-circle " onclick="window.open(`view.php?id='.$chapter_id.'&type='.$qt.'`)"> '.$text.' </div>';
        }

        $list.='<option value="'.$b['chapter_id'].'">'.$b['chapter_name'].'</option>';
        $code.='
            <div class="panel panel-default row">
                <div class="panel-heading col-md-12">
                    <h4 class="panel-title col-md-12">
                        <a class="accordion-toggle collapsed"> 
                            <div class="col-md-3">'.$b['chapter_name'].'</div> 
                            <div class="col-md-9 text-right" style="margin-bottom:10px">'.$btn.'</div>
                        </a>
                    </h4>
                </div>
               
            </div>
        ';
    }
    $list.='</optgroup>';
    $code.='</div></div></div></div></div>';
}


?>