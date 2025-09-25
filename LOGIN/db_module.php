<?php
// db_module.php
// dành cho project của bạn - không thay giao diện

function taoKetNoi(&$link) {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'login_db'; // đổi tên DB nếu bạn dùng tên khác

    $link = mysqli_connect($host, $user, $pass, $db);
    if (!$link) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }
    mysqli_set_charset($link, 'utf8');
    return true;
}

function giaiPhongBoNho(&$link, $close = true) {
    if (isset($link) && $link) {
        if ($close) mysqli_close($link);
        $link = null;
    }
    return true;
}

// INSERT/UPDATE/DELETE
function chayTruyVanKhongTraVeDL($link, $sql) {
    $res = mysqli_query($link, $sql);
    if (!$res) {
        error_log("MySQL error: " . mysqli_error($link) . " --- SQL: " . $sql);
    }
    return $res;
}

// SELECT (trả về mysqli_result hoặc false)
function chayTruyVanTraVeDL($link, $sql) {
    $res = mysqli_query($link, $sql);
    if (!$res) {
        error_log("MySQL error: " . mysqli_error($link) . " --- SQL: " . $sql);
        return false;
    }
    return $res;
}
?>
