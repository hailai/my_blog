<?php
    /*$title=$_POST['title'];
    $time=$_POST['time'];*/
    if(isset($_POST['articleId']) && empty($_POST['commentsId'])){
        echo "<script>alert('222')</script>";
        $articleId=$_POST['articleId'];
        $sql="delete from article where id='$articleId'";
        require '../common/connect.php';
        $data=new data();
        $con=$data->connect();
        $con->query($sql);
        if($con->affected_rows){
            echo '删除成功';
        }
    }
    if(isset($_POST['articleId']) && isset($_POST['commentsId'])){
        $articleId=$_POST['articleId'];
        $commentsId=$_POST['commentsId'];
        $comments_read="select id,name,comments,time from comments where article_id=$articleId";
        require '../common/connect.php';
        $data=new data();
        $con=$data->connect();

        $comments_delete="delete from comments where article_id=$articleId and id=$commentsId";

        $con->query($comments_delete);
        if($con->affected_rows){
            $read_rst=$con->query($comments_read);
            $comments_num=$read_rst->num_rows;
            echo "<p>文章评论[ $comments_num ]</p>";
            while($comments_row=$read_rst->fetch_assoc()){
                $comments_id=$comments_row['id'];
                $name=$comments_row['name'];
                $time=$comments_row['time'];
                $comments_content=$comments_row['comments'];
                echo "<div id='comments_block'><div id='comments_name'>$name |&nbsp</div>";
                echo "<div id='comments_time'>$time</div>";
                echo "<div id='comments_content'>$comments_content</div>";
                echo "<div id='comments_delete'><a href='javascript:;' onclick='deleteComments($articleId,$comments_id)'>删除</a></div></div>";
            }
        }
    }

?>
