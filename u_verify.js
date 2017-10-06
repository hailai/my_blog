function display() {
    document.getElementById("notice").style.display="none";
}
function commentsRresh() {
    var myForm=document.getElementById("comments_sub");
    var name = myForm.name.value;
    var mail = myForm.mail.value;
    var comments= myForm.comments.value;
    var website=myForm.website.value;
    var id=myForm.id.value;
    var reg=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
    if(name.replace(/(^\s*)|(\s*$)/g,"").length==0){
        var notice = '你没有输入姓名';
        document.getElementById("notice").innerHTML=notice;
        document.getElementById("notice").style.display="block";
        setTimeout("display()","2500");
        return false;
    }
    if(mail==null || !reg.test(mail)){
        var notice='邮箱错误';
        document.getElementById("notice").innerHTML=notice;
        document.getElementById("notice").style.display="block";
        setTimeout("display()","2500");
        return false;
    }
    if(comments.replace(/(^\s*)|(\s*$)/g,"").length==0){
        var notice = '你没有输入留言内容';
        document.getElementById("notice").innerHTML=notice;
        document.getElementById("notice").style.display="block";
        setTimeout("display()","2500");
        return false;
    }
    xmlHttp=createXMLHttpRequest();
    var url="add_comments.php";
    var postStr="id="+id+"&name="+name+"&mail="+mail+"&website="+website+"&comments="+comments;
    xmlHttp.open("POST",url,true);
    xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xmlHttp.send(postStr);
    xmlHttp.onreadystatechange=function () {
        if(xmlHttp.readyState==4&&xmlHttp.status==200){
            var commentsBlock=document.getElementById("article_comments");
            commentsBlock.innerHTML=xmlHttp.responseText;
            document.getElementById("reset_button").click();
        }
    }
}
function createXMLHttpRequest() {
    var xmlHttp;
    try {
        //chrome, Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            //IE5，6
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                //IE7以上
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                alert("您的浏览器不支持AJAX！");
                return false;
            }
        }
    }
    return xmlHttp;
}
