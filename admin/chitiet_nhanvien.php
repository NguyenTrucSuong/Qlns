<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID nhân viên không hợp lệ.";
    exit;
}

$id = $_GET['id'];

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');

if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

$sql = "SELECT nhanvien.id, nhanvien.ho_ten, nhanvien.chuc_vu, nhanvien.ngay_sinh, nhanvien.dia_chi, nhanvien.so_dien_thoai, donvi.ten_don_vi, bangcap.ten_bang_cap, nhanvien.avatar
        FROM nhanvien
        JOIN donvi ON nhanvien.id_don_vi = donvi.id
        JOIN bangcap ON nhanvien.id_bang_cap = bangcap.id
        WHERE nhanvien.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Không tìm thấy nhân viên với ID: $id";
    exit;
}

$nhanvien = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Nhân Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ADD8E6;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 900px;
            margin-top: 50px;
        }

        .card {
            display: flex;
            flex-direction: row; 
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            padding: 15px;
            flex: 1;
        }

        .card-body {
            padding: 20px;
            flex: 3;
        }

        .avatar-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
            flex: 1;
        }

        .avatar-img {
            width: 150px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .btn {
            border-radius: 30px;
            padding: 8px 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">

            <div class="card-body">
                <div class="card-header">
                    Chi Tiết Nhân Viên
                </div>
                <h5 class="mb-4">Thông Tin Nhân Viên</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>Họ Tên</th>
                        <td><?php echo htmlspecialchars($nhanvien['ho_ten']); ?></td>
                    </tr>
                    <tr>
                        <th>Chức Vụ</th>
                        <td><?php echo htmlspecialchars($nhanvien['chuc_vu']); ?></td>
                    </tr>
                    <tr>
                        <th>Ngày Sinh</th>
                        <td><?php echo htmlspecialchars($nhanvien['ngay_sinh']); ?></td>
                    </tr>
                    <tr>
                        <th>Đơn Vị</th>
                        <td><?php echo htmlspecialchars($nhanvien['ten_don_vi']); ?></td>
                    </tr>
                    <tr>
                        <th>Bằng Cấp</th>
                        <td><?php echo htmlspecialchars($nhanvien['ten_bang_cap']); ?></td>
                    </tr>
                    <tr>
                        <th>Địa Chỉ</th>
                        <td><?php echo htmlspecialchars($nhanvien['dia_chi']); ?></td>
                    </tr>
                    <tr>
                        <th>Số Điện Thoại</th>
                        <td><?php echo htmlspecialchars($nhanvien['so_dien_thoai']); ?></td>
                    </tr>
                </table>
                <a href="quanly_nhanvien.php" class="btn btn-primary">Quay lại danh sách</a>
            </div>

            <div class="avatar-container">
                <?php if ($nhanvien['avatar']): ?>
                    <img src="<?php echo htmlspecialchars($nhanvien['avatar']); ?>" alt="Avatar" class="avatar-img">
                <?php else: ?>
                    <p>Chưa có ảnh đại diện.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>
