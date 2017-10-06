<?php
require './header.php';
error_reporting(E_ALL^E_NOTICE^E_WARNING);
session_start();
$user=$_SESSION['admin'];
if(empty($user)){
    header('location:admin.php');
}else {
    ?>
    <body><header>
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
    <?php
    require '../common/connect.php';
    $current_page=isset($_GET['page'])?$_GET['page']:1;
    $par_page = 6;
    $tsql="select count(*) from article";
    $data = new data();
    $con = $data->connect();
    $total = $con->query($tsql)->fetch_row();
    $total_num=$total[0];
    $page = ceil($total_num / $par_page);
    $offset=($current_page-1)*$par_page;
    $sql = "select id,title,label,roundup,time from article order by time desc limit $offset,$par_page";
    $rst=$con->query($sql);
    $data->close();
    ?>
    <article>
    <div id='list_head'>
          <div id='list_name'>全部博文 (<?php echo $total_num ?>)</div>
          <div id='list_search'><input type='text' name='keywords'><input type='submit' value='搜索'></div>
            </div>
    <?php
    while ($row = $rst->fetch_assoc()) {
        $id=$row['id'];
        $title = $row['title'];
        $time = $row['time'];
        $label=$row['label'];
        $roundup = $row['roundup'];
        ?>
        <div class='control_block'>
            <div class='show_title'><a href='full_show.php?id=<?php echo $id ?>&status=0'><?php echo  $title ?></a></div>
            <div class='show_label'><?php echo $label ?></div>
            <div class='show_roundup'><?php echo $roundup ?></div>
            <div class='show_time'><?php echo $time ?></div>
            <div class='show_full'><a href='full_show.php?id=<?php echo $id ?>&status=0'>查看全文</a></div>
            <div class='show_update'><a href='full_show.php?id=<?php echo $id ?>&status=1'>修改</a></div>
            <div class='show_delete'><a href='javascript:void(0)' onclick='deleteBlog(<?php echo $id ?>);'>删除</a></div>
        </div>
        <?php
        }
        ?>
        <div id="page_cut">
            <?php
            if($page<6){
                for($i=1;$i<=$page;$i++){
                    if($i==$current_page){
                        echo '<div class="page_number_now">'.$i.'</div>';
                    }else{
                        echo "<div class='page_number_jump'><a href='index.php?page=$i '>".$i.'</a></div>';
                    }
                }
            }else {
               //write later..

            }

            ?>

        </div>
    </article>
    </body>
<?php
}

?>
<?php
require './footer.php';
?>

