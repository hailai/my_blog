<?php
    require './header.php';
    session_start();
    if(isset($_SESSION['admin'])){
        $user=$_SESSION['admin'];
    }else{
        echo '<script>window.location.href="./admin.php"</script>';
        return false;
    }
?>
    <body>
    <header>
    <div id='block_title'>欢迎你，大帅</div>
    <div id='name'><?php echo $user ?></div>
    <div id='logout'><a href='./logout.php'>退出</a></div>
    <div id='nav'>
        <ul>
        <li><a href='./admin.php'>博文</a></li>
        <li><a href='./add_blog.php'>写博</a></li>
        <li><a href='#'>留言</a></li>
        </ul>
    </div>
    </header>
    <article>
    <form action="###" name="add_blog" method="post" onsubmit="return verify_blog();">
    <div id="article_tile">标题 <input type="text" name="article_title"></div>
    <div id="article_label">类别
        <label><input type="radio" name="label" value="html/css">html/css</label>
        <label><input type="radio" name="label" value="js">js</label>
        <label><input type="radio" name="label" value="php">php</label>
        <label><input type="radio" name="label" value="linux">linux</label>
        <label><input type="radio" name="label" value="数据库">数据库</label>
        <label><input type="radio" name="label" value="其他">其他</label>
    </div>
    <div id="cover_picture">图片 <input type="text" name="cover_picture" placeholder="输入封面图片地址"></div>
    <div id="main_word">正文 </div>
    <textarea id="article_main" name="article_main" placeholder="这里输入博文" ></textarea>
   <script>
       var article_main = new Simditor({
           textarea: $('#article_main'),
           toolbar:['bold', 'italic', 'underline', 'strikethrough', 'fontScale',
               'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link',
               'image', 'hr', '|', 'indent', 'outdent', 'alignment']});
   </script>
    <input type="submit" name="sub" class="article_sub">
</form>
<div id="add_page_notice"></div>
    </article>
</body>
<?php
require './footer.php';
?>
<?php
    if(isset($_POST['sub'])){
        $title=$_POST['article_title'];
        $species=$_POST['label'];
        $cover_picture=$_POST['cover_picture'];
        $blog=$_POST['article_main'];
        $pure=strip_tags($blog);
        $pure_words=str_replace("&nbsp","",$pure);
        $length=200;
        $roundup=mb_strcut($pure_words,0,$length);
        $ellipsis="……";
        $roundup=$roundup.$ellipsis;
        require '../common/connect.php';
        $data=new data();
        $con=$data->connect();
        $ist_title=$con->real_escape_string($title);
        $ist_picture=$con->real_escape_string($cover_picture);
        $ist_roundup=$con->real_escape_string($roundup);
        $ist_blog=$con->real_escape_string($blog);
        $sql="INSERT INTO article(title,label,coverpicture,roundup,content,time) VALUES('$ist_title','$species','$ist_picture','$ist_roundup','$ist_blog',NOW())";
        $con->query($sql);
        if($con->affected_rows>0){
            echo '<script>successshow(0);</script>';
        }
        $data->close();
    }
?>
