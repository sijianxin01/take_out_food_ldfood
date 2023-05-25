-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2023-05-25 10:49:31
-- 服务器版本： 10.4.24-MariaDB
-- PHP 版本： 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `ldfood`
--

-- --------------------------------------------------------

--
-- 表的结构 `categories`
--

CREATE TABLE `categories` (
  `catid` int(10) UNSIGNED NOT NULL,
  `catname` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `categories`
--

INSERT INTO `categories` (`catid`, `catname`) VALUES
(1, '炒饭'),
(2, '面条'),
(4, '炒菜');

-- --------------------------------------------------------

--
-- 表的结构 `foods`
--

CREATE TABLE `foods` (
  `fno` char(20) NOT NULL,
  `username` char(16) NOT NULL,
  `title` char(100) DEFAULT NULL,
  `catid` int(10) UNSIGNED DEFAULT NULL,
  `price` float(4,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `state` varchar(20) NOT NULL DEFAULT '正常'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `foods`
--

INSERT INTO `foods` (`fno`, `username`, `title`, `catid`, `price`, `description`, `state`) VALUES
('111', 'shop', '蛋炒饭', 1, 8.00, '美味的蛋炒饭', '售罄'),
('221', 'shop', '兰州牛肉面', 2, 4.00, '美味的兰州牛肉面', '正常'),
('222', 'shop', '兰州拉面', 2, 7.00, '美味的兰州拉面', '推荐'),
('311', 'myshop', '西红柿炒鸡蛋', 4, 12.00, '美味的西红柿炒鸡蛋', '正常');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `orderid` int(10) UNSIGNED NOT NULL,
  `username` varchar(16) NOT NULL,
  `total` float(6,2) DEFAULT NULL,
  `date` datetime NOT NULL,
  `order_status` char(10) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `position` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`orderid`, `username`, `total`, `date`, `order_status`, `name`, `phone`, `position`) VALUES
(15, 'sjx', 114.00, '2022-06-17 16:40:02', 'PARTIAL', 'name', '0000', 'position'),
(16, 'sjx', 114.00, '2022-06-17 16:40:31', 'PARTIAL', 'name', '0000', 'position'),
(17, 'sjx', 114.00, '2022-06-17 16:41:47', 'PARTIAL', 'name', '0000', 'position'),
(18, 'sjx', 114.00, '2022-06-17 16:46:37', 'PARTIAL', 'name', '0000', 'position'),
(19, 'sjx', 19.00, '2022-06-17 16:53:06', 'PARTIAL', 'name', '0000', 'position'),
(20, 'myuser', 12.00, '2022-06-24 03:22:35', 'PARTIAL', 'name', '0000', 'position'),
(21, 'myuser', 12.00, '2022-06-24 03:23:26', 'PARTIAL', 'name', '0000', 'position'),
(22, 'myuser', 12.00, '2022-06-24 03:23:51', 'PARTIAL', 'name', '0000', 'position'),
(23, 'myuser', 12.00, '2022-06-24 03:23:53', 'PARTIAL', 'name', '0000', 'position'),
(24, 'myuser', 12.00, '2022-06-24 03:25:38', 'PARTIAL', 'name', '0000', 'position'),
(25, 'myuser', 12.00, '2022-06-24 03:26:24', 'PARTIAL', 'name', '0000', 'position'),
(26, 'sjx', 31.00, '2022-06-24 06:15:00', 'PARTIAL', 'name', '0000', 'position');

-- --------------------------------------------------------

--
-- 表的结构 `order_items`
--

CREATE TABLE `order_items` (
  `orderid` int(10) UNSIGNED NOT NULL,
  `fno` char(20) NOT NULL,
  `item_price` float(4,2) NOT NULL,
  `quantity` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `order_items`
--

INSERT INTO `order_items` (`orderid`, `fno`, `item_price`, `quantity`) VALUES
(15, '222', 7.00, 6),
(15, '111', 8.00, 4),
(16, '222', 7.00, 6),
(16, '111', 8.00, 4),
(17, '222', 7.00, 6),
(17, '111', 8.00, 4),
(18, '222', 7.00, 6),
(18, '111', 8.00, 4),
(19, '111', 8.00, 1),
(19, '222', 7.00, 1),
(20, '311', 12.00, 1),
(21, '311', 12.00, 1),
(22, '311', 12.00, 1),
(23, '311', 12.00, 1),
(24, '311', 12.00, 1),
(25, '311', 12.00, 1),
(26, '311', 12.00, 2),
(26, '222', 7.00, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `username` varchar(16) NOT NULL,
  `password` char(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 1,
  `name` varchar(30) NOT NULL,
  `sex` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `qq` varchar(20) NOT NULL,
  `default_pos` char(100) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`username`, `password`, `email`, `type`, `name`, `sex`, `age`, `phone`, `qq`, `default_pos`, `description`) VALUES
('sjx', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'sijianxin01@163.com', 1, 'sjx', 0, 0, '0000', '0000', 'position', 'description'),
('shop', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'sijianxin01@163.com', 2, 'shop', 0, 0, '0000', '0000', 'position', 'description'),
('myshop', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'sijianxin01@163.com', 2, 'myshop', 0, 21, '0000', '0000', 'position', 'description'),
('myuser', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'sijianxin01@163.com', 1, 'myuser', 0, 21, '0000', '0000', 'position', 'description'),
('admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', '\'\'', 3, '\'\'', 1, 1, '\'\'', '\'\'', '\'\'', '\'\'');

--
-- 转储表的索引
--

--
-- 表的索引 `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`catid`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `categories`
--
ALTER TABLE `categories`
  MODIFY `catid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `orderid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
