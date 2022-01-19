-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 19 2022 г., 09:39
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `banner`
--

-- --------------------------------------------------------

--
-- Структура таблицы `views_log`
--

CREATE TABLE `views_log` (
  `id` int NOT NULL,
  `ip_address` int UNSIGNED NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `view_date` datetime NOT NULL,
  `page_url` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `views_count` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `views_log`
--

INSERT INTO `views_log` (`id`, `ip_address`, `user_agent`, `view_date`, `page_url`, `views_count`) VALUES
(7, 2130706433, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:96.0) Gecko/20100101 Firefox/96.0', '2022-01-19 09:37:26', 'http://banner/index1.html', 49),
(8, 2130706433, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv0) Gecko/20100101 Firefox/96.0', '2022-01-19 09:33:03', 'http://banner/index2.html', 22),
(9, 2130706433, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:96.0) Gecko/20100101 Firefox/96.0', '2022-01-19 09:39:07', 'http://banner/index2.html', 9);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `views_log`
--
ALTER TABLE `views_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_address` (`ip_address`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `views_log`
--
ALTER TABLE `views_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
