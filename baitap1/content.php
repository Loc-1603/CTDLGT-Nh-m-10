<?php
    require_once "data.php";
    $cag = isset($_GET['gr']) ? $_GET['gr'] : '';
    
    if(!$cag || !array_key_exists($cag, $data)) {
        $keys = array_keys($data);
        header("Location: index.php?gr=" . $keys[0]);
        exit;
    }
    
    $man = $data[$cag];
    foreach ($man as $mankey => $manval) {
        echo "<div class='nav_bar'>" . $mankey . "</div>";
        echo "<div class='products-container'>";
        foreach ($manval as $prod) {
            echo "<div class='prd_item'>";
            // Kiểm tra xem có hình ảnh không, nếu không thì hiển thị placeholder
            //$image_path = "images/" . $prod['image'];
            $image_path = "images/" . $prod['image'];  // dùng cho PHP
            $image_url  = "images/" . $prod['image'];  // dùng cho HTML


            //var_dump($image_path, file_exists($image_path));

            if (file_exists($image_path)) {
                //echo "<img src='" . $image_path . "' alt='" . $prod['name'] . "' class='prd_img'>";
                $image_url = "/baitap1/images/" . $prod['image'];
                echo "<img src='" . $image_url . "' alt='" . $prod['name'] . "' class='prd_img'>";


            } else {
                echo "<div class='prd_img_placeholder'>[Image: " . $prod['name'] . "]</div>";
            }
            echo "<div class='prd_name'>" . $prod['name'] . "</div>";
            echo "</div>";
        }
        echo "<div class='clear'></div>";
        echo "</div>";
    }
?>
<style>
    .nav_bar {
        padding: 8px 10px;
        background-color: #036;
        color: white;
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    
    .nav_bar:first-child {
        margin-top: 0;
    }
    
    .products-container {
        padding-bottom: 15px;
    }
    
    .prd_item {
        width: 160px;
        height: 180px;
        background-color: #eef;
        border: solid 1px #ccc;
        color: #333;
        text-align: center;
        padding: 10px;
        margin: 0px 8px 8px 0px;
        float: left;
        border-radius: 5px;
        box-sizing: border-box;
    }
    
    .prd_img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin: 0 auto 8px auto;
        border: 1px solid #ddd;
        display: block;
    }
    
    .prd_img_placeholder {
        width: 100px;
        height: 100px;
        background-color: #fff;
        border: 1px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px auto;
        font-size: 12px;
        color: #666;
        text-align: center;
    }
    
    .prd_name {
        font-size: 13px;
        font-weight: bold;
        line-height: 1.2;
    }
    
    .clear {
        clear: both;
    }
</style>