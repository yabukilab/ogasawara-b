-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-07-06 13:32:44
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
-- テーブルの構造 `department`
--
drop table if exists department;

CREATE TABLE `department` (
  `ryakugo` varchar(10) DEFAULT NULL,
  `gakka` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `department`
--

INSERT INTO `department` (`ryakugo`, `gakka`) VALUES
('ut', '宇宙・半導体工学科'),
('sen', '先端材料工学科'),
('den', '電気電子工学科'),
('jo', '情報通信システム工学科'),
('ouyo', '応用化学科'),
('ken', '建築学科'),
('tosi', '都市環境工学科'),
('deza', 'デザイン科学科'),
('seimei', '生命科学科'),
('tinome', '知能メディア学科'),
('jouhou', '情報工学科'),
('ninti', '認知情報科学科'),
('koudo', '高度応用情報科学科'),
('dejihen', 'デジタル変革科学科'),
('keideza', '経営デザイン科学科'),
('net', '情報ネットワーク学科'),
('keijou', '経営情報科学科'),
('pm', 'プロジェクトマネジメント学科'),
('kinyuu', '金融・経営リスク科学科');

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--
drop table if exists posts;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `department_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `created_at`, `department_id`) VALUES
(1, 15, '今日は暑い。PM演習ももう少しです。みんな、頑張ろう！', '2024-07-06 05:48:13', 'pm'),
(2, 15, '繰り返しますが、今日は本当に暑い。東京都知事選挙に行ってきたよ。', '2024-07-06 06:43:37', 'zen'),
(3, 15, 'もう一回書き込むよ！　これで3回目。', '2024-07-06 05:53:48', 'pm'),
(4, 15, 'もう一回書き込むよ！　これで4回目。', '2024-07-06 06:43:49', 'zen'),
(5, 15, 'なかなか難しい。これで5回目。行ったり来たりするとセッションで情報をやり取りしないといけないので面倒だな。', '2024-07-06 05:56:54', 'pm'),
(6, 15, 'savechat.phpを直したよ。これで大丈夫だと思うけど。', '2024-07-06 06:06:13', 'pm'),
(7, 15, 'これを記入してコメントが増えればOKなのだけど…', '2024-07-06 07:17:29', 'zen'),
(8, 15, '雨が降りそうです。とても暑い。今日は学校に来ない方がいいな。', '2024-07-06 07:32:53', 'pm'),
(9, 15, '全体には登校できるのだ', '2024-07-06 07:33:19', 'zen'),
(10, 18, 'はじめての書き込みです。よろしくお願いします。', '2024-07-06 07:34:43', 'net'),
(11, 18, 'こっちにも書き込んでみるね。みなさんよろしくお願いします。', '2024-07-06 07:35:18', 'zen'),
(12, 19, '新しい学科ですね。頑張ります！よろしくお願いします。', '2024-07-06 07:36:23', 'ut'),
(13, 19, '僕も今年入学しました。宇宙飛行士になりたいです。', '2024-07-06 07:36:52', 'zen'),
(14, 19, 'ほぼ完成かな。なかなか難しいな。というか、データの引き継ぎが面倒。', '2024-07-06 07:37:36', 'ut'),
(15, 20, 'プロジェクトマネジメント学科に入学しました。よろしくお願いしますね！', '2024-07-06 11:10:01', 'pm'),
(16, 20, 'こっちにも挨拶しておきますね。マリーゴールド、聞いてね。', '2024-07-06 11:10:26', 'zen'),
(17, 21, '今日の雨はすごかった。暑かったし。しんどい。', '2024-07-06 11:12:05', 'net');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--
drop table if exists users;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `faculty` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `faculty`, `department`, `created_at`) VALUES
(15, 'user1', '$2y$10$9Is5oI24sbOb4lx1r6dJpO0srFQPVhAC5dzv6j6oGBbED31vm6XlK', 'shakai', 'pm', '2024-07-05 16:21:08'),
(16, 'user2', '$2y$10$.1/6yx5XsUXUaWuLktsQqOSg2hWtmQas9LS3T3JTmumlNHAOxx2Mu', 'shakai', 'keijou', '2024-07-05 16:27:17'),
(17, 'user3', '$2y$10$dT81zb/OLFaKYvfbMObHr.ctNLeTnv7eTCJJf.E2jKZIMZGMecqvy', 'shakai', 'kinyuu', '2024-07-05 16:51:13'),
(18, 'user4', '$2y$10$DeEneJ.ft//3TY7AA2YG2.L6SapiFJGsNWc6i4.3m2KNsIKr1b5BG', 'jouhou', 'net', '2024-07-05 18:05:51'),
(19, '小笠原秀人', '$2y$10$YA896lnJaqnR0vlxxmx0weYEPrIpF80CiLrynj7yE9dGM0UUPvv0m', 'kougaku', 'ut', '2024-07-06 07:35:53'),
(20, 'あいみょん', '$2y$10$k9Dyr.7o/WKiMAS3v4GfOuLL8Kdsbk5BMUNs5/McOtI3ungEQIwPS', 'shakai', 'pm', '2024-07-06 09:53:08'),
(21, 'おれ', '$2y$10$dwcEPZzvlCoC9.TjN58wU.ckYg3if/HiDYfv2jm.vjnUR1LV2FGuC', 'jouhou', 'net', '2024-07-06 11:11:28');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `posts`
--
ALTER TABLE `posts`
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
-- テーブルの AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
