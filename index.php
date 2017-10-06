<?php require './header.php' ?>
<article>
    <?php
        require './common/connect.php';
        $data=new data();
        $con=$data->connect();
        $num_sql="select count(*) from article";
        $num_rst=$con->query($num_sql)->fetch_row();
        $article_num=$num_rst[0];
        $par_page=6;
        $page_num=ceil($article_num/$par_page);
        $page=isset($_GET['page'])?$_GET['page']:1;
        $page=is_numeric($page)?$page:1;
        $page=$page>$page_num?$page_num:$page;
        $offset=($page-1)*$par_page;
        $sql="select id,time,title,coverpicture,label,roundup from article order by id desc limit $offset,$par_page";
        $rst=$con->query($sql);
        if($rst){
            while ($row=$rst->fetch_assoc()){
                $id=$row['id'];
                $time=$row['time'];
                $title=$row['title'];
                $cover_picture=$row['coverpicture'];
                $label=$row['label'];
                $roundup=$row['roundup'];
                $sql_comments="select count(*) from comments where article_id=$id";
                $comments_rst=$con->query($sql_comments)->fetch_row();
                $comments_num=$comments_rst[0];
                ?>
<div class="article_block">
    <div class="title"><a href="article.php?id=<?php echo $id ?>"><?php echo $title ?></a></div>
    <div class="time"><?php echo $time ?></div>
    <div class="cover_pic"><img src="<?php echo $cover_picture ?>"></div>
    <div class="roudup"><?php echo $roundup ?></div>
    <div class="label"><a href="###"> <?php echo $label ?></a></div>
    <div class="full_show"><a href='article.php?id=<?php echo $id ?>'>查看全文</a></div>
    <div class="comments_num"><a href='article.php?id=<?php echo $id ?>'><?php echo $comments_num ?>评论</a></div>
</div>

                <?php
            }
        }

    ?>
    <div id="page_jump">
        <?php
            for($i=1;$i<=$page_num;$i++){
                if($i==$page){
                    echo "<div id='now_page'>$i</div>";
                }else{
                    echo "<div id='link_page'><a href='index.php?page=$i'>$i</a></div>";
                }
            }
        ?>
    </div>
</article>


<?php require 'footer.php' ?>

