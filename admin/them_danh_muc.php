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


if (isset($_POST['add'])) {
    $ten_danh_muc = $_POST['ten_danh_muc'];
    $sql = "INSERT INTO danhmuckhenthuong_kyluat (ten_danh_muc) VALUES ('$ten_danh_muc')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Danh mục đã được thêm thành công.'); window.location.href='quanly_dmktkl.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Danh Mục Khen Thưởng Kỷ Luật</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ADD8E6; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Thêm Danh Mục Khen Thưởng Kỷ Luật</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="ten_danh_muc" class="form-label">Tên danh mục</label>
                <input type="text" class="form-control" id="ten_danh_muc" name="ten_danh_muc" required>
            </div>
            <button type="submit" name="add" class="btn btn-success">Thêm</button>
            <a href="quanly_dmktkl.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
