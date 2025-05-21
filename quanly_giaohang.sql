-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 21, 2025 lúc 04:50 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanly_giaohang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `buucuc`
--

CREATE TABLE `buucuc` (
  `id_buuCuc` int(11) NOT NULL,
  `tenBuuCuc` varchar(50) NOT NULL,
  `diaChi` varchar(100) NOT NULL,
  `tinhThanh` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diachi`
--

CREATE TABLE `diachi` (
  `id_diaChi` int(11) NOT NULL,
  `diaChiNguoiNhan` text NOT NULL,
  `tinh_tp` varchar(100) NOT NULL,
  `quan_huyen` varchar(100) NOT NULL,
  `phuong_xa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `diachi`
--

INSERT INTO `diachi` (`id_diaChi`, `diaChiNguoiNhan`, `tinh_tp`, `quan_huyen`, `phuong_xa`) VALUES
(19, '123 đồng nai', 'Thành phố Hồ Chí Minh', 'Quận Bình Tân', 'Phường Bình Trị Đông B'),
(20, 'Phúc Hưng', 'Tỉnh Thái Nguyên', 'Huyện Đồng Hỷ', 'Xã Hợp Tiến'),
(21, '123 đường số 1', 'Tỉnh Lạng Sơn', 'Huyện Chi Lăng', 'Xã Hòa Bình'),
(22, 'Phúc Hưng', 'Tỉnh Bắc Ninh', 'Thành phố Từ Sơn', 'Phường Tương Giang'),
(23, 'đường số 1', 'Tỉnh Tiền Giang', 'Thành phố Gò Công', 'Phường Long Chánh'),
(24, 'vĩnh cửu', 'Tỉnh Đồng Nai', 'Huyện Vĩnh Cửu', 'Xã Trị An'),
(25, '123 đường số 1', 'Tỉnh Bình Định', 'Huyện Phù Cát', 'Xã Cát Trinh'),
(26, 'đường số 1', 'Thành phố Hà Nội', 'Quận Bắc Từ Liêm', 'Phường Phú Diễn'),
(27, '123 đường số 1', 'Tỉnh Thái Nguyên', 'Huyện Võ Nhai', 'Xã Phương Giao'),
(28, '72 liên xã ', 'Tỉnh Quảng Trị', 'Huyện Triệu Phong', 'Xã Triệu Đại'),
(29, '592/16 Hồ Học Lãm', 'Thành phố Hồ Chí Minh', 'Quận Bình Tân', 'Phường Bình Trị Đông B'),
(30, 'hồ học lãm', 'Tỉnh Thái Nguyên', 'Huyện Đồng Hỷ', 'Xã Hóa Trung');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `doanhthu`
--

CREATE TABLE `doanhthu` (
  `id_doanhThu` int(11) NOT NULL,
  `maVanDon` varchar(40) NOT NULL,
  `tongTien` float NOT NULL,
  `ngayTinh` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `doanhthu`
--

INSERT INTO `doanhthu` (`id_doanhThu`, `maVanDon`, `tongTien`, `ngayTinh`) VALUES
(1, 'DGH20250512151347', 147123, '2025-05-13'),
(2, 'DGH20250512151347', 147123, '2025-05-13'),
(3, 'DGH20250513045234', 324000, '2025-05-13'),
(4, 'DGH20250513060406', 1261390, '2025-05-13'),
(5, 'DGH20250513171646', 724000, '2025-05-13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `maVanDon` varchar(40) NOT NULL,
  `id_khachHang` int(11) NOT NULL,
  `id_nhanVien` int(11) DEFAULT NULL,
  `id_trangThai` int(11) NOT NULL,
  `id_sanPham` int(11) DEFAULT NULL,
  `id_nguoiNhan` int(11) NOT NULL,
  `id_nguoiGui` int(11) NOT NULL,
  `id_thanhToan` int(11) DEFAULT NULL,
  `ngayTaoDon` datetime NOT NULL,
  `ghiChu` text DEFAULT NULL,
  `ngayGiao` datetime DEFAULT NULL,
  `id_phi` int(11) DEFAULT NULL,
  `hinhThucGui` varchar(50) NOT NULL,
  `KL_DH` decimal(10,2) NOT NULL,
  `rong` decimal(10,2) DEFAULT NULL,
  `dai` int(11) DEFAULT NULL,
  `cao` decimal(10,2) DEFAULT NULL,
  `giaTriHang` decimal(15,2) DEFAULT NULL,
  `COD` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`maVanDon`, `id_khachHang`, `id_nhanVien`, `id_trangThai`, `id_sanPham`, `id_nguoiNhan`, `id_nguoiGui`, `id_thanhToan`, `ngayTaoDon`, `ghiChu`, `ngayGiao`, `id_phi`, `hinhThucGui`, `KL_DH`, `rong`, `dai`, `cao`, `giaTriHang`, `COD`) VALUES
('DGH20250510061257', 10, 2, 6, NULL, 8, 19, NULL, '2025-05-10 06:12:57', NULL, NULL, 7, 'Lấy hàng tận nơi', 700.00, 12.00, 12, 12.00, 300000.00, 1000000.00),
('DGH20250512104939', 1, 2, 9, NULL, 9, 20, NULL, '2025-05-12 10:49:39', 'không ', NULL, 8, 'Lấy hàng tận nơi', 1200.00, 12.00, 12, 12.00, 123123.00, 200000.00),
('DGH20250512110118', 2, 2, 3, NULL, 10, 21, NULL, '2025-05-12 11:01:18', 'không', NULL, 9, 'Lấy hàng tận nơi', 12.00, 12.00, 12, 12.00, 300000.00, 1000000.00),
('DGH20250512110634', 2, 2, 9, NULL, 11, 22, NULL, '2025-05-12 11:06:34', 'cho xem hàng ', NULL, 10, 'Lấy hàng tận nơi', 123.00, 12.00, 12, 12.00, 300000.00, 1234556.00),
('DGH20250512112800', 2, 2, 3, NULL, 12, 23, NULL, '2025-05-12 11:28:00', 'cho xem hàng ', NULL, 11, 'Lấy hàng tận nơi', 200.00, 12.00, 12, 12.00, 1200000.00, 1200000.00),
('DGH20250512151347', 10, 2, 4, NULL, 13, 24, NULL, '2025-05-12 15:13:47', 'cho xem hàng ', NULL, 12, 'Lấy hàng tận nơi', 12.00, 12.00, 12, 12.00, 200000.00, 123123.00),
('DGH20250513045234', 11, 2, 4, NULL, 14, 25, NULL, '2025-05-13 04:52:34', 'cho xem hàng ', NULL, 13, 'Gửi tại bưu cục', 200.00, 12.00, 12, 12.00, 300000.00, 300000.00),
('DGH20250513055642', 11, 2, 5, NULL, 15, 26, NULL, '2025-05-13 05:56:42', 'cho xem hàng ', NULL, 14, 'Lấy hàng tận nơi', 123.00, 12.00, 12, 12.00, 123123.00, 300000.00),
('DGH20250513060406', 11, 2, 4, NULL, 16, 27, NULL, '2025-05-13 06:04:06', 'cho xem hàng ', NULL, 15, 'Lấy hàng tận nơi', 123.00, 12.00, 12, 12.00, 300000.00, 1231234.00),
('DGH20250513171646', 10, 2, 4, NULL, 17, 28, NULL, '2025-05-13 17:16:46', NULL, NULL, 16, 'Lấy hàng tận nơi', 900.00, 12.00, 12, 12.00, 700000.00, 700000.00),
('DGH20250515140343', 12, 2, 5, NULL, 18, 29, NULL, '2025-05-15 14:03:43', 'cho xem hàng ', NULL, 17, 'Gửi tại bưu cục', 1100.00, 12.00, 12, 12.00, 800000.00, 1111000.00),
('DGH20250515145234', 12, NULL, 6, NULL, 19, 30, NULL, '2025-05-15 14:52:34', 'cho kiểm tra hàng', NULL, 18, 'Lấy hàng tận nơi', 123.00, 12.00, 12, 12.00, 12345.00, 1000000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `id_hoaDon` int(11) NOT NULL,
  `maVanDon` varchar(40) NOT NULL,
  `ngayTao` datetime NOT NULL,
  `soTien` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `id_khachHang` int(11) NOT NULL,
  `tenKhachHang` varchar(100) NOT NULL,
  `soDienThoai` varchar(15) NOT NULL,
  `diaChi` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`id_khachHang`, `tenKhachHang`, `soDienThoai`, `diaChi`, `email`, `password`) VALUES
(10, 'Phúc Hưng', '0376963735', '592/16 Hồ Học Lãm', 'fisph01@gmail.com', '$2y$10$h051VIq9vIRp49P/SgqEoOuPxmr/P6vwPvR9wZNeL2nIj7AodMe4y'),
(11, 'user', '0352237434', '592/16 Hồ Học Lãm, Bình Tân', 'user@gmail.com', '$2y$10$eBdc274BdBq61d9PgvZWu.QM9qDJ4s2qKEs9ZyAgNgrNtwDeG6oxi'),
(12, 'Hồ Thị Cẩm Phương', '0376963735', 'Vĩnh cửu, đồng nai', 'camphuong@gmail.com', '$2y$10$/OmZsAMBXc5MDcooZ.Je2uap6SEXGDFxAAc08.29/8rpS0wzOTzFS'),
(13, 'Phúc Hưng', '0376963735', '592/16 Hồ Học Lãm', 'hung@gmail.com', '$2y$10$A/Q/rLjHQSuo1GEqFzeA6OTPB9hCKuNC.O9u1nI0DYCHfon.jN11K'),
(14, 'Trần thị ngân', '0333045402', '592/16 Hồ Học Lãm, Bình Tân', 'ngan@gmail.com', '$2y$10$xH8nJbZ.uoMlMNdYQkkHSOnNX4/8cjjRLkUi9iSVH7TNHfQrNy.oy'),
(15, 'Phúc Hưng', '0376963735', '592/16 Hồ Học Lãm', 'pcph@gmail.com', '$2y$10$70gKpylZR.rrpXgkKUuoVOg25AzCKO2/O7qjXG9ritXIN.E/fGdJ6'),
(16, 'Phúc Hưng', '0376963735', '592/16 Hồ Học Lãm', 'user123@gmail.com', '$2y$10$/jII78LT.K6L1yChK/hRiOBWg6W1AKa/.H.uSjjfjQGSkf1SKFUMu');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khohang`
--

CREATE TABLE `khohang` (
  `id_kho` int(11) NOT NULL,
  `tenKho` varchar(100) NOT NULL,
  `diaChi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lichlamviec`
--

CREATE TABLE `lichlamviec` (
  `id_lichLamViec` int(11) NOT NULL,
  `id_NhanVien` int(11) NOT NULL,
  `ngayLamViec` date NOT NULL,
  `thoiGianBatDau` time NOT NULL,
  `thoiGianKetThuc` time NOT NULL,
  `ghiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lichsu_trangthai`
--

CREATE TABLE `lichsu_trangthai` (
  `id_lichSuTrangThai` int(11) NOT NULL,
  `maVanDon` varchar(40) NOT NULL,
  `id_TrangThai` int(11) NOT NULL,
  `mocThoiGian` datetime NOT NULL,
  `diaDiem` varchar(255) DEFAULT NULL,
  `HIMnotes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lichsu_trangthai`
--

INSERT INTO `lichsu_trangthai` (`id_lichSuTrangThai`, `maVanDon`, `id_TrangThai`, `mocThoiGian`, `diaDiem`, `HIMnotes`) VALUES
(5, 'DGH20250510061257', 1, '2025-05-10 06:12:57', 'Thành phố Hồ Chí Minh', 'Tạo đơn thành công'),
(6, 'DGH20250512104939', 1, '2025-05-12 10:49:39', 'Tỉnh Thái Nguyên', 'Tạo đơn thành công'),
(7, 'DGH20250512104939', 3, '2025-05-12 15:55:45', 'Thành phố Hồ Chí Minh', 'Cập nhật trạng thái: Đã giao thành công'),
(8, 'DGH20250512110118', 1, '2025-05-12 11:01:18', 'Tỉnh Lạng Sơn', 'Tạo đơn thành công'),
(9, 'DGH20250512110118', 3, '2025-05-12 16:02:27', 'Thành phố Hồ Chí Minh', 'Cập nhật trạng thái: Đã giao thành công'),
(10, 'DGH20250512110634', 1, '2025-05-12 11:06:34', 'Tỉnh Bắc Ninh', 'Tạo đơn thành công'),
(11, 'DGH20250512104939', 9, '2025-05-12 16:21:06', 'Thành phố Hồ Chí Minh', 'Giao thất bại'),
(12, 'DGH20250512110634', 9, '2025-05-12 16:21:29', 'Thành phố Hồ Chí Minh', 'Giao thất bại'),
(13, 'DGH20250512112800', 1, '2025-05-12 11:28:00', 'Tỉnh Tiền Giang', 'Tạo đơn thành công'),
(14, 'DGH20250512112800', 3, '2025-05-12 16:30:04', 'Thành phố Hồ Chí Minh', 'Đã giao thành công'),
(15, 'DGH20250512151347', 1, '2025-05-12 15:13:47', 'Tỉnh Đồng Nai', 'Tạo đơn thành công'),
(16, 'DGH20250512151347', 3, '2025-05-12 20:14:47', 'Thành phố Hồ Chí Minh', 'Đã giao thành công'),
(17, 'DGH20250512151347', 4, '2025-05-13 09:48:35', 'Thành phố Hồ Chí Minh', 'Đã giao'),
(18, 'DGH20250512151347', 4, '2025-05-13 09:48:40', 'Thành phố Hồ Chí Minh', 'Đã giao'),
(19, 'DGH20250513045234', 1, '2025-05-13 04:52:34', 'Tỉnh Bình Định', 'Tạo đơn thành công'),
(20, 'DGH20250513045234', 4, '2025-05-13 09:55:35', 'Thành phố Hồ Chí Minh', 'Đã giao'),
(21, 'DGH20250513055642', 1, '2025-05-13 05:56:42', 'Thành phố Hà Nội', 'Tạo đơn thành công'),
(22, 'DGH20250513055642', 3, '2025-05-13 10:57:22', 'Thành phố Hồ Chí Minh', 'Đang giao hàng'),
(23, 'DGH20250513055642', 5, '2025-05-13 10:57:46', 'Thành phố Hồ Chí Minh', 'Giao không thành công'),
(24, 'DGH20250513055642', 5, '2025-05-13 10:57:51', 'Thành phố Hồ Chí Minh', 'Giao không thành công'),
(25, 'DGH20250513060406', 1, '2025-05-13 06:04:06', 'Tỉnh Thái Nguyên', 'Tạo đơn thành công'),
(26, 'DGH20250513055642', 2, '2025-05-13 11:04:17', 'Thành phố Hồ Chí Minh', 'Đã phân công cho nhân viên ID: 2'),
(27, 'DGH20250513060406', 2, '2025-05-13 11:04:23', 'Thành phố Hồ Chí Minh', 'Đã phân công cho nhân viên ID: 2'),
(28, 'DGH20250513060406', 3, '2025-05-13 11:05:03', 'Thành phố Hồ Chí Minh', 'Đang giao hàng'),
(29, 'DGH20250513060406', 4, '2025-05-13 11:05:54', 'Thành phố Hồ Chí Minh', 'Đã giao'),
(30, 'DGH20250513055642', 3, '2025-05-13 11:12:28', 'Thành phố Hồ Chí Minh', 'Đang giao hàng'),
(31, 'DGH20250513055642', 5, '2025-05-13 11:12:38', 'Thành phố Hồ Chí Minh', 'Giao không thành công'),
(32, 'DGH20250513171646', 1, '2025-05-13 17:16:46', 'Tỉnh Quảng Trị', 'Tạo đơn thành công'),
(33, 'DGH20250513171646', 2, '2025-05-13 22:19:21', 'Thành phố Hồ Chí Minh', 'Đã phân công cho nhân viên ID: 2'),
(34, 'DGH20250513171646', 3, '2025-05-13 22:21:07', 'Thành phố Hồ Chí Minh', 'Đang giao hàng'),
(35, 'DGH20250513171646', 4, '2025-05-13 22:21:53', 'Thành phố Hồ Chí Minh', 'Đã giao'),
(36, 'DGH20250515140343', 1, '2025-05-15 14:03:43', 'Thành phố Hồ Chí Minh', 'Tạo đơn thành công'),
(37, 'DGH20250515140343', 2, '2025-05-15 19:21:12', 'Thành phố Hồ Chí Minh', 'Đã phân công cho nhân viên ID: 2'),
(38, 'DGH20250515140343', 3, '2025-05-15 19:27:31', 'Thành phố Hồ Chí Minh', 'Đang giao hàng'),
(39, 'DGH20250515140343', 5, '2025-05-15 19:29:35', 'Thành phố Hồ Chí Minh', 'Giao không thành công'),
(40, 'DGH20250515145234', 1, '2025-05-15 14:52:34', 'Tỉnh Thái Nguyên', 'Tạo đơn thành công'),
(41, 'DGH20250510061257', 6, '2025-05-16 12:03:55', 'Hệ thống', 'Đơn hàng đã được hủy bởi người gửi'),
(42, 'DGH20250512112800', 3, '2025-05-16 17:07:49', 'Thành phố Hồ Chí Minh', 'Đang giao'),
(43, 'DGH20250515145234', 6, '2025-05-20 12:45:06', 'Hệ thống', 'Đơn hàng đã được hủy bởi người gửi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lienhe`
--

CREATE TABLE `lienhe` (
  `id_lienHe` int(11) NOT NULL,
  `ten` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `chuDe` varchar(200) NOT NULL,
  `tinNhan` text NOT NULL,
  `ngayGui` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoigui`
--

CREATE TABLE `nguoigui` (
  `id_nguoiGui` int(11) NOT NULL,
  `tenNguoiGui` varchar(100) NOT NULL,
  `diaChiNguoiGui` text NOT NULL,
  `sdtNguoiGui` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoigui`
--

INSERT INTO `nguoigui` (`id_nguoiGui`, `tenNguoiGui`, `diaChiNguoiGui`, `sdtNguoiGui`) VALUES
(19, 'Phan Công Phúc Hưng', '123 tên lửa', '0376963735'),
(20, 'Hồ Thị Cẩm Phương', '123 đồng nai', '0376963735'),
(21, 'Nguyễn Đình Hoàng', 'bình định', '0376963735'),
(22, 'Hồ Thị Cẩm Phương', '592/16 hồ học lãm, bình tân, TP.HCM', '0376963735'),
(23, 'Phan Thiên Khải', 'Gò vấp', '01230123123'),
(24, 'Hồ Thị Cẩm Phương iu', '123 đồng nai', '0376963735'),
(25, 'Phan Thiên Khải', 'phú yên', '0376963735'),
(26, 'Hưng', '123 đồng nai', '0376963735'),
(27, 'tài', '123 đồng nai', '0376963735'),
(28, 'phúc hưng', '592/16 hồ học lãm, bình tân, TP.HCM', '0376963735'),
(29, 'Hồ Thị Cẩm Phương', 'trị an, Vĩnh cửu, đồng nai', '0832061261'),
(30, 'phúc hưng', '123 đồng nai', '0376963735');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoinhan`
--

CREATE TABLE `nguoinhan` (
  `id_nguoiNhan` int(11) NOT NULL,
  `tenNguoiNhan` varchar(100) NOT NULL,
  `soDienThoai` varchar(15) NOT NULL,
  `id_diaChi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoinhan`
--

INSERT INTO `nguoinhan` (`id_nguoiNhan`, `tenNguoiNhan`, `soDienThoai`, `id_diaChi`) VALUES
(8, 'Phúc Hưng', '0352237434', 19),
(9, 'Phúc Hưng', '0352237434', 20),
(10, 'Phúc Hưng', '0352237434', 21),
(11, 'Phúc Hưng', '0352237434', 22),
(12, 'Bùi anh tài', '0376963735', 23),
(13, 'Phúc Hưng', '0376963735', 24),
(14, 'Nguyễn Đình Hoàng', '0352237434', 25),
(15, 'Phúc Hưng', '0376963735', 26),
(16, 'Phúc Hưng', '0352237434', 27),
(17, 'Phan Như Quỳnh', '0352237434', 28),
(18, 'Phúc Hưng', '0376963735', 29),
(19, 'Phúc Hưng', '0376963735', 30);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `id_nhanVien` int(11) NOT NULL,
  `tenNhanVien` varchar(100) NOT NULL,
  `soDienThoai` varchar(15) NOT NULL,
  `diaChi` text NOT NULL,
  `viTri` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phanQuyen` int(11) DEFAULT 0,
  `viTriLat` decimal(9,6) DEFAULT NULL,
  `viTriLng` decimal(9,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`id_nhanVien`, `tenNhanVien`, `soDienThoai`, `diaChi`, `viTri`, `email`, `password`, `phanQuyen`, `viTriLat`, `viTriLng`) VALUES
(1, 'Phúc Hưng', '0376963735', 'Ho Chi Minh', 'manager', 'fisph01@gmail.com', '12345', 1, NULL, NULL),
(2, 'nguyễn đình hoàng', '0352237434', 'thủ đức ', 'Giao hàng', 'hoanglit652003@gmail.com', '123', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phi`
--

CREATE TABLE `phi` (
  `id_phi` int(11) NOT NULL,
  `maVanDon` varchar(20) DEFAULT NULL,
  `phiDichVu` decimal(15,2) NOT NULL,
  `phiKhaiGia` decimal(15,2) DEFAULT 0.00,
  `phiCOD` decimal(15,2) DEFAULT 0.00,
  `tongPhi` decimal(15,2) NOT NULL,
  `benTraPhi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phi`
--

INSERT INTO `phi` (`id_phi`, `maVanDon`, `phiDichVu`, `phiKhaiGia`, `phiCOD`, `tongPhi`, `benTraPhi`) VALUES
(3, 'DGH123123123', 23000.00, 5000.00, 123000.00, 250000.00, 'người gửi trả phí'),
(4, 'DGH20250509051357', 24000.00, 5000.00, 1000000.00, 1029000.00, 'Người gửi trả phí'),
(5, 'DGH20250509150206', 24000.00, 6173.00, 1234556.00, 1264729.00, 'Người gửi trả phí'),
(6, 'DGH20250509150846', 24000.00, 6156.00, 1231234.00, 1261390.00, 'Người gửi trả phí'),
(7, 'DGH20250510061257', 24000.00, 5000.00, 1000000.00, 1029000.00, '1'),
(8, 'DGH20250512104939', 24000.00, 0.00, 200000.00, 224000.00, 'Người gửi trả phí'),
(9, 'DGH20250512110118', 24000.00, 5000.00, 1000000.00, 1029000.00, 'Người gửi trả phí'),
(10, 'DGH20250512110634', 24000.00, 6173.00, 1234556.00, 1264729.00, 'Người nhận trả phí'),
(11, 'DGH20250512112800', 24000.00, 6000.00, 1200000.00, 1230000.00, 'Người nhận trả phí'),
(12, 'DGH20250512151347', 24000.00, 0.00, 123123.00, 147123.00, 'Người gửi trả phí'),
(13, 'DGH20250513045234', 24000.00, 0.00, 300000.00, 324000.00, 'Người nhận trả phí'),
(14, 'DGH20250513055642', 24000.00, 0.00, 300000.00, 324000.00, 'Người gửi trả phí'),
(15, 'DGH20250513060406', 24000.00, 6156.00, 1231234.00, 1261390.00, 'Người nhận trả phí'),
(16, 'DGH20250513171646', 24000.00, 0.00, 700000.00, 724000.00, '1'),
(17, 'DGH20250515140343', 24000.00, 5555.00, 1111000.00, 1140555.00, 'Người nhận trả phí'),
(18, 'DGH20250515145234', 24000.00, 5000.00, 1000000.00, 1029000.00, 'Người gửi trả phí');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `id_sanPham` int(11) NOT NULL,
  `maVanDon` varchar(50) DEFAULT NULL,
  `maSP` varchar(50) NOT NULL,
  `tenSanPham` varchar(50) NOT NULL,
  `soLuong` int(11) NOT NULL,
  `khoiLuong` decimal(10,2) NOT NULL,
  `Dai` decimal(10,2) DEFAULT NULL,
  `Rong` decimal(10,2) DEFAULT NULL,
  `giaTri` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`id_sanPham`, `maVanDon`, `maSP`, `tenSanPham`, `soLuong`, `khoiLuong`, `Dai`, `Rong`, `giaTri`) VALUES
(6, 'DGH20250512104939', '123', 'nón', 2, 200.00, NULL, NULL, NULL),
(7, 'DGH20250512110118', '123', 'quần ', 3, 200.00, NULL, NULL, NULL),
(8, 'DGH20250512110634', '123', 'áo', 12, 200.00, NULL, NULL, NULL),
(9, 'DGH20250512112800', '12', 'điện thoại', 1, 200.00, NULL, NULL, NULL),
(10, 'DGH20250512151347', '12', 'đồng hồ', 1, 200.00, NULL, NULL, NULL),
(11, 'DGH20250513045234', '123', 'balo', 1, 200.00, NULL, NULL, NULL),
(12, 'DGH20250513055642', '23', 'đèn', 1, 200.00, NULL, NULL, NULL),
(13, 'DGH20250513060406', '12', 'thước', 1, 200.00, NULL, NULL, NULL),
(14, 'DGH20250513171646', '123', 'Máy tính cầm tay', 2, 1800.00, NULL, NULL, NULL),
(15, 'DGH20250510061257', '1234', 'Máy tính cầm tay', 1, 300.00, NULL, NULL, NULL),
(18, 'DGH20250515140343', '108', 'xe kaido house', 1, 200.00, NULL, NULL, NULL),
(19, 'DGH20250515140343', '123', 'Siêu xe hot wheels', 3, 200.00, NULL, NULL, NULL),
(20, 'DGH20250515140343', 'mh702', 'mô hình xe', 1, 300.00, NULL, NULL, NULL),
(21, 'DGH20250515145234', '123', 'Máy tính cầm tay', 1, 200.00, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhtoan`
--

CREATE TABLE `thanhtoan` (
  `id_thanhToan` int(11) NOT NULL,
  `maVanDon` varchar(40) NOT NULL,
  `phuongThuc` varchar(50) NOT NULL,
  `trangThai` varchar(20) NOT NULL,
  `ngayThanhToan` datetime DEFAULT NULL,
  `soTien` int(11) NOT NULL,
  `nguoiThanhToan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongbao`
--

CREATE TABLE `thongbao` (
  `id_thongBao` int(11) NOT NULL,
  `id_NhanVien` int(11) NOT NULL,
  `noiDung` text NOT NULL,
  `ngayTao` datetime NOT NULL,
  `trangThai` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thongbao`
--

INSERT INTO `thongbao` (`id_thongBao`, `id_NhanVien`, `noiDung`, `ngayTao`, `trangThai`) VALUES
(1, 2, 'Bạn được phân công đơn hàng DGH20250510061257', '2025-05-12 15:28:57', 'Đã đọc'),
(2, 2, 'Bạn được phân công đơn hàng DGH20250512104939', '2025-05-12 15:51:02', 'Đã đọc'),
(3, 2, 'Đơn hàng DGH20250512104939 đã được cập nhật trạng thái: Đã giao thành công', '2025-05-12 15:55:45', 'Đã đọc'),
(4, 2, 'Bạn được phân công đơn hàng DGH20250512104939', '2025-05-12 16:01:32', 'Đã đọc'),
(5, 2, 'Bạn được phân công đơn hàng DGH20250512110118', '2025-05-12 16:01:46', 'Đã đọc'),
(6, 2, 'Đơn hàng DGH20250512110118 đã được cập nhật trạng thái: Đã giao thành công', '2025-05-12 16:02:27', 'Đã đọc'),
(7, 2, 'Bạn được phân công đơn hàng DGH20250512110634', '2025-05-12 16:11:14', 'Đã đọc'),
(8, 2, 'Đơn hàng DGH20250512104939 đã được cập nhật trạng thái: Giao thất bại', '2025-05-12 16:21:06', 'Đã đọc'),
(9, 2, 'Đơn hàng DGH20250512110634 đã được cập nhật trạng thái: Giao thất bại', '2025-05-12 16:21:29', 'Đã đọc'),
(10, 2, 'Bạn được phân công đơn hàng DGH20250512112800', '2025-05-12 16:28:28', 'Đã đọc'),
(11, 2, 'Đơn hàng DGH20250512112800 đã được cập nhật trạng thái: Đã giao thành công', '2025-05-12 16:30:04', 'Đã đọc'),
(12, 2, 'Bạn được phân công đơn hàng DGH20250512151347', '2025-05-12 20:14:05', 'Đã đọc'),
(13, 2, 'Đơn hàng DGH20250512151347 đã được cập nhật trạng thái: Đã giao thành công', '2025-05-12 20:14:47', 'Đã đọc'),
(14, 2, 'Đơn hàng DGH20250512151347 đã được cập nhật trạng thái: Đã giao', '2025-05-13 09:48:35', 'Đã đọc'),
(15, 2, 'Đơn hàng DGH20250512151347 đã được cập nhật trạng thái: Đã giao', '2025-05-13 09:48:40', 'Đã đọc'),
(16, 2, 'Bạn được phân công đơn hàng DGH20250513045234', '2025-05-13 09:53:43', 'Đã đọc'),
(17, 2, 'Đơn hàng DGH20250513045234 đã được cập nhật trạng thái: Đã giao', '2025-05-13 09:55:35', 'Đã đọc'),
(18, 2, 'Bạn được phân công đơn hàng DGH20250513055642', '2025-05-13 10:56:57', 'Đã đọc'),
(19, 2, 'Đơn hàng DGH20250513055642 đã được cập nhật trạng thái: Giao không thành công', '2025-05-13 10:57:46', 'Đã đọc'),
(20, 2, 'Đơn hàng DGH20250513055642 đã được cập nhật trạng thái: Giao không thành công', '2025-05-13 10:57:51', 'Đã đọc'),
(21, 2, 'Bạn được phân công đơn hàng DGH20250513055642', '2025-05-13 11:04:17', 'Đã đọc'),
(22, 2, 'Bạn được phân công đơn hàng DGH20250513060406', '2025-05-13 11:04:23', 'Đã đọc'),
(23, 2, 'Đơn hàng DGH20250513060406 đã được cập nhật trạng thái: Đã giao', '2025-05-13 11:05:54', 'Đã đọc'),
(24, 2, 'Đơn hàng DGH20250513055642 đã được cập nhật trạng thái: Giao không thành công', '2025-05-13 11:12:38', 'Đã đọc'),
(25, 2, 'Bạn được phân công đơn hàng DGH20250513171646', '2025-05-13 22:19:21', 'Đã đọc'),
(26, 2, 'Đơn hàng DGH20250513171646 đã được cập nhật trạng thái: Đã giao', '2025-05-13 22:21:53', 'Đã đọc'),
(27, 2, 'Bạn được phân công đơn hàng DGH20250515140343', '2025-05-15 19:21:12', 'Đã đọc'),
(28, 2, 'Đơn hàng DGH20250515140343 đã được cập nhật trạng thái: Giao không thành công', '2025-05-15 19:29:35', 'Đã đọc'),
(29, 2, 'Đơn hàng DGH20250512112800 đã được cập nhật trạng thái: Đang giao', '2025-05-16 17:07:49', 'Đã đọc');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthai`
--

CREATE TABLE `trangthai` (
  `id_trangThai` int(11) NOT NULL,
  `tenTrangThai` varchar(100) NOT NULL,
  `moTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthai`
--

INSERT INTO `trangthai` (`id_trangThai`, `tenTrangThai`, `moTa`) VALUES
(1, 'Đã tạo', 'Đơn hàng đã được tạo'),
(2, 'Đang xử lý', 'Đơn hàng đang được xử lý'),
(3, 'Đang giao', 'Đơn hàng đang trong quá trình vận chuyển'),
(4, 'Đã giao', 'Đơn hàng của bạn đã được giao thành công '),
(5, 'Giao không thành công', 'Đơn hàng của bạn giao thành công do người nhận từ chối nhận hàng '),
(6, 'Đã hủy', 'Đơn hàng đã bị hủy');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vanchuyen`
--

CREATE TABLE `vanchuyen` (
  `id_vanChuyen` int(11) NOT NULL,
  `maVanDon` varchar(40) NOT NULL,
  `id_BuuCuc` int(11) NOT NULL,
  `id_KhoHang` int(11) NOT NULL,
  `ngayXuat` datetime DEFAULT NULL,
  `ngayNhap` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `buucuc`
--
ALTER TABLE `buucuc`
  ADD PRIMARY KEY (`id_buuCuc`);

--
-- Chỉ mục cho bảng `diachi`
--
ALTER TABLE `diachi`
  ADD PRIMARY KEY (`id_diaChi`);

--
-- Chỉ mục cho bảng `doanhthu`
--
ALTER TABLE `doanhthu`
  ADD PRIMARY KEY (`id_doanhThu`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`maVanDon`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`id_hoaDon`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`id_khachHang`);

--
-- Chỉ mục cho bảng `khohang`
--
ALTER TABLE `khohang`
  ADD PRIMARY KEY (`id_kho`);

--
-- Chỉ mục cho bảng `lichlamviec`
--
ALTER TABLE `lichlamviec`
  ADD PRIMARY KEY (`id_lichLamViec`);

--
-- Chỉ mục cho bảng `lichsu_trangthai`
--
ALTER TABLE `lichsu_trangthai`
  ADD PRIMARY KEY (`id_lichSuTrangThai`);

--
-- Chỉ mục cho bảng `lienhe`
--
ALTER TABLE `lienhe`
  ADD PRIMARY KEY (`id_lienHe`);

--
-- Chỉ mục cho bảng `nguoigui`
--
ALTER TABLE `nguoigui`
  ADD PRIMARY KEY (`id_nguoiGui`);

--
-- Chỉ mục cho bảng `nguoinhan`
--
ALTER TABLE `nguoinhan`
  ADD PRIMARY KEY (`id_nguoiNhan`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`id_nhanVien`);

--
-- Chỉ mục cho bảng `phi`
--
ALTER TABLE `phi`
  ADD PRIMARY KEY (`id_phi`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id_sanPham`);

--
-- Chỉ mục cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD PRIMARY KEY (`id_thanhToan`);

--
-- Chỉ mục cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  ADD PRIMARY KEY (`id_thongBao`);

--
-- Chỉ mục cho bảng `trangthai`
--
ALTER TABLE `trangthai`
  ADD PRIMARY KEY (`id_trangThai`);

--
-- Chỉ mục cho bảng `vanchuyen`
--
ALTER TABLE `vanchuyen`
  ADD PRIMARY KEY (`id_vanChuyen`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `buucuc`
--
ALTER TABLE `buucuc`
  MODIFY `id_buuCuc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `diachi`
--
ALTER TABLE `diachi`
  MODIFY `id_diaChi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `doanhthu`
--
ALTER TABLE `doanhthu`
  MODIFY `id_doanhThu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `id_hoaDon` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `id_khachHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `khohang`
--
ALTER TABLE `khohang`
  MODIFY `id_kho` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `lichlamviec`
--
ALTER TABLE `lichlamviec`
  MODIFY `id_lichLamViec` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `lichsu_trangthai`
--
ALTER TABLE `lichsu_trangthai`
  MODIFY `id_lichSuTrangThai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `lienhe`
--
ALTER TABLE `lienhe`
  MODIFY `id_lienHe` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nguoigui`
--
ALTER TABLE `nguoigui`
  MODIFY `id_nguoiGui` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `nguoinhan`
--
ALTER TABLE `nguoinhan`
  MODIFY `id_nguoiNhan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `id_nhanVien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `phi`
--
ALTER TABLE `phi`
  MODIFY `id_phi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id_sanPham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  MODIFY `id_thanhToan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  MODIFY `id_thongBao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `trangthai`
--
ALTER TABLE `trangthai`
  MODIFY `id_trangThai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `vanchuyen`
--
ALTER TABLE `vanchuyen`
  MODIFY `id_vanChuyen` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
