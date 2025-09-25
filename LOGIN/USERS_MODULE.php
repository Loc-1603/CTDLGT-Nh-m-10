<?php
// users_module.php

function dangki($link, $username, $password, $email){
    $sql = "INSERT INTO tbl_users (id, username, password, email) VALUES (
        NULL,
        '".mysqli_real_escape_string($link, $username)."',
        '".md5($password)."',
        '".mysqli_real_escape_string($link, $email)."'
    )";

    $result = mysqli_query($link, $sql);

    if (!$result) {
        die("Lỗi SQL: " . mysqli_error($link) . " --- Query: " . $sql);
    }
}

function dangnhap($link, $username, $password){
    $result = chayTruyVanTraVeDL($link, "SELECT COUNT(*) FROM tbl_users WHERE username='".mysqli_real_escape_string($link, $username)."'
        AND password='".md5($password)."'");

    if (!$result) return false;

    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    if($row[0] > 0){
        $_SESSION['username'] = $username;
        return true;
    } else {
        return false;
    }
}

function dangxuat(){
    if(isset($_SESSION['username'])){
        unset($_SESSION['username']);
        return true; // sửa: trả true khi đăng xuất thành công
    } else
        return false;
}
?>
