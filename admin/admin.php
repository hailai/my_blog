<?php require 'header.php'; ?>
<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
session_start();
$user=$_SESSION['admin'];
if(isset($user)){
    //echo '<script>window.location.href="main_blog.php";</script>';
    header('location:index.php');
}else {
?>
<body>
<div id="log_page">
    <div id="log_title"><p>博客</p>
        <p>管理一下吧！</p></div>
    <form action="#" method="post">
        <table>
            <th colspan="2">请登录</th>
            <tr>
                <td>名字</td>
                <td><input name="name"></td>
            </tr>
            <tr>
                <td>密码</td>
                <td><input name="password" type="password"></td>
            </tr>
            <tr>
                <td>验证码：</td>
                <td><input name="input_code"></td>
            </tr>
            <tr>
                <td><img src="verifycode.php" id="pic"></td>
                <td>
                    <a href="javascript:void (0)"
                       onclick=" document.getElementById('pic').src='verifycode.php' ">换一个</a>
                </td>
            </tr>
        </table>
        <input type="submit" name="submit" value="提交">
    </form></body>
    <?php
    }
    if(isset($_POST['submit'])){
        session_start();
        require '../common/config.php';
        $name=$_POST['name'];
        $password=$_POST['password'];
        $input_code=$_POST['input_code'];
        if($name==null || $password==null){
            echo '不能为空！';
            return false;
        }elseif ($name!=Admin){
            echo '用户名错误';
        }elseif ($password!=Password){
            echo '密码错误';
        }elseif ($input_code!=$_SESSION['authcode']){
            echo '验证码错误';
        }else{
            $_SESSION['admin']=$name;
            echo '<script>window.location.href="./admin.php"</script>';
        }
    }
    ?>
</div>
<?php require 'footer.php'; ?>
