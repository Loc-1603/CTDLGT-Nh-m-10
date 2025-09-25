<?php
session_start();
require_once "db_module.php";
require_once "validate_module.php";
require_once "users_module.php";

$link = NULL;
taoKetNoi($link);

if (
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['password2']) &&
    isset($_POST['email']) &&
    isset($_POST['captcha'])
) {
    // kiểm tra các điều kiện dữ liệu
    $valid = ($_POST['password'] === $_POST['password2']); // mật khẩu nhập lại phải khớp
    $valid = $valid && validateLenUP($_POST['username']);  // username phải dài 8–30 ký tự
    $valid = $valid && validateLenUP($_POST['password']);  // password phải dài 8–30 ký tự
    $valid = $valid && validateEmail($_POST['email']);     // email đúng định dạng

    // kiểm tra captcha
    if (!isset($_SESSION['captcha']) || $_POST['captcha'] !== $_SESSION['captcha']) {
        $valid = false;
    }

    if ($valid) {
        if (existsUsername($link, $_POST['username'])) {
            giaiPhongBoNho($link, true);
            header("Location: dangki.php?msg=duplicate&username=" . $_POST['username'] . "&email=" . $_POST['email']);
            exit;
        } else {
            dangki($link, $_POST['username'], $_POST['password'], $_POST['email']);
            giaiPhongBoNho($link, true);
            header("Location: dangki.php?msg=done");
            exit;
        }
    } else {
        giaiPhongBoNho($link, true);
        header("Location: dangki.php?msg=invalid-data&username=" . $_POST['username'] . "&email=" . $_POST['email']);
        exit;
    }
}
?>
