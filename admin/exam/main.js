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

function check_score(){
  var total=0;
    var lenn=$("input[name^='num']").length;
    for(var i=0;i<lenn;i++){
        var num=$("input[name^='num']").eq(i).val();if(num==''){num=0;}
        total=parseInt(total)+parseInt(num);
    }
    var marks=$("input[name=positive]").val();if(marks==''){marks=0;}
    total=total*marks;
    $("input[name=total]").val(total);
}

$(document).ready(function(){
	$(".page-sidebar>ul>li").eq(3).addClass('start open active');
	$("input[name=start],input[name=end]").datetimepicker({autoclose:true});
	$("input[name=time_limit]").timepicker({autoclose:true,showMeridian:!1,defaultTime:'00:00',minuteStep:1});
	$("input[name=class]").change(function(){
       var data=$(this).val();
       if(data==9){
        $("select[name=level]").empty();
        $("select[name=level]").html(`
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
        <option value="9">Others</option>`);
      }
       if(data==10){
        $("select[name=level]").empty();
        $("select[name=level]").html(`
        <option value="" selected disabled> -Select Level -</option>
        <option value="0">All Level</option>
        <option value="1">Level 1</option>
        <option value="2">Level 2</option>
        <option value="3">Level 3</option>`);
       } 
    })
})

$(document).on("click",".delete",function(){
	$(this).parent().parent().remove();check_score();
})
$(document).on("click",".create-test",function(){
	$(".add-test-panel").css({"-webkit-transform":"translateY(0%)","-moz-transform":"translateY(0%)","transform":"translateY(0%)"});
})
$(document).on("keyup","input[name^='num'],input[name=positive]",function(){
    check_score();
})

$(document).on("click","#close-panel",function(){
	location.href=('../exam/');
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

$(document).on("click","#close-tab",function(){
  $(".info-window").css({"-webkit-transform":"translateX(-100%)","-moz-transform":"translateX(-100%)","transform":"translateX(-100%)"});
    $(".overlay").fadeOut();
})

$(document).on("click","#delete_test",function(){
  var data=$(this).attr('data-attr');
  location.href=('./?action=delete&id='+data);
})