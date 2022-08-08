-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 18 2021 г., 15:26
-- Версия сервера: 5.7.21-20-beget-5.7.21-20-1-log
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `p96357hm_datdata`
--

-- --------------------------------------------------------

--
-- Структура таблицы `grafick`
--
-- Создание: Май 03 2021 г., 07:52
--

DROP TABLE IF EXISTS `grafick`;
CREATE TABLE `grafick` (
  `id` int(11) NOT NULL,
  `param` int(11) NOT NULL,
  `datazamer` date NOT NULL,
  `znachenie` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `grafick`
--

INSERT INTO `grafick` (`id`, `param`, `datazamer`, `znachenie`) VALUES
(1, 1, '2021-04-11', 23.388066419881667),
(2, 1, '2021-04-12', 24.461319003611763),
(3, 1, '2021-04-13', 6.845452431012241),
(4, 1, '2021-04-14', 26.732891057003894),
(5, 1, '2021-04-15', 27.297023945841396),
(6, 1, '2021-04-16', 33.26084555628021),
(7, 1, '2021-04-17', 24.422779256911483),
(8, 1, '2021-04-18', 13.454606136757683),
(9, 1, '2021-04-19', 29.217812924103942),
(10, 1, '2021-04-20', 8.452076340440883);

-- --------------------------------------------------------

--
-- Структура таблицы `param`
--
-- Создание: Май 03 2021 г., 07:52
--

DROP TABLE IF EXISTS `param`;
CREATE TABLE `param` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `param`
--

INSERT INTO `param` (`id`, `title`) VALUES
(1, 'Мошность'),
(2, 'Сила тока'),
(3, 'Напряжение');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `grafick`
--
ALTER TABLE `grafick`
  ADD PRIMARY KEY (`id`),
  ADD KEY `param` (`param`);

--
-- Индексы таблицы `param`
--
ALTER TABLE `param`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `grafick`
--
ALTER TABLE `grafick`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `param`
--
ALTER TABLE `param`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `grafick`
--
ALTER TABLE `grafick`
  ADD CONSTRAINT `grafick_ibfk_1` FOREIGN KEY (`param`) REFERENCES `param` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
