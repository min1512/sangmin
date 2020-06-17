//네비게이션 부분 처리
$(function(){
    $("span.block_arrow").click(function(){
        if($(this).parent().hasClass("up")) {
            $(this).parent().removeClass("up");
        }
        else {
            $("div.gnb ul li").each(function(){
                $(this).removeClass("up");
                $(this).find(".menu").removeClass("on");
            });
            $(this).parent().addClass("up");
        }
        act_menu();
    });
    act_menu();
});

function act_menu() {
    $("div.gnb ul li").each(function(){
        if($(this).hasClass("up")){
            //$(this).find("span.block_arrow i").removeClass().addClass("fal fa-angle-up");
            $(this).find("span.block_arrow i").attr("class","fal fa-angle-up");
            $(this).find("p").each(function(){ $(this).slideDown();})
            $(this).find(".menu").addClass("on");
        }
        else {
            //$(this).find("span.block_arrow i").removeClass().addClass("fal fa-angle-down");
            $(this).find("span.block_arrow i").attr("class","fal fa-angle-down");
            $(this).find("p").each(function(){ $(this).slideUp();})
            $(this).find(".menu").removeClass("on");
        }
    });
}

function goUrl(url, target) {
    if(!target) target="";

    if(target=="")
        document.location.href = url;
    else
        window.open(url);
}
function frmReset(frm) {
    $("form[name="+frm+"]")[0].reset();
    $("form[name="+frm+"]").find("input[type=hidden]").each(function(){
        if($(this).attr("name")!="_token") $(this).val("");
    });
}
