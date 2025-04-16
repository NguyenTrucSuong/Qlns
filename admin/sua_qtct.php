<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM quatrinhcongtac WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_nhan_vien = $_POST['id_nhan_vien'];
        $ngay_bat_dau = $_POST['ngay_bat_dau'];
        $ngay_ket_thuc = $_POST['ngay_ket_thuc'];
        $chuc_vu = $_POST['chuc_vu'];
        $don_vi_lam_viec = $_POST['don_vi_lam_viec'];

     
        $update_sql = "UPDATE quatrinhcongtac SET 
                        id_nhan_vien = '$id_nhan_vien',
                        ngay_bat_dau = '$ngay_bat_dau',
                        ngay_ket_thuc = '$ngay_ket_thuc',
                        chuc_vu = '$chuc_vu',
                        don_vi_lam_viec = '$don_vi_lam_viec'
                        WHERE id = $id";
        if ($conn->query($update_sql) === TRUE) {
            header('Location: quanly_qtct.php');
            exit;
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
}


$sql_nv = "SELECT id, ho_ten FROM nhanvien";
$result_nv = $conn->query($sql_nv);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Quá Trình Công Tác</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ADD8E6; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Sửa Quá Trình Công Tác</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="id_nhan_vien" class="form-label">Chọn Nhân Viên</label>
                <select class="form-select" id="id_nhan_vien" name="id_nhan_vien" required>
                    <?php
                    while ($row_nv = $result_nv->fetch_assoc()) {
                        $selected = ($row_nv['id'] == $row['id_nhan_vien']) ? 'selected' : '';
                        echo "<option value='" . $row_nv["id"] . "' $selected>" . $row_nv["ho_ten"] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="ngay_bat_dau" class="form-label">Ngày Bắt Đầu</label>
                <input type="date" class="form-control" id="ngay_bat_dau" name="ngay_bat_dau" value="<?php echo $row['ngay_bat_dau']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="ngay_ket_thuc" class="form-label">Ngày Kết Thúc</label>
                <input type="date" class="form-control" id="ngay_ket_thuc" name="ngay_ket_thuc" value="<?php echo $row['ngay_ket_thuc']; ?>">
            </div>
            <div class="mb-3">
                <label for="chuc_vu" class="form-label">Chức Vụ</label>
                <input type="text" class="form-control" id="chuc_vu" name="chuc_vu" value="<?php echo $row['chuc_vu']; ?>">
            </div>
            <div class="mb-3">
                <label for="don_vi_lam_viec" class="form-label">Đơn Vị Làm Việc</label>
                <input type="text" class="form-control" id="don_vi_lam_viec" name="don_vi_lam_viec" value="<?php echo $row['don_vi_lam_viec']; ?>">
            </div>
            <button type="submit" class="btn btn-warning">Cập Nhật</button>
            <a href="quanly_qtct.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
