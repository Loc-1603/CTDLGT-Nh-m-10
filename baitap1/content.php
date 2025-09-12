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
        echo "<div class='brand-header mb-3'>";
        echo "<h4 class='mb-0'><i class='fas fa-building mr-2'></i>" . $mankey . "</h4>";
        echo "</div>";
        
        echo "<div class='row mb-4'>";
        foreach ($manval as $prodIndex => $prod) {
            $modalId = $mankey . "_" . $prodIndex; // tạo id duy nhất
            echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-3'>";
            echo "<div class='card product-card h-100 shadow-sm'>";

            // Ảnh sản phẩm
            $image_path = "images/" . $prod['image'];
            $image_url = "images/" . $prod['image'];

            if (file_exists($image_path)) {
                $image_url = "/baitap1/images/" . $prod['image'];
                echo "<img src='" . $image_url . "' alt='" . $prod['name'] . "' class='card-img-top product-img'>";
            } else {
                echo "<div class='card-img-top product-img-placeholder d-flex align-items-center justify-content-center'>";
                echo "<div class='text-center text-muted'>";
                echo "<i class='fas fa-image fa-2x mb-2'></i><br>";
                echo "<small>" . $prod['name'] . "</small>";
                echo "</div>";
                echo "</div>";
            }

            echo "<div class='card-body text-center'>";
            echo "<h6 class='card-title product-name'>" . $prod['name'] . "</h6>";

            // Nút mở modal
            echo "<button class='btn btn-primary btn-sm btn-block' data-toggle='modal' data-target='#imageModal{$modalId}'>";
            echo "<i class='fas fa-search-plus mr-1'></i>View Details";
            echo "</button>";

            echo "</div>"; // card-body
            echo "</div>"; // card
            echo "</div>"; // col

            // Modal hiển thị ảnh to
            echo "
            <div class='modal fade' id='imageModal{$modalId}' tabindex='-1' role='dialog' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
                <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>{$prod['name']}</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body text-center'>
                    <img src='/baitap1/images/{$prod['image']}' class='img-fluid' alt='{$prod['name']}'>
                </div>
                </div>
            </div>
            </div>";
        }


        echo "</div>";
    }
?>

<style>
    .brand-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .brand-header h4 {
        font-weight: 600;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }
    
    .product-card {
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        background: white;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    
    .product-img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px 8px 0 0;
        transition: all 0.3s ease;
    }
    
    .product-img:hover {
        transform: scale(1.05);
    }
    
    .product-img-placeholder {
        width: 100%;
        height: 150px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 8px 8px 0 0;
        border: 2px dashed #dee2e6;
    }
    
    .card-body {
        padding: 15px;
    }
    
    .product-name {
        color: #333;
        font-weight: 600;
        margin-bottom: 15px;
        min-height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1.3;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #0056b3, #004085);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .fas {
        color: #6c757d;
    }
    
    .brand-header .fas {
        color: white;
    }
    
    /* Responsive adjustments */
    @media (max-width: 576px) {
        .col-sm-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        .product-img, .product-img-placeholder {
            height: 200px;
        }
    }
    
    @media (min-width: 992px) {
        .col-lg-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }
    }
</style>