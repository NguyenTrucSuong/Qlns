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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ho_ten = $_POST['ho_ten'];
    $chuc_vu = $_POST['chuc_vu'];
    $ngay_sinh = $_POST['ngay_sinh'];
    $id_don_vi = $_POST['id_don_vi'];
    $id_bang_cap = $_POST['id_bang_cap'];

    $sql_insert = "INSERT INTO nhanvien (ho_ten, chuc_vu, ngay_sinh, id_don_vi, id_bang_cap)
                   VALUES ('$ho_ten', '$chuc_vu', '$ngay_sinh', $id_don_vi, $id_bang_cap)";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Thêm nhân viên thành công!";
        header('Location: quanly_nhanvien.php');
        exit;
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
    <title>Thêm nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #ADD8E6;
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Thêm nhân viên mới</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="ho_ten" class="form-label">Họ Tên</label>
                <input type="text" class="form-control" id="ho_ten" name="ho_ten" required>
            </div>
            <div class="mb-3">
                <label for="chuc_vu" class="form-label">Chức Vụ</label>
                <input type="text" class="form-control" id="chuc_vu" name="chuc_vu" required>
            </div>
            <div class="mb-3">
                <label for="ngay_sinh" class="form-label">Ngày Sinh</label>
                <input type="date" class="form-control" id="ngay_sinh" name="ngay_sinh" required>
            </div>
            <div class="mb-3">
                <label for="id_don_vi" class="form-label">Đơn Vị</label>
                <select class="form-control" id="id_don_vi" name="id_don_vi" required>
                    <option value="">Chọn đơn vị</option>
                    <?php
                    $sql_don_vi = "SELECT * FROM donvi";
                    $result_don_vi = $conn->query($sql_don_vi);
                    while ($don_vi = $result_don_vi->fetch_assoc()) {
                        echo "<option value='" . $don_vi['id'] . "'>" . $don_vi['ten_don_vi'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_bang_cap" class="form-label">Bằng Cấp</label>
                <select class="form-control" id="id_bang_cap" name="id_bang_cap" required>
                    <option value="">Chọn bằng cấp</option>
                    <?php
                    $sql_bang_cap = "SELECT * FROM bangcap";
                    $result_bang_cap = $conn->query($sql_bang_cap);
                    while ($bang_cap = $result_bang_cap->fetch_assoc()) {
                        echo "<option value='" . $bang_cap['id'] . "'>" . $bang_cap['ten_bang_cap'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Thêm nhân viên</button>
            <a href="quanly_nhanvien.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>