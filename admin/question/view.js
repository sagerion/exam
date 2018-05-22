toastr.options = {
  "closeButton": true,
  "debug": false,
  "positionClass": "toast-bottom-right",
  "onclick": null,
  "showDuration": "1000",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};
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
            ['style', ['bold', 'italic', 'underline']],
            ['font', [ 'superscript', 'subscript']],
            ['mybutton', ['Arrow']]
          ],
          buttons: {
            Arrow: HelloButton
          },
          height:250,
    });
})


$(document).on("click",".question-option,.question-text,.question-text-fillup",function(){
    var data=$(this).html();
    $("#editor").modal({backdrop: 'static', keyboard: false});
    $('.summernote').summernote("code",data);
    $(this).addClass("active-element");
    var att=$(".active-element").attr('data-attr');
    var vak=$(this).parent().find("input[name^='answer']").val();
    if(vak==att){$("input[name=correct]").prop('checked',true);}
    if(vak!=att){$("input[name=correct]").removeAttr('checked');}
})
$(document).on("click",".delete",function(){
    $(this).addClass('active-question');
    var data=$(this).attr('data-attr');
    var type=$(this).attr('data-type');
    $.ajax({type:"POST",url:"op.php",data:"action=delete&type="+type+"&id="+data,cache:false,
        success:function(e){
            if(type=="tf"){$(".active-question").parent().parent().remove();}
            else{$(".active-question").parent().remove();}
            
            $(".active-question").removeClass('active-question');
            toastr.error('Question Deleted.', 'Removed!')
        }
    })    
})

$(document).on("click","#ok",function(){
    var data=$('.summernote').summernote('code');
    var att=$(".active-element").attr('data-attr');
    if(att=="fillup"){
        var str=data;
        var start=0;var end=0;var ans='';var i=0,k=0,f=0;
        var last=str.lastIndexOf("</u>");
        while(i<last){
            start = str.substring(f).indexOf("<u>");
            end = str.substring(f+start+3).indexOf("</u>");
            if(str.substring(f+start+3,f+start+end+3)!=''){ans+= str.substring(f+start+3,f+start+end+3)+';';}
            f=f+start+end+7;i=f;
        }
        ans=ans.substring(0,(ans.length-1));
        $(".active-element").html(data);
        $(".active-element").parent().find('textarea[name^="q"]').text(str);
        $(".active-element").parent().find('input[name^="answer"]').val(ans);
    }
    else{$(".active-element").html(data);$(".active-element").parent().find('textarea.'+att).text(data);}
    $("#editor").modal("hide");
    $(".active-element").removeClass('active-element');
})

$(document).on("click",".tf-option",function(){
    var data=$(this).attr("data-attr");
    $(this).parent().find(".right").removeClass('right');
    $(this).addClass("right");
    $(this).parent().find("input[name^='answer']").val(data);
})


$(document).on("click","input[name=correct]",function(){


  if(this.checked){
    var att=$(".active-element").attr('data-attr');
    if(att=="a" || att=="b" || att=="c" || att=="d"){   
      $(".active-element").parent().find("input[name^='answer']").val(att);
      $(".active-element").parent().find(".right").removeClass('right');
      $(".active-element").parent().find("div[data-attr="+att+"]").addClass('right');
    }
  }
  else if(
      $(this).prop('checked')==false){$(".active-element").parent().find("input[name^='answer']").val('');
      $(".active-element").parent().find(".right").removeClass('right');
  }



})