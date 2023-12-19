-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Гру 19 2023 р., 23:15
-- Версія сервера: 10.4.28-MariaDB
-- Версія PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `carshop`
--

-- --------------------------------------------------------

--
-- Структура таблиці `manufacturer`
--

CREATE TABLE `manufacturer` (
  `ID` int(11) NOT NULL,
  `Manufacturer_Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `manufacturer`
--

INSERT INTO `manufacturer` (`ID`, `Manufacturer_Name`) VALUES
(25, 'TestManufacturer');

-- --------------------------------------------------------

--
-- Структура таблиці `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `Order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` varchar(255) NOT NULL,
  `Buyer_Id` int(11) NOT NULL,
  `Seller_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `order_detail`
--

CREATE TABLE `order_detail` (
  `ID` int(11) NOT NULL,
  `Orders_ID` int(11) NOT NULL,
  `Part_ID` int(11) NOT NULL,
  `Number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `part`
--

CREATE TABLE `part` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL,
  `Warranty_period` int(11) NOT NULL,
  `Price` decimal(15,2) NOT NULL,
  `Date_of_manufacture` date NOT NULL,
  `manufacturer_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Структура таблиці `role`
--

CREATE TABLE `role` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `role`
--

INSERT INTO `role` (`ID`, `Name`) VALUES
(1, 'Покупець'),
(2, 'Продавець'),
(3, 'Адміністратор');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Token` varchar(255) NOT NULL,
  `role_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`ID`);

--
-- Індекси таблиці `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_buyer_orders` (`Buyer_Id`),
  ADD KEY `fk_sales_orders` (`Seller_ID`);

--
-- Індекси таблиці `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_part` (`Part_ID`),
  ADD KEY `fk_order` (`Orders_ID`);

--
-- Індекси таблиці `part`
--
ALTER TABLE `part`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_part_manufacturer` (`manufacturer_ID`);

--
-- Індекси таблиці `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`ID`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_users_role` (`role_ID`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблиці `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблиці `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблиці `part`
--
ALTER TABLE `part`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблиці `role`
--
ALTER TABLE `role`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_buyer_orders` FOREIGN KEY (`Buyer_Id`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `fk_sales_orders` FOREIGN KEY (`Seller_ID`) REFERENCES `users` (`ID`);

--
-- Обмеження зовнішнього ключа таблиці `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_order` FOREIGN KEY (`Orders_ID`) REFERENCES `orders` (`ID`),
  ADD CONSTRAINT `fk_part` FOREIGN KEY (`Part_ID`) REFERENCES `part` (`ID`);

--
-- Обмеження зовнішнього ключа таблиці `part`
--
ALTER TABLE `part`
  ADD CONSTRAINT `fk_part_manufacturer` FOREIGN KEY (`manufacturer_ID`) REFERENCES `manufacturer` (`ID`);

--
-- Обмеження зовнішнього ключа таблиці `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_ID`) REFERENCES `role` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
