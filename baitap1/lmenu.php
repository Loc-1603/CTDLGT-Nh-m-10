<?php
    require "data.php";
    $current = isset($_GET['gr']) ? $_GET['gr'] : '';
?>
<ul style="list-style: none; padding: 10px; margin: 0;">
<?php
    foreach ($data as $menuitem => $value) {
        $active = ($current == $menuitem) ? 'class="active"' : '';
        echo "<li><a href='index.php?gr=" . $menuitem . "' " . $active . ">" . $menuitem . "</a></li>";
    }
    // Thêm mục "PC AIO" như trong hình
    echo "<li><a href='#'>PC AIO</a></li>";
?>
</ul>
<style>
    #lmenu ul li {
        margin-bottom: 5px;
    }
    #lmenu a {
        text-decoration: none;
        color: #000;
        display: block;
        padding: 5px;
        border-radius: 3px;
    }
    #lmenu a:hover {
        background-color: rgba(255,255,255,0.3);
    }
    #lmenu a.active {
        font-weight: bold;
        color: red;
        background-color: rgba(255,255,255,0.2);
    }
</style>