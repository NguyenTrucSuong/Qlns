<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];

   
    $delete_sql = "DELETE FROM chitietkhenthuong_kyluat WHERE id = $id";

    if ($conn->query($delete_sql) === TRUE) {
       
        echo "<script>alert('Chi tiết khen thưởng/kỷ luật đã được xóa thành công.'); window.location.href='quanly_ctktkl.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "ID không hợp lệ.";
}

$conn->close();
?>
