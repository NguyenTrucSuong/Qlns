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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_nhan_vien = $_POST['id_nhan_vien'];
    $id_danh_muc_ktkl = $_POST['id_danh_muc_ktkl'];
    $ngay_ly_do = $_POST['ngay_ly_do'];
    $mo_ta = $_POST['mo_ta'];

    $sql = "INSERT INTO chitietkhenthuong_kyluat (id_nhan_vien, id_danh_muc_ktkl, ngay_ly_do, mo_ta) 
            VALUES ($id_nhan_vien, $id_danh_muc_ktkl, '$ngay_ly_do', '$mo_ta')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Chi tiết khen thưởng/kỷ luật đã được thêm thành công.'); window.location.href='quanly_ctktkl.php';</script>";
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
    <title>Thêm Chi Tiết Khen Thưởng Kỷ Luật</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ADD8E6; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Thêm Chi Tiết Khen Thưởng Kỷ Luật</h2>
        <form action="them_chitiet.php" method="POST">
            <div class="mb-3">
                <label for="id_nhan_vien" class="form-label">Chọn Nhân Viên</label>
                <select name="id_nhan_vien" id="id_nhan_vien" class="form-select" required>
                    <option value="">Chọn nhân viên</option>
                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');
                    $result = $conn->query("SELECT id, ho_ten FROM nhanvien");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['ho_ten'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_danh_muc_ktkl" class="form-label">Chọn Danh Mục Khen Thưởng/Kỷ Luật</label>
                <select name="id_danh_muc_ktkl" id="id_danh_muc_ktkl" class="form-select" required>
                    <option value="">Chọn danh mục</option>
                    <?php
                    $result = $conn->query("SELECT id, ten_danh_muc FROM danhmuckhenthuong_kyluat");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['ten_danh_muc'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="ngay_ly_do" class="form-label">Ngày Lý Do</label>
                <input type="date" name="ngay_ly_do" id="ngay_ly_do" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="mo_ta" class="form-label">Mô Tả</label>
                <textarea name="mo_ta" id="mo_ta" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
