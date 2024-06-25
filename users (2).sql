-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-06-25 10:52:54
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
(9, 'user19', '$2y$10$mHpNjlRj9606tqrmfolXRObv/VHisrUoxk48awf7vtVpTSVvBSy4m', 'kougaku', 'sen', '2024-06-21 12:28:27', NULL);

--
-- ダンプしたテーブルのインデックス
--

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
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
