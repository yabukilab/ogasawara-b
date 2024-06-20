-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-06-20 08:06:02
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
-- データベース: `sample`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
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
(1, 'user1', '$2y$10$favZuFHVnwvwUGFpB/5Nou1sohe.ZfHrZi4qwH9NdQ2rd0DiBDF0a', 'shakai', 'pm', '2024-06-06 05:41:55', NULL),
(3, 'user2', '$2y$10$1/V46mFb7oqXR9kChSTleuf8gUvBYuy6wnob35/GnjT75B7gqjhve', 'shakai', 'pm', '2024-06-06 05:48:51', NULL),
(4, 'user3', 'pass3', 'shakai', 'pm', '2024-06-06 05:58:34', NULL),
(5, 'user4', '$2y$10$5evIibD9LiS/Txhp4PtDRee7RLrY3Pp3iIrENFeU7cTMQMenOPQd2', 'kougaku', 'jo', '2024-06-06 06:04:12', NULL),
(6, 'user5', '$2y$10$vGGMJcq1Lf3BRcQnoKKFJu4AT75EwHdwRsXOXqS6Qbrb6pzOV7ZRG', 'senshin', 'mirobo', '2024-06-06 06:11:23', NULL),
(7, 'user7', '$2y$10$0fQelgSp0Bzg2Gnm1K8Nd.xo/Mnu7GKGC09Vv2uXxT1f7asrpuhr.', 'mirai', 'dejihen', '2024-06-14 08:52:36', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
