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

var append='';

function check_answer(){
	var lenn=$("input[name^='answer']").length;var j=0;
	$("#count-question span").html(lenn);
	for(var i=0;i<lenn;i++){
		var stat=$("input[name^='answer']").eq(i).val();
		if(stat==''){j=1;}	
	}
	
	if(j==1){$("input[name=save]").prop("disabled",true);}
	else{$("input[name=save]").prop("disabled",false);}
}

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
	$(".page-sidebar>ul>li").eq(2).addClass('start open active');
	$("select[name=chapter]").select2({
			allowClear: true,
			placeholder: "Select One",
            width: null
	});
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
	$('.note-editable').html("");
	$("button.add-new").prop('disabled',true);
})
$(document).on("click",".add-question",function(){
	$(".add-question-panel").css({'-moz-transform':'translateY(0%)','-webkit-transform':'translateY(0%)','transform':'translateY(0%)'});
})
$(document).on("click",".close-question",function(){
	$(".add-question-panel").css({'-moz-transform':'translateY(-100%)','-webkit-transform':'translateY(-100%)','transform':'translateY(-100%)'});
	location.reload();
})

$(document).on("change","input[name=type]",function(){
	var data=$(this).val();
	$("input[name=type]").prop('disabled',true);
	$(this).prop('disabled',false);
	if(data=="mcq"){
		append=`
			<div class="row question portlet light">
	            <div class="col-md-12 question-text" data-attr="q">Question</div><textarea wrap="hard" name="q[]" class="hide q">Question</textarea>
	            <div class="row text-center option-row ">
	                <div class="col-md-2 question-option" data-attr="a">Option</div><textarea name="a[]" class="hide a">Option</textarea>
	                <div class="col-md-2 question-option" data-attr="b">Option</div><textarea name="b[]" class="hide b">Option</textarea>
	                <div class="col-md-2 question-option" data-attr="c">Option</div><textarea name="c[]" class="hide c">Option</textarea>
	                <div class="col-md-2 question-option" data-attr="d">Option</div><textarea name="d[]" class="hide d">Option</textarea>
	                <div class="col-md-1 pull-right btn btn-circle btn-default btn-icon-only dark tooltips delete-question" data-title="Delete"><i class="icon-trash"></i></div>
	                <input type="hidden" name="answer[]" />
	            </div>
	        </div>
		`;
	}
	if(data=="tf"){
		append=`
			 <div class="row question portlet light">
                <div class="col-md-12 question-text" data-attr="q">Question</div><textarea wrap="hard" name="q[]" class="hide q">Question</textarea>
                <div class="row text-center option-row ">
                    <div class="col-md-2 tf-option" data-attr="t">True</div>
                    <div class="col-md-2 tf-option" data-attr="f">False</div>
                    <div class="col-md-1 pull-right btn btn-circle btn-default btn-icon-only dark tooltips delete-question" data-title="Delete"><i class="icon-trash"></i></div>
                    <input type="hidden" name="answer[]" />
                </div>
            </div>
		`;
	}
	if(data=="fillup"){
		append=`
			<div class="row question portlet light">
                <div class="col-md-11 question-text-fillup" data-attr="fillup">Fillups</div><textarea wrap="hard" name="q[]" class="hide q">Fillups</textarea>
                <div class="col-md-1 pull-right btn btn-circle btn-default btn-icon-only dark tooltips delete-fillup" data-title="Delete"><i class="icon-trash"></i></div>
            	<input type="hidden" name="answer[]" />
            </div>
		`;
	}
	if(data=="name"){
		append=`
			<div class="row question portlet light">
                <div class="col-md-11 question-text-fillup" data-attr="fillup">Name the Following</div><textarea wrap="hard" name="q[]" class="hide q">Fillups</textarea>
                <div class="col-md-1 pull-right btn btn-circle btn-default btn-icon-only dark tooltips delete-fillup" data-title="Delete"><i class="icon-trash"></i></div>
            	<input type="hidden" name="answer[]" />
            </div>
		`;
	}

	$("button.add-new").prop('disabled',false);
})

$(document).on("click",".add-new",function(){
	$(".question-body").append(append);check_answer();
	var objDiv = document.getElementById("popup-window");
	objDiv.scrollTop = objDiv.scrollHeight;

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
	check_answer();
	
})

$(document).on("click",".tf-option",function(){
	var data=$(this).attr("data-attr");
	$(this).parent().find(".right").removeClass('right');
	$(this).addClass("right");
	$(this).parent().find("input[name^='answer']").val(data);
	check_answer();
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

$(document).on("click",".delete-question",function(){
	$(this).parent().parent().remove();check_answer();
})

$(document).on("click",".delete-fillup",function(){
	$(this).parent().remove();check_answer();
})