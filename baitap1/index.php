<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" charset="utf-8">
    <title>Electronics Store</title>
    <style>
        body {
            margin: 0px;
            font-family: Arial, sans-serif;
        }
        #container {
            width: 1000px;
            margin: 0px auto;
        }
        #banner {
            height: 150px;
            background-color: #39C;
            padding: 10px;
            color: white;
            display: flex;
            align-items: center;
        }
        #banner h1 {
            margin: 0;
            font-size: 36px;
        }
        #menu {
            height: 30px;
            background-color: red;
        }
        #lmenu {
            height: auto;
            width: 200px;
            background-color: #FC6;
            float: left;
            min-height: 400px;
        }
        #content {
            height: auto;
            width: 800px;
            background-color: #f5f5f5;
            float: left;
            padding: 10px;
            box-sizing: border-box;
            min-height: 400px;
        }
        #footer {
            height: 50px;
            background-color: #096;
            color: white;
            text-align: center;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="banner">
            <h1>Electronics Store</h1>
        </div>
        <div id="menu"><?php include "menu.php"; ?></div>
        <div id="lmenu"><?php include "lmenu.php"; ?></div>
        <div id="content"><?php include "content.php"; ?></div>
        <br style="clear:both;">
        <div id="footer">
            <p>&copy; 2023 Electronics Store. All rights reserved.</p>
        </div>
    </div>
</body>
</html>