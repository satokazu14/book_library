-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 
-- サーバのバージョン： 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_library`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `max_number` int(11) NOT NULL,
  `tag_1` varchar(50) DEFAULT NULL,
  `tag_2` varchar(50) DEFAULT NULL,
  `isbn` varchar(255) NOT NULL,
  `del_flg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `book`
--

INSERT INTO `book` (`id`, `title`, `max_number`, `tag_1`, `tag_2`, `isbn`, `del_flg`) VALUES
(6, 'いぬまるだしっ', 11, 'ギャグ', 'ジャンプ', 'PKEY:08874634874634315501', 1),
(7, '呪術廻戦', 7, 'バトル', 'ジャンプ', 'PKEY:08881516881516315501', 1),
(8, '僕のヒーローアカデミア', 23, 'バトル', 'ジャンプ', 'PKEY:08880264880264315501', 0),
(9, '鬼滅の刃', 17, 'バトル', 'ジャンプ', 'PKEY:08880723880723315501', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
