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

    $sql = "SELECT * FROM chitietkhenthuong_kyluat WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_nhan_vien = $row['id_nhan_vien'];
        $id_danh_muc_ktkl = $row['id_danh_muc_ktkl'];
        $ngay_ly_do = $row['ngay_ly_do'];
        $mo_ta = $row['mo_ta'];
    } else {
        echo "Không tìm thấy chi tiết khen thưởng kỷ luật.";
        exit;
    }
} else {
    echo "ID không hợp lệ.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_nhan_vien = $_POST['id_nhan_vien'];
    $id_danh_muc_ktkl = $_POST['id_danh_muc_ktkl'];
    $ngay_ly_do = $_POST['ngay_ly_do'];
    $mo_ta = $_POST['mo_ta'];

    $update_sql = "UPDATE chitietkhenthuong_kyluat 
                    SET id_nhan_vien = $id_nhan_vien, id_danh_muc_ktkl = $id_danh_muc_ktkl, ngay_ly_do = '$ngay_ly_do', mo_ta = '$mo_ta' 
                    WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Cập nhật chi tiết khen thưởng kỷ luật thành công!'); window.location.href='quanly_ctktkl.php';</script>";
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
    <title>Sửa Chi Tiết Khen Thưởng Kỷ Luật</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ADD8E6; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Sửa Chi Tiết Khen Thưởng Kỷ Luật</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="id_nhan_vien" class="form-label">Nhân Viên</label>
                <select id="id_nhan_vien" name="id_nhan_vien" class="form-control" required>
                    <?php
                  
                    $conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');
                    $sql_nhanvien = "SELECT id, ho_ten FROM nhanvien";
                    $result_nhanvien = $conn->query($sql_nhanvien);
                    while ($row_nhanvien = $result_nhanvien->fetch_assoc()) {
                        $selected = ($row_nhanvien['id'] == $id_nhan_vien) ? 'selected' : '';
                        echo "<option value='" . $row_nhanvien['id'] . "' $selected>" . $row_nhanvien['ho_ten'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_danh_muc_ktkl" class="form-label">Danh Mục Khen Thưởng/Kỷ Luật</label>
                <select id="id_danh_muc_ktkl" name="id_danh_muc_ktkl" class="form-control" required>
                    <?php
                    
                    $sql_danhmuc = "SELECT id, ten_danh_muc FROM danhmuckhenthuong_kyluat";
                    $result_danhmuc = $conn->query($sql_danhmuc);
                    while ($row_danhmuc = $result_danhmuc->fetch_assoc()) {
                        $selected = ($row_danhmuc['id'] == $id_danh_muc_ktkl) ? 'selected' : '';
                        echo "<option value='" . $row_danhmuc['id'] . "' $selected>" . $row_danhmuc['ten_danh_muc'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="ngay_ly_do" class="form-label">Ngày Lý Do</label>
                <input type="date" id="ngay_ly_do" name="ngay_ly_do" class="form-control" value="<?php echo $ngay_ly_do; ?>" required>
            </div>

            <div class="mb-3">
                <label for="mo_ta" class="form-label">Mô Tả</label>
                <textarea id="mo_ta" name="mo_ta" class="form-control" rows="4"><?php echo $mo_ta; ?></textarea>
            </div>

            <button type="submit" class="btn btn-success">Cập Nhật</button>
            <a href="quanly_ctktkl.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
