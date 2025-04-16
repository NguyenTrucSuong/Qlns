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

$thongBao = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_nhan_vien = $_POST['id_nhan_vien'];
    $ngay_bat_dau = $_POST['ngay_bat_dau'];
    $ngay_ket_thuc = $_POST['ngay_ket_thuc'];
    $chuc_vu = $_POST['chuc_vu'];
    $don_vi_lam_viec = $_POST['don_vi_lam_viec'];

    $sql = "INSERT INTO quatrinhcongtac (id_nhan_vien, ngay_bat_dau, ngay_ket_thuc, chuc_vu, don_vi_lam_viec)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $id_nhan_vien, $ngay_bat_dau, $ngay_ket_thuc, $chuc_vu, $don_vi_lam_viec);

    if ($stmt->execute()) {
        $thongBao = "<div class='alert alert-success'>Thêm quá trình công tác thành công!</div>";
    } else {
        $thongBao = "<div class='alert alert-danger'>Lỗi: " . $stmt->error . "</div>";
    }
}


$nhanvienResult = $conn->query("SELECT id, ho_ten FROM nhanvien ORDER BY ho_ten ASC");
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm quá trình công tác</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        background: linear-gradient(to right, #e0f7fa, #ffffff);
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 700px;
        margin-top: 50px;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        background-color: #17a2b8;
        color: white;
        font-weight: bold;
        font-size: 20px;
        text-align: center;
    }

    .btn {
        border-radius: 30px;
        padding: 6px 14px;
        font-size: 14px;
    }

    label {
        font-weight: 500;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Thêm quá trình công tác
            </div>
            <div class="card-body">
                <?php echo $thongBao; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="id_nhan_vien" class="form-label">Nhân viên</label>
                        <select name="id_nhan_vien" id="id_nhan_vien" class="form-select" required>
                            <option value="">-- Chọn nhân viên --</option>
                            <?php while ($row = $nhanvienResult->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['ho_ten']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="ngay_bat_dau" class="form-label">Ngày bắt đầu</label>
                        <input type="date" name="ngay_bat_dau" id="ngay_bat_dau" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="ngay_ket_thuc" class="form-label">Ngày kết thúc</label>
                        <input type="date" name="ngay_ket_thuc" id="ngay_ket_thuc" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="chuc_vu" class="form-label">Chức vụ</label>
                        <input type="text" name="chuc_vu" id="chuc_vu" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="don_vi_lam_viec" class="form-label">Đơn vị làm việc</label>
                        <input type="text" name="don_vi_lam_viec" id="don_vi_lam_viec" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="quanly_qtct.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay
                            lại</a>
                        <button type="submit" class="btn btn-success"><i class="bi bi-save2"></i> Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php $conn->close(); ?>