-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 03:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanly_nhansu`
--

-- --------------------------------------------------------

--
-- Table structure for table `bangcap`
--

CREATE TABLE `bangcap` (
  `id` int(11) NOT NULL,
  `ten_bang_cap` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bangcap`
--

INSERT INTO `bangcap` (`id`, `ten_bang_cap`) VALUES
(1, 'Cử nhân'),
(11, 'Tiến Sĩ'),
(12, 'Thạc Sĩ'),
(14, 'Cao đẳng'),
(15, 'Trung cấp'),
(16, ' Kỹ sư'),
(17, 'Chứng chỉ chuyên môn'),
(19, 'Chứng chỉ ngoại ngữ');

-- --------------------------------------------------------

--
-- Table structure for table `chamcong`
--

CREATE TABLE `chamcong` (
  `id` int(11) NOT NULL,
  `id_nhan_vien` int(11) NOT NULL,
  `thang_lam_viec` date NOT NULL,
  `so_ngay_lam` int(11) NOT NULL,
  `luong` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chamcong`
--

INSERT INTO `chamcong` (`id`, `id_nhan_vien`, `thang_lam_viec`, `so_ngay_lam`, `luong`) VALUES
(4, 7, '2025-04-01', 30, 6000000.00),
(6, 13, '2025-04-01', 29, 5800000.00),
(7, 16, '2025-04-01', 29, 8700000.00),
(8, 2, '2025-03-01', 31, 6200000.00),
(9, 8, '2025-04-01', 28, 8400000.00);

-- --------------------------------------------------------

--
-- Table structure for table `chitietkhenthuong_kyluat`
--

CREATE TABLE `chitietkhenthuong_kyluat` (
  `id` int(11) NOT NULL,
  `id_nhan_vien` int(11) DEFAULT NULL,
  `id_danh_muc_ktkl` int(11) DEFAULT NULL,
  `ngay_ly_do` date NOT NULL,
  `mo_ta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitietkhenthuong_kyluat`
--

INSERT INTO `chitietkhenthuong_kyluat` (`id`, `id_nhan_vien`, `id_danh_muc_ktkl`, `ngay_ly_do`, `mo_ta`) VALUES
(2, 15, 2, '2023-04-15', 'Kỷ luật vì vi phạm nội quy công ty.'),
(3, 7, 1, '2023-06-01', 'Khen thưởng vì đạt thành tích xuất sắc trong dự án.');

-- --------------------------------------------------------

--
-- Table structure for table `chucvu`
--

CREATE TABLE `chucvu` (
  `id` int(11) NOT NULL,
  `ten_chuc_vu` varchar(255) DEFAULT NULL,
  `luong_coban` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chucvu`
--

INSERT INTO `chucvu` (`id`, `ten_chuc_vu`, `luong_coban`) VALUES
(1, 'Giám đốc', 500000),
(2, 'Trưởng phòng', 250000),
(3, 'Nhân viên', 150000),
(4, 'Quản Lý', 200000),
(5, 'Phó Giám Đốc', 300000),
(6, 'Tổ Trưởng', 180000);

-- --------------------------------------------------------

--
-- Table structure for table `danhmuckhenthuong_kyluat`
--

CREATE TABLE `danhmuckhenthuong_kyluat` (
  `id` int(11) NOT NULL,
  `ten_danh_muc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `danhmuckhenthuong_kyluat`
--

INSERT INTO `danhmuckhenthuong_kyluat` (`id`, `ten_danh_muc`) VALUES
(1, 'Khen thưởng'),
(2, 'Kỷ luật');

-- --------------------------------------------------------

--
-- Table structure for table `donvi`
--

CREATE TABLE `donvi` (
  `id` int(11) NOT NULL,
  `ten_don_vi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donvi`
--

INSERT INTO `donvi` (`id`, `ten_don_vi`) VALUES
(2, 'Phòng Máy '),
(3, 'Phòng Kỹ Thuật'),
(4, 'Phòng Tài Chính'),
(11, 'Phòng Nhân Sự'),
(12, 'Phòng Kinh Doanh'),
(13, 'Phòng Hành Chính');

-- --------------------------------------------------------

--
-- Table structure for table `loaihinhdaotao`
--

CREATE TABLE `loaihinhdaotao` (
  `id` int(11) NOT NULL,
  `ten_loai_hinh_daotao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loaihinhdaotao`
--

INSERT INTO `loaihinhdaotao` (`id`, `ten_loai_hinh_daotao`) VALUES
(1, 'Đào tạo nội bộ'),
(2, 'Đào tạo bên ngoài'),
(6, 'Đào tạo trực tuyến'),
(7, 'Đào tạo qua các khóa học ngắn hạn'),
(8, 'Đào tạo nghề'),
(9, 'Đào tạo trao đổi/trao quyền'),
(10, 'Đào tạo theo dự án');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `chuc_vu` varchar(255) NOT NULL,
  `ngay_sinh` date NOT NULL,
  `id_don_vi` int(11) DEFAULT NULL,
  `id_bang_cap` int(11) DEFAULT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) NOT NULL,
  `id_chuc_vu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`id`, `ho_ten`, `chuc_vu`, `ngay_sinh`, `id_don_vi`, `id_bang_cap`, `dia_chi`, `so_dien_thoai`, `avatar`, `id_chuc_vu`) VALUES
(2, 'Trần Thị B', 'Quản lý ', '1985-10-22', 2, NULL, 'Cần Thơ', '0123323818', '', 4),
(3, 'Lê Minh C', 'Giám đốc', '1980-03-01', 3, NULL, '3/2 Hưng Lợi', '0123323243', '', 1),
(7, 'Lê Thị Trúc Ngân', 'Quản Lý', '2002-03-13', 2, 1, '586-Cần Thơ', '0124233818', 'uploads/mauanh2.jpg', 4),
(8, 'Nguyễn Trúc Sương', 'Phó Giám Đốc', '2002-11-11', 4, NULL, 'Mậu Thân - Cần Thơ', '0373901567', '', 5),
(13, 'Phạm Tiểu Băng', 'Quản Lý', '2002-11-06', 2, 1, 'Long Mỹ - Hậu Giang', '0138024813', 'uploads/mauanh2.jpg', 4),
(15, 'Nguyễn Thị Mai', 'Quản Lý', '1999-05-12', 2, 1, NULL, NULL, '', 4),
(16, 'Lê Thái Tú', 'Phó Giám Đốc', '1990-07-15', 3, 11, NULL, NULL, '', 5),
(17, 'Huỳnh Thảo Vy', 'Giám Đốc', '1996-06-02', 4, 1, '', '', '', 6),
(18, 'Trần Thanh Thảo', 'Quản Lý', '1995-04-04', 13, 11, 'Sóc Trăng', '0123024813', '', 4),
(19, 'Lê Thị Khá', 'Tổ Trưởng', '1998-08-27', 13, 14, '', '', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `quatrinhcongtac`
--

CREATE TABLE `quatrinhcongtac` (
  `id` int(11) NOT NULL,
  `id_nhan_vien` int(11) DEFAULT NULL,
  `ngay_bat_dau` date NOT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `chuc_vu` varchar(255) DEFAULT NULL,
  `don_vi_lam_viec` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quatrinhcongtac`
--

INSERT INTO `quatrinhcongtac` (`id`, `id_nhan_vien`, `ngay_bat_dau`, `ngay_ket_thuc`, `chuc_vu`, `don_vi_lam_viec`) VALUES
(11, 18, '2024-03-01', '2025-04-15', 'Quản Lý', 'Phòng Hành Chính'),
(15, 7, '2024-04-01', '2025-04-08', 'Quản Lý', 'Phòng Máy');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'trucsuong', '123456', '2024-11-20 10:45:35'),
(2, 'admin', '123', '2024-11-29 10:56:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bangcap`
--
ALTER TABLE `bangcap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chamcong`
--
ALTER TABLE `chamcong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nhan_vien` (`id_nhan_vien`);

--
-- Indexes for table `chitietkhenthuong_kyluat`
--
ALTER TABLE `chitietkhenthuong_kyluat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nhan_vien_ktkl` (`id_nhan_vien`),
  ADD KEY `fk_danh_muc_ktkl` (`id_danh_muc_ktkl`);

--
-- Indexes for table `chucvu`
--
ALTER TABLE `chucvu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `danhmuckhenthuong_kyluat`
--
ALTER TABLE `danhmuckhenthuong_kyluat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donvi`
--
ALTER TABLE `donvi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loaihinhdaotao`
--
ALTER TABLE `loaihinhdaotao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_don_vi` (`id_don_vi`),
  ADD KEY `fk_bang_cap` (`id_bang_cap`),
  ADD KEY `FK_nhanvien_chucvu` (`id_chuc_vu`);

--
-- Indexes for table `quatrinhcongtac`
--
ALTER TABLE `quatrinhcongtac`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nhan_vien` (`id_nhan_vien`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bangcap`
--
ALTER TABLE `bangcap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `chamcong`
--
ALTER TABLE `chamcong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `chitietkhenthuong_kyluat`
--
ALTER TABLE `chitietkhenthuong_kyluat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `danhmuckhenthuong_kyluat`
--
ALTER TABLE `danhmuckhenthuong_kyluat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `donvi`
--
ALTER TABLE `donvi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `loaihinhdaotao`
--
ALTER TABLE `loaihinhdaotao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `quatrinhcongtac`
--
ALTER TABLE `quatrinhcongtac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chamcong`
--
ALTER TABLE `chamcong`
  ADD CONSTRAINT `chamcong_ibfk_1` FOREIGN KEY (`id_nhan_vien`) REFERENCES `nhanvien` (`id`);

--
-- Constraints for table `chitietkhenthuong_kyluat`
--
ALTER TABLE `chitietkhenthuong_kyluat`
  ADD CONSTRAINT `fk_danh_muc_ktkl` FOREIGN KEY (`id_danh_muc_ktkl`) REFERENCES `danhmuckhenthuong_kyluat` (`id`),
  ADD CONSTRAINT `fk_nhan_vien_ktkl` FOREIGN KEY (`id_nhan_vien`) REFERENCES `nhanvien` (`id`);

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `FK_nhanvien_chucvu` FOREIGN KEY (`id_chuc_vu`) REFERENCES `chucvu` (`id`),
  ADD CONSTRAINT `fk_bang_cap` FOREIGN KEY (`id_bang_cap`) REFERENCES `bangcap` (`id`),
  ADD CONSTRAINT `fk_don_vi` FOREIGN KEY (`id_don_vi`) REFERENCES `donvi` (`id`);

--
-- Constraints for table `quatrinhcongtac`
--
ALTER TABLE `quatrinhcongtac`
  ADD CONSTRAINT `fk_nhan_vien` FOREIGN KEY (`id_nhan_vien`) REFERENCES `nhanvien` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
