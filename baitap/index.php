<?php
// data.php - File chứa dữ liệu sản phẩm
$data = array( 
    "Máy tính xách tay" => array(
        "Apple" => array("iMac", "MacBook Pro", "MacBook Air"), 
        "Asus" => array("Asus Zenbook", "Asus Transformer Book", "Asus Taichi"), 
        "Dell" => array("XPS 11", "XPS 13", "Inspiron 15", "Latitude 15") 
    ),
    "Máy tính bảng" => array(
        "Sony" => array("Máy tính bảng Sony Z", "Máy tính bảng Sony S"), 
        "Samsung" => array("Galaxy Nexus 10", "Galaxy Tab 10.1", "Note 8") 
    ),
    "Điện thoại thông minh" => array(
        "Apple" => array("iPhone 4", "iPhone 4s", "iPhone 5"), 
        "Samsung" => array("Galaxy S3", "Galaxy S4", "Galaxy Note 2"), 
        "HTC" => array("HTC One X", "HTC One S", "HTC One") 
    ),
    "Tivi" => array(
        "Sharp" => array("Sharp DX43P", "Sharp TH32D", "Sharp DD72X"), 
        "Sony" => array("Sony DT42V", "Sony UT45X", "Sony UT60M") 
    ),
    "PC AIO" => array(
        "Dell" => array("Dell Inspiron AIO", "Dell XPS AIO"), 
        "HP" => array("HP Pavilion AIO", "HP Envy AIO") 
    )
);

// Xử lý danh mục được chọn
$selected_category = isset($_GET['gr']) ? $_GET['gr'] : '';

// Nếu danh mục không tồn tại, chọn danh mục đầu tiên
if (!array_key_exists($selected_category, $data)) {
    $keys = array_keys($data);
    $selected_category = $keys[0];
}

// Lấy danh sách sản phẩm theo danh mục
$category_products = $data[$selected_category];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Mục Sản Phẩm</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        
        #container {
            width: 1000px;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        #banner {
            height: 150px;
            background-color: #3399CC;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: bold;
        }
        
        #menu {
            height: 30px;
            background-color: #FF3333;
            display: flex;
            align-items: center;
            padding: 0 10px;
        }
        
        #menu a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
            font-weight: bold;
        }
        
        #menu a:hover {
            text-decoration: underline;
        }
        
        #lmenu {
            width: 200px;
            background-color: #FFCC66;
            float: left;
            min-height: 400px;
            padding: 10px;
        }
        
        #content {
            width: 780px;
            float: left;
            min-height: 400px;
            padding: 10px;
            background-color: rgba(34, 153, 255, 0.2);
        }
        
        #footer {
            height: 200px;
            background-color: #2096FF;
            clear: both;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .nav_bar {
            padding: 3px 5px;
            background-color: #003366;
            color: white;
            font-weight: bold;
            margin-top: 5px;
        }
        
        .brand_container {
            margin-bottom: 20px;
        }
        
        .prd_item {
            width: 152px;
            height: 20px;
            background-color: #3366CC;
            border: solid 1px white;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin: 0 3px 3px 3px;
            float: left;
        }
        
        .clear {
            clear: both;
        }
        
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        
        ul li {
            margin-bottom: 5px;
        }
        
        ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        
        ul li a:hover {
            color: #003366;
        }
        
        .active-category {
            color: #003366 !important;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="banner">CỬA HÀNG ĐIỆN TỬ TECHWORLD</div>
        
        <div id="menu">
            <a href="#">Trang chủ</a>
            <a href="#">Sản phẩm</a>
            <a href="#">Khuyến mãi</a>
            <a href="#">Liên hệ</a>
        </div>
        
        <div id="lmenu">
            <h3>Danh mục sản phẩm</h3>
            <ul>
                <?php
                foreach ($data as $category => $products) {
                    $is_active = ($category == $selected_category) ? 'class="active-category"' : '';
                    echo "<li><a href='?gr=" . urlencode($category) . "' $is_active>" . $category . "</a></li>";
                }
                ?>
            </ul>
        </div>
        
        <div id="content">
            <?php
            foreach ($category_products as $brand => $products) {
                echo "<div class='nav_bar'>" . $brand . "</div>";
                echo "<div class='brand_container'>";
                
                foreach ($products as $product) {
                    echo "<div class='prd_item'>" . $product . "</div>";
                }
                
                echo "<div class='clear'></div>";
                echo "</div>";
            }
            ?>
        </div>
        
        <div class="clear"></div>
        
        <div id="footer">
            &copy; 2023 Cửa hàng điện tử TechWorld - Điện thoại: 0123.456.789
        </div>
    </div>
</body>
</html>