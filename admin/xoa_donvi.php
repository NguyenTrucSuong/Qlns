<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');

if (!isset($_GET['id'])) {
    echo "Không có ID đơn vị để xóa!";
    exit;
}

$id = intval($_GET['id']);


$sql_donvi = "SELECT id, ten_don_vi FROM donvi WHERE id != ?";
$stmt = $conn->prepare($sql_donvi);
$stmt->bind_param("i", $id);
$stmt->execute();
$result_donvi = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Xóa đơn vị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">
    <div class="container">
        <h2 class="mb-4 text-danger">Xác nhận xóa đơn vị</h2>
        <p>Bạn có chắc chắn muốn xóa đơn vị này không?</p>
        <form action="xuly_xoa_donvi.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="new_donvi" class="form-label">Chọn đơn vị thay thế cho các nhân viên (nếu có):</label>
                <select name="new_donvi" id="new_donvi" class="form-select" required>
                    <?php
                    while ($row = $result_donvi->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['ten_don_vi']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
            <a href="quanly_donvi.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</body>

</html>

<?php
$conn->close();
?>