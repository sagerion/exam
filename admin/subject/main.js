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
}

$(document).ready(function(){
	$(".page-sidebar>ul>li").eq(1).addClass('start open active');
	$('[data-toggle=confirmation]').confirmation({
	  rootSelector: '[data-toggle=confirmation]',
	});

})

$("[data-toggle=confirmation]").on("confirmed.bs.confirmation",function(){
	var data=$(this).attr('data-attr');
	$(this).parent().parent().parent().parent().addClass('active-panel-chapter');
	$.ajax({type:"POST",url:"op.php",data:"action=delete_chapter&chapter_id="+data,cache:false,
		success:function(d){
			if(d=="success"){
				$(".active-panel-chapter").remove();
				toastr.error("Chatper Database Updated", "Chapter Deleted");
			}
		}
	})
});

$(document).on("click",".add-chapter",function(){
	$(this).parent().parent().find('.caption,.actions').fadeOut(400);
	$(this).parent().parent().find('.input-group').addClass('active-input');
	setTimeout(function(){
		$(".active-input").fadeIn();
		$(".active-input input[type=text]").trigger('focus');
		$(".active-input").removeClass('active-input');
	},500);
})

$(document).on("click",".close-chapter",function(){
	$(this).parent().parent().parent().find('.input-group input').val('');
	$(this).parent().parent().parent().find('.input-group').fadeOut(400);
	$(this).parent().parent().parent().find('.caption,.actions').addClass('active-row');
	setTimeout(function(){
		$(".active-row").fadeIn();
		$(".active-row").removeClass('active-row');
	},500);
})

$(document).on("click",".save-chapter",function(){
	var chapter=$(this).parent().parent().find("input[name=chapter_name]").val();
	var subject_id=$(this).parent().parent().find("input[name=subject_id]").val();
	$(this).parent().parent().parent().parent().addClass('active-row');
	$.ajax({
		type:"POST",url:"op.php",data:"subject_id="+subject_id+"&chapter="+chapter+"&action=add_chapter",cache:false,
		success:function(id){
			$('.active-row').find('.accordion').append(`
				 <div class="panel panel-default">
		            <div class="panel-heading">
		                <h4 class="panel-title">
		                <div class="accordion-toggle"><span class="chapter-name">`+chapter+`</span>
	                     </div>
	                     </h4>
		            </div>
		        </div>          
				`);
			$('.active-row').find('.input-group input').val('');
			$('.active-row').find('.input-group').fadeOut(400);
			$('.active-row').find('.caption,.actions').addClass('active-row');
			$('[data-toggle=confirmation]').confirmation({
			  rootSelector: '[data-toggle=confirmation]',
			});
			setTimeout(function(){
				$(".active-row .caption,.active-row .actions").fadeIn();
				$(".active-row").removeClass('active-row');
			},500);
			toastr.success("New Chapter Updated", "Chapter Added");
		}
	})
	
})


$(document).on("click",".add-section",function(){
	var data=$(this).attr('data-attr');
	var text=$(this).parent().find('.chapter-name').text();
	$("input[name=chapter_id]").val(data);
	$("#add-section-modal  .chapter-name").html(text);
	$("#add-section-modal").modal("show");
})

$(document).on("click",".section-chapter",function(){
	var data=$(this).attr('data-attr');
	var text=$(this).text();
	$("input[name=section_id]").val(data);
	$("#delete-section-modal  .section-name").html(text);
	$("#delete-section-modal").modal("show");
})

$(document).on("click","input[name=delete_section]",function(){
	var section_id=$("input[name=section_id]").val();
	$.ajax({type:"POST",url:"op.php",data:"action=delete_section&section="+section_id,cache:false,
		success:function(id){
			if(id=="success"){
				$(".section_"+section_id).remove();
				$("input[name=section_id]").val('');
				$("#delete-section-modal").modal("hide");
				toastr.error("Section Database Updated", "Section Deleted");
			}
		}
	})
})


$("form#add-section").submit(function(e){
	e.preventDefault();
	var section=$("input[name=section]").val();
	var chapter_id=$("input[name=chapter_id]").val();
	$.ajax({type:"POST",url:"op.php",data:"action=add_section&section="+section+"&chapter="+chapter_id,cache:false,
		success:function(id){
			$("#collapse_"+chapter_id+">div").append(`<label class="label label-default bg-grey-steel font-dark section-chapter section_`+id+`" data-attr="`+id+`">`+section+`</label>`);
			$("input[name=section]").val('');
			$("#add-section-modal").modal("hide");
			toastr.success("New Section Updated", "Section Added");
		}
	})
})