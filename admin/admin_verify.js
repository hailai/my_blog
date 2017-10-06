function verify_blog() {
    var title=document.forms['add_blog']['article_title'].value;
    var species=document.forms['add_blog']['label'];
    var coverPicture=document.forms.add_blog.cover_picture.value;
    var article=document.getElementById("article_main");
    var notice=document.getElementById("add_page_notice");
    if(title.replace(/(^\s*)|(\s*$)/g,"").length==0){
        notice.style.display="block";
        notice.innerHTML="没有输入标题";
        setTimeout("display()","1500");
        return false;
    }
    var f=0;
    for(var i=0;i<species.length;i++){
        if(species[i].checked==true){
            f=1;
            break;
        }
    }
    if(f != 1){
        notice.style.display="block";
        notice.innerHTML="没有选择类别";
        setTimeout("display()","1500");
        return false;
    }
    if(coverPicture.replace(/^\s*$/g,"").length==0){
        notice.style.display="block";
        notice.innerHTML="未输入封面图片";
        setTimeout("display()","1500");
        return false;
    }
    if((article.value.search(/(^\s*$)|(^>(&nbsp;(\s?))+<\/)/g))!=-1){
        notice.style.display="block";
        notice.innerHTML="文章没有内容";
        setTimeout("display()","1500");
        return false;
    }
}
function display() {
    document.getElementById("add_page_notice").style.display="none";
}


function link() {
    window.location.href="./index.php";
}
function successshow(sts) {
    var sts=sts;
    if(sts==0){
        var notice=document.getElementById("add_page_notice");
        notice.style.display="block";
        notice.innerHTML="发表成功！";
        setTimeout("link()","1000");
    }
    if(sts==1){
        var notice=document.getElementById("add_page_notice");
        notice.style.display="block";
        notice.innerHTML="修改成功！";
        setTimeout("link()","1000");
    }
}

//以上是验证功能，下面开始是删除功能

function deleteBlog(id) {
    if(confirm("确定要删除吗？")){
        var articleId=id;
        xmlHttp=createXMLHttpRequest();
        var url="delete_blog.php";
        var postStr="articleId="+articleId;
        xmlHttp.open("POST",url,true);
        xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xmlHttp.send(postStr);
        xmlHttp.onreadystatechange=run;
    }else{
        return false;
    }
}
function deleteComments(articleId,commentsId) {
    if(confirm("你确定要删除吗？")){
        var articleId=articleId;
        var commentsId=commentsId;
        xmlHttp=createXMLHttpRequest();
        var url="delete_blog.php";
        var postStr="articleId="+articleId+"&commentsId="+commentsId;
        xmlHttp.open("POST",url,true);
        xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xmlHttp.send(postStr);
        xmlHttp.onreadystatechange=function () {
            if(xmlHttp.readyState==4&&xmlHttp.status==200){
                var fullComments=document.getElementById("full_comments");
                fullComments.innerHTML=xmlHttp.responseText;
            }
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
function run() {
    if(xmlHttp.readyState==4&&xmlHttp.status==200){
        var deleteCfm=document.createElement("div");
        deleteCfm.id="delConfirm";
        deleteCfm.innerHTML=xmlHttp.responseText;
        document.body.appendChild(deleteCfm);
        setTimeout(function () {
            document.body.removeChild(deleteCfm);
            window.location.reload(true);
        },"500");

    }
}