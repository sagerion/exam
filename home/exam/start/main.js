var j=0;


var timerId = setInterval(function(){
  countdown -= 1000;
  var min = Math.floor(countdown / (60 * 1000));
  var sec = Math.floor((countdown - (min * 60 * 1000)) / 1000);  //correct

  if (countdown <= 0) {
     $("button[name=check]").trigger('click');
     $(".timer").html('');
     clearInterval(timerId);
     //doSomething();
  } else {
     $(".timer").html(min + " : " + sec);
  }
if(j>3){}
}, 1000); 


var HelloButton = function (context) {
  var ui = $.summernote.ui;

  // create button
  var button = ui.button({
    contents: '→',
    tooltip: 'Arrow',
    click: function () {
      context.invoke('editor.insertText', '→');
    }
  });
  return button.render();  
}


$(document).ready(function(){
    $(".summernote").summernote({
      'removeFormat':true,
      toolbar: [
          ['font', [ 'superscript', 'subscript']],
          ['mybutton', ['Arrow']]
        ],
        buttons: {
          Arrow: HelloButton
        },
        height:250,
    });
    $('.note-editable').html("");
    window.onbeforeunload = function() { return "Your work will be lost."; };
})



$(document).on("click",".question-option",function(){
  var data=$(this).attr('data-attr');
  $(this).parent().parent().find('.right').removeClass('right');
  $(this).addClass('right');
  $(this).parent().parent().find("input[name^='answer']").val(data);
})


$(document).on("click",".question-text u",function(){
  var data=$(this).html();
  $("#editor").modal({backdrop: 'static', keyboard: false});
  $('.summernote').summernote("code",data);
  $(this).addClass("active-element");
})

$(document).on("click","#ok",function(){
  var data=$('.summernote').summernote('code');
  $(".active-element").html(data);
  var ans='';
  $(".active-element").parent().find("u").each(function(){
      var d=$(this).html();ans=ans+''+d+';';
  });
  $(".active-element").closest('div.question-text').parent().find("input[name^='answer']").val(ans);
  $("#editor").modal("hide");
  $(".active-element").removeClass('active-element');
  
})

$(document).on("click","button[name=check]",function(){
  $("#confirm_submit").modal('hide');
  $(".circle-loader,.overlay").fadeIn();
  var lenn=$("input[name='answer[]']").length;
  var right_answer=0;var wrong_answer=0;
  var saved_answer=new Array();
  for(var i=0;i<lenn;i++){
    saved_answer[i]=$("input[name='answer[]']").eq(i).val();
  }
  for(var i=0;i<lenn;i++){
  $("input[name='answer[]']").eq(i).parent().addClass('active-check');
  var current_answer=saved_answer[i];
  if(current_answer=='a' || current_answer=='b' || current_answer=='c' || current_answer=='d' || current_answer=='t' || current_answer=='f'){
    current_answer=current_answer;
  }else{
    current_answer=current_answer.substring(0,current_answer.length-1);
  }
  current_answer=current_answer.toLowerCase();
  current_answer=current_answer.replace(/ /g, "");
  current_answer=current_answer.replace(/&nbsp;/g, "");
  current_answer=current_answer.replace(/(<p[^>]+?>|<p>|<\/p>)/g, "");
  current_answer=current_answer.replace(/<br>/g, "");
  current_answer=current_answer.replace(/<br\/>/g, "");
  current_answer=current_answer.replace(/-/g, "");

  var right_current=answer[i];
  right_current=right_current.toLowerCase();
  right_current=right_current.replace(/ /g, "");
  right_current=right_current.replace(/&nbsp;/g, "");
  right_current=right_current.replace(/(<p[^>]+?>|<p>|<\/p>)/g, "");
  right_current=right_current.replace(/<br>/g, "");
  right_current=right_current.replace(/<br\/>/g, "");
  right_current=right_current.replace(/-/g, "");

  if(current_answer==right_current){
      right_answer++;
      if(answer[i]=='a' || answer[i]=='b' || answer[i]=='c' ||answer[i]=='d' || answer[i]=='t' || answer[i]=='f'){
        $(".active-check .incorrect").removeClass('incorrect');
        $(".active-check .right").removeClass('right');
        $('.active-check div[data-attr='+answer[i]+']').addClass('right-answer');
      }
      //fillup
      else{
        $(".active-check .question-text").empty();
        $(".active-check .question-text").append('<span class="pull-left bold">Q'+(i+1)+'</span>'+question[i]);
      }
      $('.active-check>.question-text>span').prop('class','icon-check font-green-turquoise pull-left');
    }
    else{
      wrong_answer++;
      //mcq
      if(answer[i]=='a' || answer[i]=='b' || answer[i]=='c' ||answer[i]=='d' || answer[i]=='t' || answer[i]=='f'){
        $(".active-check .right").removeClass('right');
        $('.active-check div[data-attr='+answer[i]+']').addClass('right');
        if(saved_answer[i] !=''){$('.active-check div[data-attr='+saved_answer[i]+']').addClass('incorrect');}
      }
      else{
        $(".active-check .question-text").empty();
        $(".active-check .question-text").append('<span class="pull-left bold">Q'+(i+1)+'</span>'+question[i]);
        $(".active-check .question-text").append('<br/><div class="text-center" style="font-size:12px;font-weight:bold">Your Answer: '+current_answer+'</div>')
      }

      $('.active-check>.question-text>span').prop('class','icon-close font-red pull-left');
    }
    $(".active-check").removeClass('active-check');
  }
  $(".option-row,.question-text u").css('pointer-events','none');
  clearInterval(timerId);
  var score=(right_answer*positive)-(wrong_answer*negative);
  $(".timer").html('Score: '+score+' / '+total+' ');
  $.ajax({
    type:"POST",
    url:"../check/index.php",
    data:"test_id="+test_id+"&score="+score+"&total="+total+"&user_id="+uni_id,
    cache:false,
    success:function(e){
         $(".title>span>small").remove();
          $("a#confirm_button").remove();
          $(".floating-buttons").show();

          $(".circle-loader,.overlay").fadeOut();
    }

  })
 
})


$(document).on("click","#print",function(){
  window.print();
})