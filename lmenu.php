<?php
    require "data.php";
    $current = isset($_GET['gr']) ? $_GET['gr'] : '';
?>

<div class="list-group list-group-flush">
<?php
    foreach ($data as $menuitem => $value) {
        $active = ($current == $menuitem) ? 'active' : '';
        echo "<a href='index.php?gr=" . $menuitem . "' class='list-group-item list-group-item-action " . $active . "'>";
        
        // Add icons for each category
        $icon = '';
        switch($menuitem) {
            case 'Laptop':
                $icon = '<i class="fas fa-laptop mr-2"></i>';
                break;
            case 'Tablet':
                $icon = '<i class="fas fa-tablet-alt mr-2"></i>';
                break;
            case 'Smartphone':
                $icon = '<i class="fas fa-mobile-alt mr-2"></i>';
                break;
            case 'Television':
                $icon = '<i class="fas fa-tv mr-2"></i>';
                break;
        }
        
        echo $icon . $menuitem . "</a>";
    }
?>
</div>

<style>
    #lmenu .list-group {
        margin: 0;
        border-radius: 0;
    }
    
    #lmenu .list-group-item {
        background-color: transparent;
        border: none;
        border-bottom: 1px solid rgba(255,255,255,0.2);
        color: #333;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 12px 15px;
    }
    
    #lmenu .list-group-item:hover {
        background-color: rgba(255,255,255,0.3);
        color: #000;
        text-decoration: none;
        transform: translateX(5px);
    }
    
    #lmenu .list-group-item.active {
        background-color: rgba(255,255,255,0.4);
        color: #dc3545;
        font-weight: bold;
        border-left: 4px solid #dc3545;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.1);
    }
    
    #lmenu .list-group-item:last-child {
        border-bottom: none;
    }
    
    #lmenu .fas {
        width: 20px;
        text-align: center;
    }
</style>