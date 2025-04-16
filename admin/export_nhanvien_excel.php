<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');
if ($conn->connect_error) {
    die("Kết nối CSDL thất bại: " . $conn->connect_error);
}

$keyword = $_GET['keyword'] ?? '';
$chucvu = $_GET['chucvu'] ?? '';
$donvi = $_GET['donvi'] ?? '';
$bangcap = $_GET['bangcap'] ?? '';

$sql = "SELECT nhanvien.id, nhanvien.ho_ten, nhanvien.chuc_vu, nhanvien.ngay_sinh, donvi.ten_don_vi, bangcap.ten_bang_cap
        FROM nhanvien
        JOIN donvi ON nhanvien.id_don_vi = donvi.id
        JOIN bangcap ON nhanvien.id_bang_cap = bangcap.id";

$conditions = [];

if (!empty($keyword)) {
    $conditions[] = "nhanvien.ho_ten LIKE '%" . $conn->real_escape_string($keyword) . "%'";
}
if (!empty($chucvu)) {
    $conditions[] = "nhanvien.chuc_vu = '" . $conn->real_escape_string($chucvu) . "'";
}
if (!empty($donvi)) {
    $conditions[] = "donvi.ten_don_vi = '" . $conn->real_escape_string($donvi) . "'";
}
if (!empty($bangcap)) {
    $conditions[] = "bangcap.ten_bang_cap = '" . $conn->real_escape_string($bangcap) . "'";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$result = $conn->query($sql);


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Họ Tên');
$sheet->setCellValue('C1', 'Chức Vụ');
$sheet->setCellValue('D1', 'Ngày Sinh');
$sheet->setCellValue('E1', 'Đơn Vị');
$sheet->setCellValue('F1', 'Bằng Cấp');

$rowNum = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowNum, $row['id']);
    $sheet->setCellValue('B' . $rowNum, $row['ho_ten']);
    $sheet->setCellValue('C' . $rowNum, $row['chuc_vu']);
    $sheet->setCellValue('D' . $rowNum, $row['ngay_sinh']);
    $sheet->setCellValue('E' . $rowNum, $row['ten_don_vi']);
    $sheet->setCellValue('F' . $rowNum, $row['ten_bang_cap']);
    $rowNum++;
}

$filename = 'danhsach_nhanvien_' . date('Ymd_His') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
$conn->close();
exit;