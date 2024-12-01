-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 26, 2024 lúc 11:05 AM
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
-- Cơ sở dữ liệu: `webphim`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('conversation-ad9f1c53d824a24840714619fa6acc8f8aabd523-ad9f1c53d824a24840714619fa6acc8f8aabd523', 'a:5:{s:12:\"conversation\";O:38:\"App\\Http\\Controllers\\MovieConversation\":4:{s:8:\"\0*\0token\";N;s:12:\"\0*\0cacheTime\";N;s:8:\"\0*\0genre\";N;s:10:\"\0*\0country\";N;}s:8:\"question\";s:53:\"s:45:\"Bạn muốn xem phim theo thể loại nào?\";\";s:20:\"additionalParameters\";s:6:\"a:0:{}\";s:4:\"next\";s:1357:\"O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:1127:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:0:{}s:8:\"function\";s:783:\"function(\\BotMan\\BotMan\\Messages\\Incoming\\Answer $answer) {\n            $genreName = $answer->getText();\n\n            try {\n                $genre = \\App\\Models\\Genre::where(\'name\', \'like\', \'%\' . $genreName . \'%\')->first();\n                if ($genre) {\n                    $this->genre = $genre;\n                    //$this->say(\'Thể loại bạn đã chọn: \' . $genre->name);\n                    $this->askCountry();\n                } else {\n                    $this->say(\"Không có thể loại phim này, vui lòng nhập lại.\");\n                    $this->repeat();\n                }\n            } catch (\\Exception $e) {\n                $this->say(\"Có lỗi khi tìm thể loại phim. Vui lòng thử lại.\");\n                $this->repeat();\n            }\n        }\";s:5:\"scope\";s:38:\"App\\Http\\Controllers\\MovieConversation\";s:4:\"this\";O:38:\"App\\Http\\Controllers\\MovieConversation\":4:{s:8:\"\0*\0token\";N;s:12:\"\0*\0cacheTime\";N;s:8:\"\0*\0genre\";N;s:10:\"\0*\0country\";N;}s:4:\"self\";s:32:\"00000000000002730000000000000000\";}\";s:4:\"hash\";s:44:\"ZGdNiiF20Npg6FwklfRUuOce6xF3LrTLB/korVVT6F8=\";}}\";s:4:\"time\";s:21:\"0.05829200 1732561446\";}', 1732563846);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Phim Bộ', 'Đây là các bộ phim có nhiều tập và thường kéo dài qua nhiều phần hoặc mùa. Phim bộ có thể thuộc nhiều thể loại như tình cảm, hành động, kinh dị, hoặc hài hước. Phim bộ thường có thời lượng mỗi tập khá ngắn và có cốt truyện phát triển dần qua từng tập hoặc từng mùa.', '2024-09-14 03:06:35', '2024-09-14 03:11:26'),
(2, 'Phim Lẻ', 'Phim lẻ là các bộ phim có thời lượng từ 90 phút đến 3 giờ và hoàn thành toàn bộ cốt truyện trong một tập duy nhất. Phim lẻ thường có nội dung ngắn gọn, rõ ràng, không kéo dài qua nhiều tập như phim bộ. Phim lẻ có thể thuộc nhiều thể loại như hành động, kinh dị, viễn tưởng, tình cảm, và nhiều hơn nữa.', '2024-09-14 03:06:42', '2024-09-14 03:11:43'),
(4, 'Chiếu Rạp', 'Đây là các bộ phim được sản xuất với chất lượng cao và được công chiếu tại các rạp chiếu phim trước khi phát hành trên các nền tảng trực tuyến. Phim chiếu rạp thường có ngân sách lớn, kỹ xảo tinh vi, và dàn diễn viên nổi tiếng. Nội dung phim chiếu rạp đa dạng từ hành động, tình cảm, khoa học viễn tưởng đến hoạt hình và kinh dị.', '2024-09-14 03:08:24', '2024-10-04 00:34:39'),
(5, 'TV Show', 'TV Show (chương trình truyền hình) là các chương trình được phát sóng trên kênh truyền hình, thường không phải là phim truyện dài tập. Chúng có thể là các chương trình thực tế, trò chơi, talk show, hoặc chương trình hài kịch. TV Show thường được phát sóng định kỳ hàng tuần và có sự tham gia của các khách mời hoặc người nổi tiếng.', '2024-09-14 03:08:32', '2024-09-14 03:13:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `movie_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `movie_id`, `content`, `image`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'hay', NULL, '2024-09-15 01:26:37', '2024-09-15 01:26:37'),
(2, 2, 1, 'hay quá', NULL, '2024-09-15 01:29:30', '2024-09-15 01:29:30'),
(3, 2, 1, 'hay vãi', NULL, '2024-09-15 02:34:08', '2024-09-15 02:34:08'),
(4, 2, 3, 'hay', NULL, '2024-09-15 02:38:30', '2024-09-15 02:38:30'),
(5, 2, 3, 'hay', NULL, '2024-09-15 02:39:00', '2024-09-15 02:39:00'),
(8, 2, 4, 'hay quá đi', NULL, '2024-09-15 02:49:28', '2024-09-15 02:49:28'),
(9, 2, 2, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa😆😆😆😆😆😆😆😆😆😆😆😆😆😆😆😆😆😆😆😆', NULL, '2024-09-15 03:14:18', '2024-09-15 03:14:18'),
(10, 2, 2, 'hay', NULL, '2024-09-15 03:26:28', '2024-09-15 03:26:28'),
(11, 2, 3, 'vaaaaaaaaaa', NULL, '2024-09-15 03:35:41', '2024-09-15 03:35:41'),
(12, 2, 3, '😆😆😆😆', NULL, '2024-09-15 03:36:06', '2024-09-15 03:36:06'),
(13, 2, 3, 'hayyyyy', NULL, '2024-09-15 03:50:29', '2024-09-15 03:50:29'),
(14, 2, 3, 'abbb', NULL, '2024-09-15 03:56:13', '2024-09-15 03:56:13'),
(15, 2, 3, '😁😁😁', NULL, '2024-09-15 03:57:27', '2024-09-15 03:57:27'),
(16, 2, 3, 'hayyyyyyyyy', NULL, '2024-09-15 04:00:10', '2024-09-15 04:00:10'),
(17, 2, 2, 'aaaaaaaaaaaaaaa', NULL, '2024-09-15 04:05:49', '2024-09-15 04:05:49'),
(18, 2, 2, 'aaaaaaaaaaaaaaaa', NULL, '2024-09-15 04:06:35', '2024-09-15 04:06:35'),
(19, 2, 3, 'a', NULL, '2024-09-15 04:22:21', '2024-09-15 04:22:21'),
(20, 2, 2, 'a', NULL, '2024-09-15 04:26:19', '2024-09-15 04:26:19'),
(21, 2, 3, 'hay', NULL, '2024-09-15 04:27:03', '2024-09-15 04:27:03'),
(22, 2, 3, 'aa', NULL, '2024-09-15 04:27:25', '2024-09-15 04:27:25'),
(23, 2, 3, 'hayyyyy', NULL, '2024-09-15 04:31:34', '2024-09-15 04:31:34'),
(24, 2, 1, 'hay quá', NULL, '2024-09-15 05:48:00', '2024-09-15 05:48:00'),
(25, 2, 1, 'aaaaaaaaaaaaaaaa😆', NULL, '2024-09-15 05:48:40', '2024-09-15 05:48:40'),
(26, 2, 5, 'hayyy 😆', NULL, '2024-09-23 22:54:30', '2024-09-23 22:54:30'),
(27, 2, 6, '😂⏮🏋💟', NULL, '2024-09-24 03:10:33', '2024-09-24 03:10:33'),
(28, 2, 6, '😍😍😍', NULL, '2024-09-24 03:10:42', '2024-09-24 03:10:42'),
(29, 2, 10, 'cute 😖', NULL, '2024-09-24 03:31:02', '2024-09-24 03:31:02'),
(30, 3, 5, 'chill', NULL, '2024-10-13 02:26:29', '2024-10-13 02:26:29'),
(35, 21, 2, '😀😀', NULL, '2024-10-27 04:07:24', '2024-10-27 04:07:24'),
(36, 21, 10, 'abc', NULL, '2024-11-01 16:50:19', '2024-11-01 16:50:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `countries`
--

INSERT INTO `countries` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Trung Quốc', 'Phim Trung Quốc thường được biết đến với các bộ phim lịch sử, cổ trang, và võ thuật. Nội dung phim hay xoay quanh các cuộc chiến tranh giành quyền lực, các triều đại phong kiến, hoặc các nhân vật anh hùng trong truyền thuyết. Ngoài ra, điện ảnh Trung Quốc hiện đại cũng phát triển mạnh về thể loại tình cảm, tâm lý, và xã hội với sự đầu tư kỹ xảo và nội dung đa dạng.', '2024-09-14 02:53:52', '2024-09-14 02:53:52'),
(2, 'Hồng Kông', 'Hồng Kông nổi tiếng với dòng phim võ thuật, hành động, và hình sự. Các bộ phim võ thuật của Hồng Kông, đặc biệt là những bộ phim của Lý Tiểu Long, Thành Long, đã đưa tên tuổi điện ảnh Hồng Kông ra thế giới. Thể loại hình sự, cảnh sát đối đầu với thế giới ngầm cũng là một đặc trưng của điện ảnh Hồng Kông.', '2024-09-14 02:54:05', '2024-09-14 02:54:05'),
(3, 'Đài Loan', 'Phim Đài Loan có sự pha trộn giữa văn hóa truyền thống Trung Hoa và hiện đại. Thể loại phim tình cảm, lãng mạn, và phim về cuộc sống gia đình là điểm nổi bật. Ngoài ra, điện ảnh Đài Loan cũng rất được yêu thích với các bộ phim tâm lý xã hội mang đậm dấu ấn con người và cảm xúc.', '2024-09-14 02:54:25', '2024-09-14 02:54:25'),
(4, 'Ấn Độ', 'Bollywood – ngành công nghiệp điện ảnh Ấn Độ – nổi tiếng với các bộ phim có màu sắc rực rỡ, nhiều bài hát, vũ điệu, và các câu chuyện lãng mạn. Phim Ấn Độ thường có sự kết hợp giữa hành động, tình cảm, và gia đình. Ngoài ra, các bộ phim sử thi và phim về thần thoại Ấn Độ cũng là thế mạnh lớn của nền điện ảnh này.', '2024-09-14 02:54:40', '2024-09-14 02:59:34'),
(5, 'Hàn Quốc', 'Điện ảnh Hàn Quốc nổi tiếng với phim truyền hình dài tập và các bộ phim điện ảnh cảm động về tình yêu, gia đình, và tâm lý xã hội. Phim Hàn Quốc thường khai thác sâu các mối quan hệ giữa con người và những bi kịch cá nhân. Ngoài ra, phim Hàn còn nổi bật với thể loại kinh dị và hình sự, được dàn dựng kỹ lưỡng và kịch tính.', '2024-09-14 02:54:58', '2024-09-14 03:00:03'),
(6, 'Âu Mỹ', 'Phim Âu Mỹ chiếm lĩnh thị trường quốc tế với sự đa dạng về thể loại như hành động, khoa học viễn tưởng, siêu anh hùng, hài hước, và kinh dị. Các bộ phim Hollywood thường có quy mô lớn, kỹ xảo hoành tráng và dàn diễn viên nổi tiếng. Điện ảnh châu Âu thì thường chú trọng vào chiều sâu tâm lý và nghệ thuật, với các bộ phim tâm lý, chính kịch, và xã hội.', '2024-09-14 02:55:12', '2024-09-14 02:55:12'),
(7, 'Anh', 'Điện ảnh Anh nổi tiếng với phong cách châm biếm, hài hước tinh tế và chiều sâu nghệ thuật. Các bộ phim chính kịch, lịch sử, và tiểu sử về hoàng gia Anh thường thu hút khán giả. Ngoài ra, thể loại phim hình sự, điều tra, và trinh thám của Anh cũng rất thành công với những tác phẩm kinh điển như series \"Sherlock Holmes.\"', '2024-09-14 02:55:47', '2024-09-14 03:01:14'),
(8, 'Thái Lan', 'Điện ảnh Thái Lan thường nổi bật với thể loại phim kinh dị, tâm linh, và hài hước. Phim kinh dị Thái Lan thường khai thác sâu vào yếu tố ma quái, phong tục và niềm tin tâm linh. Ngoài ra, Thái Lan còn sản xuất nhiều phim tình cảm và phim học đường rất được yêu thích trong khu vực châu Á.', '2024-09-14 02:56:00', '2024-09-14 02:56:00'),
(9, 'Nhật Bản', 'Phim Nhật Bản nổi bật với thể loại anime (phim hoạt hình) và phim hành động siêu nhiên, mang đậm chất văn hóa truyền thống như samurai, kiếm đạo, và triết lý Phật giáo. Phim Nhật Bản cũng có nhiều tác phẩm khai thác cuộc sống hiện đại, mối quan hệ gia đình, và những câu chuyện tâm lý phức tạp.', '2024-09-14 02:56:12', '2024-09-14 03:00:59'),
(10, 'Việt Nam', 'Phim Việt Nam đang phát triển với nhiều thể loại khác nhau, từ phim tình cảm, hài hước, đến phim lịch sử, chiến tranh, và xã hội. Các bộ phim gần đây chú trọng hơn vào chất lượng sản xuất, kỹ xảo, và câu chuyện gần gũi với đời sống của người dân Việt Nam. Những bộ phim khai thác chủ đề truyền thống và văn hóa Việt Nam cũng rất được khán giả yêu thích.', '2024-09-14 02:56:27', '2024-09-14 02:56:27'),
(11, 'Tây Ban Nha', 'Điện ảnh Tây Ban Nha nổi tiếng với thể loại phim chính kịch, tâm lý xã hội, và kinh dị. Phong cách làm phim của Tây Ban Nha thường có phần phá cách và đậm chất nghệ thuật, với các đạo diễn nổi tiếng như Pedro Almodóvar. Các bộ phim Tây Ban Nha thường chú trọng vào câu chuyện độc đáo và sự phát triển sâu sắc của nhân vật.', '2024-09-14 02:56:38', '2024-09-14 02:56:38'),
(12, 'Canada', 'Điện ảnh Canada thường pha trộn giữa phong cách làm phim Mỹ và châu Âu, với sự đa dạng về thể loại, từ chính kịch, phim tâm lý, đến phim tài liệu và phim kinh dị. Canada cũng nổi tiếng với các bộ phim truyền hình và điện ảnh khai thác văn hóa và xã hội đa sắc tộc. Phim Canada thường chú trọng đến nhân vật và những câu chuyện đời thường.', '2024-09-14 02:56:49', '2024-09-14 02:56:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `episodes`
--

CREATE TABLE `episodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `movie_id` bigint(20) UNSIGNED NOT NULL,
  `episode_number` int(11) NOT NULL,
  `duration` int(11) DEFAULT NULL,
  `server1` text DEFAULT NULL,
  `server2` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `episodes`
--

INSERT INTO `episodes` (`id`, `movie_id`, `episode_number`, `duration`, `server1`, `server2`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 24, 'https://vip.opstream11.com/share/904626aeca7400bec9965c654a0be99a', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240714/rkLmE2Gw/index.m3u8', '2024-09-17 03:46:23', '2024-09-17 04:29:09'),
(2, 1, 2, 24, 'https://vip.opstream11.com/share/46d1980e375ce08915b30d9a328c2fdc', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240717/JGGYNJ3n/index.m3u8', '2024-09-17 05:05:05', '2024-09-17 05:05:05'),
(3, 1, 3, 24, 'https://vip.opstream11.com/share/f2d10f708b2d69b2bfda21f03462d80b', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240722/d7oP7Bxw/index.m3u8', '2024-09-17 05:27:11', '2024-09-17 05:40:12'),
(4, 6, 1, 24, 'https://vip.opstream11.com/share/18aaf4672792c237acf34af9f8fe3ee3', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240729/6KBZDBM4/index.m3u8', '2024-09-19 03:07:15', '2024-09-19 03:07:15'),
(5, 6, 2, 24, 'https://vip.opstream11.com/share/383df222b83e1c6dd536dd72ff48ce09', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240729/sOyBS90G/index.m3u8', '2024-09-19 03:07:44', '2024-09-19 03:07:44'),
(6, 6, 3, 24, 'https://vip.opstream11.com/share/15745f4ca680d4379ed5becc7ac512f2', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240729/OgJPM79f/index.m3u8', '2024-09-19 03:08:10', '2024-09-19 03:08:10'),
(7, 6, 4, 24, 'https://vip.opstream11.com/share/31eb164dddc5d19866fa8304cb496788', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240806/0nWYiDjJ/index.m3u8', '2024-09-19 03:08:29', '2024-09-19 03:08:29'),
(8, 6, 5, 24, 'https://vip.opstream11.com/share/d23a5efe0c79a92ea18ee9145fabd92c', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240814/YqCBPaos/index.m3u8', '2024-09-19 03:08:56', '2024-09-19 03:08:56'),
(9, 6, 6, 24, 'https://vip.opstream11.com/share/9f303e64c8b06cbbf6c3b44e28acbd25', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240819/m4di86LD/index.m3u8', '2024-09-19 03:09:18', '2024-09-19 03:09:18'),
(10, 6, 7, 24, 'https://vip.opstream11.com/share/284c2099f0edd7786c443222e5b67a18', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240827/Ff83XF7P/index.m3u8', '2024-09-19 03:09:35', '2024-09-19 03:10:43'),
(11, 6, 8, 24, 'https://vip.opstream90.com/share/c12706a7c6e8d6476c3d2b6ae0042a82', 'https://player.phimapi.com/player/?url=https://s4.phim1280.tv/20240901/tdQPrsuL/index.m3u8', '2024-09-19 03:09:51', '2024-09-19 03:10:52'),
(12, 6, 9, 24, 'https://vip.opstream90.com/share/a64bd53139f71961c5c31a9af03d775e', 'https://player.phimapi.com/player/?url=https://s4.phim1280.tv/20240910/ELHT0WsU/index.m3u8', '2024-09-19 03:10:05', '2024-09-19 03:10:05'),
(13, 6, 10, 24, 'https://vip.opstream90.com/share/326fb04c3abf030fe3f4e341f39b573f', 'https://player.phimapi.com/player/?url=https://s4.phim1280.tv/20240919/BDcS8x72/index.m3u8', '2024-09-19 03:11:17', '2024-09-19 03:11:17'),
(14, 1, 4, 24, 'https://vip.opstream11.com/share/53f2dbb091f398f19cb6f3222dd36791', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240806/a1EnIDcE/index.m3u8', '2024-09-19 03:40:01', '2024-09-19 03:40:01'),
(15, 1, 5, 24, 'https://vip.opstream11.com/share/7bb8ddc278c3cb9182204c6d92d0b370', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240814/gKFfAkCu/index.m3u8', '2024-09-19 03:40:39', '2024-09-19 03:40:39'),
(16, 1, 6, 24, 'https://vip.opstream11.com/share/975ac04228ee0a0343208119e9838c94', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240821/FYdigz2u/index.m3u8', '2024-09-19 03:40:58', '2024-09-19 03:40:58'),
(17, 1, 7, 24, 'https://vip.opstream11.com/share/6dbe523032e74da51d47dd44aa7ed477', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240827/3zG8j6lC/index.m3u8', '2024-09-19 03:41:12', '2024-09-19 03:41:12'),
(18, 3, 1, 104, 'https://vip.opstream14.com/share/92fb0c6d1758261f10d052e6e2c1123c', 'https://player.phimapi.com/player/?url=https://s1.phim1280.tv/20231029/fvqD0D6t/index.m3u8', '2024-09-19 03:42:55', '2024-09-19 03:42:55'),
(19, 4, 1, 97, 'https://vip.opstream12.com/share/445e1050156c6ae8c082a8422bb7dfc0', 'https://player.phimapi.com/player/?url=https://s2.phim1280.tv/20240110/AU5KUnNO/index.m3u8', '2024-09-19 03:43:51', '2024-09-19 03:43:51'),
(20, 2, 1, 24, 'https://vip.opstream11.com/share/94244e6261dcec35d39f4a6a34d9a693', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240714/OrfvyKdo/index.m3u8', '2024-09-19 03:45:14', '2024-09-19 03:45:14'),
(21, 2, 2, 24, 'https://vip.opstream11.com/share/5c9dd188159c09ac3db3a286a47f7eb2', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240714/Do7C3CHY/index.m3u8', '2024-09-19 03:45:43', '2024-09-19 03:45:43'),
(22, 2, 3, 24, 'https://vip.opstream11.com/share/bc30d7d15b1d0c233137e9d7e241ec37', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240720/QhgRvRlF/index.m3u8', '2024-09-19 03:46:15', '2024-09-19 03:46:15'),
(23, 2, 4, 24, 'https://vip.opstream11.com/share/035f105ff246dd73af10ab601c34bebd', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240726/s0L3wqho/index.m3u8', '2024-09-19 03:46:32', '2024-09-19 03:46:32'),
(24, 2, 5, 24, 'https://vip.opstream11.com/share/ae5b27338e5d09a6fbb71afec41f0334', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240806/Fnb2DyEm/index.m3u8', '2024-09-19 03:46:50', '2024-09-19 03:46:50'),
(25, 2, 6, 24, 'https://vip.opstream11.com/share/5d4a4c9d4609bb473387350092e94b8d', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240810/JCfGvkVB/index.m3u8', '2024-09-19 03:47:08', '2024-09-19 03:47:08'),
(26, 2, 7, 24, 'https://vip.opstream11.com/share/443a2e7ec2ad7cd9f488724d91c35f46', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240817/Ctpu0cMj/index.m3u8', '2024-09-19 03:47:21', '2024-09-19 03:47:21'),
(27, 2, 8, 24, 'https://vip.opstream11.com/share/54d77f5dc6f98d0d68a23cf792c49e57', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240823/1OH9VLAw/index.m3u8', '2024-09-19 03:47:36', '2024-09-19 03:47:36'),
(28, 2, 9, 24, 'https://vip.opstream90.com/share/aac61539fd1fb209b44b9f9d0d8d28ac', 'https://player.phimapi.com/player/?url=https://s4.phim1280.tv/20240901/W0NFoVE3/index.m3u8', '2024-09-19 03:48:31', '2024-09-19 03:48:31'),
(29, 5, 1, 60, 'https://vip.opstream17.com/share/8e9122fa7ac8483b423d3c591d9972a1', 'https://player.phimapi.com/player/?url=https://s4.phim1280.tv/20240902/KJ5JgLqp/index.m3u8', '2024-09-19 03:50:03', '2024-09-19 03:50:03'),
(30, 5, 2, 60, 'https://vip.opstream17.com/share/5cd096b58d0fc4db8a84fdb5e9826a29', 'https://player.phimapi.com/player/?url=https://s4.phim1280.tv/20240902/lYvW92Cs/index.m3u8', '2024-09-19 03:50:19', '2024-09-19 03:50:19'),
(31, 5, 3, 60, 'https://vip.opstream11.com/share/cad238d1a08f7e900773636d4f9e53b1', 'https://player.phimapi.com/player/?url=https://s4.phim1280.tv/20240907/Myt9jXUS/index.m3u8', '2024-09-19 03:50:38', '2024-09-19 03:51:57'),
(32, 5, 4, 60, 'https://vip.opstream11.com/share/72c8d523aa3ae7b0dc08cbfa456cf9cd', 'https://player.phimapi.com/player/?url=https://s4.phim1280.tv/20240907/qME5M9Ks/index.m3u8', '2024-09-19 03:50:53', '2024-09-19 03:52:11'),
(33, 5, 5, 60, 'https://vip.opstream11.com/share/4bfa2caff8f01cfe2df6095c0e888138', 'https://player.phimapi.com/player/?url=https://s4.phim1280.tv/20240919/voPrnsQq/index.m3u8', '2024-09-19 03:51:14', '2024-09-19 03:51:14'),
(34, 10, 1, 110, 'https://vip.opstream17.com/share/a9c154c4658d7fc48fd2be3ef34d9109', 'https://player.phimapi.com/player/?url=https://s3.phim1280.tv/20240804/yIhJ7TWu/index.m3u8', '2024-09-19 04:34:43', '2024-09-23 22:20:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genres`
--

CREATE TABLE `genres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `genres`
--

INSERT INTO `genres` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Hành động', 'Phim hành động thường có nhịp độ nhanh, với nhiều cảnh đánh nhau, rượt đuổi, và các pha mạo hiểm. Nhân vật chính thường phải đối mặt với những thử thách khó khăn và nguy hiểm, mang đến sự kịch tính và phấn khích tột độ cho người xem.', '2024-09-14 00:19:37', '2024-09-14 02:26:52'),
(2, 'Phiêu lưu', 'Phim phiêu lưu xoay quanh các cuộc hành trình, khám phá thế giới mới hoặc hoàn thành những nhiệm vụ đầy thử thách. Các nhân vật thường trải qua những hành trình dài với nhiều nguy hiểm, đưa khán giả vào những thế giới mới lạ và đầy bất ngờ.', '2024-09-14 00:38:29', '2024-09-14 02:27:44'),
(3, 'Kinh dị', 'Phim kinh dị thường gây sợ hãi và căng thẳng cho người xem, những pha hù dọa thót tim, với các yếu tố rùng rợn như ma quái, quái vật, hoặc các tình huống đáng sợ và bí ẩn, mang đến sự kích thích đặc biệt cho những ai yêu thích cảm giác mạnh.', '2024-09-14 00:38:51', '2024-09-14 02:29:04'),
(4, 'Hài hước', 'Các bộ phim hài mang lại tiếng cười cho khán giả thông qua các tình huống vui nhộn, nhân vật kỳ quặc, hoặc đối thoại hóm hỉnh.', '2024-09-14 00:39:03', '2024-09-14 02:29:31'),
(5, 'Tình cảm', 'Phim tình cảm tập trung vào các mối quan hệ tình yêu giữa các nhân vật chính, thường có yếu tố lãng mạn, ngọt ngào và đôi khi cũng đầy nước mắt.', '2024-09-14 00:39:09', '2024-09-14 02:31:18'),
(6, 'Hoạt hình', 'Phim hoạt hình được làm từ các hình vẽ hoặc các hình ảnh động (2D, 3D) thay vì người thật đóng. Thể loại này phù hợp với mọi độ tuổi, nhưng đặc biệt phổ biến đối với trẻ em. Hoạt hình có thể bao gồm các câu chuyện hài hước, viễn tưởng, và phiêu lưu, với những nhân vật và thế giới sáng tạo.', '2024-09-14 00:53:46', '2024-09-14 03:21:07'),
(7, 'Kiếm hiệp', 'Phim kiếm hiệp là thể loại đặc trưng của văn hóa Á Đông, xoay quanh các cao thủ võ thuật và kiếm thuật, với những câu chuyện về danh dự, lòng trung thành và các trận đấu mãn nhãn.', '2024-09-14 00:55:45', '2024-09-14 02:33:00'),
(8, 'Tâm lý', 'Phim tâm lý tập trung vào sự phát triển nhân vật, cảm xúc và các mối quan hệ phức tạp giữa con người. Thể loại này thường khám phá sâu sắc về tâm hồn, hành vi, và những xung đột nội tâm của các nhân vật, mang đến những cảm xúc sâu lắng và những bài học đáng suy ngẫm về cuộc sống.', '2024-09-14 00:56:16', '2024-09-14 02:35:33'),
(9, 'Chiến tranh', 'Phim chiến tranh thường tái hiện lại những cuộc xung đột quân sự lớn hoặc nhỏ, với các cảnh chiến đấu khốc liệt và các vấn đề về lòng yêu nước, chiến lược quân sự, và sự hy sinh của những người lính.', '2024-09-14 00:56:40', '2024-09-14 02:36:48'),
(10, 'Hình sự', 'Phim hình sự xoay quanh các vụ án tội phạm, điều tra phá án, và các tình huống căng thẳng liên quan đến thế giới tội phạm. Thường có các nhân vật như thám tử, cảnh sát, hoặc tội phạm trong vai trò trung tâm, mang đến sự hồi hộp, kịch tính và những màn đấu trí nghẹt thở.', '2024-09-14 01:14:45', '2024-09-14 02:37:56'),
(11, 'Cổ trang', 'Phim cổ trang lấy bối cảnh trong các thời đại lịch sử cổ xưa, với trang phục, kiến trúc và phong tục truyền thống của những thời kỳ đó. Thể loại này thường tập trung vào các câu chuyện quyền lực, hoàng gia, hoặc anh hùng trong quá khứ.', '2024-09-14 01:15:00', '2024-09-14 02:38:41'),
(12, 'Thể thao', 'Phim thể thao thường kể về các môn thể thao và những câu chuyện về sự nỗ lực, vượt qua thử thách để đạt được thành công. Phim thể thao thường mang đến sự cảm hứng, phấn khích và những thông điệp về tinh thần thể thao.', '2024-09-14 01:15:08', '2024-09-14 02:39:55'),
(13, 'Khoa học', 'Phim khoa học tập trung vào các phát minh, hiện tượng và nghiên cứu khoa học. Thể loại này có thể bao gồm cả khoa học viễn tưởng hoặc các câu chuyện về sự phát triển công nghệ và nghiên cứu thực tế, mang đến sự tò mò, kiến thức và những câu hỏi về tương lai.', '2024-09-14 01:15:24', '2024-09-14 02:41:21'),
(14, 'Âm nhạc', 'Phim âm nhạc thường xoay quanh cuộc sống của các nhạc sĩ, ca sĩ, hoặc các ban nhạc, với những cảnh trình diễn âm nhạc nổi bật. Thể loại này thường chứa các yếu tố về đam mê nghệ thuật, mang đến sự giải trí, cảm hứng và những giai điệu tuyệt vời.', '2024-09-14 01:42:44', '2024-09-14 02:42:54'),
(15, 'Tài liệu', 'Phim tài liệu thường trình bày các sự kiện hoặc vấn đề trong thực tế, cung cấp thông tin chi tiết, phân tích và những cái nhìn chân thực về một chủ đề cụ thể.', '2024-09-14 01:43:02', '2024-09-14 02:43:21'),
(16, 'Lịch sử', 'Phim lịch sử tái hiện lại những sự kiện có thật trong quá khứ, thường tập trung vào những giai đoạn quan trọng của lịch sử nhân loại.', '2024-09-14 01:43:10', '2024-09-14 02:43:53'),
(17, 'Chính kịch', 'Phim chính kịch tập trung vào khai thác cảm xúc, tình huống xã hội hoặc cá nhân đầy chiều sâu, thường mang đến sự xúc động và những bài học đáng suy ngẫm cho khán giả.', '2024-09-14 01:43:16', '2024-09-14 02:44:51'),
(18, 'Võ thuật', 'Phim võ thuật đặc trưng bởi các màn đối kháng và kỹ năng chiến đấu, thường là các môn võ truyền thống hoặc pha trộn với phong cách hiện đại.', '2024-09-14 01:51:27', '2024-09-14 02:45:12'),
(19, 'Học đường', 'Phim học đường chủ yếu xoay quanh cuộc sống của học sinh, sinh viên, với các vấn đề về tình bạn, tình yêu, học hành và phát triển cá nhân.', '2024-09-14 01:51:35', '2024-09-14 02:45:30'),
(20, 'Bí ẩn', 'Phim bí ẩn thường xoay quanh các câu đố hoặc vụ án cần được giải quyết, mang đến cảm giác hồi hộp và căng thẳng khi người xem cùng tìm ra sự thật.', '2024-09-14 01:57:53', '2024-09-14 02:46:14'),
(21, 'Gia đình', 'Phim gia đình thường mang thông điệp tích cực về tình yêu thương và sự gắn kết trong gia đình, với những tình huống gần gũi và xúc động.', '2024-09-14 02:02:11', '2024-09-14 02:48:02'),
(22, 'Kỳ Ảo', 'Phim Kỳ Ảo là các phim có chủ đề tưởng tượng, không có thực, thường gồm phép thuật, các sự việc hiện tượng siêu nhiên, các sinh vật giả tưởng, hay những thế giới tưởng tượng kỳ ảo.', '2024-09-14 04:31:34', '2024-09-14 04:31:34'),
(23, 'Viễn tưởng', 'Phim viễn tưởng thường lấy bối cảnh trong tương lai hoặc các thế giới giả tưởng với công nghệ tiên tiến, sinh vật ngoài hành tinh, hoặc hiện tượng siêu nhiên.', '2024-09-14 04:32:58', '2024-09-14 04:32:58'),
(24, 'Lãng mạn', 'Thể loại lãng mạn trong phim tập trung vào những câu chuyện tình yêu và các mối quan hệ giữa các nhân vật. Đây là thể loại thường khám phá các khía cạnh của tình yêu, từ những cuộc gặp gỡ lãng mạn đầu tiên, những thử thách trong mối quan hệ, đến những khoảnh khắc cảm động và hạnh phúc.', '2024-09-14 04:37:06', '2024-09-14 04:37:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reply_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `comment_id`, `reply_id`, `created_at`, `updated_at`) VALUES
(6, 21, 9, NULL, '2024-10-27 04:09:46', '2024-10-27 04:09:46'),
(7, 21, 30, NULL, '2024-10-27 04:21:55', '2024-10-27 04:21:55'),
(11, 21, 24, NULL, '2024-10-27 04:41:39', '2024-10-27 04:41:39'),
(12, 21, 3, NULL, '2024-10-27 04:41:54', '2024-10-27 04:41:54'),
(21, 2, 29, NULL, '2024-10-27 05:17:58', '2024-10-27 05:17:58'),
(30, 2, 30, NULL, '2024-10-27 06:19:54', '2024-10-27 06:19:54'),
(36, 2, 9, NULL, '2024-10-27 06:56:58', '2024-10-27 06:56:58'),
(37, 21, 35, NULL, '2024-10-27 17:35:26', '2024-10-27 17:35:26'),
(60, 21, 18, NULL, '2024-10-31 01:37:41', '2024-10-31 01:37:41'),
(61, 21, 2, NULL, '2024-10-31 02:39:31', '2024-10-31 02:39:31'),
(62, 21, 29, NULL, '2024-11-01 16:50:10', '2024-11-01 16:50:10'),
(63, 23, 29, NULL, '2024-11-13 03:09:23', '2024-11-13 03:09:23'),
(64, 23, NULL, 1, '2024-11-13 03:09:53', '2024-11-13 03:09:53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(23, '0001_01_01_000000_create_users_table', 1),
(24, '0001_01_01_000001_create_cache_table', 1),
(25, '0001_01_01_000002_create_jobs_table', 1),
(26, '2024_08_18_034957_create_countries_table', 1),
(27, '2024_08_18_035048_create_release_years_table', 1),
(28, '2024_08_18_035128_create_categories_table', 1),
(29, '2024_08_18_035236_create_genres_table', 1),
(30, '2024_08_18_035308_create_movies_table', 1),
(31, '2024_08_18_035330_create_movie_genres_table', 1),
(32, '2024_08_18_035416_create_episodes_table', 1),
(33, '2024_08_18_035455_create_watch_histories_table', 1),
(34, '2024_08_18_035510_create_watch_lists_table', 1),
(35, '2024_08_18_035534_create_comments_table', 1),
(36, '2024_08_18_035644_create_news_table', 1),
(37, '2024_08_18_053146_create_views_table', 1),
(38, '2024_08_26_092126_create_trailers_table', 1),
(39, '2024_09_01_082737_create_replies_table', 1),
(40, '2024_09_01_082856_create_ratings_table', 1),
(41, '2024_10_27_171923_create_likes_table', 1),
(42, '2024_11_02_075705_create_services_table', 1),
(43, '2024_11_06_110309_create_services_orders_table', 1),
(44, '2024_11_12_134956_add_columns_to_users_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `movies`
--

CREATE TABLE `movies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `release_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `director` varchar(255) DEFAULT NULL,
  `studio` varchar(255) DEFAULT NULL,
  `actor` varchar(255) DEFAULT NULL,
  `total_episode` int(11) DEFAULT NULL,
  `other_name` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `background_image` text DEFAULT NULL,
  `hot` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `movies`
--

INSERT INTO `movies` (`id`, `name`, `description`, `release_year_id`, `country_id`, `category_id`, `director`, `studio`, `actor`, `total_episode`, `other_name`, `image`, `background_image`, `hot`, `created_at`, `updated_at`) VALUES
(1, 'Wistoria: Trượng và Kiếm', 'Will là một cậu bé bước vào học viện ma pháp với mục tiêu trở thành một ma pháp sư. Tuy là một người chăm chỉ thế nhưng cậu có một điểm yếu chết người đó là không thể sử dụng ma pháp. Nhận lại những cái nhìn lạnh lùng của các giáo viên và những bạn bè trong trường nhưng Will không bỏ cuộc mà vẫn hướng về phía trước. Ngay cả khi không thể sử dụng trượng, cậu vẫn cầm thanh kiếm trên tay chiến đấu theo cách riêng của mình trong một thế giới nơi ma pháp là tối cao. Tin vào sức mạnh của bản thân và để giữ lời hứa với người mình yêu quý.', 25, 9, 1, 'Yoshihara Tatsuya', 'BANDAI NAMCO PICTURES', 'Hiromichi Tezuka, Erica Muse, Atsushi Kosaka, Kôhei Amasaki,...', 12, 'Wistoria: Wand and Sword', 'wistoria-wand-and-sword.jpg', 'wistoria-wand-and-sword-background.jpg', 1, '2024-09-14 03:33:56', '2024-09-14 03:34:52'),
(2, 'Hậu Cung Giả Tạo', 'Một hậu cung chỉ có một nữ chính?! Eiji Kitahama, học sinh cuối cấp của câu lạc bộ kịch, người khao khát có được một hậu cung giống như trong bộ truyện tranh, và Rin Nanakura, người không thể không đóng vai những nhân vật khác trước mặt đàn anh Kitahama của mình. Tsundere và Teaser, Clingy và Cool, cũng như Ladylike, càng đóng nhiều nhân vật, cô càng mất kiểm soát cảm xúc dành cho tiền bối của mình. Phải chăng Nanakura đã bộc lộ con người thật của mình với tiền bối, một người có phần ngốc nghếch và cứng đầu?', 25, 9, 1, 'Toshihiro Kikuchi', 'Nomad', 'Nobuhiko Okamoto, Saori Hayami,...', 12, 'Pseudo Harem', 'pseudo-harem.jpg', 'pseudo-harem-background.jpg', 1, '2024-09-14 03:40:01', '2024-11-05 20:59:49'),
(3, 'Pokémon: Thám Tử Pikachu', 'Trong một thế giới nơi con người và Pokémon cùng tồn tại, một siêu thám tử tích điện cộng tác với con trai người cộng sự mất tích để phá vụ án mất tích này.', 20, 6, 2, 'Rob Letterman', 'Shepperton Studio', 'Ryan Reynolds, Justice Smith, Kathryn Newton,...', 1, 'Pokémon Detective Pikachu', 'pokemon-detective-pikachu.jpg', 'pokemon-detective-pikachu-background.jpg', 0, '2024-09-14 03:54:39', '2024-09-14 03:55:17'),
(4, 'Mirai: Em Gái Đến Từ Tương Lai', 'Từ một cậu bé bướng bỉnh được cưng chiều nhất gia đình, Kun bỗng thấy vị trí của mình bị lung lay khi em gái cậu – Mirai, ra đời. Đố kỵ xen lẫn tủi thân, cậu bé 4 tuổi cảm thấy tình thương của bố mẹ dành cho mình bị giảm sút và cậu hoàn toàn bị choáng ngợp với việc phải trở thành một người anh. Mọi thứ dường rắc rối hơn khi Kun tình cờ phát hiện ra một cánh cổng kỳ lạ nơi đưa cậu đến gặp mẹ mình lúc bà còn là một cô bé và em gái mình – Mirai lại là một học sinh tuổi teen. Trải qua rất nhiều cuộc phiêu lưu, liệu Kun có dần thay đổi bản thân và học được cách trở thành một người anh trai đúng nghĩa?', 19, 9, 2, 'Hosoda Mamoru', 'Studio Chizu', 'Kamishiraishi Moka, Kuroki Haru, Hoshino Gen', 1, 'Mirai no Mirai', 'mirai.jpg', 'mirai-background.jpg', 0, '2024-09-14 04:38:39', '2024-09-19 02:39:51'),
(5, 'Lọ Lem 2 Giờ Sáng', 'Lọ Lem 2 Giờ Sáng kể về Yoon Seo thuộc type độc lập và thực tế. Mẹ của bạn trai cô yêu cầu cô chia tay cùng đề nghị sẽ cho cô 1 khoản tiền lớn. Yoon Seo tin rằng truyện cổ tích không tồn tại trong thế giới của cô và quyết định nhận tiền. Nhưng bạn trai cô lại cố gắng theo đuổi và thay đổi suy nghĩ của cô về tình yêu.', 25, 5, 1, 'Seo Min Jung', 'Aljja', 'Shin Hyun Been, Moon Sang Min, Yoon Park, Park So Jin, Hong Bi Ra', 10, 'Cinderella at 2AM', 'cinderella-at-2-am.jpg', 'cinderella-at-2-am-background.jpg', 0, '2024-09-19 02:45:57', '2024-09-19 02:45:57'),
(6, 'Atri: My Dear Moments', 'Một phần của nền văn minh loài người đã bị nuốt chửng bởi sự dâng cao bất thường của mực nước biển, nguyên nhân vẫn chưa được làm sáng tỏ. Ikaruga Natsuki, cậu bé mồ côi mẹ và mất một chân trong tai nạn, trở về quê nhà sau nhiều năm sống khổ cực tại thành phố lớn. Tuy nhiên, khi về đến nơi, tất cả những gì cậu thấy chỉ là căn nhà cũ đã bị ngập dưới nước. Cậu không còn ai thân thuộc, chỉ có chiếc tàu và tàu ngầm do bà để lại, cùng với một khoản nợ lớn phải trả. Cơ hội duy nhất để Natsuki lấy lại ước mơ về tương lai là nhận lời mời của Catherine - kẻ thu nợ đáng ngờ. Họ cùng nhau đi tìm kho báu trong phòng thí nghiệm dưới biển của bà Natsuki, nơi có tin đồn bà đã giấu một điều gì đó quý giá. Nhưng khi đến nơi, họ không tìm thấy tiền bạc hay đá quý, thay vào đó là một cô gái kỳ lạ đang ngủ say trong quan tài. Cô ấy tên là Atri. Atri là một người máy, nhưng cô sở hữu vẻ ngoài và cảm xúc như một con người thật sự. Cô biết ơn Natsuki vì đã giải thoát mình khỏi quan tài. Trong thị trấn nhỏ dần chìm trong biển, một mùa hè đáng nhớ sắp diễn ra với cậu bé và cô gái người máy bí ẩn...', 25, 9, 1, 'Katou Makoto', 'TROYCA', 'Akao Hikaru,  Ono, Kensho,  Takahashi, Minami,...', 13, 'ATRI -My Dear Moments-', 'arti-my-dear-moments.jpg', 'arti-my-dear-moments-background.jpg', 0, '2024-09-19 02:53:21', '2024-09-19 02:53:21'),
(7, 'Bạn Trai Cũ Là Sếp Của Tôi', 'Cặp thanh mai trúc mã Liêu Vân Thừa và Đồng Niệm đã yêu nhau từ thời đại học nhưng lại chia tay vì hiểu lầm. Nhiều năm sau, họ gặp lại nhau nhưng thân phận và địa vị đã chênh lệch. Công ty của Đồng Niệm được công ty của Liêu Vân Thừa mua lại, nên họ buộc phải trở thành đồng nghiệp. Biết được Đồng Niệm vẫn độc thân sau bao nhiêu năm qua, Liêu Vân Thừa quyết định theo đuổi cô. Để tránh cho Đồng Niệm hiểu lầm, anh lập một tài khoản mạng và trở thành bạn qua mạng của cô. Khi Đồng Niệm gặp nguy hiểm, Liêu Vân Thừa luôn là người đầu tiên đứng ra bảo vệ cô. Hai người họ cùng nhau vượt qua những cạm bẫy chốn công sở, những sự việc như quấy rối tình dục nơi công sở,... Sau khi cùng hợp tác xử lý kẻ phản diện, Liêu Vân Thừa đã thành công theo đuổi Đồng Niệm, hai người cuối cùng cũng trở về bên nhau.', 24, 1, 1, 'Đang cập nhật', 'Đang cập nhật', 'Li Jiajia, Jin Xiao, Qu Meng Ting,...', 24, 'Ex-Boyfriend & Boss', 'ban-trai-cu-la-sep-cua-toi.jpg', 'ban-trai-cu-la-sep-cua-toi-background.jpg', 0, '2024-09-19 04:07:23', '2024-09-19 04:35:15'),
(8, 'Nguyệt Thượng Triêu Nhan', 'Vân Triêu Nhan, một cô gái có khả năng nhìn thấy những người kẻ mà người thường không thể nhìn thấy được gọi là \"nghịch tiên\". Một ngày nọ cô tình cờ gặp Nhậm Thời Khuyết vốn là vị thần mặt trăng đang đi tuần tại nhân gian. Vì nghịch tiên không dám tới gần Thời Khuyết nên cô tìm mọi cách có thể để đi theo Thời Khuyết để tránh khỏi rắc rối. Từ đây cả hai đã bắt đầu một câu chuyện đồng hành kỳ lạ và mối quan hệ của họ không dừng lại ở đó.', 25, 1, 1, 'Đang cập nhật', 'Đang cập nhật', 'Đang cập nhật', 24, 'Moon Romance', 'nguyet-thuong-trieu-nhan.jpg', 'nguyet-thuong-trieu-nhan-background.jpg', 0, '2024-09-19 04:13:36', '2024-09-19 04:15:31'),
(9, 'Gặp Lại Người Bên Gối', 'Người đàn ông tuổi trung niên thành đạt về sự nghiệp nhưng phiền não trong tình cảm. Tình nghĩa khó vẹn toàn, một người là vợ cũ mất tích nhiều năm, một người là hồng nhan tri kỷ. Năm 2012, nữ phóng viên Cố Tình Thiên (do Huỳnh Trí Văn đóng) yêu “sư phụ” Dương Vạn Sâm (do Mã Đức Chung đóng). Sau đó, họ kết hôn và sinh con trai Dương Chí Khiên. Năm 2016, Thiên gặp tai nạn, rơi xuống biển mất tích. Dương Vạn Sâm “gà trống nuôi con”, anh mất hết hy vọng khi tìm kiếm vợ. Sau 7 năm, Sâm trở thành tổng giám đốc sáng tạo của công ty sản xuất, anh tổ chức hôn lễ với Chu Thiện Mỹ (do Trương Hy Văn đóng) - hồng nhan tri kỷ giúp anh thoát khỏi vực sâu cuộc đời. Đột nhiên, Tình Thiên trở về. Thiên bị hôn mê nhiều năm, cô mất trí nhớ và lưu lạc đến Indonesia. Được sự giúp đỡ của luật sư Kim Trường Thắng (do La Thiên Vũ đóng), Thiên trở về tìm lại ký ức năm xưa. Đám cưới của Sâm và Mỹ tạm hoãn, Sâm tìm cách giúp Thiên hồi phục trí nhớ. Tình Thiên quay lại nghề phóng viên. Thiên điều tra được sự cố té núi năm xưa không phải tai nạn, mà có người hãm hại. Mặt khác, Vạn Sâm đối mặt với người tình mới và vợ cũ nên cảm thấy khó xử. Lúc này, anh lại lo sợ Tình Thiên hồi phục trí nhớ nên luôn theo dõi cô. Mỹ cảm thấy ghen tị với Thiên nên bày nhiều mưu kế lấy lòng Sâm và Chí Khiên...', 25, 2, 1, 'Đang cập nhật', 'Đang cập nhật', 'Joe Ma, Mandy Wong, Kelly Cheung, Joey Law, Tsui Wing,...', 25, 'In Bed With A Stranger', 'gap-lai-nguoi-ben-goi.jpg', 'gap-lai-nguoi-ben-goi-background.jpg', 0, '2024-09-19 04:22:19', '2024-09-19 04:23:19'),
(10, 'Gia Đình x Điệp Viên Mã: Trắng', 'Trong bộ phim lần này, sau khi nhận được yêu cầu thay thế mình trong Chiến dịch Strix, Loid Forger quyết định giúp con gái Anya chiến thắng trong cuộc thi nấu ăn tại Học viện Eden bằng cách nấu bữa ăn yêu thích của hiệu trưởng để tránh bị thay thế khỏi nhiệm vụ mật. Nhưng từ đây, gia đình Forger phát hiện ra bí mật kinh hoàng ảnh hưởng đến hòa bình thế giới.', 24, 9, 4, 'Takashi Katagiri', 'Wit Studio', 'Takuya Eguchi, Atsumi Tanezaki, Saori Hayami, Kenichirō Matsuda,...', 1, 'SPY x FAMILY CODE: White', 'spy-x-family-code-white.jpg', 'spy-x-family-code-white-background.jpg', 0, '2024-09-19 04:34:10', '2024-09-23 22:18:19'),
(11, 'Thòng Lọng Ma 2', 'Sau một nghi lễ thanh tẩy thất bại, vị pháp sư đầy mâu thuẫn cố giúp đỡ một nhà ngoại cảm trẻ và cô độc có người dì bị một ác quỷ quyền năng nhập xác.', 21, 3, 2, 'Đang cập nhật', 'Đang cập nhật', 'Lý Khang Sinh, Hứa An Thực, Trần Tuyết Chân,...', 1, 'The Rope Curse 2', 'thong-long-ma-2.jpg', 'thong-long-ma-2-background.jpg', 0, '2024-09-19 04:38:58', '2024-09-19 04:38:58'),
(12, 'APOLLO 13: SỐNG SÓT', 'Sử dụng các thước phim và cuộc phỏng vấn nguyên gốc, bộ phim tài liệu này kể câu chuyện gay cấn về tàu Apollo 13 và hành trình khó khăn để đưa các phi hành gia trở về nhà an toàn.', 25, 7, 2, 'Pete Middleton', 'Đang cập nhật', 'Đang cập nhật', 1, 'Apollo 13: Survival', 'apollo-13-survival.jpg', 'apollo-13-survival-background', 0, '2024-09-19 04:44:37', '2024-09-19 04:44:37'),
(13, 'Vương Quốc Thiên Đường', 'Kingdom of Heaven là một bản anh hùng ca hoành tráng về một người chàng trai bỗng nhiên phát hiện ra mình bị đẩy vào một cuộc chiến kéo dài cả thập kỉ. Trở thành cư dân trong một vùng đất xa lạ, chàng phải phục vụ cho một tên vua bị đày ải, rồi đem lòng yêu một cấm cung hoàng hậu xinh đẹp và trở thành một hiệp sĩ. Chàng vừa phải bảo vệ dân chúng Jerusalem khỏi các thế lực tàn bạo, vừa phải đấu tranh để giữ gìn nền hòa bình vốn đã rất mong manh...', 6, 11, 2, 'Ridley Scott', 'Babelsberg Motion Pictures', 'Orlando Bloom, Eva Green, Liam Neeson,...', 1, 'Kingdom of Heaven', 'vuong-quoc-thien-duong.jpg', 'vuong-quoc-thien-duong-background.jpg', 0, '2024-09-19 04:59:08', '2024-09-19 04:59:19'),
(14, 'Phân khu 36', 'Khi một số trẻ em mất tích dưới tay một sát nhân hàng loạt ở Phân khu 36, viên cảnh sát biến chất nọ buộc phải phá giải vụ án rùng rợn này bằng mọi giá.', 25, 4, 2, 'Aditya Nimbalkar', 'Đang cập nhật', 'Mahadev Singh Lakhawat, Baharul Islam, Ajeet Singh Palawat,...', 1, 'Sector 36', 'phan-khu-36.jpg', 'phan-khu-36-background.jpg', 0, '2024-09-19 05:02:40', '2024-09-19 05:02:40'),
(15, 'Ngang Qua Bầu Trời', 'Chàng trai nọ chuyển đến Thái Lan để theo học tại học viện danh tiếng và thực hiện ước mơ trở thành nghệ sĩ âm nhạc nổi tiếng như người bố quá cố của mình.', 24, 8, 1, 'Takonkiet Viravan, Jariwat Uppakharnchaiyaphat', 'Đang cập nhật', 'Bulaset Phusinchokwongsa, Narakorn Nichakulthanachot, Fatima Dechawaleekul,...', 14, 'Across the Sky', 'across-the-sky.jpg', 'across-the-sky-background.jpg', 0, '2024-09-19 05:12:24', '2024-09-19 05:12:24'),
(16, 'Bẫy Chuột', 'Câu chuyện bắt đầu vào sinh nhật lần thứ 21 của Alex, nhưng thay vì một bữa tiệc bình thường, cô lại phải làm việc trễ tại một trung tâm trò chơi giải trí. Đêm của cô trở nên kinh hoàng khi bạn bè cô bất ngờ đến chơi, và họ tất cả đều bị mắc kẹt với một kẻ giết người đeo mặt nạ hình con chuột Mickey, chơi một trò chơi sinh tử.', 25, 12, 2, 'Jamie Bailey', 'Đang cập nhật', 'Simon Phillips, Sophie McIntosh, Nick Biskupek, James Laurin,...', 1, 'The Mouse Trap', 'the-mouse-trap.jpg', 'the-mouse-trap-background.jpg', 0, '2024-09-19 05:18:13', '2024-09-19 05:18:13'),
(17, 'Giấc Mơ Sân Cỏ', 'Phim Giấc Mơ Sân Cỏ - Captain Tsubasa 2018: Một cậu bé thần đồng của bóng đá Nhật có tên Ozora Tsubasa - Đại Không Dực, trải qua thời gian, Tsubasa trở thành đội trưởng của đội tuyển trẻ và sau đó là Đội tuyển bóng đá quốc gia Nhật Bản.', 19, 9, 1, 'Toshiyuki Kato', 'David Production', 'Yûko Sanpei, Ayaka Fukuhara, Mustumi Tamura', 25, 'Captain Tsubasa 2018', 'captain-tsubasa-2018.jpg', 'captain-tsubasa-2018-background.jpg', 0, '2024-09-19 05:26:36', '2024-09-19 05:26:36'),
(18, 'Thiếu Niên Bạch Mã Túy Xuân Phong', 'Tiểu công tử Bách Lý Đông Quân của phủ Trấn Tây hầu không học võ nghệ mà chỉ say mê ủ rượu, nguyên nhân là vì lời hẹn \"tửu kiếm thành tiên\" với người bạn thuở nhỏ Diệp Vân. Số mệnh đưa đẩy cậu nhận Lý Trường Sinh đệ nhất thiên hạ làm thầy, bắt đầu học võ, gặp gỡ hồng nhan tri kỷ Nguyệt Dao, gặp lại Diệp Vân đã đổi tên thành Diệp Đỉnh Chi, kết bạn với lãng khách giang hồ Tư Không Trường Phong. Những thiếu niên cùng nhau bắt đầu câu chuyện giang hồ thuộc về riêng mình.', 25, 1, 1, 'Đang cập nhật', 'Đang cập nhật', 'Đang cập nhật', 40, 'Dashing Youth', 'dashing-youth.jpg', 'dashing-youth-background.jpg', 0, '2024-09-19 05:31:13', '2024-09-19 05:31:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `movie_genres`
--

CREATE TABLE `movie_genres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `movie_id` bigint(20) UNSIGNED NOT NULL,
  `genre_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `movie_genres`
--

INSERT INTO `movie_genres` (`id`, `movie_id`, `genre_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 6, NULL, NULL),
(4, 1, 19, NULL, NULL),
(5, 1, 20, NULL, NULL),
(6, 2, 4, NULL, NULL),
(7, 2, 5, NULL, NULL),
(8, 2, 6, NULL, NULL),
(9, 2, 19, NULL, NULL),
(10, 3, 1, NULL, NULL),
(11, 3, 2, NULL, NULL),
(12, 3, 4, NULL, NULL),
(13, 3, 20, NULL, NULL),
(14, 3, 21, NULL, NULL),
(16, 4, 1, NULL, NULL),
(17, 4, 2, NULL, NULL),
(18, 4, 6, NULL, NULL),
(19, 4, 17, NULL, NULL),
(20, 4, 21, NULL, NULL),
(21, 4, 22, NULL, NULL),
(22, 5, 4, NULL, NULL),
(23, 5, 5, NULL, NULL),
(24, 5, 8, NULL, NULL),
(25, 5, 17, NULL, NULL),
(26, 6, 5, NULL, NULL),
(27, 6, 6, NULL, NULL),
(28, 6, 13, NULL, NULL),
(29, 6, 17, NULL, NULL),
(30, 6, 23, NULL, NULL),
(31, 7, 4, NULL, NULL),
(32, 7, 5, NULL, NULL),
(33, 7, 8, NULL, NULL),
(34, 7, 17, NULL, NULL),
(35, 7, 24, NULL, NULL),
(36, 8, 5, NULL, NULL),
(37, 8, 11, NULL, NULL),
(38, 9, 17, NULL, NULL),
(39, 9, 20, NULL, NULL),
(40, 10, 1, NULL, NULL),
(43, 11, 3, NULL, NULL),
(44, 11, 8, NULL, NULL),
(45, 12, 15, NULL, NULL),
(46, 13, 1, NULL, NULL),
(47, 13, 2, NULL, NULL),
(48, 13, 8, NULL, NULL),
(49, 13, 9, NULL, NULL),
(50, 14, 10, NULL, NULL),
(51, 14, 17, NULL, NULL),
(52, 15, 14, NULL, NULL),
(53, 15, 17, NULL, NULL),
(54, 16, 3, NULL, NULL),
(55, 16, 13, NULL, NULL),
(56, 16, 17, NULL, NULL),
(57, 16, 23, NULL, NULL),
(58, 17, 2, NULL, NULL),
(59, 17, 12, NULL, NULL),
(60, 17, 19, NULL, NULL),
(61, 17, 21, NULL, NULL),
(62, 18, 7, NULL, NULL),
(63, 18, 11, NULL, NULL),
(64, 10, 2, NULL, NULL),
(65, 10, 4, NULL, NULL),
(66, 10, 6, NULL, NULL),
(67, 10, 21, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `title_image` text DEFAULT NULL,
  `content_image` text DEFAULT NULL,
  `other_content` text DEFAULT NULL,
  `other_image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `title_image`, `content_image`, `other_content`, `other_image`, `created_at`, `updated_at`) VALUES
(1, 'Phim chuyển thể từ truyện Nguyễn Nhật Ánh: Từ dở đến hay nhất!', 'Nguyễn Nhật Ánh là cái tên không còn xa lạ với những độc giả trẻ tuổi Việt Nam. Ông nổi tiếng là ‘cây bút tuổi thơ’ với bề dày các tác phẩm văn học lấy đề tài học đường, tái hiện quãng trời hoa niên mà chính tác giả từng thừa nhận rằng vì bản thân rời xa quê hương, xa tuổi thơ từ sớm mà luôn đau đáu nghĩ về nó. Những tác phẩm nổi tiếng của ông cũng đã được chuyển thể thành phim truyền hình, phim điện ảnh và đều để lại được ấn tượng nhất định với khán giả. Dù là điện ảnh hay truyền hình, giờ đây nhà văn Nguyễn Nhật Ánh đã trở thành cái tên thương hiệu thu hút khán giả phải xem cho bằng được các tác phẩm chuyển thể nhờ hình ảnh bắt mắt, nội dung chỉn chu và lôi cuốn mang màu sắc tuổi thơ.\r\n\r\nHãy cũng nhìn lại những bộ phim được chuyển thể từ những áng văn của Nguyễn Nhật Ánh từ dở tới hay nhất:\r\n\r\n<strong>Cô gái đến từ hôm qua</strong>\r\n\r\nNăm 2017, phim <strong>Cô gái đến từ hôm qua</strong> do đạo diễn Phan Gia Nhật Linh chuyển thể lên màn ảnh rộng ra mắt khán giả. Phim quy tụ dàn diễn viên trẻ gồm: Ngô Kiến Huy, Miu Lê, Jin Phạm, Hoàng Yến Chibi…\r\n\r\nBộ phim với lời kể của Thư - cậu học trò cấp ba phải lòng Việt An - cô bạn xinh nhất lớp, xen kẽ dòng hồi tưởng của anh về người bạn thơ ấu Tiểu Li. Kịch bản bám sát cốt truyện của nhà văn Nguyễn Nhật Ánh. Các tình tiết được xây dựng theo mạch của truyện, đan xen giữa quá khứ và hiện đại, dần hiện lên qua lời kể của Thư.\r\n\r\n<strong>Cô gái đến từ hôm qua</strong> là một bộ phim khá của điện ảnh Việt, nhưng là một bước lùi so với bộ phim chuyển thể trước đó của nhà văn Nguyễn Nhật Ánh. Nhờ chuyển thể từ truyện của Nguyễn Nhật Ánh nên phần lớn tuyến nhân vật được xây dựng hợp lý và đáng yêu. <strong>Cô gái đến từ hôm qua</strong> tránh được vấn đề kịch bản vốn là điểm yếu nhất của điện ảnh Việt. Thế nhưng nó lại đi theo vết xe đổ khác đó là thiếu đi sự chỉn chu trong cách thể hiện, sự đối lập giữa các tình tiết trong nguyên tác và tình tiết mới được bổ sung thêm.', 'ngay-xua-co-mot-chuyen-301726815905-1729602250625492540601-198-0-1245-2000-crop-1729602270229213938122820241101094536.jpg', '120241031150047.jpg', '<strong>Mắt biếc</strong>\r\n\r\n<strong>Mắt biếc</strong> được chuyển thể từ tác phẩm cùng tên của nhà văn vào năm 2019. Đạo diễn Victor Vũ thực hiện phần chuyển thể, đưa tác phẩm lên màn ảnh rộng với doanh thu hơn 165 tỉ đồng.\r\n\r\nNội dung phim xoay quanh mối tình đơn phương giữa Ngạn và Hà Lan. Hà Lan là cô gái có đôi mắt đẹp, buồn nhưng tính cách không hề yếu mềm mà ngược lại rất cá tính. Ngạn và Hà Lan biết nhau từ thuở nhỏ, tình yêu của Ngạn với Hà Lan cũng lớn dần theo năm tháng. Chuyện tình đơn phương không thành, trớ trêu thay, con gái của Hà Lan là Trà Long lại nhen nhóm tình cảm với Ngạn.\r\n\r\n<strong>Mắt biếc</strong> thành công khi làm bật những tình tiết gãy gọn, đủ đánh thức cảm xúc người xem dù có thể là chưa đọc qua truyện, phim diễn tả được những nỗi niềm chất chứa, dồn nén da diết trong Ngạn tạo nên linh hồn cho <strong>Mắt biếc</strong>. Phần lồng tiếng chưa thuyết phục nhưng nhạc phim hay, góc quay, hình ảnh lời thoại đều ổn. Tuy nhiên, trang phục và tình tiết phim nhiều chỗ chưa phù hợp với bối cảnh trong phim, diễn xuất cũng là điểm chưa tốt lắm của phim.', 'images1581945-phim-mat-biec20241101094540.jpg', '2024-10-31 16:16:32', '2024-11-01 04:31:32'),
(2, 'Dù chưa công chiếu chính thức, ‘Venom: The Last Dance’ đã đứng đầu phòng vé', 'Venom được cho là một trong những phim siêu anh hùng rất thành công của nhà Sony. Phần thứ ba cũng là phần cuối cùng trong loạt phim Venom. Sau cuộc đối đầu với Carnage tại phần trước, bộ phim tiếp tục xoay quanh hành trình cuối của Eddie Brock (Tom Hardy) và Venom trước cuộc xâm lược của ác thần Knull. Theo nguyên tác, Knull là một vị thần nguyên thủy xuất hiện sau sự hủy diệt trong lần lặp lại thứ sáu ở vũ trụ. Phẫn nộ vì “vương quốc” bị phá hoại, hắn đã tạo ra All-Black The Necrosword để tiêu diệt một trong những Celestials. Sau khi bị tống giam, hắn khai sinh ra chủng tộc Klyntar, hay còn gọi là Symbiote.\r\n\r\nBộ phim hứa hẹn tạo nên những pha hành động hoành tráng, thỏa mãn người hâm mộ. Cặp đôi Eddie Brock và Venom sẽ phải bảo vệ Trái Đất khỏi cuộc xâm lược của thế lực phản diện.', 'news-title-venom.jpg', 'news-venom1.png', '<strong>Venom: Kèo cuối</strong> đã tạo nên cơn sốt nhanh chóng khi chiếm lĩnh vị trí số một tại các phòng vé, gây bão cư dân mạng sau tin tức khởi chiếu được tung ra. Tiếp nối thành công hai phần trước, với sự yêu thích của khán giả, Venom 3 đã có lượng người hâm mộ sẵn sàng đến rạp ngay những ngày đầu công chiếu. Điều này đã được kiểm chứng khi 22 nghìn vé được bán trong ngày chiếu sớm đầu tiên (23/10) theo thống kê từ Box Office Vietnam. Thành công này không phải ngẫu nhiên mà là kết quả bởi nhiều yếu tố. Thêm nữa, việc hé lộ những tình tiết hấp dẫn trong trailer và thông tin được tiết lộ trước đó, khán giả càng thêm hứng thú và mong muốn khám phá hành trình của Venom - Eddie Brock. Đặc biệt, sự xuất hiện của nhân vật mới - Knull, đã kích thích trí tò mò với người xem\r\n\r\n<strong>Venom: Kèo cuối</strong> có suất chiếu sớm từ 19h ngày 23/10 và 24/10. Bộ phim dự kiến khởi chiếu chính thức vào ngày 25/10/2024 tại các cụm rạp.', 'news-venom2.jpg', '2024-10-31 19:06:44', '2024-11-01 04:32:39'),
(3, 'Những bí ẩn thú vị trong siêu phẩm Anime đứng đầu phòng vé Nhật Bản \'Look Back\'', '<strong>Tên của hai nhân vật chính trong phim</strong>\r\n\r\n<strong>Look Back: Liệu ta có dám nhìn lại?</strong> xoay quanh nhân vật chính là hai cô gái trẻ Fujino và Kyomoto cùng sở hữu đam mê sáng tác manga. Fujino và Kyomoto học cùng trường tiểu học; ban đầu, Fujino coi Kyomoto là đối thủ, nhưng sau đó giữa cả hai đã nảy sinh một tình bạn bền chặt, thúc đẩy họ chạm đến những cột mốc thành công trong sự nghiệp sáng tác.\r\n\r\nNếu dùng nửa đầu tên của Fujino và nửa cuối tên của Kyomoto ghép lại, ta sẽ có từ Fujimoto - cũng chính là họ của tác giả Fujimoto Tatsuki. Và cá tính khác biệt của cả Fujino hay Kyomoto cũng chính là hai trường phái tinh thần của chính tác giả Fujimoto Tatsuki trên chặng đường sáng tác của mình.\r\n\r\nNgoài ra, tên của Kyomoto cũng khiến nhiều khán giả liên tưởng đến studio Kyoto Animation - nơi xảy ra vụ phóng hỏa thảm khốc năm 2019, cũng là sự kiện có thật khiến tác giả Fujimoto Tatsuki quyết định sáng tác <strong>Look Back</strong>.', 'news-lock-back-title.png', 'news-lock-back1.jpg', '<strong>Những phân đoạn không thoại \"xé truyện bước ra\"</strong>\r\n\r\nMột trong những điểm độc đáo khiến <strong>Look Back</strong> nói riêng và các one-shot khác của tác giả Fujimoto Tatsuki được yêu thích chính là \"tính điện ảnh\" trong các tác phẩm này.\r\n\r\nTrong <strong>Look Back</strong> cả phiên bản Anime, đạo diễn Oshiyama đã giữ lại rất nguyên vẹn nét đặc trưng \"hạn chế lời thoại\" của tác phẩm gốc. Fujino và Kyomoto không nói quá nhiều, cũng không có những câu thoại mang tính triết lý. Thay vào đó, cả tác giả và đạo diễn cùng sử dụng nghệ thuật \"show don\'t tell\" với rất nhiều các phân đoạn không lời thoại liên tiếp nhau, chỉ sử dụng biểu cảm và hành động của nhân vật để trò chuyện với khán giả.\r\n\r\nHầu hết những phân đoạn không thoại - mà trong truyện là những trang đôi, hay hàng loạt ô truyện không lời liên tiếp đều được mang lên màn ảnh, hoàn toàn không có lời thoại nào. Có chăng, phần âm nhạc được sử dụng trong phim càng góp phần giúp đẩy cảm xúc của khán giả lên cao trào.\r\n\r\n<strong>Hé lộ thêm một one-shot khác của Fujimoto Tatsuki sẽ bước lên màn ảnh?</strong>\r\n\r\nBên cạnh <strong>Look Back</strong>, tác giả Fujimoto Tatsuki cũng có rất nhiều one-shot đình đám khác, một trong số đó phải kể đến Goodbye, Eri nhận được rất nhiều cảm tình từ độc giả.\r\n\r\nTheo cốt truyện, Fujino và Kyomoto đã dành một ngày đi chơi cùng nhau sau khi cả hai đạt giải trong một cuộc thi vẽ truyện tranh, trong đó cả hai dành thời gian cùng nhau xem một bộ phim. Thế nhưng, trong phiên bản truyện tranh, tác giả Fujimoto Tatsuki chỉ cho khán giả thấy biểu cảm của hai cô bé.\r\n\r\nTrong khi đó, ở phiên bản điện ảnh, cả hai cô bé đang xem bộ phim được thực hiện bởi nhân vật chính Yuta Ito trong Goodbye, Eri. Đây có thể là một \"easter egg\" thú vị, nhưng cũng cho các fan của Fujimoto Tatsuki hy vọng one-shot đình đám khác của ông sẽ bước lên màn ảnh rộng.', 'news-lock-back2.jpg', '2024-10-31 19:24:10', '2024-11-01 04:40:22'),
(4, 'Những lý do khiến \'Conan Movie 27: Ngôi sao 5 cánh 1 triệu đô\' bay phấp phới tại phòng vé', 'Tính đến thời điểm hiện tại, bộ phim điện ảnh thứ 27 của series <strong>Thám tử lừng danh Conan</strong> đã thu về gần 108 tỷ đồng tại phòng vé Việt, vượt qua nhiều đối thử sừng sỏ trong và ngoài nước, chẳng hạn như bom tấn Marvel Deadpool & Wolverine. Đây là một thành tích ấn tượng với bộ phim thuộc nhượng quyền thương mại Conan và hiện, phim đang được kỳ vọng sẽ soán ngôi vương dòng phim anime của Doraemon: Nobita và bản giao hưởng địa cầu tại phòng vé.\r\n\r\nCó nhiều lý do dẫn đến thành công của <strong>Conan Movie 27: Ngôi sao 5 cánh 1 triệu đô</strong>. Đầu tiên, Conan là một tựa phim thân thuộc với nhiều thế hệ khán giả Việt. Kể từ khi ra mắt lần đầu tiên vào năm 1994 cho đến nay, chàng thám tử teo nhỏ Edogawa Conan đã đồng hành cùng biết bao thế hệ khán giả và đến tận thời điểm hiện tại, có những người đã trưởng thành nhưng vẫn dành tình cảm lớn đến với nhân vật hư cấu này.', 'news-title-conan-movie-27.png', 'news-conan-movie-27-1.jpg', 'Đó chỉ là một yếu tố. Bên cạnh những nhân vật quen thuộc như Conan, Mori Kogoro, Ran... <strong>Conan Movie 27: Ngôi sao 5 cánh 1 triệu đô</strong> có sự góp mặt của những nhân vật \"hút fan\" hàng đầu như siêu trộm ánh trăng Kaito Kid, thám tử miền Tây Hattori Henji... và đặc biệt là màn ra mắt màn ảnh rộng của Aoko - cô bạn \"thanh mai trúc mã\" với chàng siêu trộm. Không chỉ vậy, sự xuất hiện của những nhân vật \"khách mời\" như nhà văn trinh thám Kudo Yusaku, Siêu trộm Kid đời đầu Kuroba Toichi hay màn hé lộ mối quan hệ thực sự giữa Kid và Conan càng thu hút hơn sự quan tâm của khán giả.\r\n\r\nQuan trọng hơn cả, <strong>Conan Movie 27: Ngôi sao 5 cánh 1 triệu đô</strong> có một cốt truyện thú vị, hấp dẫn. Bộ phim là sự kết hợp hài hòa giữa những màn suy luận sắc sảo và những pha hành động nghẹt thở, xen lẫn vào đó là những chi tiết hài hước, khiến người xem không nhịn được cười.\r\n\r\nVới những lý do kể trên, không khó để hiểu được vì sao <strong>Conan Movie 27: Ngôi sao 5 cánh 1 triệu đô</strong> lại thành công đến vậy.', 'news-conan-movie-27-2.jpg', '2024-10-31 19:29:46', '2024-11-01 04:44:49'),
(5, '\'Doraemon: Nobita và Bản giao hưởng địa cầu\' bị chê \'nhạt nhẽo\'?', 'Là phần phim thứ 43 trong loạt phim điện ảnh về chú mèo máy nổi tiếng, <strong>Doraemon: Nobita và Bản giao hưởng địa cầu</strong> kể về cuộc chiến chống lại \"tế bào Noise\" đang nhăm nhe phá hoại những hành tinh có âm nhạc, trong đó có cả Trái Đất, của Nobita, Doraemon và những người bạn. Trong cuộc chiến đó, cả nhóm đã phiêu lưu đến một cung điện âm nhạc, tập sử dụng những loại nhạc cụ và rồi, sử dụng chính những loại nhạc cụ đó để chiến đấu.\r\n\r\nDù chỉ mới ra mắt vào cuối tuần rồi qua 2 ngày chiếu sớm, <strong>Doraemon: Nobita và Bản giao hưởng địa cầu</strong> đã xô đổ hàng loạt kỷ lục. Tính đến thời điểm hiện tại, phim thu về gần 25 triệu USD trên toàn cầu. Tại thị trường Việt Nam, Movie 43 gây choáng khi hất đổ ngôi vương phòng vé của Lật mặt 7, thu về hơn 26 tỷ đồng dù chưa chính thức khởi chiếu', 'news-title-doraemon-movie-43.jpg', 'news-doraemon-movie-43-1.png', 'Gặt hái nhiều thành công tại phòng vé nhưng <strong>Doraemon: Nobita và Bản giao hưởng địa cầu</strong> lại nhận về ý kiến trái chiều về mặt nội dung. Nhiều khán giả đánh giả bộ phim tương đối nhạt nhẽo, không truyền tải được nhiều thông điệp ý nghĩ như lên án vấn nạn săn bắt, mua bán động vật hoang dã trong Doraemon: Cuộc phiêu lưu tới đảo giấu vàng hay cảnh báo mối nguy của việc chạy đua vũ trang và vũ khí hạt nhân như Nobita và lâu đài dưới đáy biển...\r\n\r\nNói như vậy không phải là Movie 43 không có thông điệp, chỉ có điều, thông điệp về tầm quan trọng của âm nhạc không được đánh giá cao như những Movie trước đó. Thêm vào đó, diễn biến của phim tương đối nhẹ nhàng, phản diện không gây sức ảnh hưởng lớn như phản diện trong những phần phim trước đó. Điều này đồng nghĩa với việc, phim thiếu đi những pha hành động gay cấn.\r\n\r\nTuy nhiên, cũng phải nhìn lại, Doraemon là loạt phim hoạt hình hướng tới đối tượng khán giả trẻ con, chính vì vậy, nhà sản xuất sẽ cân nhắc nhiều yếu tố để làm hài lòng những khán giả nhí này. Trong khi đó, nội dung đơn giản, nhẹ nhàng của <strong>Doraemon: Nobita và Bản giao hưởng địa cầu</strong> lại rất phù hợp với các bạn nhỏ. Với những bạn nhỏ, bộ phim với nhân vật quen thuộc, đồ họa đẹp mắt và nội dung dễ hiểu là quá đủ để các em thích thú dõi theo.', 'news-doraemon-movie-43-2.png', '2024-10-31 20:01:56', '2024-11-01 04:46:19'),
(6, '\'Deadpool và Wolverine\' vì sao lại hút khán giả \'kinh khủng\' như vậy?', '<strong>Dealpool 3</strong> do Shawn Levy đạo diễn, phim chứng tỏ được sức hút qua rất nhiều tình tiết hài hước và các pha hành động. Phim lấy bối cảnh sáu năm sau các sự kiện trong <strong>Deadpool</strong> khi nhân vật chính từ bỏ nghề đánh thuê, quay trở về với cuộc sống làm nhân viên bán ô tô. Trong một buổi tối khi anh cùng các bạn đang tổ chức buổi tiệc sinh nhật thì nhóm đặc vụ thuộc Cơ quan Phương sai Thời gian bất ngờ xuất hiện và bắt cóc <strong>Deadpool</strong> về trụ sở.\r\n\r\nNhân viên TVA Paradox nói sẽ hủy diệt thế giới của <strong>Deadpool do Wolverine</strong> - nhân vật trung tâm của dòng thời gian - qua đời sau sự kiện ở Logan. Quyết định này sẽ khiến cho những người anh yêu thương phải chết. Vậy anh sẽ làm gì đây để có thể cứu rỗi được thế giới và những người mình yêu?\r\n\r\n<strong>Dealpool 3</strong> vẫn giữ nguyên được phong cách “thiếu nghiêm túc” của thương hiệu siêu anh hùng ăn khách này. Phim tiếp tục được xây dựng trên ý tưởng đa vũ trụ, kịch bản <strong>Deadpool & Wolverine</strong> tiếp tục theo chân chàng siêu anh hùng ngổ ngáo Wade Wilson (tức <strong>Deadpool</strong>) ở vũ trụ Earth-10005', 'news-title-deadpool3.png', 'news-deadpool3-1.jpg', 'Tên tuổi Hugh Jackman gắn liền Wolverine trong suốt hơn hai thập niên. Với vẻ ngoài rắn rỏi, đôi mắt sắc lạnh, Jackman cho thấy nhân vật là người mạnh mẽ nhưng cũng tổn thương và cô độc. Với <strong>Deadpool</strong>, anh đấu tranh chỉ vì muốn trở nên quan trọng với mọi người, trong phim lẫn ngoài đời thật. Dù có khả năng bất tử, nhân vật vẫn sợ một ngày nào đó mình sẽ bị lãng quên.\r\n\r\n<strong>Deadpool & Wolverine</strong> có thể xem là một cột mốc lịch sử Marvel khi đánh dấu sự gia nhập chính thức của 2 nhân vật siêu anh hùng đình đám này vào vũ trụ điện ảnh của họ. Trước đó, cả <strong>Deadpool và Wolverine</strong> đều xuất hiện trong các bộ phim của 20th Century Fox, trước khi công ty này bán lại cho Disney vào năm 2017. <strong>Dealpool 3</strong> cũng trở thành bộ phim điện ảnh đầu tiên của Marvel Cinematic Universe bị dán nhãn 18+.\r\n\r\nĐiểm giúp <strong>Deadpool & Wolverine</strong> chinh phục khán giả là hàng loạt chi tiết hài hước, bạo lực được cài cắm khéo léo trong suốt thời lượng hơn 2 tiếng của bộ phim. Trong vai siêu anh hùng “mỏ hỗn” bậc nhất của Marvel, Ryan Reynolds tiếp tục là người gồng gánh tuyến tình tiết nhí nhố, ngổ ngáo của tác phẩm. Nếu đã là fan của <strong>Deadpool</strong> từ trước, khán giả chắc chắn sẽ tiếp tục không thể ngồi yên trước những màn tấu hài đầy trí tuệ của ngôi sao Canada này trong phần mới.\r\n\r\nNhìn chung, <strong>Deadpool & Wolverine</strong> là một bộ phim giàu tính giải trí, xứng đáng là một trong những bom tấn đáng xem nhất của mùa phim hè Hollywood năm nay. Dù đã gia nhập Marvel, Ryan Reynolds vẫn thành công trong việc giữ nguyên những nét đặc sắc của thương hiệu <strong>Deadpool</strong> để không khiến người hâm mộ thất vọng. Tác phẩm được lồng ghép rất nhiều các tình tiết tri ân, easter egg gợi nhớ các bộ phim siêu anh hùng của 20th Century Fox, đồng thời hứa hẹn một chương mới đầy tiềm năng cho Marvel.', 'news-deadpool3-2.png', '2024-10-31 20:04:32', '2024-11-01 04:51:33'),
(7, 'Vì sao \'Quỷ ăn tạng 2\' đứng top phòng vé, nhiều bom tấn \'hít khói\'?', 'Tính đến ngày 16/10, bom tấn <strong>Quỷ ăn tạng 2</strong> - Tee Yod tiếp tục đứng nhất phòng vé Việt với doanh thu lên tới 46 tỷ đồng, bộ phim nhận được nhiều sự quan tâm của khán giả Việt, đành bại nhiều bom tấn để dẫn đầu vị trí số 1 vì lý do gì?\r\n\r\nTiếp nói phần đầu, ba năm sau cái chết của cô em gái Yam, Yak - người anh cả trong gia đình vẫn tiếp tục săn lùng linh hồn bí ẩn mặc áo choàng đen. Gặp một cô gái có triệu chứng giống Yam, Yak phát hiện ra người bảo vệ linh hồn, pháp sư ẩn dật Puang, sống trong một khu rừng đầy nguy hiểm. Giữa những phép thuật ma quỷ và những sinh vật nguy hiểm. Khi họ đuổi theo linh hồn mặc áo choàng đen, tiếng kêu đầy ám ảnh của Tee Yod sắp quay trở lại một lần nữa...', 'news-title-quy-an-tang-2.jpg', 'news-quy-an-tang-2-1.jpg', '<strong>Quỷ ăn tạng 2</strong> có phần hù dọa và kinh dị tương đối ổn, với phần hóa trang chỉn chu và gây ra cảm giác sợ hãi tột độ cho khán giả. Thể loại phim kinh dị đang ngày càng phổ biến với khán giả Việt Nam, khi nhiều thống kê gần đây cho thấy các phim kinh dị luôn đứng đầu phòng vé Việt nên thành công của <strong>Quỷ ăn tạng 2</strong> là điều rất đương nhiên.\r\n\r\nNgoài ra, bộ phim cũng có phần hành động rất đã mắt và làm liên tưởng rất nhiều phong cách Hollywood, khiến bộ phim trở nên đậm chất giải trí hơn cả. Giới chuyên môn nhận xét, phim không quá xuất sắc nhưng có kịch bản khá gãy gọn, \"dễ thấm\" và dễ hiểu. Hành trình trả thù của Yak tuy rằng còn nhiều điểm bất cập, chưa hoàn toàn logic nhưng nhìn chung không quá lấn cấn. Bộ phim cũng ca ngợi tình cảm gia đình gắn gó, rằng tình yêu thương và sự đoàn kết trong gia đình có thể vượt qua được mọi sóng gió. Đây không phải là lần đầu tiên điện ảnh Thái gây bão tại Việt Nam, trước đó có bộ phim Gia tài của ngoại cũng nhận về nhiều cảm tình của khán giả Việt, cho thấy điện ảnh Thái ngày càng tiến bộ và có nhiều điểm nhấn.\r\n\r\nĐiện ảnh Thái thực tế làm rất tốt trong việc xuất khẩu tác phẩm ra nước ngoài. Tuy vậy khi xem phim của họ, không có một chút nào gọi là sính ngoại mà trái lại, họ sử dụng chất liệu là những nét văn hóa truyền thống của dân tộc, văn hóa và xã hội con người Thái, vẫn đủ để thu hút khán giả quốc tế.', 'news-quy-an-tang-2-2.jpg', '2024-10-31 20:07:08', '2024-11-01 04:52:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('chithanhcdv456@gmail.com', '$2y$12$xnADesQOheZC47yu1WQ/guu1xysdjmCGL9bUI5XWYghOKv0sa0sIq', '2024-10-27 03:02:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `movie_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `movie_id`, `rating`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 10, '2024-09-15 05:11:36', '2024-09-15 05:11:36'),
(2, 2, 3, 9, '2024-09-17 02:39:27', '2024-09-17 02:39:27'),
(3, 2, 10, 10, '2024-09-23 22:44:53', '2024-09-23 22:44:53'),
(4, 2, 4, 5, '2024-09-23 22:46:26', '2024-09-23 22:46:26'),
(5, 2, 5, 10, '2024-09-23 22:54:16', '2024-09-23 22:54:16'),
(6, 2, 7, 9, '2024-09-24 02:33:45', '2024-09-24 02:33:45'),
(7, 3, 10, 9, '2024-10-01 05:32:49', '2024-10-01 05:32:49'),
(8, 2, 2, 10, '2024-10-06 03:48:40', '2024-10-06 03:48:40'),
(11, 21, 10, 10, '2024-11-01 16:50:03', '2024-11-01 16:50:03'),
(12, 2, 15, 9, '2024-11-06 01:46:40', '2024-11-06 01:46:40'),
(13, 23, 10, 10, '2024-11-08 02:47:24', '2024-11-08 02:47:24'),
(14, 23, 5, 2, '2024-11-12 09:44:47', '2024-11-12 09:44:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `release_years`
--

CREATE TABLE `release_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year` year(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `release_years`
--

INSERT INTO `release_years` (`id`, `year`, `created_at`, `updated_at`) VALUES
(1, '2000', '2024-09-14 03:02:06', '2024-09-14 03:02:06'),
(2, '2001', '2024-09-14 03:02:16', '2024-09-14 03:02:16'),
(3, '2002', '2024-09-14 03:02:24', '2024-09-14 03:02:24'),
(4, '2003', '2024-09-14 03:02:34', '2024-09-14 03:02:34'),
(5, '2004', '2024-09-14 03:03:32', '2024-09-14 03:03:32'),
(6, '2005', '2024-09-14 03:03:40', '2024-09-14 03:03:40'),
(7, '2006', '2024-09-14 03:03:52', '2024-09-14 03:03:52'),
(8, '2007', '2024-09-14 03:04:02', '2024-09-14 03:04:02'),
(9, '2008', '2024-09-14 03:04:08', '2024-09-14 03:04:08'),
(10, '2009', '2024-09-14 03:04:12', '2024-09-14 03:04:12'),
(11, '2010', '2024-09-14 03:04:16', '2024-09-14 03:04:16'),
(12, '2011', '2024-09-14 03:04:19', '2024-09-14 03:04:19'),
(13, '2012', '2024-09-14 03:04:22', '2024-09-14 03:04:22'),
(14, '2013', '2024-09-14 03:04:26', '2024-09-14 03:04:26'),
(15, '2014', '2024-09-14 03:04:30', '2024-09-14 03:04:30'),
(16, '2015', '2024-09-14 03:04:33', '2024-09-14 03:04:33'),
(17, '2016', '2024-09-14 03:04:37', '2024-09-14 03:04:37'),
(18, '2017', '2024-09-14 03:04:40', '2024-09-14 03:04:40'),
(19, '2018', '2024-09-14 03:04:43', '2024-09-14 03:04:43'),
(20, '2019', '2024-09-14 03:04:47', '2024-09-14 03:04:47'),
(21, '2020', '2024-09-14 03:04:50', '2024-09-14 03:04:50'),
(22, '2021', '2024-09-14 03:04:54', '2024-09-14 03:04:54'),
(23, '2022', '2024-09-14 03:04:56', '2024-09-14 03:04:56'),
(24, '2023', '2024-09-14 03:05:00', '2024-09-14 03:05:00'),
(25, '2024', '2024-09-14 03:05:04', '2024-09-14 03:05:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `replies`
--

CREATE TABLE `replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `replies`
--

INSERT INTO `replies` (`id`, `comment_id`, `user_id`, `content`, `image`, `created_at`, `updated_at`) VALUES
(1, 29, 23, '😍', NULL, '2024-11-13 03:09:45', '2024-11-13 03:09:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `duration` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `price`, `duration`, `created_at`, `updated_at`) VALUES
(1, 'Tháng', '<li>Xem các bộ phim hot</li>\r\n<li>Nhận thông báo khi có phim mới </li>\r\n', 20000.00, 30, '2024-11-02 01:03:24', '2024-11-02 01:03:24'),
(2, 'Năm', '<li>Xem các bộ phim hot</li>\r\n<li>Nhận thông báo khi có phim mới </li>', 200000.00, 365, '2024-11-02 01:03:55', '2024-11-06 02:27:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services_orders`
--

CREATE TABLE `services_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `service_start_at` timestamp NULL DEFAULT NULL,
  `service_end_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `services_orders`
--

INSERT INTO `services_orders` (`id`, `user_id`, `service_id`, `order_code`, `payment_method`, `service_start_at`, `service_end_at`, `status`, `created_at`, `updated_at`) VALUES
(1, 21, 1, '979879233', 'VNPay', '2024-11-05 22:23:02', '2024-12-05 22:23:02', 'Đã hủy', '2024-11-05 22:23:02', '2024-11-05 22:23:02'),
(2, 21, 1, '1146392091', 'VNPay', '2024-11-05 23:08:01', '2024-12-05 23:08:01', 'Đang sử dụng', '2024-11-05 23:08:01', '2024-11-05 23:08:01'),
(4, 2, 2, '83183168', 'VNPay', '2024-11-05 23:14:49', '2025-11-05 23:14:49', 'Đã hủy', '2024-11-05 23:14:49', '2024-11-05 23:14:49'),
(5, 2, 1, '868273640', 'VNPay', '2024-11-06 01:27:03', '2024-12-06 01:27:03', 'Đã hủy', '2024-11-06 01:27:03', '2024-11-06 02:51:42'),
(6, 23, 1, '615496722', 'VNPay', '2024-11-08 02:42:55', '2024-12-08 02:42:55', 'Đang sử dụng', '2024-11-08 02:42:55', '2024-11-08 02:42:55'),
(7, 2, 1, '514790241', 'VNPay', '2024-11-25 10:03:46', '2024-12-25 10:03:46', 'Đang sử dụng', '2024-11-25 10:03:46', '2024-11-25 10:03:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Bko0YOUN6A0YRcqqtc7jjjfuQxkMdUfGShAWIb6d', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoibUE0TUJndFFDS0hENElvY2dENmZ0STFTNlpYZmd6am5BRHRlSjVFdSI7czozOiJ1cmwiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vZGFzaGJvYXJkIjt9czo1NToibG9naW5fYmFja3BhY2tfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjI6InBhc3N3b3JkX2hhc2hfYmFja3BhY2siO3M6NjA6IiQyeSQxMiRxd1dSYkJWWXFDWFJ5TE0yNUZ3NUVlMHRNVURRSjdtSS9xTzZUb2lILzRHRzI1enNxWXNOVyI7fQ==', 1732559311),
('GHePlCXjNr9SDktRcSTkoQ70C8YdhtYfQPhI83f5', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiR2ZyWmszV3VDY3ZaRElZcmpZMWdDNGVGc3Z1NlNjWjJLZ3R0Wk5nRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzMyNTYwMjEwO319', 1732561836),
('rvgHkLL0TyPsuD7tICDkDrzWHznNqWVySi3Gqdum', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia1BSWHVUTkJldXdxYlZEY3lkeGlyV0szN0JGNnM5d3Z4am1vMmloTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fX0=', 1732561871),
('uC7pi5tAF964d59j70KvnekzqmG5XeW04VYNOJCA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFpWZEtyNjJISERYc25uaXFMZndaU1VSeW5yQXFxbEZvNzNXQ2RjaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1732615451);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trailers`
--

CREATE TABLE `trailers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `movie_id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `trailers`
--

INSERT INTO `trailers` (`id`, `movie_id`, `url`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'https://www.youtube.com/embed/B87mHRu3aXQ?si=4HQ5aUn6l5RtJU9w', NULL, '2024-09-15 05:51:13', '2024-09-15 05:52:25'),
(2, 3, 'https://www.youtube.com/embed/1roy4o4tqQM?si=mNFBHjv05gCl70sM', NULL, '2024-09-19 03:53:41', '2024-09-19 03:53:41'),
(3, 2, 'https://www.youtube.com/embed/4VYNTfXuAJ0?si=8Asl2TK6StgFa46t', NULL, '2024-09-19 03:54:46', '2024-09-19 03:58:02'),
(4, 6, 'https://www.youtube.com/embed/K6O3FOOWoao?si=hS072qIMmeT4Dolc', NULL, '2024-09-19 03:55:30', '2024-09-19 03:55:30'),
(5, 4, 'https://www.youtube.com/embed/6d-lsJZgmJs?si=ip8ZH2kr77BgZIyE', NULL, '2024-09-19 03:56:38', '2024-09-19 03:56:38'),
(6, 5, 'https://www.youtube.com/embed/58FKUvsLgd4?si=5ZfpmWriqp_WCR5R', NULL, '2024-09-19 03:59:11', '2024-09-19 03:59:11'),
(7, 10, 'https://www.youtube.com/embed/boLFW-C1wF4?si=ICtqK_ukUt-u5p-1', NULL, '2024-09-23 22:21:48', '2024-09-23 22:25:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_start_at` timestamp NULL DEFAULT NULL,
  `service_end_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `google_id`, `facebook_id`, `avatar`, `is_admin`, `remember_token`, `created_at`, `updated_at`, `service_id`, `service_start_at`, `service_end_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$qwWRbBVYqCXRyLM25Fw5Ee0tMUDQJ7mI/qO6ToiH/4GG25zsqYsNW', NULL, NULL, NULL, 1, NULL, '2024-09-13 23:56:02', '2024-09-13 23:56:02', NULL, NULL, NULL),
(2, 'chithanhcdv456', 'chithanhcdv456@gmail.com', '2024-09-14 22:41:15', '$2y$12$WhTPlYB7Gcq4FHOj7vklp.KDODxxne0Yx3O.fkzbYFtui1GBseUXi', '104228838140470417039', NULL, 'arti-my-dear-moments.jpg', 0, 'W7F4K1POP8NZklh4cXvUFvBBhavyfP8MIa1KUPx21hWLVXyV9ecL69jw7rDb', '2024-09-14 22:40:22', '2024-11-25 10:03:46', 1, '2024-11-25 10:03:46', '2024-12-25 10:03:46'),
(3, 'chithanhcdv77', 'chithanhcdv77@gmail.com', '2024-10-01 05:35:17', '$2y$12$SaIU6ALoC.OklN2NgM6reunW/h.pAncvUJcYzbKJWUtm.aGP56dfO', '113876669512467593891', NULL, 'gi.png', 0, NULL, '2024-10-01 05:32:14', '2024-11-13 03:08:42', NULL, NULL, NULL),
(4, 'chithanhcdv555', 'chithanhcdv555@gmail.com', '2024-10-01 07:01:54', '$2y$12$cfvzydBLyF.1jp3A.CIGyuQqXnQhaaacPBq8uFuNBHWscq0le27iG', '109537986320297817606', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocKJpJECsM9X94yq-aqpy66IwlLCZcp7q_Oyl19dC4YkESs3DA=s96-c', 0, NULL, '2024-10-01 07:00:31', '2024-11-02 05:44:19', NULL, NULL, NULL),
(21, 'T', 'chithanhcdv999@gmail.com', '2024-10-27 01:24:33', '$2y$12$aawTN9TvsKLkYiTSJ0cc7.IjTrcf8BGvRTAWfDzSjlJA27cl1vNuy', '104922337631695484959', NULL, 'encore2.jpg', 0, NULL, '2024-10-27 01:23:02', '2024-11-05 23:08:01', 1, '2024-11-05 23:08:01', '2024-12-05 23:08:01'),
(22, 'Thien Nguyen', 'chithanhcdv444@gmail.com', '2024-11-12 10:45:42', NULL, '113834966444072619322', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocKcLYE5KgmR1ezWb_hN3fq6dL2ptpl-XGGwHtgYh2U6fDBd9g=s96-c', 0, NULL, '2024-11-02 02:42:44', '2024-11-12 10:45:42', NULL, NULL, NULL),
(23, 'chithanhcdv', 'chithanhcdv7@gmail.com', '2024-11-08 02:42:08', NULL, '107034373852480832547', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocLlG6HyQHdSEDHrXzuvqrjcSkQm1RcEyTlrp3gFp8VOx1nfPKiJ=s96-c', 0, NULL, '2024-11-08 02:41:33', '2024-11-13 04:18:50', 1, '2024-11-08 02:42:55', '2024-12-08 02:42:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `views`
--

CREATE TABLE `views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `movie_id` bigint(20) UNSIGNED NOT NULL,
  `views_count` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `views`
--

INSERT INTO `views` (`id`, `movie_id`, `views_count`, `created_at`, `updated_at`) VALUES
(1, 4, 8, '2024-10-30 23:19:18', '2024-10-30 23:19:18'),
(2, 1, 45, '2024-11-12 09:19:19', '2024-11-12 09:19:19'),
(3, 6, 13, '2024-11-12 09:43:53', '2024-11-12 09:43:53'),
(4, 10, 81, '2024-11-25 10:04:02', '2024-11-25 10:04:02'),
(5, 2, 43, '2024-11-08 03:54:04', '2024-11-08 03:54:04'),
(6, 5, 23, '2024-11-01 18:17:05', '2024-11-01 18:17:05'),
(7, 7, 18, '2024-11-06 01:52:43', '2024-11-06 01:52:43'),
(8, 18, 2, '2024-09-27 06:04:47', '2024-09-27 06:04:47'),
(9, 13, 1, '2024-09-27 06:02:33', '2024-09-27 06:02:33'),
(10, 8, 2, '2024-09-28 03:33:46', '2024-09-28 03:33:46'),
(11, 9, 1, '2024-09-28 03:33:49', '2024-09-28 03:33:49'),
(15, 3, 1, '2024-09-28 04:53:40', '2024-09-28 04:53:40'),
(16, 15, 2, '2024-11-06 01:46:40', '2024-11-06 01:46:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `watch_histories`
--

CREATE TABLE `watch_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `movie_id` bigint(20) UNSIGNED NOT NULL,
  `watched_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `watch_histories`
--

INSERT INTO `watch_histories` (`id`, `user_id`, `movie_id`, `watched_at`, `created_at`, `updated_at`) VALUES
(1, 2, 6, '2024-09-19 06:06:11', NULL, NULL),
(2, 2, 4, '2024-09-19 06:08:45', NULL, NULL),
(3, 2, 1, '2024-09-19 06:08:59', NULL, NULL),
(4, 2, 1, '2024-09-19 06:09:11', NULL, NULL),
(5, 2, 1, '2024-09-19 06:11:14', NULL, NULL),
(6, 2, 6, '2024-09-19 06:14:48', NULL, NULL),
(7, 2, 1, '2024-09-19 06:15:21', NULL, NULL),
(8, 2, 4, '2024-09-19 06:15:44', NULL, NULL),
(9, 2, 5, '2024-09-23 22:54:43', NULL, NULL),
(10, 2, 5, '2024-09-23 22:55:03', NULL, NULL),
(11, 2, 5, '2024-09-23 22:55:17', NULL, NULL),
(12, 2, 5, '2024-09-23 22:55:27', NULL, NULL),
(13, 2, 7, '2024-09-24 02:35:15', NULL, NULL),
(14, 2, 7, '2024-09-24 02:36:06', NULL, NULL),
(15, 2, 7, '2024-09-24 02:37:14', NULL, NULL),
(16, 2, 7, '2024-09-24 02:37:21', NULL, NULL),
(17, 2, 1, '2024-09-24 02:51:17', NULL, NULL),
(18, 2, 1, '2024-09-24 02:55:26', NULL, NULL),
(19, 2, 1, '2024-09-24 02:55:49', NULL, NULL),
(20, 2, 1, '2024-09-24 02:56:07', NULL, NULL),
(21, 2, 1, '2024-09-24 02:59:27', NULL, NULL),
(22, 2, 1, '2024-09-24 03:00:02', NULL, NULL),
(23, 2, 1, '2024-09-24 03:00:10', NULL, NULL),
(24, 2, 1, '2024-09-24 03:00:26', NULL, NULL),
(25, 2, 6, '2024-09-24 03:00:38', NULL, NULL),
(26, 2, 10, '2024-09-24 03:01:26', NULL, NULL),
(27, 2, 10, '2024-09-24 03:08:17', NULL, NULL),
(28, 2, 10, '2024-09-24 03:09:07', NULL, NULL),
(29, 2, 1, '2024-09-24 03:09:22', NULL, NULL),
(30, 2, 1, '2024-09-24 03:09:33', NULL, NULL),
(31, 2, 6, '2024-09-24 03:10:36', NULL, NULL),
(32, 2, 6, '2024-09-24 03:10:42', NULL, NULL),
(33, 2, 6, '2024-09-24 03:12:02', NULL, NULL),
(34, 2, 6, '2024-09-24 03:12:43', NULL, NULL),
(35, 2, 6, '2024-09-24 03:19:21', NULL, NULL),
(36, 2, 6, '2024-09-24 03:22:27', NULL, NULL),
(37, 2, 6, '2024-09-24 03:22:36', NULL, NULL),
(38, 2, 6, '2024-09-24 03:22:48', NULL, NULL),
(39, 2, 10, '2024-09-24 03:35:58', NULL, NULL),
(40, 2, 10, '2024-09-24 03:37:31', NULL, NULL),
(41, 2, 10, '2024-09-24 03:43:07', NULL, NULL),
(42, 2, 10, '2024-09-24 03:46:37', NULL, NULL),
(43, 2, 10, '2024-09-24 03:46:52', NULL, NULL),
(44, 2, 10, '2024-09-24 03:46:59', NULL, NULL),
(45, 2, 10, '2024-09-24 03:50:59', NULL, NULL),
(46, 2, 10, '2024-09-24 03:51:09', NULL, NULL),
(47, 2, 10, '2024-09-24 03:51:13', NULL, NULL),
(48, 2, 10, '2024-09-24 03:51:45', NULL, NULL),
(49, 2, 7, '2024-09-24 03:53:22', NULL, NULL),
(50, 2, 7, '2024-09-24 03:57:34', NULL, NULL),
(51, 2, 7, '2024-09-24 03:57:41', NULL, NULL),
(52, 2, 7, '2024-09-24 03:57:44', NULL, NULL),
(53, 2, 7, '2024-09-24 03:57:48', NULL, NULL),
(54, 2, 2, '2024-09-24 03:58:00', NULL, NULL),
(55, 2, 2, '2024-09-24 03:58:05', NULL, NULL),
(56, 2, 2, '2024-09-24 03:58:07', NULL, NULL),
(57, 2, 2, '2024-09-24 03:59:11', NULL, NULL),
(58, 2, 2, '2024-09-24 03:59:21', NULL, NULL),
(59, 2, 2, '2024-09-24 04:00:58', NULL, NULL),
(60, 2, 2, '2024-09-24 04:01:33', NULL, NULL),
(61, 2, 2, '2024-09-24 04:01:39', NULL, NULL),
(62, 2, 2, '2024-09-24 04:01:42', NULL, NULL),
(63, 2, 2, '2024-09-24 04:01:59', NULL, NULL),
(64, 2, 2, '2024-09-24 04:06:44', NULL, NULL),
(65, 2, 2, '2024-09-24 04:07:13', NULL, NULL),
(66, 2, 2, '2024-09-24 04:07:49', NULL, NULL),
(67, 2, 2, '2024-09-24 04:07:57', NULL, NULL),
(68, 2, 2, '2024-09-24 04:08:07', NULL, NULL),
(69, 2, 2, '2024-09-24 04:09:13', NULL, NULL),
(70, 2, 2, '2024-09-24 04:11:49', NULL, NULL),
(71, 2, 2, '2024-09-24 04:12:06', NULL, NULL),
(72, 2, 2, '2024-09-24 04:12:51', NULL, NULL),
(73, 2, 2, '2024-09-24 04:13:17', NULL, NULL),
(74, 2, 2, '2024-09-24 04:13:37', NULL, NULL),
(75, 2, 2, '2024-09-24 04:13:46', NULL, NULL),
(76, 2, 2, '2024-09-24 04:13:56', NULL, NULL),
(77, 2, 10, '2024-09-24 04:16:38', NULL, NULL),
(78, 2, 1, '2024-09-24 04:16:50', NULL, NULL),
(79, 2, 1, '2024-09-24 04:19:59', NULL, NULL),
(80, 2, 1, '2024-09-24 04:20:31', NULL, NULL),
(81, 2, 1, '2024-09-24 05:24:11', NULL, NULL),
(82, 2, 1, '2024-09-24 05:24:42', NULL, NULL),
(83, 2, 6, '2024-09-24 05:26:54', NULL, NULL),
(84, 2, 6, '2024-09-24 05:29:41', NULL, NULL),
(86, 4, 10, '2024-10-13 02:04:09', NULL, NULL),
(97, 21, 1, '2024-10-27 04:44:36', NULL, NULL),
(98, 2, 2, '2024-10-27 06:28:50', NULL, NULL),
(99, 2, 2, '2024-10-27 06:29:04', NULL, NULL),
(100, 2, 2, '2024-10-27 06:30:05', NULL, NULL),
(101, 21, 4, '2024-10-30 23:16:48', NULL, NULL),
(102, 21, 4, '2024-10-30 23:18:26', NULL, NULL),
(103, 21, 4, '2024-10-30 23:19:19', NULL, NULL),
(104, 21, 2, '2024-10-31 02:24:18', NULL, NULL),
(105, 21, 2, '2024-10-31 02:24:25', NULL, NULL),
(106, 21, 2, '2024-10-31 02:24:35', NULL, NULL),
(107, 21, 10, '2024-10-31 02:37:17', NULL, NULL),
(108, 21, 1, '2024-11-01 18:08:57', NULL, NULL),
(109, 2, 5, '2024-11-01 18:17:05', NULL, NULL),
(110, 2, 10, '2024-11-01 18:17:20', NULL, NULL),
(111, 2, 1, '2024-11-01 18:17:25', NULL, NULL),
(112, 2, 2, '2024-11-01 19:18:02', NULL, NULL),
(113, 2, 2, '2024-11-01 19:18:18', NULL, NULL),
(114, 21, 1, '2024-11-01 19:41:39', NULL, NULL),
(115, 2, 15, '2024-11-06 01:46:12', NULL, NULL),
(116, 2, 15, '2024-11-06 01:46:40', NULL, NULL),
(117, 2, 7, '2024-11-06 01:50:27', NULL, NULL),
(118, 2, 7, '2024-11-06 01:50:31', NULL, NULL),
(119, 2, 7, '2024-11-06 01:50:37', NULL, NULL),
(120, 2, 7, '2024-11-06 01:50:54', NULL, NULL),
(121, 2, 7, '2024-11-06 01:51:17', NULL, NULL),
(122, 2, 7, '2024-11-06 01:52:08', NULL, NULL),
(123, 2, 7, '2024-11-06 01:52:43', NULL, NULL),
(124, 2, 2, '2024-11-06 02:15:58', NULL, NULL),
(125, 23, 10, '2024-11-08 03:46:58', NULL, NULL),
(126, 23, 2, '2024-11-08 03:54:04', NULL, NULL),
(127, 2, 10, '2024-11-09 22:57:55', NULL, NULL),
(128, 2, 10, '2024-11-09 22:58:15', NULL, NULL),
(129, 2, 10, '2024-11-09 23:00:23', NULL, NULL),
(130, 2, 10, '2024-11-09 23:00:57', NULL, NULL),
(131, 23, 1, '2024-11-12 09:19:19', NULL, NULL),
(132, 23, 6, '2024-11-12 09:43:53', NULL, NULL),
(133, 22, 10, '2024-11-12 10:33:14', NULL, NULL),
(134, 2, 10, '2024-11-25 10:04:02', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `watch_lists`
--

CREATE TABLE `watch_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `movie_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `watch_lists`
--

INSERT INTO `watch_lists` (`id`, `user_id`, `movie_id`, `created_at`, `updated_at`) VALUES
(15, 2, 4, '2024-09-24 05:22:01', '2024-09-24 05:22:01'),
(18, 2, 1, '2024-09-24 05:23:34', '2024-09-24 05:23:34'),
(19, 2, 6, '2024-09-24 05:29:35', '2024-09-24 05:29:35'),
(20, 2, 3, '2024-09-24 05:30:18', '2024-09-24 05:30:18'),
(21, 2, 7, '2024-09-28 05:44:19', '2024-09-28 05:44:19'),
(22, 3, 10, '2024-10-01 05:33:05', '2024-10-01 05:33:05'),
(27, 21, 10, '2024-10-27 01:23:29', '2024-10-27 01:23:29'),
(28, 21, 2, '2024-11-01 16:49:29', '2024-11-01 16:49:29'),
(29, 23, 10, '2024-11-08 02:47:00', '2024-11-08 02:47:00');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_movie_id_foreign` (`movie_id`);

--
-- Chỉ mục cho bảng `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `episodes_movie_id_foreign` (`movie_id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes_user_id_foreign` (`user_id`),
  ADD KEY `likes_comment_id_foreign` (`comment_id`),
  ADD KEY `likes_reply_id_foreign` (`reply_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movies_release_year_id_foreign` (`release_year_id`),
  ADD KEY `movies_country_id_foreign` (`country_id`),
  ADD KEY `movies_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_genres_movie_id_foreign` (`movie_id`),
  ADD KEY `movie_genres_genre_id_foreign` (`genre_id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_user_id_foreign` (`user_id`),
  ADD KEY `ratings_movie_id_foreign` (`movie_id`);

--
-- Chỉ mục cho bảng `release_years`
--
ALTER TABLE `release_years`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `replies_comment_id_foreign` (`comment_id`),
  ADD KEY `replies_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `services_orders`
--
ALTER TABLE `services_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_orders_order_code_unique` (`order_code`),
  ADD KEY `services_orders_user_id_foreign` (`user_id`),
  ADD KEY `services_orders_service_id_foreign` (`service_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `trailers`
--
ALTER TABLE `trailers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trailers_movie_id_foreign` (`movie_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_service_id_foreign` (`service_id`);

--
-- Chỉ mục cho bảng `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `views_movie_id_foreign` (`movie_id`);

--
-- Chỉ mục cho bảng `watch_histories`
--
ALTER TABLE `watch_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `watch_histories_user_id_foreign` (`user_id`),
  ADD KEY `watch_histories_movie_id_foreign` (`movie_id`);

--
-- Chỉ mục cho bảng `watch_lists`
--
ALTER TABLE `watch_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `watch_lists_user_id_foreign` (`user_id`),
  ADD KEY `watch_lists_movie_id_foreign` (`movie_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `genres`
--
ALTER TABLE `genres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `movies`
--
ALTER TABLE `movies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `movie_genres`
--
ALTER TABLE `movie_genres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `release_years`
--
ALTER TABLE `release_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `replies`
--
ALTER TABLE `replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `services_orders`
--
ALTER TABLE `services_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `trailers`
--
ALTER TABLE `trailers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `views`
--
ALTER TABLE `views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `watch_histories`
--
ALTER TABLE `watch_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT cho bảng `watch_lists`
--
ALTER TABLE `watch_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `episodes`
--
ALTER TABLE `episodes`
  ADD CONSTRAINT `episodes_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_reply_id_foreign` FOREIGN KEY (`reply_id`) REFERENCES `replies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `movies_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `movies_release_year_id_foreign` FOREIGN KEY (`release_year_id`) REFERENCES `release_years` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD CONSTRAINT `movie_genres_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_genres_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `services_orders`
--
ALTER TABLE `services_orders`
  ADD CONSTRAINT `services_orders_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `trailers`
--
ALTER TABLE `trailers`
  ADD CONSTRAINT `trailers_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `views`
--
ALTER TABLE `views`
  ADD CONSTRAINT `views_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `watch_histories`
--
ALTER TABLE `watch_histories`
  ADD CONSTRAINT `watch_histories_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `watch_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `watch_lists`
--
ALTER TABLE `watch_lists`
  ADD CONSTRAINT `watch_lists_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `watch_lists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
