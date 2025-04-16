
<?php
$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$id_bang_cap = $_GET['id'];

$sql_check = "SELECT * FROM nhanvien WHERE id_bang_cap = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $id_bang_cap);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    $sql_update = "UPDATE nhanvien SET id_bang_cap = NULL WHERE id_bang_cap = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $id_bang_cap);
    $stmt_update->execute();
    

}

$sql_delete_bangcap = "DELETE FROM bangcap WHERE id = ?";
$stmt_delete_bangcap = $conn->prepare($sql_delete_bangcap);
$stmt_delete_bangcap->bind_param("i", $id_bang_cap);
$stmt_delete_bangcap->execute();

$conn->close();
?>
