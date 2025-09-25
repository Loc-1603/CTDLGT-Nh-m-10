<?php
// validate_module.php

// kiểm tra độ dài username/password: từ 8 đến 30 kí tự
function validateLenUP($up) {
    $len = mb_strlen(trim($up), 'UTF-8');
    return ($len >= 8 && $len <= 30);
}

// kiểm tra email hợp lệ
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// kiểm tra username đã tồn tại trong DB hay chưa
function existsUsername($link, $username) {
    $username = mysqli_real_escape_string($link, $username);
    $result = chayTruyVanTraVeDL($link, "SELECT COUNT(*) FROM tbl_users WHERE username='$username'");
    if (!$result) return false; // nếu query lỗi thì coi như chưa tồn tại
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    return ($row[0] > 0);
}
?>
