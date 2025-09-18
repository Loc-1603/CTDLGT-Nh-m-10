<?php
// Cải thiện cấu hình session để hoạt động ổn định hơn
ini_set('session.cookie_lifetime', 86400); // 24 giờ
ini_set('session.gc_maxlifetime', 86400);  // 24 giờ
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);

// Đặt tên session riêng để tránh conflict
session_name('NHANVIEN_SESSION');

// Khởi động session
session_start();

// Debug: Kiểm tra session
if (isset($_GET['debug'])) {
    echo "<h3>Session Debug Info:</h3>";
    echo "Session ID: " . session_id() . "<br>";
    echo "Session Save Path: " . session_save_path() . "<br>";
    echo "Session Status: " . session_status() . "<br>";
    echo "Cookie Lifetime: " . ini_get('session.cookie_lifetime') . "<br>";
    echo "GC Maxlifetime: " . ini_get('session.gc_maxlifetime') . "<br>";
    echo "Session Data: <pre>" . print_r($_SESSION, true) . "</pre>";
    exit;
}

// Khởi tạo dữ liệu với key cụ thể
$sessionKey = 'dsNhanVien_v2'; // Thêm version để tránh conflict

if (!isset($_SESSION[$sessionKey])) {
    $_SESSION[$sessionKey] = array(
        array("id" => 1, "hoten" => "Nguyen Van A", "tuoi" => 22, "hsl" => 3.2, "mucluongcoso" => 5000000),
        array("id" => 2, "hoten" => "Tran Thi B", "tuoi" => 24, "hsl" => 2.8, "mucluongcoso" => 4800000),
        array("id" => 3, "hoten" => "Le Van C", "tuoi" => 26, "hsl" => 3.5, "mucluongcoso" => 5200000)
    );
    
    // Lưu thời gian khởi tạo
    $_SESSION['init_time'] = time();
}

// Xử lý các action từ JavaScript
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'get_data') {
        $data = $_SESSION[$sessionKey] ?? [];
        $response = [
            'data' => $data,
            'session_id' => session_id(),
            'init_time' => $_SESSION['init_time'] ?? 0,
            'current_time' => time()
        ];
        echo json_encode($response);
        exit;
    }
    elseif ($action === 'add') {
        $hoten = trim($_POST['hoten'] ?? '');
        $tuoi = intval($_POST['tuoi'] ?? 0);
        $hsl = floatval($_POST['hsl'] ?? 0);
        $mucluongcoso = intval($_POST['mucluongcoso'] ?? 0);
        
        if (!empty($hoten) && $tuoi > 0 && $hsl > 0 && $mucluongcoso > 0) {
            $dsNhanVien = $_SESSION[$sessionKey] ?? [];
            $newId = count($dsNhanVien) > 0 ? max(array_column($dsNhanVien, 'id')) + 1 : 1;
            $newEmployee = [
                'id' => $newId, 
                'hoten' => $hoten, 
                'tuoi' => $tuoi, 
                'hsl' => $hsl, 
                'mucluongcoso' => $mucluongcoso
            ];
            $dsNhanVien[] = $newEmployee;
            $_SESSION[$sessionKey] = $dsNhanVien;
            
            // Force session write
            session_write_close();
            session_start();
            
            echo json_encode(['success' => true, 'message' => 'Đã thêm nhân viên thành công!', 'data' => $newEmployee]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ!']);
        }
        exit;
    }
    elseif ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        
        if ($id > 0) {
            $dsNhanVien = $_SESSION[$sessionKey] ?? [];
            $foundIndex = -1;
            foreach ($dsNhanVien as $index => $nhanVien) {
                if ($nhanVien['id'] === $id) {
                    $foundIndex = $index;
                    break;
                }
            }
            
            if ($foundIndex >= 0) {
                array_splice($dsNhanVien, $foundIndex, 1);
                $_SESSION[$sessionKey] = $dsNhanVien;
                
                // Force session write
                session_write_close();
                session_start();
                
                echo json_encode(['success' => true, 'message' => 'Đã xóa nhân viên thành công!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy nhân viên!']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID không hợp lệ!']);
        }
        exit;
    }
    elseif ($action === 'check_session') {
        $response = [
            'session_active' => session_status() === PHP_SESSION_ACTIVE,
            'session_id' => session_id(),
            'data_count' => count($_SESSION[$sessionKey] ?? []),
            'init_time' => $_SESSION['init_time'] ?? 0,
            'current_time' => time()
        ];
        echo json_encode($response);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quản lý Nhân viên - Session Improved</title>
<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f0f0f0; }
    #app { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 1000px; margin: 0 auto; }
    h2 { color: #333; text-align: center; margin-bottom: 30px; }
    .debug-info { background: #e7f3ff; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 12px; }
    .input-group { display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; justify-content: center; align-items: center; }
    input { padding: 10px 14px; border: 1px solid #ddd; border-radius: 4px; width: 180px; font-size: 14px; }
    input:focus { outline: none; border-color: #4CAF50; box-shadow: 0 0 5px rgba(76, 175, 80, 0.3); }
    button { padding: 10px 16px; cursor: pointer; border-radius: 5px; border: none; background: #4CAF50; color: white; font-size: 14px; transition: all 0.3s ease; }
    button:hover { opacity: 0.9; transform: translateY(-1px); }
    .btn-group { display: flex; gap: 10px; justify-content: center; margin: 15px 0; flex-wrap: wrap; }
    .btn-load { background: #2196F3; }
    .btn-random { background: #9C27B0; }
    .btn-evenodd { background: #FF9800; }
    .btn-debug { background: #607D8B; }
    #message { color: green; font-weight: bold; margin: 10px 0; padding: 12px; background: #dff0d8; border-radius: 4px; display: none; text-align: center; border-left: 4px solid #4CAF50; }
    .error { color: #d9534f; background: #f2dede; border-left-color: #d9534f; }
    table { border-collapse: collapse; margin-top: 15px; width: 100%; background: white; font-size: 14px; }
    th, td { border: 1px solid #ddd; padding: 12px; text-align: center; }
    th { background: #f8f9fa; font-weight: bold; color: #333; }
    tr:nth-child(even) { background-color: #f9f9f9; }
    tr:hover { background-color: #f5f5f5; }
    .delete-btn { background: #dc3545; color: white; border: none; padding: 6px 12px; cursor: pointer; border-radius: 4px; font-size: 12px; }
    .delete-btn:hover { background: #c82333; }
    .placeholder { text-align: center; color: #777; padding: 40px; background: #f8f9fa; border-radius: 8px; border: 2px dashed #ddd; }
    .status-info { text-align: center; color: #666; font-style: italic; margin-bottom: 10px; }
    .session-status { background: #fff3cd; padding: 10px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #ffeaa7; }
</style>
</head>
<body>
    <div id="app">
        <h2>📊 Hệ Thống Quản lý Nhân viên</h2>
        
        <div class="session-status">
            <div id="session-info">🔄 Đang kiểm tra session...</div>
        </div>
        
        <div class="input-group">
            <input type="text" id="hoten" placeholder="Họ và tên" maxlength="100">
            <input type="number" id="tuoi" placeholder="Tuổi" min="18" max="100">
            <input type="number" id="hsl" placeholder="Hệ số lương" step="0.1" min="0.1" max="10">
            <input type="number" id="mucluongcoso" placeholder="Mức lương cơ sở" min="1000000" max="100000000">
            <button onclick="addNhanVien()">➕ Thêm nhân viên</button>
        </div>
        
        <div id="message"></div>
        
        <div class="btn-group">
            <button class="btn-load" onclick="loadTable()">🔄 Tải dữ liệu</button>
            <button class="btn-random" onclick="setRandomColors()">🎨 Màu ngẫu nhiên</button>
            <button class="btn-evenodd" onclick="setEvenOddColors()">📋 Màu chẵn/lẻ</button>
            <button class="btn-debug" onclick="checkSession()">🔍 Kiểm tra Session</button>
        </div>
        
        <div id="table-container">
            <p class="placeholder">🔍 Đang tải dữ liệu nhân viên...</p>
        </div>
    </div>

<script>
let nhanVienArr = [];
let tableLoaded = false;
let sessionInfo = {};

function showMessage(message, type = 'success') {
    const messageEl = document.getElementById('message');
    messageEl.innerText = message;
    messageEl.className = type === 'error' ? 'error' : '';
    messageEl.style.display = 'block';
    
    setTimeout(() => {
        messageEl.style.display = 'none';
    }, 4000);
}

function updateSessionInfo(info) {
    sessionInfo = info;
    const sessionInfoEl = document.getElementById('session-info');
    if (sessionInfoEl && info) {
        const uptime = info.current_time - info.init_time;
        sessionInfoEl.innerHTML = `
            📡 Session: ${info.session_id ? info.session_id.substring(0, 8) + '...' : 'N/A'} | 
            📊 Dữ liệu: ${info.data_count || 0} nhân viên | 
            ⏰ Hoạt động: ${Math.floor(uptime / 60)} phút
        `;
    }
}

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
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(result => {
        if (callback) callback(result);
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Có lỗi xảy ra khi kết nối đến server!', 'error');
    });
}

function validateInput(hoten, tuoi, hsl, mucluongcoso) {
    if (!hoten || hoten.length < 2) return 'Họ tên phải có ít nhất 2 ký tự!';
    if (tuoi < 18 || tuoi > 100) return 'Tuổi phải từ 18 đến 100!';
    if (hsl < 0.1 || hsl > 10) return 'Hệ số lương phải từ 0.1 đến 10!';
    if (mucluongcoso < 1000000 || mucluongcoso > 100000000) return 'Mức lương cơ sở phải từ 1,000,000 đến 100,000,000 VNĐ!';
    return null;
}

function addNhanVien() {
    const hoten = document.getElementById("hoten").value.trim();
    const tuoi = parseInt(document.getElementById("tuoi").value.trim());
    const hsl = parseFloat(document.getElementById("hsl").value.trim());
    const mucluongcoso = parseInt(document.getElementById("mucluongcoso").value.trim());

    const validationError = validateInput(hoten, tuoi, hsl, mucluongcoso);
    if (validationError) {
        showMessage(validationError, "error");
        return;
    }

    if (nhanVienArr.some(nv => nv.hoten.toLowerCase() === hoten.toLowerCase())) {
        showMessage("Tên nhân viên đã tồn tại!", "error");
        return;
    }

    sendRequest('add', { hoten, tuoi, hsl, mucluongcoso }, function(result) {
        if (result.success) {
            showMessage(result.message);
            document.getElementById("hoten").value = "";
            document.getElementById("tuoi").value = "";
            document.getElementById("hsl").value = "";
            document.getElementById("mucluongcoso").value = "";
            loadTable();
        } else {
            showMessage(result.message, "error");
        }
    });
}

function loadTable() {
    sendRequest('get_data', {}, function(response) {
        nhanVienArr = response.data || [];
        tableLoaded = true;
        updateSessionInfo(response);
        renderTable();
        showMessage(`Đã tải ${nhanVienArr.length} nhân viên thành công!`);
    });
}

function renderTable() {
    const tableContainer = document.getElementById('table-container');
    
    if (!tableLoaded || nhanVienArr.length === 0) {
        tableContainer.innerHTML = '<p class="placeholder">📝 Không có dữ liệu nhân viên. Vui lòng thêm nhân viên mới.</p>';
        return;
    }

    let html = `
        <table>
            <thead>
                <tr>
                    <th>🆔 ID</th>
                    <th>👤 Họ tên</th>
                    <th>🎂 Tuổi</th>
                    <th>📊 Hệ số lương</th>
                    <th>💰 Mức lương cơ sở</th>
                    <th>💵 Mức lương</th>
                    <th>⚙️ Thao tác</th>
                </tr>
            </thead>
            <tbody>
    `;

    nhanVienArr.forEach(nv => {
        const mucluong = nv.hsl * (nv.mucluongcoso || 0);
        html += `
            <tr id="row-${nv.id}">
                <td>${nv.id}</td>
                <td><strong>${nv.hoten}</strong></td>
                <td>${nv.tuoi}</td>
                <td>${nv.hsl.toFixed(1)}</td>
                <td>${(nv.mucluongcoso || 0).toLocaleString('vi-VN')} VNĐ</td>
                <td><strong>${mucluong.toLocaleString('vi-VN')} VNĐ</strong></td>
                <td><button class="delete-btn" onclick="deleteNhanVien(${nv.id})" title="Xóa nhân viên">🗑️ Xóa</button></td>
            </tr>
        `;
    });
    
    html += '</tbody></table>';
    
    const totalSalary = nhanVienArr.reduce((sum, nv) => sum + (nv.hsl * nv.mucluongcoso), 0);
    const avgAge = nhanVienArr.reduce((sum, nv) => sum + nv.tuoi, 0) / nhanVienArr.length;
    
    html += `
        <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; text-align: center;">
            <strong>📈 Thống kê:</strong> 
            Tổng số nhân viên: <strong>${nhanVienArr.length}</strong> | 
            Tổng lương: <strong>${totalSalary.toLocaleString('vi-VN')} VNĐ</strong> | 
            Tuổi trung bình: <strong>${avgAge.toFixed(1)}</strong>
        </div>
    `;
    
    tableContainer.innerHTML = html;
}

function deleteNhanVien(id) {
    const employee = nhanVienArr.find(nv => nv.id === id);
    if (!employee) {
        showMessage("Không tìm thấy nhân viên!", "error");
        return;
    }
    
    if (confirm(`Bạn có chắc chắn muốn xóa nhân viên "${employee.hoten}"?`)) {
        sendRequest('delete', { id }, function(result) {
            if (result.success) {
                showMessage(result.message);
                loadTable();
            } else {
                showMessage(result.message, "error");
            }
        });
    }
}

function checkSession() {
    sendRequest('check_session', {}, function(result) {
        let message = `Session Status:\n`;
        message += `- Active: ${result.session_active ? 'Yes' : 'No'}\n`;
        message += `- ID: ${result.session_id}\n`;
        message += `- Data Count: ${result.data_count}\n`;
        message += `- Uptime: ${Math.floor((result.current_time - result.init_time) / 60)} minutes`;
        alert(message);
        
        if (!result.session_active || result.data_count === 0) {
            showMessage('Session có vấn đề! Đang tải lại dữ liệu...', 'error');
            loadTable();
        }
    });
}

function setRandomColors() {
    if (!tableLoaded || nhanVienArr.length === 0) {
        showMessage("Vui lòng tải dữ liệu trước khi áp dụng màu!", "error");
        return;
    }
    
    const rows = document.querySelectorAll("#table-container table tbody tr");
    const colors = ['#ffebee', '#f3e5f5', '#e8eaf6', '#e3f2fd', '#e0f2f1', '#f9fbe7', '#fff3e0', '#fce4ec'];
    rows.forEach(row => {
        row.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        row.style.color = '#000';
    });
    showMessage("Đã áp dụng màu ngẫu nhiên!");
}

function setEvenOddColors() {
    if (!tableLoaded || nhanVienArr.length === 0) {
        showMessage("Vui lòng tải dữ liệu trước khi áp dụng màu!", "error");
        return;
    }
    
    const rows = document.querySelectorAll("#table-container table tbody tr");
    rows.forEach((row, i) => {
        row.style.backgroundColor = i % 2 === 0 ? "#f0f8ff" : "#ffffff";
        row.style.color = '#000';
    });
    showMessage("Đã áp dụng màu chẵn/lẻ!");
}

// Auto-refresh session info
setInterval(() => {
    if (tableLoaded) {
        sendRequest('check_session', {}, function(result) {
            updateSessionInfo(result);
        });
    }
}, 30000); // Check every 30 seconds

document.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        const activeElement = document.activeElement;
        if (['hoten', 'tuoi', 'hsl', 'mucluongcoso'].includes(activeElement.id)) {
            addNhanVien();
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    showMessage("🔄 Đang tải dữ liệu...", "success");
    loadTable();
});
</script>

<!-- Debug Link -->
<div style="text-align: center; margin-top: 20px; font-size: 12px;">
    <a href="?debug=1" target="_blank">🔍 Xem thông tin debug session</a>
</div>

</body>
</html>
