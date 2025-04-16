<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');


$id = $_GET['id'];

$sql = "DELETE FROM loaihinhdaotao WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    header('Location: quanly_lhdt.php');
    exit;
} else {
    echo "Lỗi: " . $conn->error;
}


$conn->close();
?>
