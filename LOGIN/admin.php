<?php session_start(); ?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
</head>
<body>

<?php include_once "menu.php"; ?>
<?php
if(!isset($_SESSION['username']))
{
    header("Location: dangki.php");
}
?>
<div>
    <h1>Đây là trang admin!</h1>
    <h2>Bạn chỉ vào được trang này sau khi đăng nhập!</h2>
</div>
<style>
    body{font-family:Tahoma, Geneva, sans-serif;font-size:13px;}
    #menu{margin-bottom:100px; text-align:right;}
    h1, h2{text-align:center;}
</style>
</body>
</html>