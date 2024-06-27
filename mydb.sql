-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-06-27 08:02:22
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `mydb`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `mytable`
--

CREATE TABLE `mytable` (
  `id` int(11) NOT NULL,
  `foo` varchar(100) DEFAULT NULL,
  `bar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `mytable`
--

INSERT INTO `mytable` (`id`, `foo`, `bar`) VALUES
(2, 'い', -200),
(3, 'う', 300),
(5, 'い', -200),
(6, 'う', 300),
(8, 'い', -200),
(9, 'う', 300);

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `created_at`, `user_id`, `department`) VALUES
(1, 'あああ', 'あああ', '2024-06-07 10:38:31', NULL, NULL),
(2, 'あああ', 'あああ', '2024-06-07 10:38:35', NULL, NULL),
(3, 'あああ', 'あああ', '2024-06-07 10:43:58', NULL, NULL),
(4, 'aaaa', 'aaaa\r\naaaa', '2024-06-07 10:47:49', NULL, NULL),
(5, 'ああああ', 'ああああ', '2024-06-14 07:01:58', 1, NULL),
(6, 'あああ', 'あああ', '2024-06-14 07:38:26', 1, NULL),
(7, 'zaaa', 'adfjhdfkpa', '2024-06-20 05:18:42', 1, NULL),
(8, 'zaaa', 'adfjhdfkpa', '2024-06-20 05:23:37', 1, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `productinfo`
--

CREATE TABLE `productinfo` (
  `id` int(11) NOT NULL,
  `productname` varchar(30) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `productinfo`
--

INSERT INTO `productinfo` (`id`, `productname`, `price`, `stock`) VALUES
(1, 'イヤホン', 1500, 100),
(2, 'モバイルバッテリ', 3980, 10),
(3, 'USB-TypeC接続ケーブル', 800, 50),
(4, 'LOVOT', 500000, 2);

-- --------------------------------------------------------

--
-- テーブルの構造 `sabposts`
--

CREATE TABLE `sabposts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `sabposts`
--

INSERT INTO `sabposts` (`id`, `title`, `content`, `created_at`, `user_id`, `department`) VALUES
(1, 'こんにちは', 'てすと', '2024-06-14 08:56:27', 7, ''),
(2, 'aaa', 'sssss', '2024-06-20 05:12:51', 1, '');

-- --------------------------------------------------------

--
-- テーブルの構造 `table1`
--

CREATE TABLE `table1` (
  `id` int(11) NOT NULL,
  `product` varchar(40) NOT NULL,
  `cost` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `table1`
--

INSERT INTO `table1` (`id`, `product`, `cost`, `stock`) VALUES
(1, 'A', 1280, 1),
(2, 'B', 2980, 0),
(3, 'C', 198, 3),
(4, 'D', 3980, 5),
(5, 'E', 990, 121),
(6, 'F', 1500, 100),
(7, 'G', 1980, 52),
(8, 'H', 256, 22),
(9, 'I', 512, 27),
(10, 'J', 3333, 4);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gakubu` varchar(50) NOT NULL,
  `gakka` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `department` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `gakubu`, `gakka`, `created_at`, `department`) VALUES
(1, 'user1', '$2y$10$favZuFHVnwvwU', 'shakai', 'pm', '2024-06-06 05:41:55', NULL),
(3, 'user2', '$2y$10$1/V46mFb7oqXR', 'shakai', 'pm', '2024-06-06 05:48:51', NULL),
(4, 'user3', 'pass3', 'shakai', 'pm', '2024-06-06 05:58:34', NULL),
(5, 'user4', '$2y$10$5evIibD9LiS/T', 'kougaku', 'jo', '2024-06-06 06:04:12', NULL),
(6, 'user5', '$2y$10$vGGMJcq1Lf3BR', 'senshin', 'mirobo', '2024-06-06 06:11:23', NULL),
(7, 'user7', '$2y$10$0fQelgSp0Bzg2', 'mirai', 'dejihen', '2024-06-14 08:52:36', NULL),
(8, 'user8', '$2y$10$pDEx3Obu7dzZJ', 'shakai', 'pm', '2024-06-20 06:18:53', NULL),
(9, 'user19', '$2y$10$mHpNjlRj9606tqrmfolXRObv/VHisrUoxk48awf7vtVpTSVvBSy4m', 'kougaku', 'sen', '2024-06-21 12:28:27', NULL),
(10, 'user11', '$2y$10$ejhXYpgJISx.EVzq/RJUnuqrp.DubSL7KSSs6z0Y0r82n4H1q1ZrK', 'kougaku', 'den', '2024-06-25 09:06:21', NULL),
(11, 'user12', '$2y$10$uTIpZT1E/s0VKcAaeCkYhek93OR.eIVyJYiaLKa99A3kREMmwJ0S2', 'kougaku', 'ut', '2024-06-27 05:59:19', NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `mytable`
--
ALTER TABLE `mytable`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `productinfo`
--
ALTER TABLE `productinfo`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `sabposts`
--
ALTER TABLE `sabposts`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `table1`
--
ALTER TABLE `table1`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `mytable`
--
ALTER TABLE `mytable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- テーブルの AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- テーブルの AUTO_INCREMENT `productinfo`
--
ALTER TABLE `productinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `sabposts`
--
ALTER TABLE `sabposts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `table1`
--
ALTER TABLE `table1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
