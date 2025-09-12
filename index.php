<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Electronics Store</title>
    
    <!-- Bootstrap CSS 4.6.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <style>
        body {
            margin: 0px;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        #container {
            width: 1000px;
            margin: 0px auto;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        #banner {
            height: 150px;
            background: linear-gradient(135deg, #39C, #5bc0de);
            padding: 10px;
            color: white;
            display: flex;
            align-items: center;
            border-radius: 0;
        }
        #banner h1 {
            margin: 0;
            font-size: 36px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        #menu {
            height: 30px;
            background: linear-gradient(135deg, #dc3545, #c82333);
            border-radius: 0;
        }
        #lmenu {
            height: auto;
            width: 200px;
            background: linear-gradient(135deg, #ffc107, #e0a800);
            float: left;
            min-height: 400px;
            border-radius: 0;
        }
        #content {
            height: auto;
            width: 800px;
            background-color: #f8f9fa;
            float: left;
            padding: 15px;
            box-sizing: border-box;
            min-height: 400px;
        }
        #footer {
            height: 50px;
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: white;
            text-align: center;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0;
        }
        #footer p {
            margin: 0;
            font-weight: 500;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            #container {
                width: 95%;
                margin: 10px auto;
            }
        }
        
        @media (max-width: 768px) {
            #lmenu, #content {
                width: 100%;
                float: none;
            }
            #lmenu {
                min-height: auto;
            }
            #banner h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="banner">
            <h1><i class="fas fa-store mr-3"></i>Electronics Store</h1>
        </div>
        <div id="menu"><?php include "menu.php"; ?></div>
        <div id="lmenu"><?php include "lmenu.php"; ?></div>
        <div id="content"><?php include "content.php"; ?></div>
        <br style="clear:both;">
        <div id="footer">
            <p><i class="fas fa-copyright mr-2"></i>2023 Electronics Store. All rights reserved.</p>
        </div>
    </div>
    
    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>