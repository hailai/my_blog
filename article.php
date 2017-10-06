<?php
     require './header.php';
     if(empty($_GET['id'])){
         header('index.php');
     }
     $id=$_GET['id'];
     require './common/connect.php';
     $data=new data();
     $con=$data->connect();
     $sql="select title,label,content,time from article where id=$id";
     $sql_comments="select name,website,comments,time from comments where article_id=$id order by time desc";
     $rst=$con->query($sql);
     $comments_rst=$con->query($sql_comments);
     $comments_num=$comments_rst->num_rows;
    if($rst) {
        while ($row = $rst->fetch_assoc()) {
            $time = $row['time'];
            $title = $row['title'];
            $label = $row['label'];
            $content = $row['content'];
        }
    }
?>
<article>
    <div id="content_block">
        <div id="article_title"><?php echo $title ?></div>
        <div id="article_time"><?php echo $time ?></div>
        <div id="article_comments_num"><?php echo $comments_num ?>评论</div>
        <div id="article_label"><?php echo $label ?></div>
        <div id="article_content"><?php echo $content ?></div>
    </div>
    <div id="article_comments">
        <p>文章评论<?php echo $comments_num ?></p>
        <?php
        if($comments_num){
            while ($row=$comments_rst->fetch_assoc()){
                $website=$row['website'];
                $need='http://';
                if(strpos($website, $need)===false){
                    $website=$need.$website;
                }
                ?>
                <div id="comments_block">
                    <div id="c_name"><a href="<?php echo $website ?>"><?php echo $row['name'] ?></a></div>
                    <div id="c_time">|<?php echo $row['time'] ?></div>
                    <div id="comments"><?php echo $row['comments'] ?></div>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <div id="write_comments">
        <div id="aa">写个评论</div>
        <form  name="comments_sub" id="comments_sub">
            <p><input name="name" type="text"> 名字</p>
            <p><input name="mail" type="text"> 邮箱（不会公开）</p>
            <p><input name="website" type="text"> 你的网站（可选）</p>
            <textarea placeholder="输入评论" name="comments"></textarea>
            <p><input id="reset_button" type="reset" ></p>
            <p><button type="button"  onclick="commentsRresh()">提交</button></p>
            <div id="notice">qqer</div>
            <input name="id" type="hidden" value="<?php echo $id ?>">
        </form>
    </div>
</article>
<?php
                // 用ajax吗，真的好烦的。明明PHP很简单的一点代码，偏偏reload出问题，怎么回事啊。  //可以用锚点控制位置
require 'footer.php';
?>




?>