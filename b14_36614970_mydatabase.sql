-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: sql310.byetcluster.com
-- Thời gian đã tạo: Th5 27, 2024 lúc 10:55 PM
-- Phiên bản máy phục vụ: 10.4.17-MariaDB
-- Phiên bản PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `b14_36614970_mydatabase`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price_cart` int(11) NOT NULL,
  `quality` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`product_id`, `user_id`, `price_cart`, `quality`) VALUES
(1, 7, 12000000, 2),
(1, 8, 12000000, 1),
(1, 14, 12000000, 2),
(2, 7, 61201000, 1),
(2, 14, 61201000, 1),
(3, 14, 34500000, 3),
(59, 16, 6932000, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(4, 'Bông tai'),
(5, 'Dây chuyền'),
(7, 'Kim cương'),
(6, 'Mặt Dây chuyền'),
(8, 'Ngọc Trai'),
(14, 'Nhẫn'),
(10, 'Trang sức combo'),
(9, 'Trang sức cưới'),
(11, 'Trang sức nam'),
(12, 'Trang sức phong thủy'),
(2, 'Vòng chân'),
(1, 'Vòng tay');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ct_dathang`
--

CREATE TABLE `ct_dathang` (
  `id_order` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `ct_dathang`
--

INSERT INTO `ct_dathang` (`id_order`, `product_id`, `quantity`, `price`) VALUES
(24, 1, 1, 12000000),
(24, 2, 3, 183603000),
(24, 3, 3, 103500000),
(24, 44, 2, 8000000),
(25, 1, 1, 12000000),
(25, 2, 1, 61201000),
(26, 2, 2, 122402000),
(33, 59, 1, 6932000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dathang`
--

CREATE TABLE `dathang` (
  `id_order` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `ThanhTien` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `dathang`
--

INSERT INTO `dathang` (`id_order`, `id_user`, `ThanhTien`) VALUES
(24, 7, 307103000),
(25, 7, 73201000),
(26, 9, 122402000),
(33, 16, 6932000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `Image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `Image`) VALUES
(1, 'Bông tai kim cương nữ Petton xanh ngọc bích', 'Đá Quý Kim Cương Nhân Tạo Màu Sắc / Hợp KimVàng Trắng 14KMạ Rhodium', 12000000, 'BONG5.jpg'),
(2, 'Mặt dây chuyền nữ Yoshie', 'Đá Quý	Kim Cương Nhân Tạo\r\nMàu Sắc / Hợp Kim	Vàng 14K\r\nTrọng lượng trung bình	≈ 2.65 Gram\r\nĐộ bền', 61201000, 'CHUYEN3.jpg'),
(3, 'VÒNG TAY MẮT HỔ XANH ĐEN 2A 12 MIX CHARM BI KIM TIỀN BẠC', 'Đá thạch anh', 34500000, 'vongphongthuy.png'),
(44, 'DÂY CHUYỀN SWAROVSKI THIÊN NGA ', 'Dây chuyền Swarovski thiên nga đá nhảy chính hãng Dancing Swan Necklace', 4000000, 'daychuyen_TN.png'),
(47, 'Bộ trang sức ngọc trai thật ', 'Chất liệu ngọc trai thật ( có giấy kiểm định đi kèm ) Thiết kế tinh xảo trên công nghệ 3D ', 140000000, 'botrangsucngoctrai.jpg'),
(48, 'Bộ trang sức Kim cương, nhẫn, bông tai, dây chuyền', ' Vàng trắng 14K PNJ 00703-02002 Mã: GBDDDDW000703', 40000000, 'Kimcuongbo.png'),
(49, 'Nhẫn cưới Vàng 18K đính đá ECZ PNJ Trầu Cau XMXMY009666', 'Mã: GNXMXMY009666', 23000000, 'nhancuoi.png'),
(50, 'Lắc tay nam bạc PNJSilver 0000W060210', 'Mã: SL0000W060210', 6000000, 'vongtaynam.png'),
(51, 'Lắc tay Kim cương Vàng trắng 14K PNJ Kim Bảo Như Ý', 'Mã: GLDDDDW000851', 137000000, 'vongtaykc.png'),
(52, 'Lắc Chân Bạc Nữ  Hình Ngôi Sao Băng', 'Chiếc lắc được làm bằng bạc S925 đính đá Cubic Zirconia', 550000, 'Lacchan.jpg'),
(53, 'Bông Xoàn Tấm – Shine MD_T3.13-166 ', 'Mã sản phẩm  MD_T3.13-166 Kiểu dáng circle Chất liệu VT18k Đá tấm                                         Kim cương', 12300000, 'bong-tai-kim-cuong.png'),
(54, 'VÒNG CỔ SWAROVSK', 'Vòng cổ Swarovski Mixed Cuts Mesmera Necklace 5665242 mang thiết kế thanh lịch, sang trọng', 8800000, 'Day-Chuyen.jpg'),
(55, 'MẶT DÂY HOA MẪU ĐƠN THẠCH ANH TÓC VÀNG_1.8 ', 'Mặt Dây Hoa Mẫu Đơn Thạch Anh Tóc Vàng_1.8 Bọc Vàng 10k Sủi Đá- là bảo vật May Mắn, Bình An mang đến cho người đeo cơ hội thăng tiến', 4740000, 'phongthuy.jfif'),
(56, 'Bông Tai Kim Cương sản phẩm E.TK.2313', 'Đẳng Cấp Trang Sức Trang Kim Luxury ', 18420000, 'bongtaikc.jpeg'),
(57, 'VÒNG CỔ NGỌC TRAI HỒNG HAI TẦNG T23.234', 'Loại ngọc: ngọc trai nuôi nước ngọt Màu sắc: hồng Hình dạng: giọt nước Kích thước: 5-7mm', 1800000, 'vongcongoctrai.jpg'),
(58, 'NHẪN NGỌC TRAI SIZE ĐẠI T24056', 'Loại ngọc: ngọc trai nuôi nước ngọt Màu sắc: trắng, hồng, đen', 1520000, 'nhanngoctrai.jpg'),
(59, 'Bông tai Vàng Trắng 14K đính Ngọc trai Akoya PNJ', 'Mã: GBPAXMW000169', 6932000, 'bongtaingoctrai.png'),
(60, 'Nhẫn Vàng trắng 14K đính đá ECZ PNJ XMXMW004696', 'Mã: GNXMXMW004696', 8359000, 'nhán.png'),
(61, 'Lắc tay cưới Vàng 24K PNJ Trầu Cau 0000Y002848', 'Mã: GL0000Y002848', 31578000, 'lactaytraucua.png'),
(62, 'Bộ trang sức cưới Vàng trắng 10K đính đá ECZ PNJ Trầu cau 00373-04069', 'Mã: GCXMXMW000373-GNXMXMW004069', 37862000, 'combo11.png'),
(63, 'Nhẫn nam Vàng trắng 14K đính đá Topaz PNJ TPXMW000156', 'Mã: GNTPXMW000156', 19887000, 'nhannam.png'),
(64, 'Bộ trang sức Kim cương nam Vàng Trắng 14K PNJ 000656-002309', 'Mã: GLDDDDW000656-GMDDDDW002309', 263608000, 'combonam.png'),
(65, 'Lắc chân bạc PNJ STYLE x CHOU CHOU 0000Y000026', 'Mã: SL0000Y000026', 1030500, 'LacChan1.png'),
(66, 'Lắc chân Vàng trắng Ý 18K PNJ 0000W000361', 'Mã: GL0000W000361', 15099000, 'LacChan2.png'),
(67, 'NHẪN HỒ LY THẠCH ANH TÓC VÀNG', 'Những sợi Rutile tóc vàng như những sợi kim tiền, đem lại may mắn về tài lộc, cải thiện tình cảm lứa đôi.', 1399000, 'nhanphongthuy.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_category`
--

CREATE TABLE `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
(1, 4),
(1, 9),
(3, 11),
(3, 12),
(44, 5),
(44, 6),
(47, 8),
(47, 10),
(48, 7),
(48, 9),
(48, 10),
(49, 9),
(49, 14),
(50, 1),
(50, 11),
(51, 1),
(51, 7),
(52, 2),
(53, 4),
(53, 7),
(54, 5),
(54, 7),
(55, 5),
(55, 6),
(55, 12),
(56, 4),
(56, 7),
(57, 5),
(57, 8),
(58, 8),
(58, 14),
(59, 4),
(59, 8),
(60, 7),
(60, 14),
(61, 1),
(61, 9),
(62, 9),
(62, 10),
(63, 11),
(64, 7),
(64, 10),
(64, 11),
(65, 2),
(66, 2),
(67, 12),
(67, 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qtadmin`
--

CREATE TABLE `qtadmin` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `gender` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `qtadmin`
--

INSERT INTO `qtadmin` (`id`, `username`, `password`, `email`, `gender`) VALUES
(3, 'PhanTranMinhTam', '$2y$10$avYaI/.WDxrzAxK20bXLVedFksWn8V1N4zONvU8IJUve4hCjJcjy.', 'phantranminhtam2873@gmail.com', 'Nữ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `gender` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `gender`) VALUES
(1, 'TuongVy', '$2y$10$jYJiY9oiJb4BcOgGQL99quWfuPMLZUUVMN9TwG2i3xZeeEH38hnFG', 'tuongvy@gmail.com', 'nữ'),
(3, 'tam', '$2y$10$eLhqeL8NXT2VGvCJufgk4utzVJ/jvhkoYzkNRnIhgkeLeTHxH5Siq', 'phantam@gmail.com', 'Nữ'),
(4, 'Tam', '$2y$10$I8ldlv9QHe.SD.3o.FnMMOQu0Dn1lsg1w4UdwGbGFcer9FEEe9BiW', 'PhanTam@gmail.com', 'Nữ'),
(6, 'MinhTam', '$2y$10$DnzWrTxEU09ktzelvLMTweQ/Ca.J7OYTj2EgYAq2jUbLiYm.rR6Ju', 'phantranminhtam2873@gmail.com', 'Nữ'),
(7, 'HoangThanh', '$2y$10$KrTNYpjzqTci.PCjG0Iyd.CP4D19oi7TlM36RJBQyhTbuTGWvMhHW', 'hoangthanh@gmail.com', 'Nam'),
(8, 'NguyenThuHien', '$2y$10$1qpVcHEZxNt8uWWH.cma9OwFgV5odh7nCfZDcrXqpUa3bAdMVLScy', 'thuhien@gmail.com', 'Nữ'),
(9, 'HuynhThuyNgan', '$2y$10$CMWttgjQvADXlJJvo9sh2OIfuJi99WJzjuZcW3hbZdzv/YljVQLgO', 'thuyngan@gmail.com', 'Nữ'),
(14, 'HuynhTrongMinh', '$2y$10$f7fn72BE3t/8y4FYVj8zTuBvehzkrovseI3qMu.nz.a3hcHA2low6', 'huyhtrong@gmail.com', 'Nam'),
(16, 'HoangNhatThat', '$2y$10$TglEclR0TSVjuq09chDwvuT2GIDyRpQzRaUI68wH5IPUKaqZpJ.R2', 'nhatthat@gmail.com', 'Nam');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`product_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Chỉ mục cho bảng `ct_dathang`
--
ALTER TABLE `ct_dathang`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `id_order` (`id_order`) USING BTREE;

--
-- Chỉ mục cho bảng `dathang`
--
ALTER TABLE `dathang`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_user` (`id_user`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `product_category_ibfk_1` (`category_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `dathang`
--
ALTER TABLE `dathang`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `ct_dathang`
--
ALTER TABLE `ct_dathang`
  ADD CONSTRAINT `ct_dathang_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `dathang` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ct_dathang_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `dathang`
--
ALTER TABLE `dathang`
  ADD CONSTRAINT `dathang_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
