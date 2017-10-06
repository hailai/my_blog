<?php
require './header.php';
session_start();
if(empty($_SESSION['admin'])){
    header('location:admin.php');
}else{
    $user=$_SESSION['admin'];
    $id=$_GET['id'];
    $status=$_GET['status'];
    require '../common/connect.php';
    $data=new data();
    $con=$data->connect();
    $sql="select * from article where id=$id";
    $rst=$con->query($sql);
    if($rst){
        $row=$rst->fetch_assoc();
        $title=$row['title'];
        $label=$row['label'];
        $cover_picture=$row['coverpicture'];
        $time=$row['time'];
        $content=$row['content'];
    }else{
        die('falied to data') ;
    }
    ?>
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
    <body>
    <article>
    <?php
    if($status==0){
        if(!$content){
            echo "<script>window.location.href='index.php'</script>";
        }
        $comments_sql="select id,name,comments,time from comments where article_id=$id";
        $comments_rst=$con->query($comments_sql);
        $comments_num=$comments_rst->num_rows;
        ?>
        <div id="full_title"><?php echo $title  ?></div>
        <div id="full_time"><?php echo $time ?></div>
        <div id="full_content"><?php echo $content ?></div>
        <div id="full_delete"><a href='javascript:;' onclick='deleteBlog(<?php echo $id ?>);'>删除</a></div>
        <div id="full_updata"><a href='full_show.php?id=<?php echo $id ?>&status=1'>修改</a></div>

        <div id="full_comments">
            <p>文章评论[<?php echo $comments_num ?>]</p>

                <?php
                    while($comments_row=$comments_rst->fetch_assoc()){
                        $comments_id=$comments_row['id'];
                        $name=$comments_row['name'];
                        $time=$comments_row['time'];
                        $comments_content=$comments_row['comments'];
                        echo "<div id='comments_block'><div id='comments_name'>$name |&nbsp</div>";
                        echo "<div id='comments_time'>$time</div>";
                        echo "<div id='comments_content'>$comments_content</div>";
                        echo "<div id='comments_delete'><a href='javascript:;' onclick='deleteComments($id,$comments_id)'>删除</a></div></div>";
                    }
                ?>

        </div>
<?php
    }
    if($status==1){
        ?>
        <form action="###" name="add_blog" method="post" onsubmit="return verify_blog();">
            <div id="article_tile">标题 <input type="text" name="article_title" value="<?php echo $title ?>"></div>
            <div id="article_label">类别
                <label><input type="radio" name="label" value="html/css" <?php if($label=='html/css') echo "checked"; ?> >html/css</label>
                <label><input type="radio" name="label" value="js"<?php if($label=='js') echo "checked"; ?> >js</label>
                <label><input type="radio" name="label" value="php"<?php if($label=='php') echo "checked"; ?> >php</label>
                <label><input type="radio" name="label" value="linux"<?php if($label=='linux') echo "checked"; ?> >linux</label>
                <label><input type="radio" name="label" value="数据库"<?php if($label=='数据库') echo "checked"; ?> >数据库</label>
                <label><input type="radio" name="label" value="其他"<?php if($label=='其他') echo "checked"; ?> >其他</label>
            </div>
            <div id="cover_picture">图片 <input type="text" name="cover_picture" value="<?php echo $cover_picture ?>"></div>
            <div id="main_word">正文 </div>
            <textarea id="article_main" name="article_main"><?php echo $content ?></textarea>
            <script>
                var article_main = new Simditor({
                    textarea: $('#article_main'),
                    toolbar:['bold', 'italic', 'underline', 'strikethrough', 'fontScale',
                        'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'image',
                        'hr', '|', 'indent', 'outdent', 'alignment'],
                });
            </script>
            <input type="submit" name="sub" value="修改" class="article_sub">
        </form>
        <div id="add_page_notice"></div>
        </article>
        </body>
        <?php
        require './footer.php';
        ?>
        <?php
        if(isset($_POST['sub'])){
            $new_title=$_POST['article_title'];
            $new_label=$_POST['label'];
            $new_cover_picture=$_POST['cover_picture'];
            $new_content=$_POST['article_main'];
            $update_sql="update article set title='$new_title',label='$new_label',coverpicture='$new_cover_picture',content='$new_content' where id=$id";
            $con->query($update_sql);
            if($con->affected_rows){
                echo "<script>successshow(1);</script>";
            }
        }
    }
    ?>

<?php
}
?>