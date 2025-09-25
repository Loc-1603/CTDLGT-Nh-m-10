<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Đăng Nhập</title>
</head>
<body>

<?php require_once "menu.php"; ?>

<form action="xulydangnhap.php" method="post">
    <h3 style="text-align:center; color:#f30; background:black; padding:5px;">Đăng Nhập</h3>
    <div class="frm_row">
        <div class="cls_caption">Tên tài khoản:</div>
        <div class="cls_input">
            <input type="text" name="username" />
        </div>
        <br style="clear:both;" />
    </div>
    <div class="frm_row">
        <div class="cls_caption">Mật khẩu:</div>
        <div class="cls_input">
            <input type="password" name="password" />
        </div>
        <br style="clear:both;" />
    </div>
    <div class="img_row">
        <input type="submit" value="Đăng Nhập" />
        <input type="reset" value="Xóa Form" />
    </div>
    <br style="clear:both;" />
</form>

<?php require_once "msg.php"; ?>

</body>
</html>