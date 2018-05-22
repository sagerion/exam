<?php


 $out='';$total=0;$score=0;$xyz='';$s='';
if(isset($_POST['check'])){
    $id=$_POST['id'];
    $type=$_POST['type'];
    $answer=$_POST['answer'];
    for($i=0;$i<sizeof($answer);$i++){
        $question_id=$id[$i];
        $ans=$answer[$i];
        $tp=$type[$i];
        if($tp=="mcq"){
            $sql=mysqli_query($con,"select * from mcq where mcq_id='$question_id' ");
            $a=mysqli_fetch_array($sql,MYSQLI_ASSOC);
            $correct=$a['answer'];
            $status='';$oa='';$ob='';$oc='';$od='';$css_style='';
            if($correct==$ans){$score++;$total++;
                $status="icon-check font-green-turquoise pull-left";$css_style='border-bottom:4px solid #36D7B7';
                if($ans=="a"){$oa="right-answer";}if($ans=="b"){$ob="right-answer";}if($ans=="c"){$oc="right-answer";}if($ans=="d"){$od="right-answer";}
            }
            else{
                $total++;$right_answer='';
                $status="icon-close font-red pull-left";$css_style='border-bottom:4px solid #E7505A';
                if($ans=="a"){$oa="incorrect";}if($ans=="b"){$ob="incorrect";}
                if($ans=="c"){$oc="incorrect";}if($ans=="d"){$od="incorrect";}
                if($correct=="a"){$oa="right";}if($correct=="b"){$ob="right";}
                if($correct=="c"){$oc="right";}if($correct=="d"){$od="right";}
            }

            $out.='
                <div class="row question portlet light" style="'.$css_style.'">
                    <div class="col-md-12 col-xs-12 question-text" data-attr="q"><i class="'.$status.'"></i> '.$a['question'].'</div>
                    <div class="col-md-12 col-xs-12 text-center option-row ">
                        <div class="col-md-3 col-xs-12 question-option '.$oa.'" data-attr="a">'.$a['a'].'</div>
                        <div class="col-md-3 col-xs-12 question-option '.$ob.'" data-attr="b">'.$a['b'].'</div>
                    </div>
                    <div class="col-md-12 col-xs-12 text-center option-row ">
                        <div class="col-md-3 col-xs-12 question-option '.$oc.'" data-attr="c">'.$a['c'].'</div>
                        <div class="col-md-3 col-xs-12 question-option '.$od.'" data-attr="d">'.$a['d'].'</div> 
                    </div>
                </div>
            ';
        }
        if($tp=="tf"){$css_style='';
            $sql=mysqli_query($con,"select * from tf where tf_id='$question_id' ");
            $a=mysqli_fetch_array($sql,MYSQLI_ASSOC);
            $correct=$a['answer'];
            $status='';$ot='';$of='';$css_style='';
            if($correct==$ans){$score++;$total++;$css_style='border-bottom:4px solid #36D7B7';
                $status="icon-check font-green-turquoise pull-left";
                if($ans=="t"){$ot="right-answer";}if($ans=="f"){$of="right-answer";}
            }
            else{
                $total++;$css_style='border-bottom:4px solid #E7505A';
                $status="icon-close font-red pull-left";
                if($ans=="t"){$ot="incorrect";}if($ans=="f"){$of="incorrect";}
                if($correct=="t"){$ot="right";}if($correct=="f"){$of="right";}
            }

            $out.='
                <div class="row question portlet light" style="'.$css_style.'">
                    <div class="col-md-12 col-xs-12 question-text" data-attr="q"><i class="'.$status.'"></i> '.$a['question'].'</div>
                    <div class="col-md-12 col-xs-12 text-center option-row ">
                        <div class="col-md-3 col-xs-6 question-option '.$ot.'" data-attr="t">True</div>
                        <div class="col-md-3 col-xs-6 question-option '.$of.'" data-attr="f">False</div>
                    </div>
                </div>
            ';
        }
        if($tp=="fillup"){$css_style='';
            $ans=substr($ans,0,(strlen($ans)-1));$ans=preg_replace("/\s|&nbsp;/",'',$ans);$ans=strtolower($ans);
	    
            $ans=str_replace("<p>","",$ans);
            $ans=str_replace("</p>","",$ans);
            $ans=str_replace("<br>","",$ans);
            $ans=str_replace("<br/>","",$ans);
            $ans=str_replace("-","",$ans);
            $sql=mysqli_query($con,"select * from fillup where fillup_id='$question_id' ");
            $a=mysqli_fetch_array($sql,MYSQLI_ASSOC);
            $qorder=$a['qorder'];$correct=$a['answer'];$ques='';$your=substr($answer[$i],0,(strlen($answer[$i])-1));
            if($qorder=="y"){$right=0;$correct_array=array();$ans_a=array();
                $cor=explode(";", $correct);$len=sizeof($cor);
                $ans_array=new SplFixedArray($len);$ans_a=explode(";", $ans);
                if(sizeof($ans_a)>1){$in=0;
                    for($k=0;$k<sizeof($ans_a);$k++){if($ans_a[$k]!=''){$ans_array[$in]=$ans_a[$k];$in++;} }
                }
                $len=sizeof($ans_array);
                for($v=0;$v<$len;$v++){$flag=0;
                    if($ans_array[$v]!=''){
                        if(in_array($ans_array[$v],$cor)){
                            $limit=array_search($ans_array[$v],$cor);
                            if(in_array($limit, $correct_array)){$flag==1;}
                        }
                        if(in_array($ans_array[$v],$cor) && $flag==0)
                            {$right++;array_push($correct_array, array_search($ans_array[$v], $cor));}
                        else{$right=0;}
                        }
                    }
		
                if($len==$right){$status="icon-check font-green-turquoise pull-left";$score++;$total++;$ques=$a['question'];$css_style='border-bottom:4px solid #36D7B7';}
                else{$status="icon-close font-red pull-left";$total++;$ques=$a['question'].'<br/><div class="text-center" style="font-size:12px;font-weight:bold">Your Answer: '.$your.'</div>';
                $css_style='border-bottom:4px solid #E7505A';}
            }
            else{
            if($correct==$ans){$status="icon-check font-green-turquoise pull-left";$score++;$total++;$ques=$a['question'];$css_style='border-bottom:4px solid #36D7B7';}
            else{$status="icon-close font-red pull-left";$total++;$ques=$a['question'].'<br/><div class="text-center" style="font-size:12px;font-weight:bold">Your Answer: '.$your.'</div>';
                $css_style='border-bottom:4px solid #E7505A';}
            }
            $out.='
                <div class="row question portlet light" style="'.$css_style.'">
                    <div class="col-md-12 col-xs-12 question-text" data-attr="q"><i class="'.$status.'"></i> '.$ques.'</div>
                </div>
            ';
        }
    }
}
else{
    header('location:../../');
}


?>
