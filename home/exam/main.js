

$(document).ready(function(){
    $(".page-sidebar>ul>li").eq(2).addClass('start open active');
})

$(document).on("click",".test",function(){
	$(".test-overlay").fadeIn();
	$(".test-info").css({"-moz-transform":"translateX(0%)","-webkit-transform":"translateX(0%)","transform":"translateX(0%)"});
	$(this).addClass("active-test");
})

$(document).on("click","#start-test",function(){
	var data=$(".active-test").attr("data-attr");

	location.href=('./start/?id='+data);
})
$(document).on("click","#close",function(){
	$(".test-overlay").fadeOut();
	$(".test-info").css({"-moz-transform":"translateX(-100%)","-webkit-transform":"translateX(-100%)","transform":"translateX(-100%)"});
})

$(document).on("click",".test",function(){
    var data=$(this).attr('data-attr');
    $(".info-window").css({"-webkit-transform":"translateX(0)","-moz-transform":"translateX(0)","transform":"translateX(0)"});
    $(".overlay").fadeIn();
    $.ajax({
        type:"GET",url:"op.php",data:"test="+data,cache:false,
        beforeSend:function(){
             App.blockUI({target:".info-window",boxed:true,textOnly:true});
        },
        success:function(e){
            $(".info-window").empty();
            $(".info-window").append(e);
        },
        complete:function(){
            App.unblockUI(".info-window");
        }
    })
})