<?php
    $id=$_POST['id'];
    $c_name = htmlspecialchars($_POST['name']);
    $c_mail = htmlspecialchars($_POST['mail']);
    $c_website = htmlspecialchars($_POST['website']);
    $c_comments = htmlspecialchars($_POST['comments']);
    $sql = "insert into comments(name,mail,website,article_id,comments,time) values(?,?,?,?,?,now())";

    require 'common/connect.php';
    $data=new data();
    $con=$data->connect();
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sssis', $c_name, $c_mail, $c_website, $id, $c_comments);
    $stmt->execute();
    $sql_create="select name,website,comments,time from comments where article_id=$id order by time desc";
    $rst_comments=$con->query($sql_create);
    $comments_num=$rst_comments->num_rows;
    if ($stmt->affected_rows) {
        echo "<p>文章评论 $comments_num</p>";
            while ($row=$rst_comments->fetch_assoc()){
                    $website=$row['website'];
                    $name=$row['name'];
                    $time=$row['time'];
                    $comments=$row['comments'];
                    $need='http://';
                    if(strpos($website, $need)===false){
                        $website=$need.$website;
                    }
                echo "
                <div id='comments_block'>
                    <div id='c_name'><a href=' $website '> $name </a></div>
                    <div id='c_time'>| $time </div>
                    <div id='comments'>$comments</div>
                </div>
                ";
            }

    }
?>

