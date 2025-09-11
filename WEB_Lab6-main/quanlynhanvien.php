<?php
// Khởi động session để lưu trữ dữ liệu
session_start();

// Khởi tạo dữ liệu nếu chưa có
if (!isset($_SESSION['dsNhanVien'])) {
    $_SESSION['dsNhanVien'] = array(
        array("id" => 1, "hoten" => "Nguyen Van A", "tuoi" => 22, "hsl" => 3.2),
        array("id" => 2, "hoten" => "Tran Thi B", "tuoi" => 24, "hsl" => 2.8),
        array("id" => 3, "hoten" => "Le Van C", "tuoi" => 26, "hsl" => 3.5)
    );
}

// Xử lý các action từ JavaScript
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'get_data') {
        echo json_encode($_SESSION['dsNhanVien']);
        exit;
    }
    elseif ($action === 'add') {
        $hoten = $_POST['hoten'] ?? '';
        $tuoi = intval($_POST['tuoi'] ?? 0);
        $hsl = floatval($_POST['hsl'] ?? 0);
        
        if (!empty($hoten) && $tuoi > 0 && $hsl > 0) {
            $dsNhanVien = $_SESSION['dsNhanVien'];
            $newId = count($dsNhanVien) > 0 ? max(array_column($dsNhanVien, 'id')) + 1 : 1;
            $newEmployee = ['id' => $newId, 'hoten' => $hoten, 'tuoi' => $tuoi, 'hsl' => $hsl];
            $dsNhanVien[] = $newEmployee;
            $_SESSION['dsNhanVien'] = $dsNhanVien;
            
            echo json_encode(['success' => true, 'message' => 'Đã thêm nhân viên thành công!', 'data' => $newEmployee]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ!']);
        }
        exit;
    }
    elseif ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        
        if ($id > 0) {
            $dsNhanVien = $_SESSION['dsNhanVien'];
            $foundIndex = -1;
            foreach ($dsNhanVien as $index => $nhanVien) {
                if ($nhanVien['id'] === $id) {
                    $foundIndex = $index;
                    break;
                }
            }
            
            if ($foundIndex >= 0) {
                array_splice($dsNhanVien, $foundIndex, 1);
                $_SESSION['dsNhanVien'] = $dsNhanVien;
                echo json_encode(['success' => true, 'message' => 'Đã xóa nhân viên thành công!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy nhân viên!']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID không hợp lệ!']);
        }
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Nhân viên</title>
<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f0f0f0; }
    #app { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 900px; margin: 0 auto; }
    h2 { color: #333; text-align: center; }
    .input-group { display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; justify-content: center; }
    input { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; width: 180px; }
    button { padding: 8px 14px; cursor: pointer; border-radius: 5px; border: none; background: #4CAF50; color: white; }
    button:hover { opacity: 0.9; }
    .btn-group { display: flex; gap: 10px; justify-content: center; margin: 15px 0; flex-wrap: wrap; }
    .btn-load { background: #2196F3; }
    .btn-random { background: #9C27B0; }
    .btn-evenodd { background: #FF9800; }
    #message { color: green; font-weight: bold; margin: 10px 0; padding: 10px; background: #dff0d8; border-radius: 4px; display: none; text-align: center; }
    .error { color: #d9534f; background: #f2dede; }
    table { border-collapse: collapse; margin-top: 15px; width: 100%; background: white; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background: #f2f2f2; }
    .delete-btn { background: red; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px; }
    .delete-btn:hover { background: darkred; }
    .placeholder { text-align: center; color: #777; padding: 30px; }
</style>
</head>
<body>
    <div id="app">
        <h2>Quản lý Nhân viên</h2>
        <div class="input-group">
            <input type="text" id="hoten" placeholder="Họ tên">
            <input type="number" id="tuoi" placeholder="Tuổi">
            <input type="number" id="hsl" placeholder="Hệ số lương" step="0.1">
            <button onclick="addNhanVien()">Thêm nhân viên</button>
        </div>
        <div id="message"></div>
        <div class="btn-group">
            <button class="btn-load" onclick="loadTable()">Tải dữ liệu</button>
            <button class="btn-random" onclick="setRandomColors()">Màu ngẫu nhiên</button>
            <button class="btn-evenodd" onclick="setEvenOddColors()">Màu chẵn/lẻ</button>
        </div>
        <div id="table-container">
            <p class="placeholder">Không có dữ liệu nhân viên. Vui lòng tải dữ liệu hoặc thêm nhân viên mới.</p>
        </div>
    </div>

<script>
// JavaScript xử lý giao diện và tương tác
let nhanVienArr = [];
let tableLoaded = false;

// Hiển thị thông báo
function showMessage(message, type = 'success') {
    const messageEl = document.getElementById('message');
    messageEl.innerText = message;
    messageEl.className = type === 'error' ? 'error' : '';
    messageEl.style.display = 'block';
    
    setTimeout(() => {
        messageEl.style.display = 'none';
    }, 3000);
}

// Gửi request đến server
function sendRequest(action, data = {}, callback) {
    const formData = new FormData();
    formData.append('action', action);
    
    for (const key in data) {
        formData.append(key, data[key]);
    }
    
    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (callback) callback(result);
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Có lỗi xảy ra khi kết nối đến server!', 'error');
    });
}

// Thêm nhân viên
function addNhanVien() {
    const hoten = document.getElementById("hoten").value.trim();
    const tuoi = document.getElementById("tuoi").value.trim();
    const hsl = document.getElementById("hsl").value.trim();

    if (!hoten || !tuoi || !hsl) {
        showMessage("Vui lòng nhập đầy đủ thông tin!", "error");
        return;
    }

    sendRequest('add', { hoten, tuoi, hsl }, function(result) {
        if (result.success) {
            showMessage(result.message);
            document.getElementById("hoten").value = "";
            document.getElementById("tuoi").value = "";
            document.getElementById("hsl").value = "";
            
            if (tableLoaded) {
                nhanVienArr.push(result.data);
                renderTable();
            }
        } else {
            showMessage(result.message, "error");
        }
    });
}

// Tải dữ liệu từ server
function loadTable() {
    sendRequest('get_data', {}, function(data) {
        nhanVienArr = data;
        tableLoaded = true;
        renderTable();
        showMessage('Dữ liệu đã được tải thành công!');
    });
}

// Hiển thị bảng dữ liệu
function renderTable() {
    const tableContainer = document.getElementById('table-container');
    
    if (!tableLoaded || nhanVienArr.length === 0) {
        tableContainer.innerHTML = '<p class="placeholder">Không có dữ liệu nhân viên. Vui lòng thêm nhân viên mới.</p>';
        return;
    }

    let html = `
        <table>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Tuổi</th>
                <th>Hệ số lương</th>
                <th>Thao tác</th>
            </tr>
    `;
    
    nhanVienArr.forEach(nv => {
        html += `
            <tr id="row-${nv.id}">
                <td>${nv.id}</td>
                <td>${nv.hoten}</td>
                <td>${nv.tuoi}</td>
                <td>${nv.hsl.toFixed(1)}</td>
                <td><button class="delete-btn" onclick="deleteNhanVien(${nv.id})">Xóa</button></td>
            </tr>
        `;
    });
    
    html += '</table>';
    tableContainer.innerHTML = html;
}

// Xóa nhân viên
function deleteNhanVien(id) {
    if (confirm("Bạn có chắc chắn muốn xóa nhân viên này?")) {
        sendRequest('delete', { id }, function(result) {
            if (result.success) {
                showMessage(result.message);
                nhanVienArr = nhanVienArr.filter(nv => nv.id !== id);
                renderTable();
            } else {
                showMessage(result.message, "error");
            }
        });
    }
}

// Đổi màu ngẫu nhiên
function setRandomColors() {
    if (!tableLoaded) {
        showMessage("Vui lòng tải dữ liệu trước khi áp dụng màu!", "error");
        return;
    }
    
    const rows = document.querySelectorAll("#table-container table tr");
    rows.forEach((row, i) => {
        if (i === 0) return;
        row.style.backgroundColor = getRandomColor();
    });
}

function getRandomColor() {
    const letters = "0123456789ABCDEF";
    let color = "#";
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// Đổi màu chẵn lẻ
function setEvenOddColors() {
    if (!tableLoaded) {
        showMessage("Vui lòng tải dữ liệu trước khi áp dụng màu!", "error");
        return;
    }
    
    const rows = document.querySelectorAll("#table-container table tr");
    rows.forEach((row, i) => {
        if (i === 0) return;
        row.style.backgroundColor = i % 2 === 0 ? "#f9f9f9" : "#ffffff";
    });
}

// Tự động tải dữ liệu khi trang được tải
document.addEventListener('DOMContentLoaded', function() {
    loadTable();
});
</script>
</body>
</html>