<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');


$id = $_GET['id'];
$sql = "SELECT * FROM loaihinhdaotao WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_loai_hinh = $_POST['ten_loai_hinh_daotao'];


    $update_sql = "UPDATE loaihinhdaotao SET ten_loai_hinh_daotao = '$ten_loai_hinh' WHERE id = $id";
    if ($conn->query($update_sql) === TRUE) {
        header('Location: quanly_lhdt.php');
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
    <title>Sửa Loại Hình Đào Tạo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ADD8E6; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Sửa Loại Hình Đào Tạo</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="ten_loai_hinh" class="form-label">Tên Loại Hình Đào Tạo</label>
                <input type="text" class="form-control" id="ten_loai_hinh_daotao" name="ten_loai_hinh_daotao" value="<?php echo $row['ten_loai_hinh_daotao']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="quanly_lhdt.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
