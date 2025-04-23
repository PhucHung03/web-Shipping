-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 23, 2025 lúc 05:27 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webshipping`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `diaChiNguoiNhan` text NOT NULL,
  `tinh_tp` varchar(100) NOT NULL,
  `quan_huyen` varchar(100) NOT NULL,
  `phuong_xa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `addresses`
--

INSERT INTO `addresses` (`address_id`, `diaChiNguoiNhan`, `tinh_tp`, `quan_huyen`, `phuong_xa`) VALUES
(1, '1', 'Tỉnh Phú Thọ', 'Huyện Thanh Sơn', 'Xã Tân Lập'),
(2, '72 Liên Xã', 'Tỉnh Quảng Trị', 'Huyện Triệu Phong', 'Xã Triệu Đại'),
(3, '123', 'Thành phố Hồ Chí Minh', 'Quận Bình Tân', 'Phường Bình Trị Đông B'),
(4, '1', 'Thành phố Hồ Chí Minh', 'Quận Bình Tân', 'Phường Bình Trị Đông B');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `fees`
--

CREATE TABLE `fees` (
  `fee_id` int(11) NOT NULL,
  `maVanDon` varchar(20) NOT NULL,
  `phiDichVu` decimal(15,2) NOT NULL,
  `phiKhaiGia` decimal(15,2) NOT NULL,
  `phiCOD` decimal(15,2) NOT NULL,
  `tongPhi` decimal(15,2) NOT NULL,
  `benTraPhi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `fees`
--

INSERT INTO `fees` (`fee_id`, `maVanDon`, `phiDichVu`, `phiKhaiGia`, `phiCOD`, `tongPhi`, `benTraPhi`) VALUES
(1, 'DGH20250422105226', 24000.00, 0.00, 1.00, 24001.00, 'sender-pay'),
(2, 'DGH20250422105531', 24000.00, 5000.00, 1000000.00, 1029000.00, 'sender-pay'),
(3, 'DGH20250422110233', 24000.00, 5000.00, 1000000.00, 1029000.00, 'Người gửi trả phí'),
(4, 'DGH20250422160051', 24000.00, 6156.00, 1231234.00, 1261390.00, 'Người nhận trả phí');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khach`
--

CREATE TABLE `khach` (
  `id_khachhang` int(11) NOT NULL,
  `hoTen` varchar(100) NOT NULL,
  `soDienThoai` varchar(100) NOT NULL,
  `diaChi` text DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khach`
--

INSERT INTO `khach` (`id_khachhang`, `hoTen`, `soDienThoai`, `diaChi`, `email`, `password`) VALUES
(1, 'Phúc Hưng', '0376963735', '592/16 Hồ Học Lãm', 'fisph01@gmail.com', '$2y$10$kgu3jGT7X/jwFQyUbHZSQe6WlvZULfOg6OgVlThP6VTzbm1BI.k/O'),
(2, 'Phúc Hưng', '0376963735', '592/16 Hồ Học Lãm', 'hung@gmail.com', '$2y$10$PKhtLzOjeNtH6Z5rlHNYxurTUBme8MBeyMaRvpb4px4ib.98h0HVK');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `maVanDon` varchar(40) NOT NULL,
  `id_khachhang` int(11) DEFAULT NULL,
  `hinhThucGui` varchar(50) NOT NULL,
  `KL_DH` decimal(10,2) NOT NULL,
  `dai` decimal(10,2) NOT NULL,
  `rong` decimal(10,2) NOT NULL,
  `cao` decimal(10,2) NOT NULL,
  `giaTriHang` decimal(15,2) DEFAULT NULL,
  `COD` decimal(15,2) DEFAULT NULL,
  `ghiChu` text DEFAULT NULL,
  `ngayTaoDon` datetime NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `fee_id` int(11) DEFAULT NULL,
  `current_status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`maVanDon`, `id_khachhang`, `hinhThucGui`, `KL_DH`, `dai`, `rong`, `cao`, `giaTriHang`, `COD`, `ghiChu`, `ngayTaoDon`, `sender_id`, `receiver_id`, `fee_id`, `current_status_id`) VALUES
('DGH20250422105226', 1, 'Lấy hàng tận nơi', 12341.00, 123.00, 12.00, 12.00, 0.00, 1.00, 'k', '2025-04-22 10:52:26', 1, 1, 1, 1),
('DGH20250422105531', 2, 'Lấy hàng tận nơi', 2000.00, 12.00, 12.00, 12.00, 3.00, 1000000.00, 'cho xem hàng ', '2025-04-22 10:55:31', 2, 2, 2, 1),
('DGH20250422110233', 1, 'Lấy hàng tận nơi', 1234.00, 12.00, 12.00, 12.00, 123123.00, 1000000.00, 'cho xem hàng ', '2025-04-22 11:02:33', 3, 3, 3, 1),
('DGH20250422160051', 2, 'Gửi tại bưu cục', 1234.00, 12.00, 12.00, 12.00, 3.00, 1231234.00, 'cho kiểm tra hàng', '2025-04-22 16:00:51', 4, 4, 4, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderstatuses`
--

CREATE TABLE `orderstatuses` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orderstatuses`
--

INSERT INTO `orderstatuses` (`status_id`, `status_name`, `description`) VALUES
(1, 'Đã tạo', 'Đơn hàng mới được tạo'),
(2, 'Đang xử lý', 'Đơn hàng đang được xử lý'),
(3, 'Đang giao', 'Đơn hàng đang trong quá trình vận chuyển'),
(4, 'Đã giao', 'Đơn hàng đã được giao thành công'),
(5, 'Đã hủy', 'Đơn hàng đã bị hủy');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderstatushistory`
--

CREATE TABLE `orderstatushistory` (
  `history_id` int(11) NOT NULL,
  `maVanDon` varchar(20) NOT NULL,
  `status_id` int(11) NOT NULL,
  `status_timestamp` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orderstatushistory`
--

INSERT INTO `orderstatushistory` (`history_id`, `maVanDon`, `status_id`, `status_timestamp`, `location`, `notes`) VALUES
(1, 'DGH20250422105226', 1, '2025-04-22 10:52:26', 'Tỉnh Phú Thọ', 'Tạo đơn thành công'),
(2, 'DGH20250422105531', 1, '2025-04-22 10:55:31', 'Tỉnh Quảng Trị', 'Tạo đơn thành công'),
(3, 'DGH20250422110233', 1, '2025-04-22 11:02:33', 'Thành phố Hồ Chí Minh', 'Tạo đơn thành công'),
(4, 'DGH20250422160051', 1, '2025-04-22 16:00:51', 'Thành phố Hồ Chí Minh', 'Tạo đơn thành công');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `maVanDon` varchar(20) NOT NULL,
  `maSP` varchar(50) DEFAULT NULL,
  `tenSP` varchar(255) NOT NULL,
  `KL_SP` decimal(10,2) NOT NULL,
  `SL_SP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `maVanDon`, `maSP`, `tenSP`, `KL_SP`, `SL_SP`) VALUES
(1, 'DGH20250422105226', '12', 'quần ', 200.00, 1),
(2, 'DGH20250422105531', '117', 'quần ', 200.00, 1),
(3, 'DGH20250422110233', '12', 'quần ', 200.00, 1),
(4, 'DGH20250422110233', '', '', 200.00, 1),
(5, 'DGH20250422160051', '123', 'quần ', 200.00, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `receivers`
--

CREATE TABLE `receivers` (
  `receiver_id` int(11) NOT NULL,
  `tenNguoiNhan` varchar(100) NOT NULL,
  `sdtNguoiNhan` varchar(15) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `receivers`
--

INSERT INTO `receivers` (`receiver_id`, `tenNguoiNhan`, `sdtNguoiNhan`, `address_id`) VALUES
(1, 'Phúc Hưng', '0352237434', 1),
(2, 'Phan Như Quỳnh', '0352237434', 2),
(3, 'Phúc Hưng', '0352237434', 3),
(4, 'Phúc Hưng', '0352237434', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `senders`
--

CREATE TABLE `senders` (
  `sender_id` int(11) NOT NULL,
  `tenNguoiGui` varchar(100) NOT NULL,
  `diaChiNguoiGui` text NOT NULL,
  `sdtNguoiGui` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `senders`
--

INSERT INTO `senders` (`sender_id`, `tenNguoiGui`, `diaChiNguoiGui`, `sdtNguoiGui`) VALUES
(1, 'Hồ Thị Cẩm Phương', '123 đồng nai', '0376963735'),
(2, 'Phan Công Phúc Hưng', '592/16 hồ học lãm, bình tân, TP.HCM', '0376963735'),
(3, 'Hồ Thị Cẩm Phương', '123 đồng nai', '0376963735'),
(4, 'Nguyễn Đình Hoàng', 'bình định', '0376963735');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`);

--
-- Chỉ mục cho bảng `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`fee_id`);

--
-- Chỉ mục cho bảng `khach`
--
ALTER TABLE `khach`
  ADD PRIMARY KEY (`id_khachhang`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`maVanDon`);

--
-- Chỉ mục cho bảng `orderstatuses`
--
ALTER TABLE `orderstatuses`
  ADD PRIMARY KEY (`status_id`);

--
-- Chỉ mục cho bảng `orderstatushistory`
--
ALTER TABLE `orderstatushistory`
  ADD PRIMARY KEY (`history_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `receivers`
--
ALTER TABLE `receivers`
  ADD PRIMARY KEY (`receiver_id`);

--
-- Chỉ mục cho bảng `senders`
--
ALTER TABLE `senders`
  ADD PRIMARY KEY (`sender_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `fees`
--
ALTER TABLE `fees`
  MODIFY `fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `khach`
--
ALTER TABLE `khach`
  MODIFY `id_khachhang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `orderstatuses`
--
ALTER TABLE `orderstatuses`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `orderstatushistory`
--
ALTER TABLE `orderstatushistory`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `receivers`
--
ALTER TABLE `receivers`
  MODIFY `receiver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `senders`
--
ALTER TABLE `senders`
  MODIFY `sender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
