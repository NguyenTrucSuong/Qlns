<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_don_vi = $_POST['ten_don_vi'];


    $sql = "INSERT INTO donvi (ten_don_vi) VALUES ('$ten_don_vi')";
    if ($conn->query($sql) === TRUE) {
        header('Location: quanly_donvi.php'); 
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Đơn Vị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ADD8E6; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Thêm Đơn Vị</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="ten_don_vi" class="form-label">Tên Đơn Vị</label>
                <input type="text" class="form-control" id="ten_don_vi" name="ten_don_vi" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
            <a href="quanly_donvi.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
