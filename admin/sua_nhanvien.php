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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT nhanvien.id, nhanvien.ho_ten, nhanvien.chuc_vu, nhanvien.ngay_sinh, nhanvien.id_don_vi, nhanvien.id_bang_cap,
                   nhanvien.dia_chi, nhanvien.so_dien_thoai, nhanvien.avatar, donvi.ten_don_vi, bangcap.ten_bang_cap
            FROM nhanvien
            JOIN donvi ON nhanvien.id_don_vi = donvi.id
            JOIN bangcap ON nhanvien.id_bang_cap = bangcap.id
            WHERE nhanvien.id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy nhân viên.";
        exit;
    }
} else {
    echo "ID nhân viên không hợp lệ.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ho_ten = $_POST['ho_ten'];
    $chuc_vu = $_POST['chuc_vu'];
    $ngay_sinh = $_POST['ngay_sinh'];
    $id_don_vi = $_POST['id_don_vi'];
    $id_bang_cap = $_POST['id_bang_cap'];
    $dia_chi = $_POST['dia_chi']; 
    $so_dien_thoai = $_POST['so_dien_thoai']; 

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $avatar_file = $_FILES['avatar'];
        $upload_dir = 'uploads/';
        $avatar_name = basename($avatar_file['name']);
        $avatar_path = $upload_dir . $avatar_name;

        if (move_uploaded_file($avatar_file['tmp_name'], $avatar_path)) {
            $avatar = $avatar_path;
        } else {
            echo "Lỗi khi tải ảnh lên.";
        }
    } else {
        $avatar = $row['avatar'];
    }
 
    $sql_update = "UPDATE nhanvien
                   SET ho_ten = '$ho_ten', chuc_vu = '$chuc_vu', ngay_sinh = '$ngay_sinh', id_don_vi = $id_don_vi, 
                       id_bang_cap = $id_bang_cap, dia_chi = '$dia_chi', so_dien_thoai = '$so_dien_thoai', avatar = '$avatar'
                   WHERE id = $id";

    if ($conn->query($sql_update) === TRUE) {
        echo "Cập nhật thành công!";
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
    <title>Sửa thông tin nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ADD8E6; 
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Sửa thông tin nhân viên</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="ho_ten" class="form-label">Họ Tên</label>
                <input type="text" class="form-control" id="ho_ten" name="ho_ten" value="<?php echo $row['ho_ten']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="chuc_vu" class="form-label">Chức Vụ</label>
                <input type="text" class="form-control" id="chuc_vu" name="chuc_vu" value="<?php echo $row['chuc_vu']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="ngay_sinh" class="form-label">Ngày Sinh</label>
                <input type="date" class="form-control" id="ngay_sinh" name="ngay_sinh" value="<?php echo $row['ngay_sinh']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_don_vi" class="form-label">Đơn Vị</label>
                <select class="form-control" id="id_don_vi" name="id_don_vi">
                    <option value="<?php echo $row['id_don_vi']; ?>"><?php echo $row['ten_don_vi']; ?></option>
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
                <select class="form-control" id="id_bang_cap" name="id_bang_cap">
                    <option value="<?php echo $row['id_bang_cap']; ?>"><?php echo $row['ten_bang_cap']; ?></option>
                    <?php
                    $sql_bang_cap = "SELECT * FROM bangcap";
                    $result_bang_cap = $conn->query($sql_bang_cap);
                    while ($bang_cap = $result_bang_cap->fetch_assoc()) {
                        echo "<option value='" . $bang_cap['id'] . "'>" . $bang_cap['ten_bang_cap'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="dia_chi" class="form-label">Địa Chỉ</label>
                <input type="text" class="form-control" id="dia_chi" name="dia_chi" value="<?php echo $row['dia_chi']; ?>">
            </div>
            <div class="mb-3">
                <label for="so_dien_thoai" class="form-label">Số Điện Thoại</label>
                <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" value="<?php echo $row['so_dien_thoai']; ?>">
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Ảnh Đại Diện</label>
                <input type="file" name="avatar" class="form-control" />
                <?php if ($row['avatar']): ?>
                    <p>Ảnh hiện tại: <img src="<?php echo $row['avatar']; ?>" alt="Avatar" style="width: 100px; height: auto;" /></p>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</body>

</html>

<?php
$conn->close();
?>
