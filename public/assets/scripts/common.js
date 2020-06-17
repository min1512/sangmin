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
