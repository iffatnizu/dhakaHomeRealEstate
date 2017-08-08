function changeStyle(param){
    document.execCommand(param, false, null);
    $('#pageContent').focus();
    return false;
}
function changeFontColor(){
    var name=prompt("Please Color Name","");
    if (name!=null){
        document.execCommand('forecolor', false, name);
        $('#pageContent').focus();
        return false;
    }
}
function changeLink(){
    var link=prompt("Please Insert Link","");
    if (link!=null){
        document.execCommand('createlink', false, link);
        $('#pageContent').focus();
        return false;
    }
}