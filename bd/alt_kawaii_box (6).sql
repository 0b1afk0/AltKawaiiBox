-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 25 2025 г., 22:25
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `alt_kawaii_box`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(4, 1, 2, 4, '2025-06-25 19:17:51');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'Фигурки'),
(2, 'Еда'),
(3, 'Плакаты'),
(4, 'Наклейки'),
(5, 'Манга'),
(6, 'Мерч'),
(7, 'Канцелярия');

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `message`, `created_at`) VALUES
(4, '123', '123', '2025-06-09 14:15:53'),
(5, '123', '123', '2025-06-19 19:19:10');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `anime` varchar(200) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `anime`, `img`) VALUES
(1, 1, 'Jojo Джоджо фигурка', 'Фигурка JoJo\'s Bizarre Adventure – коллекционная модель персонажа из культового аниме. Высокое качество детализации, динамичный дизайн и лицензионное исполнение. Отличный подарок для фанатов серии!', '2180', 'jojo', '/img/figure1.png'),
(2, 3, 'Плакат \"Alien Stage\" (A3)', 'Плакат \"Alien Stage\" (A3) – яркое и детализированное изображение в высоком качестве. Отлично подходит для украшения комнаты или коллекции фаната.', '245', 'alien', '/img/plakat1.png'),
(3, 2, 'Samyang Hot Chicken Flavor Ramen (Тройная острота)', 'Культовый корейский рамен с экстремальной остротой (уровень 3xSpicy)\r\nОригинальная лапша быстрого приготовления от южнокорейского бренда Samyang Foods, ставшая интернет-сенсацией благодаря своему обжигающе острому вкусу. Это не просто еда - это настоящий кулинарный вызов для любителей острых ощущений!', '210', '', '/img/food1.png'),
(4, 4, 'Набор Наклеек \"Jujutsu Kaisen – Годжо Сатору\" (коллекционные)', 'Коллекционные виниловые наклейки с изображением Годжо Сатору – самого могущественного мага из аниме «Магическая битва» (Jujutsu Kaisen). В набор входит 1 лист с несколькими стикерами разного размера и дизайна.', '320', 'juju', '/img/stickers.png'),
(5, 3, 'Постер PosterNak Аниме Звездное дитя, 40x30 см', 'Яркий и стильный постер с изображением персонажа из аниме Звёздное дитя – идеальное украшение для комнаты фаната. Чёткая печать на плотной бумаге, насыщенные цвета и удобный формат (40×30 см) позволяют легко вписать его в любой интерьер. Отличный подарок для поклонников аниме-культуры!', '245', 'oshi', '/img/plakat2.png'),
(6, 1, 'Фигурка акриловая Arcane: Джинкс', 'Коллекционная акриловая фигурка Джинкс из популярного сериала Arcane – стильное дополнение для вашей коллекции. Высокое качество печати, детализированное изображение и прочный акрил обеспечивают долговечность. Идеально смотрится на полке, рабочем столе или в витрине с аниме-атрибутикой.', '450', 'arcane', '/img/figure2.png'),
(7, 6, 'Детская футболка 3D Arcane \"Аркейн\"', 'Мягкая и удобная футболка с эффектным 3D-принтом по мотивам Arcane – отличный выбор для юных фанатов сериала. Изготовлена из качественного хлопка, не раздражает кожу и выдерживает многочисленные стирки. Красочный дизайн и стильный крой делают её любимой вещью в гардеробе ребёнка.\r\n\r\n', '825', 'arcane', '/img/merch1.png'),
(8, 2, 'Конфеты кислые Acid', 'Острые ощущения для любителей экстремальных вкусов! Кислые конфеты Acid – это взрывной микс ярких ароматов и насыщенной кислинки. Удобная упаковка позволяет брать их с собой в школу, на прогулку или вечеринку. Попробуйте – если осмелитесь!', '100', '', '/img/food2.png'),
(9, 7, '6 шт. гелевые ручки ALIEN STAGE Ivan Till Anime Mizi чёрного цвета 0,5 мм', 'Набор стильных гелевых ручек с тонким пишущим узлом (0.5 мм) и дизайном по мотивам аниме ALIEN STAGE. Чёрные чернила обеспечивают чёткие и аккуратные линии, а эргономичный корпус делает письмо комфортным. Отличный выбор для учёбы, творчества и коллекционирования.', '450', 'alien', '/img/can1.png'),
(10, 6, 'Мужская футболка 3D Jojo Kakyoin', 'Стильная мужская футболка с 3D-принтом Какуина из JoJo\'s Bizarre Adventure – для настоящих ценителей аниме. Качественный хлопок, яркие цвета и чёткая печать делают её удобной и долговечной. Выгодно выделит вас среди других фанатов JoJo!', '825', 'jojo', '/img/merch2.png'),
(11, 6, 'Кружка ДжоДжо (JoJo), 335 мл', 'Лицензионная кружка с дизайном по мотивам JoJo\'s Bizarre Adventure – идеальный подарок для поклонников серии. Объём 335 мл, керамика с устойчивым принтом, удобная ручка. Подходит для горячих и холодных напитков. Пейте свой кофе с любимыми персонажами!', '390', 'jojo', '/img/merch3.png'),
(12, 5, 'Звёздное Дитя манга. Набор 1-11 тома. На русском языке', 'Полное собрание культовой манги Звёздное Дитя в удобном формате! Все 11 томов на русском языке с качественным переводом и сохранением оригинальной вёрстки. Погрузитесь в захватывающую космическую сагу с глубоким сюжетом и потрясающими иллюстрациями. Обязательно для коллекции каждого отаку!', '9975', 'oshi', '/img/manga1.png');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `text`, `created_at`) VALUES
(8, 1, 4, 4, 'Покупал фигурку для самодельной покраски. Товар пришел в отличном состоянии, отдельное спасибо за обезжириватель. У меня конечно уже был свой, но определенно приятный бонус.', '2025-06-21');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(10) NOT NULL,
  `avatar` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `user_name`, `last_name`, `email`, `password`, `role`, `avatar`) VALUES
(1, 'admin', '', 'admin@gmail.com', '$2y$10$IeJ1gzKIokNGc4GBGktDx.1598hasbEUXNZp8C7DJUXYsTjC340.6', 'admin', 'avatar_685b227ef3807.jpg'),
(2, 'Ярослав', 'Петров', 'Jorik@gmail.com', '$2y$10$6X/NlgF/BWnKQ.T.94yrAO7mWB2nLm5NSio2u/2iy8AnjU.edHp7a', 'user', '../avatars/avatar2.jpg'),
(3, 'Oleg', 'Semenov', 'Oleg@mail.ru', '$2y$10$iagcE4liFhfWdI36mwqz5uepzdyu6Y2FkntgvjRB72d4BpUo1Kd.C', 'user', ''),
(4, '0b1afk0', '', 'oblafko@gmail.com', '$2y$10$QfdfWyubb.kzZYHeNa3x1euKbv9te/RMvktm4aoC.NJme8w7E2EbC', 'admin', '../avatars/avatar3.jpg'),
(5, 'vasya', 'vasilev', 'vasya@mail.ru', '$2y$10$ln.ELAOipi2.x8p3m8O1W.Bfd0c0saul5o1dj81x00WcnDEuzKsUG', 'user', '../avatars/avatar1.jpg'),
(6, '123', '123', '1@gmail.com', '$2y$10$764HVZ0dqLI8m7ez.uHIhOISEZ.Ve/Rr2SX5rjEiNr74MATnkLEMO', 'user', NULL),
(7, '123', '123', 'bedbitor337@gmail.com', '$2y$10$COFm5YkUkz0fOMMIAhpEVORwOQcsU7GFvPMlvj6hJxUwCPT7OgBgm', 'user', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`category_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
