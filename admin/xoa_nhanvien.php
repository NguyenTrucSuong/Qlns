<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');


if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $sql_delete = "DELETE FROM nhanvien WHERE id = $id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Xóa nhân viên thành công!";
        header('Location: quanly_nhanvien.php');
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "ID không hợp lệ.";
}


$conn->close();
?>
