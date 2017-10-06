<?php
    $rst='<script>alert("bug")</script>';
    $sp_rst=htmlspecialchars($rst);
    $aga_sp_rst=htmlspecialchars_decode($sp_rst);
    echo $sp_rst;
    echo "</br>";
    echo $aga_sp_rst;
    /*当htmlspecialchars_decode后js代码会被执行*/
?>