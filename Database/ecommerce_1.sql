-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 07:12 PM
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
-- Database: `ecommerce_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `admin_email` varchar(200) NOT NULL,
  `admin_image` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_name`, `admin_email`, `admin_image`, `admin_password`) VALUES
(1, 'admin', 'admin@gmail.com', 'desktop-wallpaper-funny-pfp-thumbnail.jpg', '$2y$10$faZC4sqrLt5ILDu.ken9z.Z2wHBF/11owyFeSVnPTbBQHVeKzbR5q');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`) VALUES
(1, 'ZAITUN'),
(2, '2Gleam'),
(3, 'Seharum Kasih'),
(4, 'SK De Parfum'),
(5, 'Home Made');

-- --------------------------------------------------------

--
-- Table structure for table `card_details`
--

CREATE TABLE `card_details` (
  `product_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`) VALUES
(1, 'Personal Care'),
(2, 'Perfume'),
(3, 'Food'),
(4, 'Household Products'),
(5, 'Candle');

-- --------------------------------------------------------

--
-- Table structure for table `orders_pending`
--

CREATE TABLE `orders_pending` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_pending`
--

INSERT INTO `orders_pending` (`order_id`, `user_id`, `invoice_number`, `product_id`, `quantity`, `payment_status`) VALUES

(19, 2, 1464686255, 5, 2, 'pending'),
(20, 2, 70568232, 1, 1, 'pending'),
(21, 2, 70568232, 3, 1, 'pending'),
(22, 2, 1398225137, 3, 1, 'pending'),
(23, 2, 1398225137, 4, 1, 'pending'),
(24, 2, 1209346871, 5, 1, 'pending'),
(25, 2, 1756335039, 4, 1, 'pending'),
(26, 2, 1756335039, 5, 1, 'pending'),
(27, 2, 1689933789, 3, 1, 'pending'),
(28, 4, 1472689637, 5, 1, 'pending'),
(29, 4, 859592118, 7, 1, 'pending'),
(30, 4, 1629927204, 8, 1, 'pending'),
(31, 4, 352606303, 10, 1, 'pending'),
(32, 4, 736697500, 16, 1, 'pending'),
(33, 4, 1504772535, 12, 1, 'pending'),
(34, 4, 1305846665, 7, 1, 'pending'),
(35, 4, 1723466301, 16, 1, 'pending'),
(36, 4, 480968334, 14, 1, 'pending'),
(37, 4, 640189905, 3, 1, 'pending'),
(38, 4, 951549549, 9, 1, 'pending'),
(39, 4, 1767325652, 9, 1, 'pending'),
(40, 4, 2059642081, 10, 1, 'pending'),
(41, 4, 1538988745, 3, 1, 'pending'),
(42, 4, 1538988745, 9, 1, 'pending'),
(43, 5, 1283931895, 16, 1, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(6, 6, 2, 1),
(7, 7, 2, 2),
(8, 8, 5, 1),
(9, 9, 3, 1),
(10, 10, 5, 1),
(11, 11, 4, 2),
(12, 12, 5, 1),
(13, 13, 3, 1),
(14, 14, 5, 1),
(15, 15, 5, 2),
(16, 16, 5, 2),
(17, 17, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(120) NOT NULL,
  `product_description` varchar(2000) NOT NULL,
  `product_keywords` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_image_one` varchar(255) NOT NULL,
  `product_image_two` varchar(255) NOT NULL,
  `product_image_three` varchar(255) NOT NULL,
  `product_price` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `product_keywords`, `category_id`, `brand_id`, `product_image_one`, `product_image_two`, `product_image_three`, `product_price`, `date`, `status`) VALUES
(1, 'Scented Candle (Agarwood)', '100 % Local Brand  100% Natural Soy Wax  Non-Toxic Premium Fragrance Oil 100 % Authentic UK Imported Concentrated Homemade & Hand Poured Soywax melt for your family, holiday, party, celebration or workplace to create a relaxed atmosphere and harmonious atmosphere! Super strong wax melts for indoor use, room, home, office Net Wt : 30 g Disclaimer  Candles are 100% fully handmade & hand poured All colours, shape, weight, sizes & scented are all custom-made pieces, there will always be slight differences from the pictures. Burning hours will be affected by humidity, wind & different factors of the particular space.', 'candle, lilin', 5, 18, 'sh(aw)1.webp', 'sh(aw)1.webp', 'sh(aw)1.webp', 7, '2024-11-20 18:00:25', 'true'),
(2, 'Scented Candle (Bergamot)', '100 % Local Brand  100% Natural Soy Wax  Non-Toxic Premium Fragrance Oil 100 % Authentic UK Imported Concentrated Homemade & Hand Poured Soywax melt for your family, holiday, party, celebration or workplace to create a relaxed atmosphere and harmonious atmosphere! Super strong wax melts for indoor use, room, home, office Net Wt : 30 g Disclaimer  Candles are 100% fully handmade & hand poured All colours, shape, weight, sizes & scented are all custom-made pieces, there will always be slight differences from the pictures. Burning hours will be affected by humidity, wind & different factors of the particular space.', 'candle, lilin', 5, 18, 'sh(b)1.webp', 'sh(b)1.webp', 'sh(b)1.webp', 7, '2024-11-06 13:25:06', 'true'),
(3, 'Cherry Blossom', 'CAR PERFUME 9ML  🚗 STRONG SCENT & LONG-LASTING – Keeps your car smelling fresh for longer!  🌿 NO HARMFUL INGREDIENTS – Safe for you and your loved ones. Drive with peace of mind while enjoying a powerful, pleasant fragrance!  👉 Get yours today and transform your car into a scent oasis!', 'car, perfume, minyak', 2, 19, 'Cherry-Blossom.jpg.webp', 'Cherry-Blossom.jpg.webp', 'Cherry-Blossom.jpg.webp', 10, '2024-11-06 13:36:34', 'true'),
(4, 'Salted Egg Cornflakes', 'Savourgasm Salted Egg Cornflakes 100 g.  APA YANG MENARIK TENTANG PRODUK INI?  ✅ Snek unik berasaskan cornflakes yang rangup terbaru di pasaran Malaysia.  ✅ Snek unik diadun sebati menggunakan bahan-bahan semulajadi (lada, daun kari)  ✅ Tanpa bahan MSG.  WARNING! SERIOUS ADDICTIVE', 'food, salted, cornflakes', 3, 20, 'sec1.webp', 'sec2.jpg', 'sec3.jpg', 10, '2024-11-20 15:39:07', 'true'),
(5, 'ZAITUN Value Pack Extra Mint Toothpaste 175g X2 / Fluoride Free Toothpaste', 'ZAITUN Extra Mint Toothpaste\r\n\r\n– It contains calcium to help with strengthening teeth.\r\n\r\n– It is specially formulated with fresh mint for long-lasting breathe.\r\n\r\n– Fluoride FREE\r\n\r\nTotal Protection / Perlindungan Penuh:\r\n\r\n✅Tartar\r\n\r\n✅Plaque\r\n\r\n✅Cavities\r\n\r\n✅Enamel\r\n\r\n✅Sensitivity\r\n\r\n✅Foul Breath\r\n\r\n✅Gum Care\r\n\r\n✅Teeth Whitening\r\n\r\nHALAL Certified', 'zaitun', 1, 16, 'z3.webp', 'z2.jpg', 'z1.jfif', 15, '2024-11-06 13:17:40', 'true'),
(6, 'Detergent 2 Litre (Blossom)', 'Introducing the Multi-Purpose Laundry Detergent that does it all! With soap, antibacterial protection, fragrance, and fabric care combined, it keeps your clothes fresh and protected. Usage Recommendation: Just 100ml for a 6kg load. Thanks to POWERGEL technology, a little goes a long way to tackle various stains! Specially formulated with color protection, anti-mildew, and anti-rust ingredients – perfect for indoor drying and long soaking with no sour smell. ADDITIONAL BENEFITS: Animal Fat-Free, ideal for home use and LAUNDRYCOIN. Double Perfume: Enhanced fragrance for long-lasting freshness!', 'sabun, detergent, cuci, baju', 4, 17, 'product_673e0365ebbdc7.03943808.jpg', 'product_673e0365ebcdf3.46342624.jpg', 'product_673e0365ebde42.73174237.jpg', 15.9, '2024-11-20 18:09:07', 'true'),
(7, 'Dishwash Lime 1 Litre', 'A dishwashing liquid suitable for household use as well as for restaurants or eateries. This powerful formula removes grease and grime, leaving your dishes clean and germ-free with antibacterial ingredients. How to Use: Mix 30ml of the liquid with 200ml of water to wash multiple dishes effortlessly.', 'sabun, dishwawsh, cuci, pinggan', 4, 17, 'product_673e040f1bc078.58654479.png', 'product_673e040f1bda36.75980673.png', 'product_673e040f1bebc1.42728617.png', 11, '2024-11-20 18:09:25', 'true'),
(8, 'Fabric & Room Spray 100 ml (Luxe Essence)', 'Say goodbye to stubborn odors! This product quickly and effectively freshens small and large spaces alike. Take it to work, on vacation, or keep it in your car for lasting freshness wherever you go. Luxe Essence features a delightful blend of bergamot and pine lavender scents. Comes in a convenient 100 ml bottle for easy portability. Direction to use: Shake before spraying to enhance its effectiveness. Spray in your space for effective results, or spray directly onto curtains for optimal freshness. For a longer-lasting scent, spray on curtains or linen and turn on the air conditioning.', 'pewangi, bilik, pewangi bilik, fabric', 4, 17, 'product_673e04d5cc3445.17965687.png', 'product_673e04d5cc4416.40141370.png', 'product_673e04d5d02641.80807906.png', 7.9, '2024-11-20 18:09:51', 'true'),
(9, 'Fabric & Room Spray 100 ml (Sandalwood Charm)', 'Say goodbye to stubborn odors! This product quickly and effectively freshens small and large spaces alike. Take it to work, on vacation, or keep it in your car for lasting freshness wherever you go. Sandalwood Charm features a delightful blend of sandalwood and vanilla scents. Comes in a convenient 100 ml bottle for easy portability. Direction to use: Shake before spraying to enhance its effectiveness. Spray in your space for effective results, or spray directly onto curtains for optimal freshness. For a longer-lasting scent, spray on curtains or linen and turn on the air conditioning.', 'pewangi, bilik, pewangi bilik, fabric', 4, 17, 'product_673e0565057965.21238553.png', 'product_673e05650589b0.95307021.png', 'product_673e05650598d1.77205922.png', 7.9, '2024-11-20 18:10:12', 'true'),
(10, 'Scented Candle (Eucalyptus)', '100 % Local Brand 100% Natural Soy Wax Non-Toxic Premium Fragrance Oil 100 % Authentic UK Imported Concentrated Homemade & Hand Poured Soywax melt for your family, holiday, party, celebration or workplace to create a relaxed atmosphere and harmonious atmosphere! Super strong wax melts for indoor use, room, home, office Net Wt : 30g Disclaimer Candles are 100% fully handmade & hand poured All colours, shape, weight, sizes & scented are all custom-made pieces, there will always be slight differences from the pictures. Burning hours will be affected by humidity, wind & different factors of the particular space.', 'candle, lilin', 5, 18, 'product_673e06b6380c26.03669474.png', 'product_673e06b63822e6.19502540.png', 'product_673e06b6383356.77833920.png', 7, '2024-11-20 18:11:16', 'true'),
(11, 'Scented Candle (Frangipani)', '100 % Local Brand\\r\\n\\r\\n100% Natural Soy Wax\\r\\n Non-Toxic\\r\\nPremium Fragrance Oil 100 % Authentic UK Imported Concentrated\\r\\nHomemade & Hand Poured\\r\\nSoywax melt for your family, holiday, party, celebration or workplace to create a relaxed atmosphere and harmonious atmosphere!\\r\\nSuper strong wax melts for indoor use, room, home, office\\r\\nNet Wt : 30 g\\r\\nDisclaimer\\r\\n\\r\\nCandles are 100% fully handmade & hand poured\\r\\nAll colours, shape, weight, sizes & scented are all custom-made pieces, there will always be slight differences from the pictures.\\r\\nBurning hours will be affected by humidity, wind & different factors of the particular space.', 'candle, lilin', 5, 18, 'product_673e0713645440.28465497.png', 'product_673e07136465f7.65400482.png', 'product_673e07136473a4.04704689.png', 7, '2024-11-20 15:58:11', 'true'),
(12, ' Scented Candle (Geranium)', '100 % Local Brand\\r\\n\\r\\n100% Natural Soy Wax\\r\\n Non-Toxic\\r\\nPremium Fragrance Oil 100 % Authentic UK Imported Concentrated\\r\\nHomemade & Hand Poured\\r\\nSoywax melt for your family, holiday, party, celebration or workplace to create a relaxed atmosphere and harmonious atmosphere!\\r\\nSuper strong wax melts for indoor use, room, home, office\\r\\nNet Wt : 30 g\\r\\nDisclaimer\\r\\n\\r\\nCandles are 100% fully handmade & hand poured\\r\\nAll colours, shape, weight, sizes & scented are all custom-made pieces, there will always be slight differences from the pictures.\\r\\nBurning hours will be affected by humidity, wind & different factors of the particular space.', 'candle, lilin', 5, 18, 'product_673e075b0c1593.52897659.png', 'product_673e075b0c2aa7.74366956.png', 'product_673e075b0c3d90.83408119.png', 7, '2024-11-20 15:59:23', 'true'),
(13, ' Apple Blossom', 'CAR PERFUME 9ML\\r\\n\\r\\n🚗 STRONG SCENT & LONG-LASTING – Keeps your car smelling fresh for longer!\\r\\n\\r\\n🌿 NO HARMFUL INGREDIENTS – Safe for you and your loved ones. Drive with peace of mind while enjoying a powerful, pleasant fragrance!\\r\\n\\r\\n👉 Get yours today and transform your car into a scent oasis!\\r\\n\\r\\n', 'car, perfume, minyak', 2, 19, 'product_673e084df13217.68450600.png', 'product_673e084df14964.31266617.png', 'product_673e084df163a0.84672810.png', 10, '2024-11-20 16:03:25', 'true'),
(14, 'Bubblegum', 'CAR PERFUME 9ML\\r\\n\\r\\n🚗 STRONG SCENT & LONG-LASTING – Keeps your car smelling fresh for longer!\\r\\n\\r\\n🌿 NO HARMFUL INGREDIENTS – Safe for you and your loved ones. Drive with peace of mind while enjoying a powerful, pleasant fragrance!\\r\\n\\r\\n👉 Get yours today and transform your car into a scent oasis!', 'car, perfume, minyak', 2, 19, 'product_673e08ff8cd1d7.63605228.png', 'product_673e08ff8cef82.79542642.png', 'product_673e08ff8d0271.32114407.png', 10, '2024-11-20 16:06:23', 'true'),
(15, 'Forest Rose', 'CAR PERFUME 9ML\\r\\n\\r\\n🚗 STRONG SCENT & LONG-LASTING – Keeps your car smelling fresh for longer!\\r\\n\\r\\n🌿 NO HARMFUL INGREDIENTS – Safe for you and your loved ones. Drive with peace of mind while enjoying a powerful, pleasant fragrance!\\r\\n\\r\\n👉 Get yours today and transform your car into a scent oasis!', 'car, perfume, minyak', 2, 19, 'product_673e099628b776.62780953.png', 'product_673e099628c823.37762334.png', 'product_673e099628daf7.85114856.png', 10, '2024-11-20 16:08:54', 'true'),
(16, 'Fresh Vanilla', 'CAR PERFUME 9ML\\r\\n\\r\\n🚗 STRONG SCENT & LONG-LASTING – Keeps your car smelling fresh for longer!\\r\\n\\r\\n🌿 NO HARMFUL INGREDIENTS – Safe for you and your loved ones. Drive with peace of mind while enjoying a powerful, pleasant fragrance!\\r\\n\\r\\n👉 Get yours today and transform your car into a scent oasis!', 'car, perfume, minyak', 2, 19, 'product_673e0a84a239c2.09969203.png', 'product_673e0a84a249e1.94773691.png', 'product_673e0a84a259d6.05504486.png', 10, '2024-11-20 16:12:52', 'true'),
(17, ' Tutti Fruity', 'CAR PERFUME 9ML\\\\r\\\\n\\\\r\\\\n🚗 STRONG SCENT & LONG-LASTING – Keeps your car smelling fresh for longer!\\\\r\\\\n\\\\r\\\\n🌿 NO HARMFUL INGREDIENTS – Safe for you and your loved ones. Drive with peace of mind while enjoying a powerful, pleasant fragrance!\\\\r\\\\n\\\\r\\\\n👉 Get yours today and transform your car into a scent oasis!', 'car, perfume, minyak', 2, 19, 'product_673e0b7ada5504.77654739.png', 'product_673e0b7ada64e3.73151056.png', 'product_673e0b7ada7156.51927039.png', 10, '2024-11-20 16:20:04', 'true'),
(18, 'Scented Candle (Pine Lavender)', '100 % Local Brand\\r\\n\\r\\n100% Natural Soy Wax\\r\\n Non-Toxic\\r\\nPremium Fragrance Oil 100 % Authentic UK Imported Concentrated\\r\\nHomemade & Hand Poured\\r\\nSoywax melt for your family, holiday, party, celebration or workplace to create a relaxed atmosphere and harmonious atmosphere!\\r\\nSuper strong wax melts for indoor use, room, home, office\\r\\nNet Wt : 30 g\\r\\nDisclaimer\\r\\n\\r\\nCandles are 100% fully handmade & hand poured\\r\\nAll colours, shape, weight, sizes & scented are all custom-made pieces, there will always be slight differences from the pictures.\\r\\nBurning hours will be affected by humidity, wind & different factors of the particular space.', 'candle, lilin', 5, 18, 'product_673e0c1fb0e825.36184321.png', 'product_673e0c1fb10192.79891852.png', 'product_673e0c1fb112e2.50856079.png', 7, '2024-11-20 16:19:43', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount_due` float NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `total_products` int(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_status` varchar(255) NOT NULL,
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`order_id`, `user_id`, `amount_due`, `invoice_number`, `total_products`, `order_date`, `payment_status`, `order_status`) VALUES
(8, 2, 20, 2121041842, 1, '2024-11-07 18:46:02', 'paid', ''),
(9, 2, 15, 1380368259, 1, '2024-11-07 19:34:19', 'paid', ''),
(10, 0, 10, 1880631341, 1, '2024-11-07 19:05:29', 'pending', ''),
(11, 0, 15, 1258927423, 1, '2024-11-07 19:05:51', 'pending', ''),
(12, 0, 30, 1423207871, 1, '2024-11-07 19:06:24', 'pending', ''),
(13, 0, 30, 1349478966, 1, '2024-11-07 19:09:12', 'pending', ''),
(14, 0, 30, 6326207, 1, '2024-11-07 19:11:32', 'pending', ''),
(15, 0, 30, 914976916, 1, '2024-11-07 19:12:54', 'pending', ''),
(16, 2, 30, 1464686255, 1, '2024-11-07 19:19:10', 'paid', ''),
(17, 2, 17, 70568232, 2, '2024-11-17 22:02:18', 'paid', ''),
(18, 2, 20, 1398225137, 2, '2024-11-20 12:10:44', 'pending', 'order placed'),
(19, 2, 15, 1209346871, 1, '2024-11-20 12:09:51', 'paid', 'out for delivery'),
(20, 2, 25, 1756335039, 2, '2024-11-20 12:09:32', 'paid', 'delivered'),
(21, 2, 10, 1689933789, 1, '2024-11-20 12:10:35', 'pending', 'order placed'),
(22, 4, 15, 1472689637, 1, '2024-11-20 12:15:17', 'paid', 'out for delivery'),
(23, 4, 11, 859592118, 1, '2024-11-20 16:24:22', 'paid', 'order placed'),
(29, 4, 10, 1723466301, 1, '2024-11-20 17:04:28', 'paid', 'pending'),
(30, 4, 10, 480968334, 1, '2024-11-20 17:29:13', 'paid', 'order placed'),
(31, 4, 20, 640189905, 1, '2024-11-20 17:29:19', 'paid', 'out for delivery'),
(33, 4, 17.9, 1767325652, 1, '2024-11-20 17:29:22', 'paid', 'order placed'),
(34, 4, 17, 2059642081, 1, '2024-11-20 17:29:27', 'paid', 'delivered'),
(35, 4, 27.9, 1538988745, 2, '2024-11-20 17:29:33', 'paid', 'out for delivery'),
(36, 5, 20, 1283931895, 1, '2024-11-20 17:37:21', 'paid', 'order placed');

-- --------------------------------------------------------

--
-- Table structure for table `user_payments`
--

CREATE TABLE `user_payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_payments`
--

INSERT INTO `user_payments` (`payment_id`, `order_id`, `invoice_number`, `amount`, `payment_method`, `payment_date`) VALUES
(2, 2, 1918753782, 35, 'cash_on_delivery', '2024-11-07 18:29:17'),
(3, 8, 2121041842, 20, 'cash_on_delivery', '2024-11-07 18:46:02'),
(4, 16, 1464686255, 30, 'online_banking', '2024-11-07 19:19:10'),
(5, 9, 1380368259, 15, 'online_banking', '2024-11-07 19:34:19'),
(6, 17, 70568232, 17, 'cash', '2024-11-17 22:02:18'),
(7, 19, 1209346871, 15, 'online_banking', '2024-11-18 18:30:48'),
(8, 20, 1756335039, 25, 'online_banking', '2024-11-19 12:22:56'),
(9, 22, 1472689637, 15, 'online_banking', '2024-11-20 11:46:01'),
(10, 23, 859592118, 11, 'online_banking', '2024-11-20 16:23:57'),
(11, 29, 1723466301, 10, 'online_banking', '2024-11-20 17:04:28'),
(12, 29, 1723466301, 10, 'online_banking', '2024-11-20 17:05:46'),
(13, 29, 1723466301, 10, 'online_banking', '2024-11-20 17:06:14'),
(14, 31, 640189905, 20, 'online_banking', '2024-11-20 17:22:38'),
(15, 30, 480968334, 10, 'online_banking', '2024-11-20 17:22:42'),
(16, 35, 1538988745, 28, 'cash', '2024-11-20 17:28:57'),
(17, 34, 2059642081, 17, 'online_banking', '2024-11-20 17:29:01'),
(18, 33, 1767325652, 18, 'cash', '2024-11-20 17:29:05'),
(19, 36, 1283931895, 20, 'online_banking', '2024-11-20 17:37:12');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_ip` varchar(100) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_mobile` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `username`, `user_email`, `user_password`, `user_image`, `user_ip`, `user_address`, `user_mobile`) VALUES
(2, 'haha', 'haha@gmail.com', '$2y$10$7M75iRaoSCNtR9VmMQD1/.LJ//n9Zp.jzlyeg0ClaFiBXFeanFK0q', 'desktop-wallpaper-funny-pfp-thumbnail.jpg', '::1', 'kl', '01111111111'),
(4, 'xorn', 'xorn@gmail.com', '$2y$10$WhLlCKNJa1to4c.1ZOwAZeE17SX.rzFJp1XTG4v7wCMXfJfe6OmLe', 'cursed-Goofy-Ahh-Images-meme_14.jpg', '::1', 'ampang', '012345789'),
(5, 'nets', 'nets@gmail.com', '$2y$10$/hW5B6dSLoUAZJw5YWXeUerD99wWheKhsJR9B/xt.7ZwhF/gORV2m', 'thanos-patrick-meme-pfp-5qy5wlmyntsq9kjq.jpg', '::1', 'gotham, klang', '01222258963');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `card_details`
--
ALTER TABLE `card_details`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders_pending`
--
ALTER TABLE `orders_pending`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `user_payments`
--
ALTER TABLE `user_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders_pending`
--
ALTER TABLE `orders_pending`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user_payments`
--
ALTER TABLE `user_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `user_orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
