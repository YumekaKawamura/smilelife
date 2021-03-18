-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3306
-- 生成日時: 2021 年 3 月 18 日 12:48
-- サーバのバージョン： 5.7.30
-- PHP のバージョン: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `smile_life`
--
CREATE DATABASE IF NOT EXISTS `smile_life` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `smile_life`;

-- --------------------------------------------------------

--
-- テーブルの構造 `checked`
--

CREATE TABLE `checked` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `diary_id` int(11) NOT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `checked`
--

INSERT INTO `checked` (`id`, `user_id`, `diary_id`, `created_at`) VALUES
(1, 3, 2, '2021-03-07'),
(2, 3, 3, '2021-03-09'),
(3, 3, 6, '2021-03-14'),
(4, 3, 4, '2021-03-14');

-- --------------------------------------------------------

--
-- テーブルの構造 `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `class`
--

INSERT INTO `class` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '3年1組', '2021-02-24', NULL),
(2, '3年2組', '2021-02-24', NULL),
(6, '4年1組', '2021-03-03', NULL),
(7, '5年1組', '2021-03-07', NULL),
(8, '5年2組', '2021-03-08', NULL),
(9, '5年3組', '2021-03-08', NULL),
(10, '6年1組', '2021-03-08', NULL),
(23, '6年2組', '2021-03-08', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `diary_id` int(11) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `comment`
--

INSERT INTO `comment` (`id`, `diary_id`, `body`) VALUES
(2, 2, '先生からのコメント'),
(3, 2, 'コメントします。'),
(4, 3, 'もうすぐ桜がさく季節ですね。たくさんかんさつしてください。'),
(5, 3, '好きな花はなんですか？'),
(6, 2, 'たくさんつもったね。'),
(7, 2, 'コメント'),
(8, 2, 'コメント２'),
(9, 2, 'コメント３'),
(10, 6, 'コメントテスト１'),
(11, 6, 'コメントテスト2'),
(12, 6, 'コメントテスト３'),
(13, 8, 'コメント１'),
(14, 8, 'コメント２'),
(15, 8, 'コメント３'),
(16, 4, 'コメント'),
(17, 4, 'コメント');

-- --------------------------------------------------------

--
-- テーブルの構造 `diary`
--

CREATE TABLE `diary` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `created_at` date NOT NULL COMMENT '登録日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `diary`
--

INSERT INTO `diary` (`id`, `user_id`, `title`, `body`, `created_at`) VALUES
(1, 3, '今の気持ち', '', '2021-03-06'),
(2, 1, '雪合戦', '今日はゆきがふりました。<br />\r\n友達と雪合戦をしました。楽しかったなあ。', '2021-03-06'),
(3, 1, '春の訪れ', '今日は、春らしい暖かいかぜを感じました。<br />\r\n春に咲く花を観察するのが楽しみです。', '2021-03-06'),
(4, 1, '遠足', '今日はサンシャイン水族館にいきました。外で泳いでいるペンギンが可愛かったです。<br />\r\nとても良い思い出になりました。', '2021-03-09'),
(5, 1, '運動会', '今日は運動会でした。優勝することはできなかったけど、みんなで力を合わせて戦うことができてとても楽しかったです。<br />\r\nリレーは１位だったので、練習の成果を発揮できたと思います。', '2021-03-14'),
(6, 21, 'テスト１', 'テスト１<br />\r\nテスト１<br />\r\nテスト１', '2021-03-14'),
(7, 21, 'テスト２', 'テスト２<br />\r\nテスト２', '2021-03-14'),
(8, 7, 'テスト１', 'テスト１<br />\r\nテスト１', '2021-03-14'),
(9, 1, 'テスト', 'テスト', '2021-03-14');

-- --------------------------------------------------------

--
-- テーブルの構造 `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `homework` text NOT NULL,
  `announce` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `num` int(11) NOT NULL,
  `pass` varchar(255) NOT NULL DEFAULT 'pass0000' COMMENT '初期設定時は統一',
  `role` int(11) NOT NULL DEFAULT '2' COMMENT '0:管理者1:先生2:一般ユーザ',
  `created_at` date NOT NULL COMMENT '登録日',
  `updated_at` date DEFAULT NULL COMMENT '更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `class_id`, `name`, `num`, `pass`, `role`, `created_at`, `updated_at`) VALUES
(1, 1, '青木太郎', 1, 'pass1111', 2, '2021-02-24', '2021-03-08'),
(2, 1, '今井あみ', 2, 'pass0000', 2, '2021-02-24', NULL),
(3, 1, '先生', 0, 'pass0000', 1, '2021-02-25', NULL),
(4, 2, '先生', 0, 'pass0000', 1, '2021-02-25', NULL),
(5, 1, '児童３', 3, 'pass0000', 2, '2021-02-28', NULL),
(6, 1, '児童４', 4, 'pass0000', 2, '2021-02-28', NULL),
(7, 6, '更新1', 1, 'pass0000', 2, '2021-03-03', '2021-03-03'),
(8, 6, '更新2', 2, 'pass0000', 2, '2021-03-03', '2021-03-03'),
(9, 6, '児童3', 3, 'pass0000', 2, '2021-03-03', '2021-03-03'),
(10, 6, '児童4', 4, 'pass0000', 2, '2021-03-03', '2021-03-03'),
(11, 6, '児童5', 5, 'pass0000', 2, '2021-03-03', '2021-03-03'),
(12, 6, '児童6', 6, 'pass0000', 2, '2021-03-03', '2021-03-03'),
(13, 6, '児童7', 7, 'pass0000', 2, '2021-03-03', '2021-03-03'),
(15, 7, 'ダミー', 1, 'pass0000', 2, '2021-03-03', '2021-03-07'),
(16, 7, 'ダミー', 2, 'pass0000', 2, '2021-03-03', '2021-03-07'),
(17, 8, 'ダミー', 1, 'pass0000', 2, '2021-03-03', NULL),
(18, 8, 'ダミー', 2, 'pass0000', 2, '2021-03-03', NULL),
(19, 9, '変更1', 1, '$2y$10$qntuW4dj8ORsCtHwUhdPVuNjIecF5t7wLzNrvxoJmDvkknQQxzgg6', 2, '2021-03-03', '2021-03-08'),
(20, 9, 'ダミー', 2, '$2y$10$6j5AxH4idyC4/UGgngKKneGclAO/p5aOq1I/MbusqtSiioTcMacoS', 2, '2021-03-03', '2021-03-08'),
(21, 2, '児童1', 1, '$2y$10$Cd7.mjcaKP61FaIxEARB1.2yq9ULQsCHA1QYbRg.h4Y6BbnAQLTSy', 2, '2021-03-06', '2021-03-14'),
(22, 2, '児童2', 2, 'pass0000', 2, '2021-03-06', NULL),
(23, 7, '先生', 0, 'pass0000', 1, '2021-03-07', '2021-03-07'),
(24, 7, '相葉雅紀', 3, 'pass0000', 2, '2021-03-07', '2021-03-07'),
(25, 7, '大野智', 4, 'pass0000', 2, '2021-03-07', '2021-03-07'),
(26, 7, '櫻井翔', 5, 'pass0000', 2, '2021-03-07', '2021-03-07'),
(27, 7, '二宮和也', 6, 'pass0000', 2, '2021-03-07', '2021-03-07'),
(28, 7, '松本潤', 7, 'pass0000', 2, '2021-03-07', '2021-03-07'),
(29, 23, '児童11', 1, '$2y$10$ZaLzfEVL2tPVdtLpQPJh8eBZWmik9NWS3L2DIxdsESddFNgvnmzkC', 2, '2021-03-08', NULL),
(30, 23, '児童12', 2, '$2y$10$ihikTP8u5b7pj6WPpssLwOvDYgXrFSf3/8SqpDjCR6.ig5nbRAnlC', 2, '2021-03-08', NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `checked`
--
ALTER TABLE `checked`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `diary`
--
ALTER TABLE `diary`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `checked`
--
ALTER TABLE `checked`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルのAUTO_INCREMENT `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- テーブルのAUTO_INCREMENT `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- テーブルのAUTO_INCREMENT `diary`
--
ALTER TABLE `diary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- テーブルのAUTO_INCREMENT `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
