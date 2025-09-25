<?php
session_start();
require_once "db_module.php";
require_once "users_module.php";

$link = NULL;
taoKetNoi($link);

if(isset($_POST['username']) && isset($_POST['password'])){
    if(dangnhap($link, $_POST['username'], $_POST['password'])){
        giaiPhongBoNho($link, true);
        header("Location: admin.php");
    }
    else{
        giaiPhongBoNho($link, true);
        header("Location: dangnhap.php?msg=login-fail");
    }
}
else{
    giaiPhongBoNho($link, true);
    header("Location: dangnhap.php");
}
?>