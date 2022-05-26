DROP SCHEMA IF EXISTS shukatsu;
CREATE SCHEMA shukatsu;
USE shukatsu;

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: db
-- 生成日時: 2022 年 5 月 26 日 09:01
-- サーバのバージョン： 8.0.29
-- PHP のバージョン: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `shukatsu`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `admin_login`
--

CREATE TABLE `admin_login` (
  `id` int NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- テーブルの構造 `agents`
--

CREATE TABLE `agents` (
  `id` int NOT NULL,
  `corporate_name` text NOT NULL,
  `started_at` date NOT NULL,
  `ended_at` date NOT NULL,
  `login_email` text NOT NULL,
  `login_pass` text NOT NULL,
  `to_send_email` text NOT NULL,
  `application_max` int NOT NULL,
  `client_name` text NOT NULL,
  `client_department` text NOT NULL,
  `client_email` text NOT NULL,
  `client_tel` text NOT NULL,
  `insert_company_name` text NOT NULL,
  `insert_logo` text NOT NULL,
  `insert_recommend_1` text NOT NULL,
  `insert_recommend_2` text NOT NULL,
  `insert_recommend_3` text NOT NULL,
  `insert_handled_number` text NOT NULL,
  `list_status` int NOT NULL,
  `insert_detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- テーブルのデータのダンプ `agents`
--

INSERT INTO `agents` (`id`, `corporate_name`, `started_at`, `ended_at`, `login_email`, `login_pass`, `to_send_email`, `application_max`, `client_name`, `client_department`, `client_email`, `client_tel`, `insert_company_name`, `insert_logo`, `insert_recommend_1`, `insert_recommend_2`, `insert_recommend_3`, `insert_handled_number`, `list_status`, `insert_detail`) VALUES
(1, '株式会社かしまホールディングス', '2022-05-01', '2025-05-01', 'kashiken', 'kashiken', 'kashiken', 0, '鹿島健太', '広報部', 'kirin.myk2018@gmail.com', '0809000300', '鹿島エージェント', '', '面接対策充実', '手厚い保障', '幅広い視点', '500000', 1, '鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿島健太鹿'),
(2, '株式会社みゆきホールディングス', '2022-05-01', '2025-05-01', 'miyuki', 'miyuki', 'miyuki', 0, '渡邊美由貴', '広報部', 'watanabemiyuki@keio.jp', '0', '渡邊エージェント', '', '圧倒的信頼度', '0', '0', '1500000', 1, '美由紀です'),
(3, '株式会社まいのホールディングス', '2022-05-01', '2025-05-01', 'maino', 'maino', 'maino', 0, '渡邊美由貴', '広報部', 'watanabemiyuki@keio.jp', '0', '田口エージェント', '', '圧倒的信頼度', 'かわいい', '昼夜逆転', '1800000', 1, ''),
(4, '株式会社ごりらホールディングス', '2022-05-01', '2025-05-01', 'maino', 'maino', 'maino', 0, '田口', '広報部', 'watanabemiyuki@keio.jp', '0', '田口エージェント', '', '圧倒的信頼度', 'かわいい', '昼夜逆転', '1800000', 2, '');

-- --------------------------------------------------------

--
-- テーブルの構造 `agents_tags`
--

CREATE TABLE `agents_tags` (
  `id` int NOT NULL,
  `agent_id` int NOT NULL,
  `tag_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- テーブルのデータのダンプ `agents_tags`
--

INSERT INTO `agents_tags` (`id`, `agent_id`, `tag_id`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 2, 1),
(4, 2, 4),
(6, 3, 2),
(7, 3, 3);

-- --------------------------------------------------------

--
-- テーブルの構造 `agent_list_status`
--

CREATE TABLE `agent_list_status` (
  `id` int NOT NULL,
  `list_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- テーブルのデータのダンプ `agent_list_status`
--

INSERT INTO `agent_list_status` (`id`, `list_status`) VALUES
(1, '掲載中'),
(2, '掲載停止');

-- --------------------------------------------------------

--
-- テーブルの構造 `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `events`
--

INSERT INTO `events` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'イベント1', '2022-05-10 14:28:55', '2022-05-10 14:28:55'),
(2, 'イベント2', '2022-05-10 14:28:55', '2022-05-10 14:28:55');

-- --------------------------------------------------------

--
-- テーブルの構造 `filter_sorts`
--

CREATE TABLE `filter_sorts` (
  `id` int NOT NULL,
  `sort_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- テーブルのデータのダンプ `filter_sorts`
--

INSERT INTO `filter_sorts` (`id`, `sort_name`) VALUES
(1, 'エージェントのタイプ'),
(2, '志望会社の規模');

-- --------------------------------------------------------

--
-- テーブルの構造 `filter_tags`
--

CREATE TABLE `filter_tags` (
  `tag_id` int NOT NULL,
  `sort_id` int NOT NULL,
  `tag_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- テーブルのデータのダンプ `filter_tags`
--

INSERT INTO `filter_tags` (`tag_id`, `sort_id`, `tag_name`) VALUES
(1, 1, '特化型'),
(2, 1, '総合型'),
(3, 2, '大手志望'),
(4, 2, 'ベンチャー志望');

-- --------------------------------------------------------

--
-- テーブルの構造 `invalid_requests`
--

CREATE TABLE `invalid_requests` (
  `id` int NOT NULL,
  `contact_id` int NOT NULL,
  `invalid_request_memo` text NOT NULL,
  `invalid_request_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- テーブルのデータのダンプ `invalid_requests`
--

INSERT INTO `invalid_requests` (`id`, `contact_id`, `invalid_request_memo`, `invalid_request_created`) VALUES
(1, 1, '不適切', '2022-05-08 12:59:39'),
(2, 2, '連絡つかない', '2022-05-08 12:59:39');

-- --------------------------------------------------------

--
-- テーブルの構造 `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `collage` text NOT NULL,
  `department` text NOT NULL,
  `class_of` int NOT NULL,
  `email` text NOT NULL,
  `tel` text NOT NULL,
  `address` text NOT NULL,
  `memo` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- テーブルのデータのダンプ `students`
--

INSERT INTO `students` (`id`, `name`, `collage`, `department`, `class_of`, `email`, `tel`, `address`, `memo`, `created_at`) VALUES
(1, 'あきら', '', '', 0, 'akira', '111111', '東京都', '不安', '2022-05-08 12:41:11'),
(3, 'こうへい', '', '', 0, 'akira', '111111', '', '不安', '2022-05-08 12:41:11'),
(4, '小林哲', 'a', 's', 25, 'akira.kobayashi1515@gmail.com', '08065581505', '中央区　日本橋', '', '2022-05-22 02:12:10'),
(5, '小林哲', 'a', 'a', 25, 'akira.kobayashi1515@gmail.com', '08065581505', '中央区　日本橋', '', '2022-05-24 08:43:55'),
(6, '小林哲', 'p', 'dsgfad', 25, 'akira.kobayashi1515@gmail.com', '08065581505', '中央区　日本橋', '', '2022-05-24 08:44:53');

-- --------------------------------------------------------

--
-- テーブルの構造 `students_contacts`
--

CREATE TABLE `students_contacts` (
  `id` int NOT NULL,
  `student_id` int NOT NULL,
  `agent_id` int NOT NULL,
  `valid_status_id` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- テーブルのデータのダンプ `students_contacts`
--

INSERT INTO `students_contacts` (`id`, `student_id`, `agent_id`, `valid_status_id`, `created`) VALUES
(3, 1, 2, 1, '2022-05-08 13:18:44'),
(4, 1, 2, 1, '2022-05-08 13:18:44'),
(5, 1, 3, 1, '2022-05-08 13:18:44'),
(6, 2, 3, 1, '2022-05-08 13:18:44'),
(7, 4, 1, 1, '2022-05-22 02:12:10'),
(8, 4, 2, 1, '2022-05-22 02:12:10'),
(9, 5, 3, 1, '2022-05-24 08:43:55'),
(10, 6, 1, 1, '2022-05-24 08:44:53'),
(11, 6, 2, 1, '2022-05-24 08:44:53');

-- --------------------------------------------------------

--
-- テーブルの構造 `students_valid_status`
--

CREATE TABLE `students_valid_status` (
  `id` int NOT NULL,
  `vlid_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- テーブルのデータのダンプ `students_valid_status`
--

INSERT INTO `students_valid_status` (`id`, `vlid_status`) VALUES
(1, '正常'),
(2, '無効登録済'),
(3, '無効申請あり');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created`, `updated`) VALUES
(1, 'testtest@gmail.com', '$2y$10$jFWlJ.8RvTWwNd1ZYv4NReC4KmMqgb804u./LDVDrz1Bb0w7h781.', '2022-05-10 14:28:55', '2022-05-10 14:28:55'),
(2, 'test@icloud.com', '$2y$10$jFWlJ.8RvTWwNd1ZYv4NReC4KmMqgb804u./LDVDrz1Bb0w7h781.', '2022-05-10 14:28:55', '2022-05-10 14:28:55'),
(3, 'test@neko.com', '$2y$10$jFWlJ.8RvTWwNd1ZYv4NReC4KmMqgb804u./LDVDrz1Bb0w7h781.', '2022-05-10 14:28:55', '2022-05-10 14:28:55'),
(4, 'test@nya.com', '$2y$10$jFWlJ.8RvTWwNd1ZYv4NReC4KmMqgb804u./LDVDrz1Bb0w7h781.', '2022-05-10 14:28:55', '2022-05-10 14:28:55'),
(5, 'test@hiii.com', '$2y$10$jFWlJ.8RvTWwNd1ZYv4NReC4KmMqgb804u./LDVDrz1Bb0w7h781.', '2022-05-10 14:28:55', '2022-05-10 14:28:55');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `agents_tags`
--
ALTER TABLE `agents_tags`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `agent_list_status`
--
ALTER TABLE `agent_list_status`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `filter_sorts`
--
ALTER TABLE `filter_sorts`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `filter_tags`
--
ALTER TABLE `filter_tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- テーブルのインデックス `invalid_requests`
--
ALTER TABLE `invalid_requests`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `students_contacts`
--
ALTER TABLE `students_contacts`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `students_valid_status`
--
ALTER TABLE `students_valid_status`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルの AUTO_INCREMENT `agents_tags`
--
ALTER TABLE `agents_tags`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルの AUTO_INCREMENT `agent_list_status`
--
ALTER TABLE `agent_list_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `filter_sorts`
--
ALTER TABLE `filter_sorts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `filter_tags`
--
ALTER TABLE `filter_tags`
  MODIFY `tag_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルの AUTO_INCREMENT `invalid_requests`
--
ALTER TABLE `invalid_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `students_contacts`
--
ALTER TABLE `students_contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- テーブルの AUTO_INCREMENT `students_valid_status`
--
ALTER TABLE `students_valid_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
