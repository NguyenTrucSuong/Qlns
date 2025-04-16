<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');

if (isset($_POST['id']) && isset($_POST['new_donvi'])) {
    $id = intval($_POST['id']);
    $new_donvi = intval($_POST['new_donvi']);


    $stmt = $conn->prepare("SELECT id FROM donvi WHERE id = ?");
    $stmt->bind_param("i", $new_donvi);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo "Đơn vị thay thế không tồn tại!";
        exit;
    }


    $stmt_update = $conn->prepare("UPDATE nhanvien SET id_don_vi = ? WHERE id_don_vi = ?");
    $stmt_update->bind_param("ii", $new_donvi, $id);
    $stmt_update->execute();

    
    $stmt_delete = $conn->prepare("DELETE FROM donvi WHERE id = ?");
    $stmt_delete->bind_param("i", $id);
    if ($stmt_delete->execute()) {
        header("Location: quanly_donvi.php");
        exit;
    } else {
        echo "Lỗi khi xóa đơn vị: " . $stmt_delete->error;
    }
} else {
    echo "Thiếu dữ liệu đầu vào!";
}

$conn->close();